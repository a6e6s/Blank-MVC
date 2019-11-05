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
            <div class="login_wrapper">
                <div class="animate form login_form profile_details ">
                    <?php flash('user_msg'); ?>
                    <div class="col-lg-12 profile_details">
                        <div class="well profile_view">
                            <form class="login_content" action="<?php echo ADMINURL . '/users/login/'; ?>" method="post">
                                <div class="col-sm-12">
                                    <h4 class="brief"> تسجيل الدخول</h4><br />
                                    <div><i class="fa fa-lock fa-5x"></i></div>
                                    <br />
                                    <div class=" text-left col-md-12 form-group <?php echo (!empty($data['email_error'])) ? 'has-error' : ''; ?>">
                                        <div class="has-feedback">
                                            <input type="email" id="email" class="form-control" name="email" placeholder="بريد المستخدم" value="<?php echo $data['email']; ?>">
                                            <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block"><?php echo $data['email_error']; ?></span>
                                        </div>
                                    </div>
                                    <div class=" text-left col-md-12 form-group <?php echo (!empty($data['password_error'])) ? 'has-error' : ''; ?>">
                                        <div class="has-feedback">
                                            <input type="password" id="password" class="form-control" name="password" placeholder="كلمة المرور" value="<?php echo $data['password']; ?>">
                                            <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block"><?php echo $data['password_error']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 bottom">
                                    <input class="btn btn-primary" value="تسجيل الدخول" name="login" type="submit" />
                                    <a class="reset_pass" href="<?php echo ADMINURL . '/users/forget/'; ?>">نسيت كلمة المرور ؟</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
