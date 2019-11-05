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
    <?php flash('page_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض  <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <!-- <div class="col-md-12 col-sm-12 col-xs-12">
            <pre dir='ltr' align='left'>
<?php
print_r($_SESSION);

?>

            </pre>
        </div> -->
    </div>
</div>
<?php
// loading  plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
