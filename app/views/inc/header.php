<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <!-- Bootstrap core CSS -->
        <link href="<?php echo URLROOT; ?>/templates/default/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template -->
        <link href="<?php echo URLROOT; ?>/templates/default/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link href="<?php echo URLROOT; ?>/templates/default/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
        <!-- iCheck -->
        <link href="<?php echo ADMINURL; ?>/template/default/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?php echo URLROOT; ?>/templates/default/css/style.css" rel="stylesheet">
        <title><?php echo SITENAME; ?></title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="logo col-lg-8 mb-2 mt-2">
                    <a class="text-success" href="<?php echo URLROOT; ?>" title="<?php echo SITENAME; ?>">
                        <img src="<?php echo URLROOT; ?>/templates/default/img/icon1.png" class="img-flud ml-3 img-responsive" alt="">
                      
                    </a>
                </div>
            </div>
        </div>
        <?php require APPROOT . '/app/views/inc/navbar.php'; ?>
