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
 * this is the base controller
 * Loading models and views
 */
class Controller {

    function __construct() {
        
    }

    /**
     * load model
     * @param string $model
     * @return object 
     */
    public function model($model) {
        // require model file
        require_once '../app/models/' . $model . '.php';
        //instatiate model
        return new $model();
    }

    /**
     * loading view
     * @param string $view
     * @param array $data
     */
    public function view($view, $data = []) {
        // check for the view file
        if (file_exists('../app/views/' . $view . ".php")) {
            require_once '../app/views/' . $view . ".php";
        } else {
            die('view does not exist');
        }
    }

}
