<!DOCTYPE html>
<!--
Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License
@license    https://opensource.org/licenses/GPL-3.0

@package    Easy CMS MVC framework
@author     Ahmed Elmahdy
@link       https://ahmedx.com

For more information about the author , see <http://www.ahmedx.com/>.
-->
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo SITENAME; ?> </title>

        <!-- Bootstrap -->
        <link href="<?php echo ADMINURL; ?>/template/default/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo ADMINURL; ?>/template/default/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo ADMINURL; ?>/template/default/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link href="<?php echo ADMINURL; ?>/template/default/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?php echo ADMINURL; ?>/template/default/css/custom.min.css" rel="stylesheet">
        <?php echo $data['header']; ?>
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php
                require ADMINROOT . '/views/inc/navbar.php';
                