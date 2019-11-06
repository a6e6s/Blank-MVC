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

//Database Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blank-mvc');
define('VERSION', '1.0.0');

//app root
define('APPROOT', dirname(dirname(__FILE__)));

// domain
define('DOMAIN', 'http://localhost');

// site folder "leave it blank if its on the main domain"
define('SITEFOLDER', '/Blank-MVC');

// url root
define('URLROOT', DOMAIN . SITEFOLDER);

// Media FOLDER
define('MEDIAFOLDER', '/media/images');

// Media url root
define('MEDIAURL', URLROOT . '/media/images');

//admin root
define('ADMINROOT', dirname(dirname(__FILE__)) . '/admin');

// Admin url root
define('ADMINURL', URLROOT . '/admin');
// site name
define('SITENAME', 'blank MVC');

//default language
define('DEFAULT_LANGUAGE', 'ar');
