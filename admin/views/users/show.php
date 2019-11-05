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

// loading plugin style
$data['header'] = '';
header("Content-Type: text/html; charset=utf-8");

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('user_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض تفاصيل المستخدم </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/users" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="col-lg-12 col-sm-12 col-xs-12 profile_details">
        <div class="col-lg-12 col-sm-12 col-xs-12 well profile_view">
            <div class="col-sm-12">
                <div class="right col-xs-5 text-center">
                    <img src="<?php echo MEDIAURL . '/' . $data['user']->image; ?>" alt="" class="img-circle img-responsive">
                </div>
                <div class="left col-xs-7">
                    <h2 class=" x_title"><?php echo $data['user']->name; ?></h2>
                    <p class="h5"><i class="fa fa-edit"></i> <strong>عن المستخدم : </strong><?php echo $data['user']->bio; ?></p>
                    <p class="h5"><i class="fa fa-envelope"></i> <strong>البريد الالكتروني : </strong><?php echo $data['user']->email; ?></p>
                    <p class="h5"><i class="fa fa-mobile"></i> <strong>الجوال : </strong><?php echo $data['user']->mobile; ?></p>
                    <p class="h5"><i class="fa fa-toggle-on"></i> <strong>حالة المستخدم : </strong>
                        <?php
                        if ($data['user']->status == 1) {
                            echo '<span class="btn btn-sm btn-success">نشط</span>';
                        } elseif ($data['user']->status == 0) {
                            echo '<span class="btn btn-sm btn-warning">محظور</span>';
                        } else {
                            echo '<span class="btn btn-sm btn-danger">محذوف</span>';
                        }
                        ?>
                    </p>
                    <p class="h5"><i class="fa fa-group"></i> <strong>مجموعة المستخدم : </strong><?php echo $data['user']->usergroup; ?></p>
                    <p class="h5"><i class="fa fa-calendar"></i> <strong>مسجل منذ : </strong><?php echo date('Y/ m/ d | H:i a', $data['user']->create_date); ?></p>
                    <p class="h5"><i class="fa fa-calendar"></i> <strong>اخر دخول : </strong><?php echo date('Y/ m/ d | H:i a', $data['user']->login_date); ?></p>

                </div>
            </div>
            <div class="col-lg-12 bottom text-right">
                <span class="col-lg-12">
                <a  href="<?php echo ADMINURL . '/users/edit/' . $data['user_id']; ?>" class="btn btn-primary">
                    <i class="fa fa-edit"></i> تعديل 
                </a> 
                </span>
            </div>
        </div>
    </div>

</div>

<?php
// loading plugin
$data['footer'] = '';


require ADMINROOT . '/views/inc/footer.php';
