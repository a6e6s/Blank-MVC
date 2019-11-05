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

class Groups extends ControllerAdmin
{

    private $groupModel;

//    private $userModel;

    public function __construct()
    {
        $this->groupModel = $this->model('Group');
    }

    /**
     * loading index view with latest groups
     */
    public function index($current = '', $perpage = 50)
    {
        // get groups
        $cond = 'WHERE status <> 2 ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->groupModel->deleteById($_POST['record'], 'group_id')) {
                        flash('group_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('group_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('groups');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->groupModel->publishById($_POST['record'], 'group_id')) {
                        flash('group_msg', 'تم تفعيل المجموعة ' . $row_num . ' بنجاح');
                    } else {
                        flash('group_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('groups');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->groupModel->unpublishById($_POST['record'], 'group_id')) {
                        flash('group_msg', 'تم تعليق المجموعة ' . $row_num . ' بنجاح');
                    } else {
                        flash('group_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('groups');
            }
        }

        //handling search
        // if user make a search
        if (isset($_POST['search'])) {
            // return to first
            $current = 1;
            $searches = $this->groupModel->handlingSearchCondition(['name', 'description', 'status']);
            $cond .= $searches['cond'];
            $bind = $searches['bind'];

        } else {
            // if user didn't search
            // look for pagenation if not clear seassion
            if (empty($current)) {
                unset($_SESSION['search']);
                // if there is pagenation and value stored into session get it and prepare Condition and bind
            } else {
                $searches = $this->groupModel->handlingSearchSessionCondition(['name', 'description', 'status']);
                $cond .= $searches['cond'];
                $bind = $searches['bind'];
            }
        }

        // get all records cout after search and filtration
        $recordsCount = $this->groupModel->allGroupsCount($cond, $bind);
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
        //get all records for current group
        $groups = $this->groupModel->getGroups($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'المجموعات والصلاحيات',
            'groups' => $groups,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('groups/index', $data);
    }

    /**
     * adding new group
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'page_title' => 'المجموعات والصلاحيات',
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'permissions' => json_encode($_POST['permissions']),
                'status' => '',
                'status_error' => '',
                'name_error' => '',
            ];

            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة المجموعة';
            }
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'من فضلك اختار اسم للمجموعة';
            }
//             mack sue there is no errors
            if (empty($data['status_error']) && empty($data['name_error'])) {
                //validated
                if ($this->groupModel->addGroup($data)) {
                    flash('group_msg', 'تم الحفظ بنجاح');
                    redirect('groups');
                } else {
                    flash('group_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('groups/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'المجموعات والصلاحيات',
                'name' => '',
                'description' => '',
                'permissions' => '',
                'status' => 0,
                'name_error' => '',
                'status_error' => '',
            ];
        }

        //loading the add group view
        $this->view('groups/add', $data);
    }

    /**
     * update group
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'group_id' => $id,
                'page_title' => 'المجموعات والصلاحيات',
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'permissions' => json_encode($_POST['permissions']),
                'status' => trim($_POST['status']),
                'status_error' => '',
                'name_error' => '',
            ];

            // validate status
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة المجموعة';
            }
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'من فضلك اختار اسم للمجموعة';
            }
//             mack sue there is no errors
            if (empty($data['status_error']) && empty($data['name_error'])) {
                //validated
                if ($this->groupModel->updateGroup($data)) {
                    flash('group_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('groups/edit/' . $id) : redirect('groups');
                } else {
                    flash('group_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('groups/add', $data);
            }
        } else {
            // featch group
            if (!$group = $this->groupModel->getGroupById($id)) {
                flash('group_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('groups');
            }

            $data = [
                'group_id' => $id,
                'page_title' => 'المجموعات والصلاحيات',
                'name' => $group->name,
                'description' => $group->description,
                'permissions' => $group->permissions,
                'status' => $group->status,
                'name_error' => '',
                'status_error' => '',
            ];
            $this->view('groups/edit', $data);
        }
    }

    /**
     * showing group details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$group = $this->groupModel->getGroupById($id)) {
            flash('group_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('groups');
        }
        $data = [
            'page_title' => 'المجموعات والصلاحيات',
            'group' => $group,
        ];
        $this->view('groups/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->groupModel->deleteById([$id], 'group_id')) {
            flash('group_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('group_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('groups');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->groupModel->publishById([$id], 'group_id')) {
            flash('group_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('group_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('groups');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->groupModel->unpublishById([$id], 'group_id')) {
            flash('group_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('group_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('groups');
    }

}
