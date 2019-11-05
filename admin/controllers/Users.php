<?php

/*
 * Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License
 * @license    https://opensource.org/licenses/GPL-3.0
 *
 * @package    Easy CMS MVC framework
 * @author     Ahmed Elmahdy
 * @link       https://ahmedx.com
 *
 * For more information about the author , see <http://www.ahmedx.com/>.
 */

class Users extends ControllerAdmin
{

    private $userModel;

//    private $userModel;

    public function __construct()
    {

        $this->userModel = $this->model('User');
    }

    /**
     * loading index view with latest users
     */
    public function index($current = '', $perpage = 50)
    {
        // get users
        $cond = 'WHERE users.status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->userModel->deleteById($_POST['record'], 'user_id')) {
                        flash('user_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('user_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('users');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->userModel->publishById($_POST['record'], 'user_id')) {
                        flash('user_msg', 'تم تفعيل المستخدم ' . $row_num . ' بنجاح');
                    } else {
                        flash('user_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('users');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->userModel->unpublishById($_POST['record'], 'user_id')) {
                        flash('user_msg', 'تم تعليق المستخدم ' . $row_num . ' بنجاح');
                    } else {
                        flash('user_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('users');
            }
        }

        //handling search
        // if user make a search
        if (isset($_POST['search'])) {
            // return to first 
            $current = 1;
            $searches = $this->userModel->handlingSearchCondition(['name', 'group_id', 'email', 'mobile', 'status']);
            $cond .= $searches['cond'];
            $bind = $searches['bind'];

        } else {
            // if user didn't search
            // look for pagenation if not clear seassion
            if (empty($current)) {
                unset($_SESSION['search']);
                // if there is pagenation and value stored into session get it and prepare Condition and bind
            } else {
                $searches = $this->userModel->handlingSearchSessionCondition(['name', 'group_id', 'email', 'mobile', 'status']);
                $cond .= $searches['cond'];
                $bind = $searches['bind'];
            }
        }

        // get all records count after search and filtration
        $recordsCount = $this->userModel->allUsersCount($cond, $bind);
        // make sure its integer value and its usable
        $current = (int) $current;
        $perpage = (int) $perpage;

        ($perpage == 0) ? $perpage = 20 : null;
        if ($current <= 0 || $current > ceil($recordsCount->count / $perpage)) {
            $current = 1;
            $limit = 'LIMIT 0 , :perpage ';
            $bindLimit[':perpage'] = $perpage;
        } else {
            $limit = 'LIMIT  ' . (($current - 1) * $perpage) . ', :perpage';
            $bindLimit[':perpage'] = $perpage;
        }
        //get all records for current user
        $users = $this->userModel->getUsers($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'groupList' => $this->userModel->groupList(' WHERE status <> 2 '),
            'header' => '',
            'title' => 'المستخدمين',
            'users' => $users,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('users/index', $data);
    }

    /**
     * adding new user
     */
    public function add()
    {
        if (!$groupList = $this->userModel->groupList(' WHERE status <> 2 ')) {
            flash('user_msg', 'برجاء انشاء مجموعة اولا حتي تتمكن من انشاء مستخدمين جدد ', 'alert alert-danger');
            redirect('users');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'page_title' => 'المستخدمين',
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'password_repeat' => trim($_POST['password_repeat']),
                'mobile' => trim($_POST['mobile']),
                'image' => '',
                'groupList' => $groupList,
                'bio' => trim($_POST['bio']),
                'group_id' => trim($_POST['group_id']),
                'status' => trim($_POST['status']),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'password_repeat_error' => '',
                'image_error' => '',
                'group_error' => '',
                'status_error' => '',
            ];
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'من فضلك اختار اسم للمستخدم';
            }
            // validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'من فضلك ادخل بريد الكتروني صحيح';
            } elseif ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_error'] = 'هذا البريد مسجل بالفعل ';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_error'] = 'هذا البريد غير صالح ';
            }
            // Validate Password
            if (empty($data['password'])) {
                $data['password_error'] = 'من فضلك قم بأدخال كلمة مرور مناسبة';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'كلمة المرور لا يجب ان تكون اقل من 6 احرف';
            }
            if (empty($data['password_repeat'])) {
                $data['password_repeat_error'] = 'من فضلك قم بأعادة كتابة كلمة المرور ';
            } elseif ($data['password'] != $data['password_repeat']) {
                $data['password_repeat_error'] = 'من فضلك اعد كتابة كلمة المرور بشكل صحيح';
            }
            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate group
            if (empty($data['group_id'])) {
                $data['group_error'] = 'من فضلك اختار مجموعة مناسبة';
            }
            // validate status
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة المستخدم';
            }
            //make sure there is no errors
            if (empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['password_repeat_error']) && empty($data['image_error']) && empty($data['group_error']) && empty($data['status_error'])) {
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                //validated
                if ($this->userModel->addUser($data)) {
                    flash('user_msg', 'تم الحفظ بنجاح');
                    redirect('users');
                } else {
                    flash('user_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            }
            //load the view with error
            $this->view('users/add', $data);
        } else {
            $data = [
                'page_title' => 'المستخدمين',
                'name' => '',
                'email' => '',
                'password' => '',
                'password_repeat' => '',
                'mobile' => '',
                'image' => '',
                'groupList' => $groupList,
                'bio' => '',
                'group_id' => '',
                'status' => '0',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'password_repeat_error' => '',
                'image_error' => '',
                'group_error' => '',
                'status_error' => '',
            ];
        }

        //loading the add user view
        $this->view('users/add', $data);
    }

    /**
     * update user
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        // get group for user selection
        if (!$groupList = $this->userModel->groupList(' WHERE status <> 2 ')) {
            flash('user_msg', 'برجاء انشاء مجموعة اولا حتي تتمكن من انشاء مستخدمين جدد ', 'alert alert-danger');
            redirect('users');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => $id,
                'page_title' => 'المستخدمين',
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'password_repeat' => trim($_POST['password_repeat']),
                'mobile' => trim($_POST['mobile']),
                'image' => '',
                'groupList' => $groupList,
                'bio' => trim($_POST['bio']),
                'group_id' => trim($_POST['group_id']),
                'status' => trim($_POST['status']),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'password_repeat_error' => '',
                'image_error' => '',
                'group_error' => '',
                'status_error' => '',
            ];
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'من فضلك اختار اسم للمستخدم';
            }
            // validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'من فضلك ادخل بريد الكتروني صحيح';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_error'] = 'هذا البريد غير صالح ';
            }
            // Validate Password
            if (!empty($data['password'])) {
                if (strlen($data['password']) < 6) {
                    $data['password_error'] = 'كلمة المرور لا يجب ان تكون اقل من 6 احرف';
                }
                if ($data['password'] != $data['password_repeat']) {
                    $data['password_repeat_error'] = 'من فضلك اعد كتابة كلمة المرور بشكل صحيح';
                }
            }

            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate group
            if (empty($data['group_id'])) {
                $data['group_error'] = 'من فضلك اختار مجموعة مناسبة';
            }
            // validate status
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة المستخدم';
            }
            //make sure there is no errors
            if (empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['password_repeat_error']) && empty($data['image_error']) && empty($data['group_error']) && empty($data['status_error'])) {
                if (!empty($data['password'])) { // Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }
                //validated
                if ($this->userModel->updateUser($data)) {
                    flash('user_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('users/edit/' . $id) : redirect('users');
                } else {
                    flash('user_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('users/edit', $data);
            }
        } else {
            // featch users
            if (!$user = $this->userModel->getUserById($id)) {
                flash('user_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('users');
            }

            $data = [
                'user_id' => $id,
                'page_title' => 'المستخدمين',
                'name' => $user->name,
                'email' => $user->email,
                'password' => '',
                'password_repeat' => '',
                'mobile' => $user->mobile,
                'image' => $user->image,
                'groupList' => $groupList,
                'bio' => $user->bio,
                'group_id' => $user->group_id,
                'status' => $user->status,
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'password_repeat_error' => '',
                'image_error' => '',
                'group_error' => '',
                'status_error' => '',
            ];
            $this->view('users/edit', $data);
        }
    }

    /**
     * showing user details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$user = $this->userModel->getUserById($id)) {
            flash('user_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('users');
        }
        $data = [
            'user_id' => $id,
            'page_title' => 'المستخدمين',
            'user' => $user,
        ];
        $this->view('users/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->userModel->deleteById([$id], 'user_id')) {
            flash('user_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('user_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('users');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->userModel->publishById([$id], 'user_id')) {
            flash('user_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('user_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('users');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->userModel->unpublishById([$id], 'user_id')) {
            flash('user_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('user_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('users');
    }

    /**
     * handling user login and create user session
     */
    public function login()
    {
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => '',
            ];
            //validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'لا يمكن ترك حقل البريد خاليا ';
            } elseif (!$this->userModel->findUserByEmail($data['email'])) {
                $data['email_error'] = 'هذ البريد ليس مسجل لدينا';
            }
            //validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'لا يمكن ترك حقل كلمة المرور خاليا';
            }
            if (empty($data['email_error']) && empty($data['password_error'])) {
                // validated
                //check and login user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    //create session and setup the user premissions
                    $this->userModel->createUserSession($loggedInUser);
                    // redirect user to dashboard
                    redirect('dashboard');
                } else {
                    $data['password_error'] = 'كلمة المرور غير صحيحة';
                    $this->view('users/login', $data);
                }
            } else {

                $this->view('users/login', $data);
            }
        } else {
            //init data
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
            ];
            //load view
            $this->view('users/login', $data);
        }
    }

    /**
     * handling user password restor through sending email activation
     */
    public function forget()
    {
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [
                'email' => trim($_POST['email']),
                'email_error' => '',
            ];
            //validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'لا يمكن ترك حقل البريد خاليا ';
            } elseif (!$this->userModel->findUserByEmail($data['email'])) {
                $data['email_error'] = 'هذ البريد ليس مسجل لدينا';
            }
            if (empty($data['email_error'])) {
                // validated
                $this->userModel->forget($data['email']);
                flash('user_msg', 'تم ارسال رابط تفعيل الحساب علي البريد المسجل لدينا ');
                redirect('users/forget');
            } else {
                $this->view('users/forget', $data);
            }
        } else {
            //init data
            $data = [
                'email' => '',
                'email_error' => '',
            ];
            //load view
            $this->view('users/forget', $data);
        }
    }

    /**
     * logging user out and clean session data
     */
    public function logout()
    {
        logout();
        redirect('users/login');
    }

    /**
     * reset user password
     * @param string $code
     */
    public function reset($code)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            ///password validation and reset and redirect to login
            $data = [
                'code' => $code,
                'password' => trim($_POST['password']),
                'password_repeat' => trim($_POST['password_repeat']),
                'password_error' => '',
                'password_repeat_error' => '',
            ];
            // Validate Password
            if (empty($data['password'])) {
                $data['password_error'] = 'من فضلك قم بأدخال كلمة مرور مناسبة';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'كلمة المرور لا يجب ان تكون اقل من 6 احرف';
            }
            if (empty($data['password_repeat'])) {
                $data['password_repeat_error'] = 'من فضلك قم بأعادة كتابة كلمة المرور ';
            } elseif ($data['password'] != $data['password_repeat']) {
                $data['password_repeat_error'] = 'من فضلك اعد كتابة كلمة المرور بشكل صحيح';
            }

            //make sure there is no errors
            if (empty($data['password_error']) && empty($data['password_repeat_error'])) {
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                //validated
                if ($this->userModel->updatePassword($data['password'], $code)) {
                    flash('user_msg', 'تم تحديث كلمة المرور بنجاح ');
                    redirect('users/login');
                } else {
                    flash('user_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                    redirect('users/reset/' . $code);
                }
            }
            $this->view('users/reset', $data);
        } else {
            //if user click on the activation code
            if (!empty($code)) {
                if ($this->userModel->checkCodeValidation($code)) {
                    flash('user_msg', 'تم تأكيد البريد الخاص بك قم بأدخال كلمة المرور الجديده للتمكن من الدخول الي حسابك');
                    $data = [
                        'code' => $code,
                        'password' => '',
                        'password_repeat' => '',
                        'password_error' => '',
                        'password_repeat_error' => '',
                    ];
                    $this->view('users/reset', $data);
                } else {
                    flash('user_msg', 'عذرا لقد انتهت صلاحية هذا الرابط ', 'alert alert-danger');
                    redirect('users/login');
                }
            } else {
                redirect('users/login');
            }
        }
    }

    /**
     * loading error view if user has no premission
     */
    public function error()
    {
        //init data
        $data = [
        ];
        //load view
        $this->view('users/error', $data);
    }

}
