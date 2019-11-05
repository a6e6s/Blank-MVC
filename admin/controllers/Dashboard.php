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

class Dashboard extends ControllerAdmin {

    public function __construct() {
        
    }

    /**
     * loading index view with latest groups
     */
    public function index() {
        $data = [
            'header' => '',
            'title' => 'لوحة التحكم',
            'footer' => ''
        ];
        $this->view('dashboard/index', $data);
    }

}
