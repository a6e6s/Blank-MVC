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
    <?php flash('group_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>اضافة  مجموعة جديدة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/groups" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <form action="<?php echo ADMINURL . '/groups/add'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" >
                <div class="form-group <?php echo (!empty($data['name_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="pageTitle">اسم المجموعة : </label>
                    <div class="has-feedback">
                        <input type="text" id="pageTitle" class="form-control" name="name" placeholder="اسم المجموعة" value="<?php echo $data['name']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['name_error']; ?></span>
                    </div>
                </div>
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label">وصف المجموعة  : </label>
                    <div class="row">
                        <textarea name="description" class="form-control"><?php echo ($data['description']); ?></textarea>
                    </div>
                </div>
                <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label">حالة المجموعة :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> مفعلة
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == '0') ? 'checked' : ''; ?> value="0" name="status"> معطلة
                        </label>
                        <span class="help-block"><?php echo $data['status_error']; ?></span>
                    </div>
                </div>
                <h2 class="page-header col-lg-12">الصلاحيات</h2>
                <div class="form-group col-lg-12">
                    <label class="control-label ">الدخول الي لوحة التحكم : </label>
                    <div class="radio">
                        <label class="">
                            <input type="radio" class="flat" value="1" name="permissions[admin_login][view]" checked="checked"> السماح 
                        </label>
                        <label class="">
                            <input type="radio" class="flat" value="0" name="permissions[admin_login][view]"> عدم السماح
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <label onclick="selectAll()" class=" col-sm-2 btn btn-success"> تحديد الكل</label>
                    <div class="col-sm-1"></div>
                    <label onclick="selectNon()" class=" col-sm-2 btn btn-success"> الغاء تحديد الكل</label>
                    <script>
                        function selectAll() {
                            $('.prevlages input[type="checkbox"]').prop("checked", "checked");
                            $('.icheckbox_flat-green').addClass("checked");
                        }
                        function selectNon() {
                            $('.prevlages input[type="checkbox"]').removeAttr('checked');
                            $('.icheckbox_flat-green').removeClass("checked");
                        }
                    </script>
                </div>
                <hr class="clear" />
                <?php
                //get the apps from controller directory 
                $apps = array_diff(scandir(ADMINROOT . '/controllers'), ['.', '..']);
                // get the permissions and decode it to object value
                $data['permissions'] = json_decode($data['permissions']);

                foreach ($apps as $app) :

                    if ($app == 'Dashboard.php') {
                        continue;
                    }
                    $app = str_replace('.php', '', $app);
                    ?>
                    <div class="form-group col-lg-2 col-md-3 col-sm-4 col-xs-6 prevlages">
                        <h2 class=""><?php echo ucfirst($app); ?> : </h2>
                        <ul class="to_do">
                            <li>
                                <p><input type="checkbox" <?php echo isset($data['permissions']->$app->index) ? 'checked' : ''; ?> class="flat" value="1" name="permissions[<?php echo $app; ?>][index]"> عرض الرئيسية </p>
                            </li>
                            <li>
                                <p><input type="checkbox" <?php echo isset($data['permissions']->$app->search) ? 'checked' : ''; ?> class="flat" value="1" name="permissions[<?php echo $app; ?>][search]"> البحث والفلترة </p>
                            </li>
                            <li>
                                <p><input type="checkbox" <?php echo isset($data['permissions']->$app->show) ? 'checked' : ''; ?> class="flat" value="1" name="permissions[<?php echo $app; ?>][show]"> عرض المحتوي </p>
                            </li>
                            <li>
                                <p><input type="checkbox" <?php echo isset($data['permissions']->$app->status) ? 'checked' : ''; ?> class="flat" value="1" name="permissions[<?php echo $app; ?>][status]"> تغيير الحالة </p>
                            </li>
                            <li>
                                <p><input type="checkbox" <?php echo isset($data['permissions']->$app->add) ? 'checked' : ''; ?> class="flat" value="1" name="permissions[<?php echo $app; ?>][add]"> اضافة جديد </p>
                            </li>
                            <li>
                                <p><input type="checkbox" <?php echo isset($data['permissions']->$app->edit) ? 'checked' : ''; ?> class="flat" value="1" name="permissions[<?php echo $app; ?>][edit]"> التعديل </p>
                            </li>
                            <li>
                                <p><input type="checkbox" <?php echo isset($data['permissions']->$app->delete) ? 'checked' : ''; ?> class="flat" value="1" name="permissions[<?php echo $app; ?>][delete]"> الحذف </p>
                            </li>
                        </ul>
                    </div>
<?php endforeach; ?>





                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">أضف   <i class="fa fa-save"> </i></button>
                    <button type="reset" class="btn btn-danger">مسح   <i class="fa fa-trash "> </i></button>
                </div>

            </form>

        </div>
    </div>
</div>
<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';


require ADMINROOT . '/views/inc/footer.php';
