
<footer class="footer py-5 bg-success">
    <div class="container-fluid footer-content">
        <div class="row">
            <div class="col-md-4 mt-1 mb-1">
                <img src="<?php echo URLROOT; ?>/templates/default/img/vision2030.png" class="img-fluid" alt="" />
            </div>
            <div class="col-md-4 mt-3 text-center">
                
            </div>
            <div class="col-md-4 mt-1">
                <p class=" ">
                    جميع الحقوق محفوظة ©
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- Bootstrap core JavaScript -->
<script src="<?php echo URLROOT; ?>/templates/default/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo URLROOT; ?>/templates/default/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<?php echo isset($data['footer']) ? $data['footer'] : ''; ?>
</body>

</html>