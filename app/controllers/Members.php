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

class Members extends Controller {

    private $pagesModel;
    private $memberModel;

    public function __construct() {
        $this->memberModel = $this->model('Member');
        $this->pagesModel = $this->model('Page');
    }

    /**
     * loading index view with latest members
     */
    public function index() {
        if (!$this->memberModel->isMemberLogged()) {
            flash('member_msg', 'ليس لديك الصلاحية لدخول هذه الصفحة ', 'alert alert-danger');
            redirect('members/login', TRUE);
        }
        $data = [
            'pages' => $this->pagesModel->getPagesTitle(),
            'header' => '',
            'title' => 'المستفيد',
            'member' => $_SESSION['member'],
            'footer' => ''
        ];
        $this->view('members/index', $data);
    }

    /**
     * generate captcha code and store it in session for comparison 
     */
    public function captcha() {
        $this->view('members/captcha');
    }

    /**
     * members registration
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'associations' => $this->memberModel->getAssociations('WHERE status =1 '),
                'association_id' => trim($_POST['association_id']),
                'national_id' => trim($_POST['national_id']),
                'birth_date' => trim($_POST['birth_date']),
                'agreement' => trim($_POST['agreement']),
                'mobile' => trim($_POST['mobile']),
                'mobile_repeat' => trim($_POST['mobile_repeat']),
                'captcha' => trim($_POST['captcha']),
                'password' => generateRandomString(),
                'national_id_error' => '',
                'birth_date_error' => '',
                'agreement_error' => '',
                'mobile_error' => '',
                'mobile_repeat_error' => '',
                'national_id_error' => '',
                'captcha_error' => ''
            ];

            // validate national_id
            if (empty($data['national_id'])) {
                $data['national_id_error'] = 'من فضلك قم بكتابة رقم الهوية';
            } else {
                if ($this->memberModel->findMemberByNId($data['national_id'])) {
                    $data['national_id_error'] = 'تم التسجيل باستخدام هذا الرقم من قبل ';
                } elseif (strlen($data['national_id']) != 10) {
                    $data['national_id_error'] = 'يجب كتابة رقم الهوية بشكل صحيح';
                }
            }
            // validate birth_date
            if (empty($data['birth_date'])) {
                $data['birth_date_error'] = 'من فضلك قم بكتابة تاريخ الميلاد';
            }
            // validate association_id
            if (empty($data['association_id'])) {
                $data['association_id_error'] = 'من فضلك قم باختيار الجمعية المسجل بها';
            }
            // validate agreement
            if (empty($data['agreement'])) {
                $data['agreement_error'] = 'يجب الاقرار بالموافقة عليصحة البيانات';
            }
            // validate mobile
            if (empty($data['mobile'])) {
                $data['mobile_error'] = 'من فضلك قم بكتابة رقم الجوال';
            } else {
                if ($this->memberModel->findMemberByMobile($data['mobile'])) {
                    $data['mobile_error'] = 'هذا الرقم مسجل بالفعل ';
                }
            }
            if (empty($data['mobile_repeat'])) {
                $data['mobile_repeat_error'] = 'من فضلك قم بأعادة كتابة رقم الجوال ';
            } elseif ($data['mobile'] != $data['mobile_repeat']) {
                $data['mobile_repeat_error'] = 'من فضلك اعد كتابة رقم الجوال بشكل صحيح';
            }
            // validate captcha
            if (empty($data['captcha'])) {
                $data['captcha_error'] = 'من فضلك قم بكتابة رمز التحقق ';
            } elseif ($data['captcha'] != $_SESSION['captcha']) {
                $data['captcha_error'] = 'من فضلك قم بكتابة رمز التحقق بشكل صحيح';
            }
            //make sure there is no errors
            if (empty($data['national_id_error']) && empty($data['birth_date_error']) && empty($data['association_id_error']) && empty($data['agreement_error']) && empty($data['captcha_error']) && empty($data['mobile_error']) && empty($data['mobile_repeat_error'])) {

                //validated
                if ($id = $this->memberModel->addMember($data)) {
                    flash('member_msg', 'تم التسجيل بنجاح وتم ارسال كلمة المرور علي الجوال الخاص بك ' . $data['password']);
                    redirect('members/login/', TRUE);
                } else {
                    flash('member_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                flash('member_msg', 'من فضلك قم بتصحيح الاخطاء التالية ', 'alert alert-danger');
            }
            //load the view with error
            $this->view('members/register', $data);
        } else {
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'associations' => $this->memberModel->getAssociations('WHERE status =1 '),
                'association_id' => '',
                'national_id' => '',
                'birth_date' => '',
                'agreement' => '',
                'mobile' => '',
                'mobile_repeat' => '',
                'national_id_error' => '',
                'birth_date_error' => '',
                'agreement_error' => '',
                'mobile_error' => '',
                'mobile_repeat_error' => '',
                'captcha_error' => ''
            ];
        }

        //loading the add member view
        $this->view('members/register', $data);
    }

    /**
     * handling member login and create member session
     */
    public function login() {
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'national_id' => trim($_POST['national_id']),
                'password' => trim($_POST['password']),
                'captcha' => trim($_POST['captcha']),
                'national_id_error' => '',
                'password_error' => '',
                'captcha_error' => ''
            ];
            //validate national_id
            if (empty($data['national_id'])) {
                $data['national_id_error'] = 'لا يمكن ترك حقل الهوية خاليا ';
            } elseif (!$this->memberModel->findMemberByNId($data['national_id'])) {
                $data['national_id_error'] = 'هذ الحساب ليس مسجل لدينا';
            }
            //validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'لا يمكن ترك حقل كلمة المرور خاليا';
            }
            // validate captcha
            if (empty($data['captcha'])) {
                $data['captcha_error'] = 'من فضلك قم بكتابة رمز التحقق ';
            } elseif ($data['captcha'] != $_SESSION['captcha']) {
                $data['captcha_error'] = 'من فضلك قم بكتابة رمز التحقق بشكل صحيح';
            }
            if (empty($data['national_id_error']) && empty($data['password_error']) && empty($data['captcha_error'])) {
                // validated
                //check and login member
                $loggedInMember = $this->memberModel->login($data['national_id'], $data['password']);
                if ($loggedInMember) {
                    //create session and setup the member premissions
                    $this->memberModel->createMemberSession($loggedInMember);
                    flash('member_msg', 'تم تسجيل الدخول بنجاح ');
                    // redirect member to dashboard
                    redirect('members', TRUE);
                } else {
                    $data['password_error'] = 'كلمة المرور غير صحيحة';
                    $this->view('members/login', $data);
                }
            } else {
                flash('member_msg', 'من فضلك قم بتصحيح الاخطاء التالية ', 'alert alert-danger');
                $this->view('members/login', $data);
            }
        } else {
            //init data
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'national_id' => '',
                'password' => '',
                'national_id_error' => '',
                'password_error' => '',
            ];
            //load view
            $this->view('members/login', $data);
        }
    }

    /**
     * update member step1
     * @param integer $id
     */
    public function step1() {
        if (!$this->memberModel->isMemberLogged()) {
            flash('member_msg', 'ليس لديك الصلاحية لدخول هذه الصفحة ', 'alert alert-danger');
            redirect('members', TRUE);
        }
        $id = $_SESSION['member']->member_id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'national_id' => $_POST['national_id'],
                'full_name' => trim($_POST['full_name']),
                'password' => trim($_POST['password']),
                'password_repeat' => trim($_POST['password_repeat']),
                'birth_date' => trim($_POST['birth_date']),
                'educational_level' => trim($_POST['educational_level']),
                'ability_to_work' => trim($_POST['ability_to_work']),
                'social_status' => trim($_POST['social_status']),
                'health_status' => trim($_POST['health_status']),
                'national_id_error' => '',
                'full_name_error' => '',
                'password_error' => '',
                'password_repeat_error' => '',
                'birth_date_error' => '',
                'educational_level_error' => '',
                'ability_to_work_error' => '',
                'social_status_error' => '',
                'health_status_error' => ''
            ];
            // validate name
            if (empty($data['full_name'])) {
                $data['full_name_error'] = 'من فضلك اختار اسم للمستفيد';
            }
            // validate birth_date
            if (empty($data['birth_date'])) {
                $data['birth_date_error'] = 'من فضلك اختار تاريخ الميلاد';
            }
            // validate educational_level
            if (empty($data['educational_level'])) {
                $data['educational_level_error'] = 'من فضلك اختار المستوي التعليمي';
            }
            // validate ability_to_work
            if (empty($data['ability_to_work'])) {
                $data['ability_to_work_error'] = 'من فضلك اختار حالة القدرة علي العمل';
            }
            // validate social_status
            if (empty($data['social_status'])) {
                $data['social_status_error'] = 'من فضلك اختار  الحالة الاجتماعية';
            }
            // validate health_status
            if (empty($data['health_status'])) {
                $data['health_status_error'] = 'من فضلك اختار الحالة الصحية';
            }
            // Validate Password
            if ($data['password'] != $data['password_repeat']) {
                $data['password_repeat_error'] = 'من فضلك اعد كتابة كلمة المرور بشكل صحيح';
            }
            //make sure there is no errors
            if (empty($data['full_name_error']) && empty($data['birth_date_error']) && empty($data['educational_level_error']) && empty($data['ability_to_work_error']) && empty($data['social_status_error']) && empty($data['health_status_error']) && empty($data['password_repeat_error'])) {
                if (!empty($data['password'])) {// Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }
                //validated
                if ($this->memberModel->updateStep1($data)) {
                    flash('member_msg', 'تم التعديل بنجاح');
                    isset($_POST['next']) ? redirect('members/step2', TRUE) : redirect('members/step1', TRUE);
                } else {
                    flash('member_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('members/step1', $data);
            }
        } else {
            // featch members
            if (!$member = $this->memberModel->getMemberById($id)) {
                flash('member_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('members');
            }

            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'full_name' => $member->full_name,
                'national_id' => $member->national_id,
                'password' => '',
                'password_repeat' => '',
                'birth_date' => date('Y-m-d', $member->birth_date),
                'ability_to_work' => $member->ability_to_work,
                'social_status' => $member->social_status,
                'health_status' => $member->health_status,
                'educational_level' => $member->educational_level,
                'full_name_error' => '',
                'national_id_error' => '',
                'password_error' => '',
                'password_repeat_error' => '',
                'ability_to_work_error' => '',
                'social_status_error' => '',
                'health_status_error' => '',
                'birth_date_error' => '',
                'educational_level_error' => ''
            ];
            $this->view('members/step1', $data);
        }
    }

    /**
     * update member step2
     * @param integer $id
     */
    public function step2() {
        if (!$this->memberModel->isMemberLogged()) {
            flash('member_msg', 'ليس لديك الصلاحية لدخول هذه الصفحة ', 'alert alert-danger');
            redirect('members', TRUE);
        }
        $id = $_SESSION['member']->member_id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'housing_status' => trim($_POST['housing_status']),
                'housing_type' => trim($_POST['housing_type']),
                'region' => trim($_POST['region']),
                'regions' => $this->memberModel->getregions(),
                'city' => trim($_POST['city']),
                'cities' => $this->memberModel->getCities(),
                'district' => trim($_POST['district']),
                'street_address' => trim($_POST['street_address']),
                'unit_number' => trim($_POST['unit_number']),
                'additional_number' => NULL,
                'postal_code' => trim($_POST['postal_code']),
                'mail_box' => trim($_POST['mail_box']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'mobile' => trim($_POST['mobile']),
                'housing_status_error' => '',
                'housing_type_error' => '',
                'region_error' => '',
                'city_error' => '',
                'district_error' => '',
                'street_address_error' => '',
                'unit_number_error' => '',
                'additional_number_error' => '',
                'postal_code_error' => '',
                'mail_box_error' => '',
                'email_error' => '',
                'phone_error' => '',
                'mobile_error' => ''
            ];
            // validate name
            if (empty($data['housing_status'])) {
                $data['housing_status_error'] = 'من فضلك اختار حالة السكن';
            }
            // validate housing_type
            if (empty($data['housing_type'])) {
                $data['housing_type_error'] = 'من فضلك اختار نوع السكن';
            }
            // validate region
            if (empty($data['region'])) {
                $data['region_error'] = 'من فضلك اختار المنطقة';
            }
            // validate city
            if (empty($data['city'])) {
                $data['city_error'] = 'من فضلك اختار المدينة';
            }
            // validate district
            if (empty($data['district'])) {
                $data['district_error'] = 'من فضلك قم بكتابة الحي';
            }
            // validate mobile
            if (empty($data['mobile'])) {
                $data['mobile_error'] = 'لا يمكن ترك حقل رقم الجوال فارغا';
            }


            //make sure there is no errors
            if (empty($data['housing_status_error']) && empty($data['housing_type_error']) && empty($data['region_error']) && empty($data['city_error']) && empty($data['district_error']) && empty($data['mobile_error'])) {
                //validated
                if ($this->memberModel->updateStep2($data)) {
                    flash('member_msg', 'تم التعديل بنجاح');
                    isset($_POST['next']) ? redirect('members/step3', TRUE) : redirect('members/step2', TRUE);
                } else {
                    flash('member_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('members/step2', $data);
            }
        } else {
            // featch members
            if (!$member = $this->memberModel->getMemberById($id)) {
                flash('member_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('members');
            }

            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'housing_status' => $member->housing_status,
                'housing_type' => $member->housing_type,
                'region' => $member->region,
                'regions' => $this->memberModel->getregions(),
                'city' => $member->city,
                'cities' => $this->memberModel->getCities(),
                'district' => $member->district,
                'street_address' => $member->street_address,
                'unit_number' => $member->unit_number,
                'additional_number' => $member->additional_number,
                'postal_code' => $member->postal_code,
                'mail_box' => $member->mail_box,
                'email' => $member->email,
                'phone' => $member->phone,
                'mobile' => $member->mobile,
                'housing_status_error' => '',
                'housing_type_error' => '',
                'region_error' => '',
                'city_error' => '',
                'district_error' => '',
                'street_address_error' => '',
                'unit_number_error' => '',
                'additional_number_error' => '',
                'postal_code_error' => '',
                'mail_box_error' => '',
                'email_error' => '',
                'phone_error' => '',
                'mobile_error' => ''
            ];
            $this->view('members/step2', $data);
        }
    }

    /**
     * update member step3
     * @param integer $id
     */
    public function step3() {
        if (!$this->memberModel->isMemberLogged()) {
            flash('member_msg', 'ليس لديك الصلاحية لدخول هذه الصفحة ', 'alert alert-danger');
            redirect('members', TRUE);
        }
        $id = $_SESSION['member']->member_id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'bank_account' => trim($_POST['bank_account']),
                'bank_name' => trim($_POST['bank_name']),
                'bank_account_error' => '',
                'bank_name_error' => ''
            ];

            //make sure there is no errors
            if (empty($data['bank_account_error']) && empty($data['bank_name_error'])) {
                //validated
                if ($this->memberModel->updateStep3($data)) {
                    flash('member_msg', 'تم التعديل بنجاح');
                    isset($_POST['next']) ? redirect('members/step4', TRUE) : redirect('members/step3', TRUE);
                } else {
                    flash('member_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('members/step3', $data);
            }
        } else {
            // featch members
            if (!$member = $this->memberModel->getMemberById($id)) {
                flash('member_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('members');
            }

            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'bank_account' => $member->bank_account,
                'bank_name' => $member->bank_name,
                'bank_account_error' => '',
                'bank_name_error' => '',
            ];
            $this->view('members/step3', $data);
        }
    }

    /**
     * update member step4
     * @param integer $id
     */
    public function step4() {
        if (!$this->memberModel->isMemberLogged()) {
            flash('member_msg', 'ليس لديك الصلاحية لدخول هذه الصفحة ', 'alert alert-danger');
            redirect('members', TRUE);
        }
        $id = $_SESSION['member']->member_id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if (isset($_POST['addRelative'])) {
                $data = [
                    'pages' => $this->pagesModel->getPagesTitle(),
                    'member_id' => $id,
                    're_full_name' => trim($_POST['re_full_name']),
                    're_national_id' => trim($_POST['re_national_id']),
                    're_birth_date' => trim($_POST['re_birth_date']),
                    're_job_status' => trim($_POST['re_job_status']),
                    're_health_status' => trim($_POST['re_health_status']),
                    'status' => 0
                ];
                $msg = '';
                // validate name
                if (empty($data['re_full_name'])) {
                    $msg .= 'من فضلك اختار اسم التابع' . "<br/>";
                }
                // validate national_id
                if (empty($data['re_national_id'])) {
                    $msg .= 'من فضلك قم بكتابة رقم الهوية للتابع' . "<br/>";
                } else {
                    if ($this->memberModel->findRelativeByNId($data['re_national_id'], $id)) {
                        $msg .= 'تم التسجيل باستخدام هذا الرقم من قبل' . "<br/>";
                    } elseif (strlen($data['re_national_id']) != 10) {
                        $msg .= 'يجب كتابة رقم هوية للتابع بشكل صحيح' . "<br/>";
                    }
                }
                // validate birth date
                if (empty($data['re_birth_date'])) {
                    $msg .= 'من فضلك اختار تاريخ الميلاد' . "<br/>";
                }
                // validate job status
                if (empty($data['re_job_status'])) {
                    $msg .= 'من فضلك اختار حالة العمل للتابع' . "<br/>";
                }
                // validate name
                if (empty($data['re_health_status'])) {
                    $msg .= 'من فضلك اختار الحالة الصحية للتابع' . "<br/>";
                }
                if (empty($msg)) {
                    //validated
                    if ($addrelative = $this->memberModel->addRelative($data)) {
                        flash('member_msg', 'تم حفظ بيانات التابع بنجاح');
                        redirect('members/step4/', TRUE);
                    } else {
                        flash('member_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                    }
                } else {
                    flash('member_msg', $msg, 'alert alert-danger');
                    redirect('members/step4/', TRUE);
                }
                die();
            }
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'relatives' => $this->memberModel->getRelatives($id)
            ];

            //make sure there is no errors

            isset($_POST['next']) ? redirect('members/step5', TRUE) : redirect('members/step4', TRUE);
        } else {
            // featch members
            if (!$member = $this->memberModel->getMemberById($id)) {
                flash('member_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('members', TRUE);
            }

            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'relatives' => $this->memberModel->getRelatives($id)
            ];
            $this->view('members/step4', $data);
        }
    }

    /**
     * update member step5
     * @param integer $id
     */
    public function step5() {
        if (!$this->memberModel->isMemberLogged()) {
            flash('member_msg', 'ليس لديك الصلاحية لدخول هذه الصفحة ', 'alert alert-danger');
            redirect('members', TRUE);
        }
        $id = $_SESSION['member']->member_id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (isset($_POST['addIncome'])) {
                $data = [
                    'pages' => $this->pagesModel->getPagesTitle(),
                    'member_id' => $id,
                    'income_type' => trim($_POST['income_type']),
                    'income_source' => trim($_POST['income_source']),
                    'income_monthly' => trim($_POST['income_monthly']),
                    'income_yearly' => trim($_POST['income_yearly']),
                    'status' => 0
                ];
                $msg = '';
                // validate income_type
                if (empty($data['income_type'])) {
                    $msg .= 'من فضلك اضف نوع الدخل' . "<br/>";
                }
                // validate income_source
                if (empty($data['income_source'])) {
                    $msg .= 'من فضلك قم بكتابة مصدر الدخل' . "<br/>";
                }
                // validate income_monthly
                if (empty($data['income_monthly'])) {
                    $msg .= 'من فضلك اضف الدخل الشهري' . "<br/>";
                }
                // validate income_yearly
                if (empty($data['income_yearly'])) {
                    $msg .= 'من فضلك اضف الدخل السنوي' . "<br/>";
                }
                if (empty($msg)) {
                    //validated
                    if ($add = $this->memberModel->addIncome($data)) {
                        flash('member_msg', 'تم حفظ بيانات الدخل بنجاح');
                        redirect('members/step5', TRUE);
                    } else {
                        flash('member_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                    }
                } else {
                    flash('member_msg', $msg, 'alert alert-danger');
                    redirect('members/step5', TRUE);
                }
                die();
            }
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'incomes' => $this->memberModel->getIncomes($id),
            ];
        } else {
            // featch members
            if (!$member = $this->memberModel->getMemberById($id)) {
                flash('member_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('members', TRUE);
            }

            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'incomes' => $this->memberModel->getIncomes($id),
            ];
            $this->view('members/step5', $data);
        }
    }

    /**
     * update member step6
     * @param integer $id
     */
    public function step6() {
        if (!$this->memberModel->isMemberLogged()) {
            flash('member_msg', 'ليس لديك الصلاحية لدخول هذه الصفحة ', 'alert alert-danger');
            redirect('members', TRUE);
        }
        $id = $_SESSION['member']->member_id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (isset($_POST['addRealstate'])) {
                $data = [
                    'pages' => $this->pagesModel->getPagesTitle(),
                    'member_id' => $id,
                    'realstate_num' => trim($_POST['realstate_num']),
                    'realstate_region' => trim($_POST['realstate_region']),
                    'realstate_city' => trim($_POST['realstate_city']),
                    'realstate_own_percint' => trim($_POST['realstate_own_percint']),
                    'realstate_aria' => trim($_POST['realstate_aria']),
                    'status' => 1
                ];
                $msg = '';
                // validate name
                if (empty($data['realstate_num'])) {
                    $msg .= 'من فضلك اضف رقم الصك' . "<br/>";
                }
                // validate national_id
                if (empty($data['realstate_region'])) {
                    $msg .= 'من فضلك قم بأختيار المنطقة' . "<br/>";
                }
                // validate birth date
                if (empty($data['realstate_city'])) {
                    $msg .= 'من فضلك قم بأختيار المدينة' . "<br/>";
                }
                // validate job status
                if (empty($data['realstate_own_percint'])) {
                    $msg .= 'من فضلك اضف نسبة التملك' . "<br/>";
                }
                // validate name
                if (empty($data['realstate_aria'])) {
                    $msg .= 'من فضلك قم بكتابة مساحة العقار' . "<br/>";
                }
                if (empty($msg)) {
                    //validated
                    if ($add = $this->memberModel->addRealstate($data)) {
                        flash('member_msg', 'تم حفظ بيانات العقار بنجاح');
                        redirect('members/step6/', TRUE);
                    } else {
                        flash('member_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                    }
                } else {
                    flash('member_msg', $msg, 'alert alert-danger');
                    redirect('members/step6/', TRUE);
                }
                die();
            }
            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'realstates' => $this->memberModel->getRealstate($id),
                'regions' => $this->memberModel->getregions(),
                'cities' => $this->memberModel->getCities()
            ];
        } else {
            // featch members
            if (!$member = $this->memberModel->getMemberById($id)) {
                flash('member_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('members', TRUE);
            }

            $data = [
                'pages' => $this->pagesModel->getPagesTitle(),
                'member_id' => $id,
                'realstates' => $this->memberModel->getRealstate($id),
                'regions' => $this->memberModel->getregions(),
                'cities' => $this->memberModel->getCities()
            ];
            $this->view('members/step6', $data);
        }
    }

    /**
     * logging user out and clean session data
     */
    public function logout() {
        logout();
        redirect('members/login', TRUE);
    }

}
