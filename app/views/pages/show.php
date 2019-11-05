<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="container page">
    <div class="row  mt-5 mb-5 card">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <h3 class="prod_title p-2">
                    <?php echo $data['page']->title; ?>
                </h3>
            </div>
            <div class="">
                <?php if(!empty($data['page']->image)) : ?>
                <img class="img-fluid" src="<?php echo MEDIAURL . '/' . $data['page']->image; ?>" />
                <?php endif; ?>
            </div>
            <div class="form-group col-md-12">
                <p><?php echo $data['page']->content; ?></p>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>
