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

session_start();

/**
 * storing flash message into the session and retrive it whene it called
 * @param string name
 * @param string text message
 * @param string css class
 * @example Store- flash('register_success','You are now registeres')
 * @example View- echo flash('register_success')
 */
function flash($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash" role="alert">' . $_SESSION[$name] . '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

/**
 * logging user out and clean session data
 */
function logout() {
    unset($_SESSION['memberLogged']);
    unset($_SESSION['donorLogged']);
    unset($_SESSION['user']);
    unset($_SESSION['group']);
    unset($_SESSION['filemanage']);
    session_destroy();
    session_start();
}


