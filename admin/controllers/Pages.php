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

class Pages extends ControllerAdmin {

    private $pageModel;

    public function __construct() {
        $this->pageModel = $this->model('Page');
    }

    /**
     * loading index view with latest pages
     */
    public function index($current = '', $perpage = 50) {
        // get pages
        $cond = 'WHERE status <> 2 ';
        $bind = [];
      
        //check user action if the form has submitted 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->pageModel->deleteById($_POST['record'], 'page_id')) {
                        flash('page_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('page_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('pages');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->pageModel->publishById($_POST['record'], 'page_id')) {
                        flash('page_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('page_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('pages');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->pageModel->unpublishById($_POST['record'], 'page_id')) {
                        flash('page_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('page_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('pages');
            }
        }

        //handling search
        // if user make a search
        if (isset($_POST['search'])) {
            // return to first 
            $current = 1;
            $searches = $this->pageModel->handlingSearchCondition(['title', 'status']);
            $cond .= $searches['cond'];
            $bind = $searches['bind'];

        } else {
            // if user didn't search
            // look for pagenation if not clear seassion
            if (empty($current)) {
                unset($_SESSION['search']);
                // if there is pagenation and value stored into session get it and prepare Condition and bind
            } else {
                $searches = $this->pageModel->handlingSearchSessionCondition(['title', 'status']);
                $cond .= $searches['cond'];
                $bind = $searches['bind'];
            }
        }

        // get all records count after search and filtration 
        $recordsCount = $this->pageModel->allPagesCount($cond, $bind);
        // make sure its integer value and its usable
        $current = (int) $current;
        $perpage = (int) $perpage;

        ($perpage == 0) ? $perpage = 20 : NULL;
        if ($current <= 0 || $current > ceil($recordsCount->count / $perpage)) {
            $current = 1;
            $limit = 'LIMIT 0 , :perpage ';
            $bindLimit[':perpage'] = $perpage;
        } else {
            $limit = 'LIMIT  ' . (( $current - 1) * $perpage) . ', :perpage';
            $bindLimit[':perpage'] = $perpage;
        }
        //get all records for current page
        $pages = $this->pageModel->getPages($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الصفحات',
            'pages' => $pages,
            'recordsCount' => $recordsCount->count,
            'footer' => ''
        ];
        $this->view('pages/index', $data);
    }

    /**
     * adding new page
     */
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $content = $this->pageModel->cleanHTML($_POST['content']);
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'page_title' => 'الصفحات',
                'title' => trim($_POST['title']),
                'content' => $content,
                'image' => '',
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => '',
                'status_error' => '',
                'image_error' => ''
            ];

            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, TRUE);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
//             mack sue there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated 
                if ($this->pageModel->addPage($data)) {
                    flash('page_msg', 'تم الحفظ بنجاح');
                    redirect('pages');
                } else {
                    flash('page_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('pages/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'الصفحات',
                'title' => '',
                'content' => '',
                'image' => '',
                'meta_keywords' => '',
                'meta_description' => '',
                'status' => 0,
                'title_error' => '',
                'status_error' => '',
                'image_error' => '',
            ];
        }

        //loading the add page view
        $this->view('pages/add', $data);
    }

    /**
     * update page
     * @param integer $id
     */
    public function edit($id) {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //cleare html content from malicious
            $content = $this->pageModel->cleanHTML($_POST['content']);
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'page_id' => $id,
                'page_title' => 'الصفحات',
                'title' => trim($_POST['title']),
                'content' => $content,
                'image' => '',
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => '',
                'status_error' => '',
                'image_error' => ''
            ];

            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, TRUE);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
//             mack sue there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated 
                if ($this->pageModel->updatePage($data)) {
                    flash('page_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('pages/edit/' . $id) : redirect('pages');
                } else {
                    flash('page_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('pages/edit', $data);
            }
        } else {
            // featch page       
            if (!$page = $this->pageModel->getPageById($id)) {
                flash('page_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('pages');
            }

            $data = [
                'page_title' => 'الصفحات',
                'page_id' => $id,
                'title' => $page->title,
                'content' => $page->content,
                'image' => $page->image,
                'meta_keywords' => $page->meta_keywords,
                'meta_description' => $page->meta_description,
                'status' => $page->status,
                'title_error' => '',
                'status_error' => '',
                'image_error' => '',
            ];
            $this->view('pages/edit', $data);
        }
    }

    /**
     * showing page details
     * @param integer $id
     */
    public function show($id) {
        if (!$page = $this->pageModel->getPageById($id)) {
            flash('page_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('pages');
        }
        $data = [
            'page_title' => 'الصفحات',
            'page' => $page
        ];
        $this->view('pages/show', $data);
    }

    /**
     * delete record by id 
     * @param integer $id
     */
    public function delete($id) {
        if ($row_num = $this->pageModel->deleteById([$id],'page_id')) {
            flash('page_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('page_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('pages');
    }

    /**
     * publish record by id 
     * @param integer $id
     */
    public function publish($id) {
        if ($row_num = $this->pageModel->publishById([$id],'page_id')) {
            flash('page_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('page_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('pages');
    }

    /**
     * publish record by id 
     * @param integer $id
     */
    public function unpublish($id) {
        if ($row_num = $this->pageModel->unpublishById([$id],'page_id')) {
            flash('page_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('page_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('pages');
    }

}
