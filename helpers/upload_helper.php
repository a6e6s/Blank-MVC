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
 * handling file upload
 * @param string $field_name input upload name
 * @param string $path
 * @param int $max_size
 * @param boolen $check_image
 * @param boolen $random_name
 * @return array @example $out['filepath'], $out['error'], $out['filename']
 */
function uploadImage($field_name = null, $path = 'media/', $max_size = 5000000, $check_image = true, $random_name = false) {

//Config Section    
//Set max file size in bytes
//Set default file extension whitelist
    $whitelist_ext = array('jpeg', 'jpg', 'png', 'gif', 'pdf');
//Set default file type whitelist
    $whitelist_type = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif','application/pdf');

//The Validation
// Create an array to hold any output
    $out = array('error' => null);

    if (!$field_name) {
        $out['error'][] = "Please specify a valid form field name";
    }

    if (!$path) {
        $out['error'][] = "Please specify a valid upload path";
    }

    if (count($out['error']) > 0) {
        return $out;
    }

//Make sure that there is a file
    if ((!empty($_FILES[$field_name])) && ($_FILES[$field_name]['error'] == 0)) {

// Get filename
        $file_info = pathinfo($_FILES[$field_name]['name']);
        $name = $file_info['filename'];
        $ext = $file_info['extension'];

//Check file has the right extension           
        if (!in_array($ext, $whitelist_ext)) {
            $out['error'][] = "امتداد غير مدعوم";
        }

//Check that the file is of the right type
        if (!in_array($_FILES[$field_name]["type"], $whitelist_type)) {
            $out['error'][] = "نوع الملف غير مدعوم";
        }

//Check that the file is not too big
        if ($_FILES[$field_name]["size"] > $max_size) {
            $out['error'][] = "حجم الملف اكبر من اللازم";
        }

//If $check image is set as true
        if ($check_image) {
            if (!getimagesize($_FILES[$field_name]['tmp_name'])) {
                $out['error'][] = "الملف المرفوع ليس صورة";
            }
        }

//Create full filename including path
        // Generate random filename
        $tmp = '_' . substr(md5(mt_rand()), 0, 5);
        if ($random_name) {

            if (!$tmp || $tmp == '') {
                $out['error'][] = "File must have a name";
            }
            $newname = $name . $tmp . '.' . $ext;
            $storename = iconv('utf-8', 'windows-1256', str_replace('ی', 'ي', $newname));
        } else {
            if (file_exists($path . $name . '.' . $ext)) {
                $newname = $name . '_' . rand(1, 20) . '.' . $ext;

                $storename = iconv('utf-8', 'windows-1256', str_replace('ی', 'ي', $newname));
            } else {
                $newname = $name . '.' . $ext;

                $storename = iconv('utf-8', 'windows-1256', str_replace('ی', 'ي', $newname));
            }
        }

//Check if file already exists on server
        if (file_exists($path . $newname)) {
            $out['error'][] = "A file with this name already exists";
        }

        if (count($out['error']) > 0) {
            //The file has not correctly validated
            return $out;
        }

        if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $path . $storename)) {
            //Success
            $out['filepath'] = $path;
            $out['filename'] = $newname;
            $out['storename'] = $storename;
            return $out;
        } else {
            $out['error'][] = "Server Error!";
        }
    } else {
        $out['error']['nofile'] = "No file uploaded";
        return $out;
    }
}
