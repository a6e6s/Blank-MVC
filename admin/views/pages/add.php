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
    <?php flash('page_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>اضافة  صفحة جديدة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/pages" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <form action="<?php echo ADMINURL . '/pages/add'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" >
                <div class="form-group">
                    <label class="control-label" for="pageTitle">عنوان الصفحة : </label>
                    <div class="has-feedback">
                        <input type="text" id="pageTitle" class="form-control" name="title" placeholder="عنوان الصفحة" value="<?php echo $data['title']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group <?php echo (!empty($data['image_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="imageUpload">صورة الصفحة : </label>
                    <div class="has-feedback input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                            <input name="image" value="<?php echo ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                        </span>
                        <span class="form-control"><small><?php echo empty($data['image']) ? 'قم بأختيار صورة مناسبة' : $data['image']; ?></small></span>
                    </div>
                    <div class="help-block"><?php echo $data['image_error']; ?></div>
                </div>
                <div class="form-group col-md-12">
                    <label class="control-label">المحتوي  : </label>
                    <div class="row">
                        <textarea name="content" id="ckeditor" class="ckeditor form-control"><?php echo ($data['content']); ?></textarea>
                    </div>
                </div>
                <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label">حالة النشر :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> منشور
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == '0') ? 'checked' : ''; ?> value="0" name="status"> غير منشور
                        </label>
                        <span class="help-block"><?php echo $data['status_error']; ?></span>
                    </div>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label">الوصف : </label>
                    <div class="text-warning ">وصف مختصر لمحرك البحث</div>
                    <div class=" form-group">
                        <textarea name="meta_description" class="form-control description" id="description" placeholder="ادرج وصف مختصر عن الصفحة"><?php echo $data['meta_description']; ?></textarea>
                    </div>
                </div>

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label" for="tags_1">الكلمات الدلالية    :</label>
                    <div class="text-warning ">افصل بين كل كلمة بعلامة (,)</div>
                    <div class=" form-group">
                        <input type="text" name="meta_keywords" value="<?php echo $data['meta_keywords']; ?>" id="tags_1" class="form-control" />
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">أضف  
                        <i class="fa fa-save"> </i></button>
                    <button type="reset" class="btn btn-danger">مسح 
                        <i class="fa fa-trash "> </i></button>
                </div>

            </form>

        </div>
    </div>
</div>
<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/ckeditor/ckeditor.js"></script>
                       
                   <script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';


require ADMINROOT . '/views/inc/footer.php';
