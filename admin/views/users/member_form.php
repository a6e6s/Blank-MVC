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

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>بيانات عامة</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Plain Page</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="wizard" class="form_wizard wizard_horizontal">
                            <ul class="wizard_steps">
                                <li>
                                    <a href="#step1">
                                        <span class="step_no">1</span>
                                        <span class="step_descr">بيانات عامة</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step2">
                                        <span class="step_no">2</span>
                                        <span class="step_descr">بيانات العنوان</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step3">
                                        <span class="step_no">3</span>
                                        <span class="step_descr">بيانات التابعين</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step4">
                                        <span class="step_no">4</span>
                                        <span class="step_descr">الافصاح عن الدخل</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step5">
                                        <span class="step_no">5</span>
                                        <span class="step_descr">بيانات العقارات</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step6">
                                        <span class="step_no">6</span>
                                        <span class="step_descr">بيانات الحساب البنكي</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step7">
                                        <span class="step_no">7</span>
                                        <span class="step_descr">مراجعة</span>
                                    </a>
                                </li>
                            </ul>
                            <div id="step1">

                                <h3 class="StepTitle">بيانات عامة</h3>
                                <hr />
                                <form class="form-horizontal form-label-left">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">الحالة الاجتماعية <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">الحالة الصحية <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">حالة القدرة على العمل <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> المستوي التعليمي <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                </form>
                                <div class="clearfix"></div>
                            </div><!--end step1-->

                            <div id="step2">

                                <h3 class="StepTitle">السكن</h3>
                                <hr />
                                <form class="form-horizontal form-label-left">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> حالة السكن <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> نوع السكن <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">المنطقة <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> المدينة <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> الحي <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> الشارع <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="clearfix"></div>
                                    <h3 class="StepTitle">العنوان</h3>
                                    <hr />
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> رقم الوحدة <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> الرقم الاضافى <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> الرمز البريدي <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> صندوق البريد <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="clearfix"></div>
                                    <h3 class="StepTitle">معلومات التواصل</h3>
                                    <hr />
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> رقم الجوال <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> رقم الجوال الاضافى<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> رقم الهاتف<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> البريد الالكتروني<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">تأكيد البريد الالكتروني<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                </form>
                                <div class="clearfix"></div>
                            </div><!--end step2-->

                            <div id="step3">

                                <h3 class="StepTitle">التابعين</h3>
                                <hr />
                                <div class="col-xs-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>الهوية الوطنية/الاقامة</th>
                                                <th>الاسم</th>
                                                <th>صلة القرابة</th>
                                                <th>الوظيفة</th>
                                                <th>الاجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5">
                                                    <h4 class="text-center alert alert-warning">لايوجد</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div><!--end  col-xs-12-->
                                <div class="clearfix"></div>
                                <div class="text-center"><a href="" class="btn btn-primary"><i class="fa fa-plus"></i> إضافة تابع</a></div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">إضافة تابع</h3>
                                    </div>
                                    <form class="form-horizontal form-label-left">
                                        <div class="panel-body">

                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> رقم الهوية<span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control" />
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> تاريخ الميلاد بالهجري <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-sm-4 col-xs-12">
                                                                <select class="form-control">
                                                                    <option>1</option>
                                                                    <option>2</option>
                                                                    <option>3</option>
                                                                </select>
                                                            </div><!--end col-xs-12-->
                                                            <div class="col-sm-4 col-xs-12">
                                                                <select class="form-control">
                                                                    <option>ربيع اول</option>
                                                                    <option></option>
                                                                    <option></option>
                                                                </select>
                                                            </div><!--end col-xs-12-->
                                                            <div class="col-sm-4 col-xs-12">
                                                                <select class="form-control">
                                                                    <option>1433</option>
                                                                    <option>1432</option>
                                                                    <option>1431</option>
                                                                </select>
                                                            </div><!--end col-xs-12-->
                                                        </div><!--end row-->
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> صلة القرابة<span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="form-control">
                                                            <option></option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                        </select>
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> الحالة الوظيفية <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="form-control">
                                                            <option> </option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                        </select>
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                        </div><!--end panel-body-->
                                        <div class="panel-footer">
                                            <a href="#" class="btn btn-success">إضافة</a>
                                            <a href="#" class="btn btn-danger">الغاء</a>
                                        </div><!--end panel-footer-->
                                    </form>
                                </div><!--end panel-->

                            </div><!--end step3-->

                            <div id="step4">

                                <h3 class="StepTitle">دخل المستفيد</h3>
                                <hr />
                                <div class="alert alert-info"><i class="fa fa-info-circle"></i> <strong>تنبيه</strong> فى حالة وجود سجل تجاري لك او لاحد أفراد أسرتك أو التابعين المسجلين ولم تصرح بذلك. فأنه سيؤثر على اهليه استحقاقك او أهلية التابع</div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> الحالة الوظيفية للمستفيد<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                            </select>
                                        </div><!--end  col-xs-12-->
                                    </div><!--end form-group-->
                                </div><!--end  col-xs-12-->
                                <div class="clearfix"></div>
                                <div class="col-xs-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>نوع الدخل</th>
                                                <th>مصدر الدخل</th>
                                                <th>المبلغ الشهري مع البدلات</th>
                                                <th>الدخل السنوي</th>
                                                <th>الاجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>راتب تقاعدي</td>
                                                <td>راتب تقاعدى من القطاع الحكومي</td>
                                                <td>1000</td>
                                                <td>120000</td>
                                                <td><a href="" class="btn btn-success btn-sm">تعديل</a><a href="" class="btn btn-danger btn-sm">حذف</a></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">
                                                    <h4 class="text-center alert alert-warning">لايوجد</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div><!--end  col-xs-12-->
                                <div class="clearfix"></div>
                                <div class="text-center"><a href="" class="btn btn-primary"><i class="fa fa-plus"></i> إضافة دخل</a></div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">إضافة دخل</h3>
                                    </div>
                                    <form class="form-horizontal form-label-left">
                                        <div class="panel-body">
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> نوع الدخل <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="form-control">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                        </select>
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> مصدر الدخل <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="form-control">
                                                            <option> </option>
                                                            <option>1432</option>
                                                            <option>1431</option>
                                                        </select>
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> المبلغ الشهري مع البدلات<span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control" />
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> الدخل السنوي <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control" />
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                        </div><!--end panel-body-->
                                        <div class="panel-footer">
                                            <a href="#" class="btn btn-success">إضافة</a>
                                            <a href="#" class="btn btn-danger">الغاء</a>
                                        </div><!--end panel-footer-->
                                    </form>
                                </div><!--end panel-->

                                <h3 class="StepTitle">دخل التابعين</h3>
                                <div class="clearfix"></div>
                                <div class="col-xs-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>الاسم</th>
                                                <th>نوع الدخل</th>
                                                <th>مصدر الدخل</th>
                                                <th>المبلغ الشهري مع البدلات</th>
                                                <th>الدخل السنوي</th>
                                                <th>الاجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td colspan="6">
                                                    <h4 class="text-center alert alert-warning">لايوجد</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div><!--end  col-xs-12-->
                                <div class="clearfix"></div>
                                <div class="text-center"><a href="" class="btn btn-primary"><i class="fa fa-plus"></i> إضافة دخل</a></div>
                                <hr />
                                <br />
                                <h3 class="StepTitle">اقرار </h3>
                                <hr />

                                <label>
                                    <input type="checkbox"> أتعهد وأقر بأن جميع البيانات المدخلة فى استمارة البيانات والدخل الخاصة بالمستفدين والتابعين صحيحة ودقيقة. وفى حال اتضح خلاف ذلك فسوف ستم الغاء عملية الاهلية، حتى لو تم اكتشاف ذلك عند اصدار القرار النهائى او بعده. كما اوافق على صحة البيانات الخاصة بي، وأتعهد بتقديم اى بيانات اخرييتم طلبها من الجهات المختصة
                                </label>

                                <div class="clearfix"></div>
                            </div><!--end step4-->

                            <div id="step5">
                                <h3 class="StepTitle">العقارات </h3>
                                <hr />
                                <div class="col-xs-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>رقم الصك</th>
                                                <th>المنطقة</th>
                                                <th>المدينة</th>
                                                <th>اجمالى نسبة التمليك</th>
                                                <th>اجمالى المساحة المملوكة</th>
                                                <th>الاجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="6">
                                                    <h4 class="text-center alert alert-warning">لايوجد</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div><!--end  col-xs-12-->
                                <div class="clearfix"></div>
                                <div class="text-center"><a href="" class="btn btn-primary"><i class="fa fa-plus"></i> إضافة</a></div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">إضافة عقار</h3>
                                    </div>
                                    <form class="form-horizontal form-label-left">
                                        <div class="panel-body">

                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> رقم الصك<span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control" />
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> المنطقة <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="form-control">
                                                            <option> </option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                        </select>
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> المدينة <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select class="form-control">
                                                            <option> </option>
                                                            <option>1432</option>
                                                            <option>1431</option>
                                                        </select>
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->

                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> اجمالى نسبة التمليك <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control" />
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> اجمالى المساحة المملوكة <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control" />
                                                    </div><!--end  col-xs-12-->
                                                </div><!--end form-group-->
                                            </div><!--end  col-xs-12-->

                                        </div><!--end panel-body-->
                                        <div class="panel-footer">
                                            <a href="#" class="btn btn-success">إضافة</a>
                                            <a href="#" class="btn btn-danger">الغاء</a>
                                        </div><!--end panel-footer-->
                                    </form>
                                </div><!--end panel-->
                            </div><!--end step5-->

                            <div id="step6">
                                <h3 class="StepTitle">الحساب البنكي </h3>
                                <hr />
                                <div class="alert alert-danger">
                                    <p>الرجاء تزويدنا برقم الحساب البنكى الخاص بك مع مراعاه ما يلى:</p>
                                    <ol>
                                        <li>إن تقديمك لرقم الحساب البنكى فى هذه المرحلة لا يعنى أهليتك لبرنامج حساب المواطن </li>
                                        <li>يجب التأكد من ان معلومات الحساب البنكى المدخلة تخص مقدم الطلب بالاسم نفسه ورقم الهوية وليس باسم شخص اخر</li>
                                        <li></li>
                                        <li></li>
                                    </ol>
                                </div><!--end alert-->
                                <form class="form-horizontal form-label-left">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> رقم الحساب البنكى <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> تأكيد رقم الحساب البنكى <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control" />
                                            </div><!--end  col-xs-12-->
                                        </div><!--end form-group-->
                                    </div><!--end  col-xs-12-->
                                    <label>
                                        <input type="checkbox"> اقر انى قمت بادخال رقم الحساب الخاص بي
                                    </label>
                                    <div class="clearfix"></div>
                                </form>
                            </div><!--end step6-->

                            <div id="step7">

                            </div><!--end step7-->

                        </div><!--end form_wizard-->
                    </div><!--end x_content-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require ADMINROOT . '/views/inc/footer.php';
