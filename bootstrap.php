<?php

/**
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
// loading configration
require_once 'config/config.php';

//loading helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/upload_helper.php';
require_once 'helpers/string_helper.php';




// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once 'libraries/' . $className . '.php';
});

