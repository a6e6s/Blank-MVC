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

// loading  plugin style
$data['header'] = '';

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('user_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/users/add" class="btn btn-success pull-left">اضف جديد <i class="fa fa-plus"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <form action="" method="post" >
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class=" form-group-sm">
                                <th colspan="2"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary" /></th>
                                <th class=""><input type="search" placeholder="بحث بالأسم " class="form-control" name="search[name]" value="" ></th>
                                <th class="">
                                    <select class="form-control" name="search[group_id]">
                                        <option value=''>بحث بالمجموعة</option>
                                            <?php foreach ($data['groupList'] as $group) {
                                                echo '<option value="' . $group->group_id . '">' . $group->name . '</option>';}
                                            ?>
                                    </select>
                                </th>
                                <th class=""><input type="search" placeholder="بحث بالبريد الالكتروني" class="form-control" name="search[email]" value="" ></th>
                                <th class=""><input type="search" placeholder="بحث برقم الجوال" class="form-control" name="search[mobile]" value="" ></th>
                                <th class="" colspan="2"></th>
                                <th width="145px">
                                    <select class="form-control" name="search[status]" >
                                        <option value=""></option>
                                        <option value="1">نشط </option>
                                        <option value="0">معلق</option>
                                    </select>
                                </th>
                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title" width="40px">صورة </th>
                                <th class="column-title">اسم المستخدم </th>
                                <th class="column-title">المجموعه </th>
                                <th class="column-title">البريد الالكتروني </th>
                                <th class="column-title">رقم الجوال </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="8">
                                    <span> تنفيذ علي الكل     :</span>
                                    <input type="submit" name="publish" value="Publish" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="Unpublish" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['users'] as $user): ?>

                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $user->user_id; ?>">
                                    </td>
                                    <td class="text-center"><img class="avatar" src="<?php echo empty($user->image) ? MEDIAURL . '/userdefault.jpg' : MEDIAURL . '/' . $user->image; ?>"</td>
                                    <td class=" "><?php echo $user->name; ?></td>
                                    <td><a class="text-warning" href="<?php echo ADMINURL . '/groups/show/' . $user->group_id; ?>"><?php echo $user->usergroup; ?></a></td>
                                    <td class=" "><?php echo $user->email; ?></i></td>
                                    <td class=" "><?php echo $user->mobile; ?></i></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $user->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $user->modified_date); ?></td>
                                    <td class="form-user">
                                        <?php
if (!$user->status) {
    echo '<a href="' . ADMINURL . '/users/publish/' . $user->user_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="معطلة"><i class="fa fa-ban"></i></a>';
} elseif ($user->status == 1) {
    echo '<a href="' . ADMINURL . '/users/unpublish/' . $user->user_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="مفعلة"><i class="fa fa-check"></i></a>';
}
?>
                                        <a href="<?php echo ADMINURL . '/users/show/' . $user->user_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/users/edit/' . $user->user_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/users/delete/' . $user->user_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach;?>

                            <tr class="tab-selected">
                                <th class="column-title" colspan="5"> العدد الكلي  :   <?php echo $data['recordsCount']; ?>  </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/users/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title" colspan="2"> </th>
                                <th class="column-title no-link last"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <ul class="pagination text-center">
                    <?php
pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/users');
?>
                </ul>


            </form>

        </div>
    </div>
</div>
<?php
// loading  plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
