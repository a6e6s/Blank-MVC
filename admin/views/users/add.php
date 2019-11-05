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
            <h3><?php echo $data['page_title']; ?> <small>اضافة  مستخدم جديد </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/users" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <form action="<?php echo ADMINURL . '/users/add'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" >
            <div class="col-md-6 col-xs-12 form-group <?php echo (!empty($data['name_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label" for="pageTitle">اسم المستخدم : </label>
                <div class="has-feedback">
                    <input type="text" id="pageTitle" class="form-control" name="name" placeholder="اسم المستخدم" value="<?php echo $data['name']; ?>">
                    <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block"><?php echo $data['name_error']; ?></span>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 form-group <?php echo (!empty($data['email_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label" for="email">البريد الالكتروني : </label>
                <div class="has-feedback">
                    <input type="email" id="email" class="form-control" name="email" placeholder="بريد المستخدم" value="<?php echo $data['email']; ?>">
                    <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block"><?php echo $data['email_error']; ?></span>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 form-group <?php echo (!empty($data['password_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label" for="password">كلمة المرور : </label>
                <div class="has-feedback">
                    <input type="password" id="password" class="form-control" name="password" placeholder="كلمة المرور" value="<?php echo $data['password']; ?>">
                    <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block"><?php echo $data['password_error']; ?></span>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 form-group <?php echo (!empty($data['password_repeat_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label" for="password_repeat">اعادة كلمة المرور: </label>
                <div class="has-feedback">
                    <input type="password" id="password_repeat" class="form-control" name="password_repeat" placeholder="كلمة المرور" value="<?php echo $data['password_repeat']; ?>">
                    <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block"><?php echo $data['password_repeat_error']; ?></span>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 form-group">
                <label class="control-label" for="mobile">رقم الجوال : </label>
                <div class="has-feedback">
                    <input type="text" id="mobile" class="form-control" name="mobile" placeholder="رقم الجوال" value="<?php echo $data['mobile']; ?>">
                    <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 form-group <?php echo (!empty($data['image_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label" for="imageUpload">صورة المستخدم : </label>
                <div class="has-feedback input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                        <input name="image" value="<?php echo ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                    </span>
                    <span class="form-control"><small><?php echo empty($data['image']) ? 'قم بأختيار صورة مناسبة' : $data['image']; ?></small></span>
                    
                </div>
                <div class="help-block"><?php echo $data['image_error']; ?></div>
            </div>

            <div class="col-md-6 col-xs-12 form-group <?php echo (!empty($data['group_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label">المجموعه</label>
                <div class="has-feedback select2-dropdown">
                    <select name="group_id" class="form-control">
                        <option value="">اختار مجموعة للمستخدم </option>
                        <?php foreach ($data['groupList'] as $group): ?>                             
                            <option value="<?php echo $group->group_id; ?>" <?php echo ($group->group_id == $data['group_id']) ? " selected " : ''; ?>>
                                <?php echo $group->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="fa fa-group form-control-feedback" aria-hidden="true"></span>
                </div>
                <span class="help-block"><?php echo $data['group_error']; ?></span>
            </div>

            <div class="col-md-6 col-xs-12 form-group <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label">حالة المستخدم :</label>
                <div class="radio">
                    <label>
                        <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> نشط
                    </label>
                    <label>
                        <input type="radio" class="flat" <?php echo ($data['status'] == '0') ? 'checked' : ''; ?> value="0" name="status"> محظور
                    </label>
                    <span class="help-block"><?php echo $data['status_error']; ?></span>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="control-label">نبذه عني  : </label>
                <div class="row">
                    <textarea name="bio" id="ckeditor" class="ckeditor form-control"><?php echo ($data['bio']); ?></textarea>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-12">
                <button type="submit" name="submit" class="btn btn-success">أضف   <i class="fa fa-save"> </i></button>
                <button type="reset" class="btn btn-danger">مسح   <i class="fa fa-trash "> </i></button>
            </div>

        </form>


    </div>
</div>
<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';


require ADMINROOT . '/views/inc/footer.php';
