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
    <?php flash('group_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/groups/add" class="btn btn-success pull-left">انشاء جديد <i class="fa fa-plus"></i></a>
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
                                <th width="70px"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" /></th>
                                <th class=""><input type="search" placeholder="بحث بأسم المجموعة" class="form-control" name="search[name]" value="" ></th>
                                <th class=""><input type="search" placeholder="بحث بالوصف" class="form-control" name="search[description]" value="" ></th>
                                <th class=""></th>
                                <th class=""></th>
                                <th width="145px">
                                    <select class="form-control" name="search[status]" >
                                        <option value=""></option>
                                        <option value="1">نشطه </option>
                                        <option value="0"> معلقة </option>
                                    </select>
                                </th>
                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">اسم المجموعة </th>
                                <th class="column-title">الوصف المختصر </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="6">
                                    <span> تنفيذ علي الكل     :</span> 
                                    <input type="submit" name="publish" value="Publish" class="btn btn-success btn-xs" />   
                                    <input type="submit" name="unpublish" value="Unpublish" class="btn btn-warning btn-xs" />   
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />  
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['groups'] as $group): ?>

                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $group->group_id; ?>">
                                    </td>
                                    <td class=" "><?php echo $group->name; ?></td>
                                    <td class=" "><?php echo $group->description; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $group->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $group->modified_date); ?></td>
                                    <td class="form-group">
                                        <?php
                                        if (!$group->status) {
                                            echo '<a href="' . ADMINURL . '/groups/publish/' . $group->group_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="معطلة"><i class="fa fa-ban"></i></a>';
                                        } elseif ($group->status == 1) {
                                            echo '<a href="' . ADMINURL . '/groups/unpublish/' . $group->group_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="مفعلة"><i class="fa fa-check"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/groups/show/' . $group->group_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/groups/edit/' . $group->group_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/groups/delete/' . $group->group_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="2"> العدد الكلي  :   <?php echo $data['recordsCount']; ?>  </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/groups/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title" colspan="1"> </th>
                                <th class="column-title no-link last"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <ul class="pagination text-center">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/groups');
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
