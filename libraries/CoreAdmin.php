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

/**
 * create URL & Loads Core controller
 * @example URL format -/controller/method/params
 */
class CoreAdmin {

    protected $currentController = 'Dashboard';
    protected $currentMethod = 'index';
    protected $parms = [];

    public function __construct() {

        $this->hasPermissions();
        $url = $this->getUrl();

//look in controller fot the controller existing and instantiat it
        if (file_exists('../admin/controllers/' . ucfirst($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
//unset 0 index
            unset($url[0]);
        }
//require the controller
        require_once '../admin/controllers/' . $this->currentController . '.php';
//init controller
        $this->currentController = new $this->currentController;

//looking for the method exist in the current controller and loading it as a page
//checking second part of the url
        if (isset($url[1])) {
// check if method exist
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
            }
            unset($url[1]);
        }


//get params
        $this->parms = $url ? array_values($url) : [];
//call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->parms);
    }

    /**
     * @param string $_get URL
     * @return string url
     * 
     */
    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

    /**
     * check for user premession before accessing or trigger any action
     * 
     */
    public function hasPermissions() {
        $url = $this->getUrl();
        //prepare controller and methoud
        isset($url[0]) ? $controller = ucfirst($url[0]) : $controller = 'Dashboard';
        isset($url[1]) ? $method = $url[1] : $method = 'index';
        //convert post request to a method
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            isset($_POST['search']) ? $method = 'search' : '';
            isset($_POST['delete']) ? $method = 'delete' : '';
            isset($_POST['publish']) ? $method = 'status' : '';
            isset($_POST['unpublish']) ? $method = 'status' : '';
        }
        $status = [ 'publish', 'unpublish', 'relativedelete', 'relativeblock', 'relativeactive','incomeDelete','realstateDelete'];
        in_array($method, $status) ? $method = 'status' : '';
        // check if user logged in
        if (isset($_SESSION['user'])) {
            //check if user is blocked
            if ($_SESSION['user']->status != 1) {
                logout();
                flash('user_msg', 'لا تملك صلاحية الدخول حيث ان الحساب الخاص بك محظور', 'alert alert-warning');
                redirect('users/error');
                //check if user group is blocked
            } elseif ($_SESSION['group']->status != 1) {
                logout();
                flash('user_msg', 'لا تملك صلاحية الدخول حيث ان المجموعة الخاصة بك محظورة ', 'alert alert-warning');
                redirect('users/error');
                //check if user have access to admin area
            } elseif ($_SESSION['permissions']->admin_login->view != 1) {
                logout();
                flash('user_msg', 'لا تملك صلاحية الدخول لوحة التحكم ', 'alert alert-warning');
                redirect('users/error');
            }
            //check if user can access the current controller
            if ($controller != 'Dashboard') {
                // check if user can access current view and he is not on the error or logout page
                if (!array_key_exists($method, $_SESSION['permissions']->$controller) && $method != 'error' && $method != 'logout') {
                    flash('user_msg', 'عذرا هذا الفعل ليس جزء من صلاحياتك', 'alert alert-danger');
                    redirect('users/error');
                }
            } elseif ($controller == 'Dashboard') {
                //if user logged in and have access to admin area he can view the dashboard
            } else {
                flash('user_msg', 'لا تملك صلاحية الدخول الي هذه الصفحة ', 'alert alert-danger');
                redirect('users/error');
            }
        } elseif ($url[0] == 'users' && $method == 'login') {
            //if the user not in the login page
        } elseif ($url[0] == 'users' && $method == 'error') {
            //if the user not in the error page
        } elseif ($url[0] == 'users' && $method == 'forget') {
            //if the user not in the forget password page
        } elseif ($url[0] == 'users' && $method == 'reset') {
            //if the user not in the reset password page
        } else {
            //if user doesn't have permission
            flash('user_msg', 'لا يمكنك عرض هذه الصفحة يرجي تسجيل الدخول اولا ', 'alert alert-danger');
            redirect('users/login');
        }
    }

}
