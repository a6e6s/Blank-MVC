
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title">
            <a target="_blank" href="<?php echo URLROOT; ?>" class="site_title"> <i class="glyphicon glyphicon-grain"></i> <span><?php echo SITENAME; ?></span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo empty($_SESSION['user']->image) ? MEDIAURL . '/userdefault.jpg' : MEDIAURL . '/' . $_SESSION['user']->image; ?>" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>مرحبا ,</span>
                <h2><?php echo $_SESSION['user']->name; ?></h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>عام</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> الرئيسية <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo ADMINURL; ?>/dashboard/index">لوحة التحكم</a></li>
                            <li><a href="<?php echo ADMINURL; ?>/users/show/<?php echo $_SESSION['user']->user_id; ?>">الملف الشخصي</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-th-large"></i> النظام <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo ADMINURL; ?>/groups">المجموعات والصلاحيات</a></li>
                            <li><a href="<?php echo ADMINURL; ?>/users">المستخدمين</a></li>
                            <li><a href="<?php echo ADMINURL; ?>/pages">الصفحات</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-bar-chart-o"></i> التقارير <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="chartjs.html">تقارير المستخدمين</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings" href="<?php echo ADMINURL; ?>/settings" >
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen" class="fullscreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo ADMINURL; ?>/users/logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo empty($_SESSION['user']->image) ? MEDIAURL . '/userdefault.jpg' : MEDIAURL . '/' . $_SESSION['user']->image; ?>"><?php echo $_SESSION['user']->name; ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?php echo ADMINURL . '/users/show/' . $_SESSION['user']->user_id; ?>"><i class="fa fa-user pull-left"></i> الملف الشخصي</a></li>
                        <li><a href="<?php echo ADMINURL; ?>/settings"><i class="fa fa-gear pull-left"></i> الأعدادات</a></li>
                        <li><a target="_blank" href="http://ahmedx.com/easycms"><i class="fa fa-life-bouy pull-left"></i> المساعدة</a></li>
                        <li><a href="<?php echo ADMINURL; ?>/users/logout"><i class="fa fa-sign-out pull-left"></i> تسجيل خروج</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->