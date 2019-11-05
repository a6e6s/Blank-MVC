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

/**
 * registeration form for user 
 */
require ADMINROOT . '/views/inc/header.php';
?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Create an Account</h2>
            <p>
                please fill out this form to register  
            </p>
            <form action="<?php echo ADMINURL; ?>/users/register" method="post">
                <div class="form-group">
                    <label for="name">Name: <sup>*</sup></label>
                    <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                    <span class="invalid-feedback"><?php echo $data['name_error']; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>"  value="<?php echo $data['password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_error'])) ? 'is-invalid' : ''; ?>"  value="<?php echo $data['confirm_password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['confirm_password_error']; ?></span>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="submit" value="Register" class="btn btn-success btn-block">
                    </div>
                    <div class="col">
                        <a href="<?php echo ADMINURL; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require ADMINROOT . '/views/inc/footer.php';
