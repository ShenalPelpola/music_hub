<div class="<?php echo $display_log_in == True ? 'popup login-popup active' : 'popup login-popup' ?>">
    <div class="close-btn">&times;</div>

    <!-- Once a user submits the registration form RegisterUser method in the Authentication
    controller will run. -->
    <?php

    // setting the attributes to the login form.
    $login_attributes = array('class' => 'form');
    echo form_open("Authentication/login_user", $login_attributes);
    ?>

    <h2>Log in</h2>

    <!-- text field for recording the username -->
    <div class="form-element">
        <label for="loginusername">Username</label>
        <input type="text" name="loginusername" id="loginusername" placeholder="Enter username">
        <?php echo form_error('loginusername', "<div class='alert alert-danger'>", "</div>") ?>
    </div>

    <!-- password field for recording the password -->
    <div class="form-element">
        <label for="loginpassword">Password</label>
        <input type="password" name="loginpassword" id="loginpassword" placeholder="Enter password">
        <?php echo form_error('loginpassword', "<div class='alert alert-danger'>", "</div>") ?>
    </div>

    <div class="form-element">
        <button>Log in</button>
    </div>

    <!-- form closed -->
    <?php echo form_close(); ?>
</div>