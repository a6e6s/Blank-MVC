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

    </head>
    <body class="login">
        <br/><br/><br/>
        <div class="col-lg-3 col-xs-2"></div>
        <div class="col-lg-6 col-xs-8 btn btn-default">
            <div class="login_wrapper h1 text-center">
                <i class="fa fa-ban  fa-5x text-danger"></i>
                <p>حدث خطأ </p><br/>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <?php flash('user_msg'); ?>
                    <p class="info"> للعودة الي الصفحة الرئيسية <strong><a href="<?php echo ADMINURL ?>">اضغط هنا</a></strong> </p>
                    <p> للرجوع مرة اخري <strong><a onclick="window.history.back();">اضغط هنا</a></strong></p><br/>
                </div>
            </div>

        </div>
        <div class="col-lg-3 col-xs-2"></div>
        <!-- jQuery -->
        <script src="<?php echo ADMINURL; ?>/template/default/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo ADMINURL; ?>/template/default/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo ADMINURL; ?>/template/default/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="<?php echo ADMINURL; ?>/template/default/vendors/nprogress/nprogress.js"></script>
        <!-- iCheck -->
        <script src="<?php echo ADMINURL; ?>/template/default/vendors/iCheck/icheck.min.js"></script>
        <!-- jQuery Smart Wizard -->
        <script src="<?php echo ADMINURL; ?>/template/default/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
        <!-- Custom Theme Scripts -->
        <script src="<?php echo ADMINURL; ?>/template/default/js/custom.min.js"></script>
    </body>
</html>
