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
            <h3><?php echo $data['page_title']; ?> <small>عرض تفاصيل المجموعة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/groups" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 page-header">
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label class="control-label">اسم المجموعة  : </label>
                <div class="bg-white">
                    <?php echo ($data['group']->name); ?>
                </div>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label class="control-label">وصف المجموعة  : </label>
                <div class="bg-white">
                    <?php echo ($data['group']->description); ?>
                </div>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">حالة المجموعة :</label>
                <div class="radio">
                    <label> 
                        <?php
                        switch ($data['group']->status) {
                            case 2:echo '<span class="btn btn-danger">محذوفة</span>';
                                break;
                            case 1:echo '<span class="btn btn-success">مفعلة</span>';
                                break;
                            case 0:echo '<span class="btn btn-warning">معطلة</span>';
                                break;
                            default:
                                break;
                        }
                        ?>
                </div>
                </label>
            </div>
            <h2 class="page-header col-lg-12">الصلاحيات</h2>
            <div class="form-group col-lg-12">
                <label class="control-label ">الدخول الي لوحة التحكم : </label>
                <div class="radio">
                    <?php
                    // get the permissions and decode it to object value
                    $data['group']->permissions = json_decode($data['group']->permissions);
                    ?>
                    <label class="btn btn-info">
                        <?php echo empty($data['group']->permissions->admin_login->view) ? 'عدم السماح ' : ' السماح'; ?>  
                    </label>
                </div>
            </div>
            <hr class="clear" />
            <?php
            //get the apps from controller directory 
            $apps = array_diff(scandir(ADMINROOT . '/controllers'), ['.', '..']);

            foreach ($apps as $app) :
                $app = str_replace('.php', '', $app);
                ?>
                <div class="form-group col-lg-2 col-md-3 col-sm-4 col-xs-6 prevlages">
                    <h2 class=""><?php echo ucfirst($app); ?> : </h2>
                    <ul class="to_do">
                        <?php
                        if (isset($data['group']->permissions->$app->index)) {
                            echo '<li><p> عرض الرئيسية</p></li>';
                        }
                        if (isset($data['group']->permissions->$app->search)) {
                            echo '<li><p> البحث والفلترة</p></li>';
                        }
                        if (isset($data['group']->permissions->$app->show)) {
                            echo '<li><p> عرض المحتوي</p></li>';
                        }
                        if (isset($data['group']->permissions->$app->status)) {
                            echo '<li><p> تغيير الحالة</p></li>';
                        }
                        if (isset($data['group']->permissions->$app->add)) {
                            echo '<li><p> اضافة جديد</p></li>';
                        }
                        if (isset($data['group']->permissions->$app->edit)) {
                            echo '<li><p> التعديل</p></li>';
                        }
                        if (isset($data['group']->permissions->$app->delete)) {
                            echo '<li><p> الحذف</p></li>';
                        }
                        ?>
                    </ul>
                </div>
            <?php endforeach; ?>

        </div>
        
            <div class="form-group">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/groups/edit/' . $data['group']->group_id; ?>" >تعديل</a>
            </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';


require ADMINROOT . '/views/inc/footer.php';
