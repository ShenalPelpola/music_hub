<div class="<?php echo $display_sign_up == True ? 'popup signup-popup active' : 'popup signup-popup' ?>">
    <div class="close-btn">&times;</div>

    <!-- Once a user submits the registration form RegisterUser method in the Authentication
    controller will run. -->
    <?php

    // setting the attributes to the login form.
    echo form_open("Authentication/register_user", array('class' => 'form'));
    ?>

    <h2>Sign Up</h2>

    <!-- text field for recording the username -->
    <div class="form-element">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter username">
        <?php echo form_error('username', "<div class='alert'>", "</div>") ?>
    </div>

    <!-- password field for recording the password -->
    <div class="form-element">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter password">
        <?php echo form_error('password', "<div class='alert'>", "</div>") ?>
    </div>

    <!-- password field for recording the confirmation password -->
    <div class="form-element">
        <label for="password">Confirm Password</label>
        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm password">
        <?php echo form_error('confirmPassword', "<div class='alert'>", "</div>") ?>
    </div>

    <div class="form-element">
        <button>Sign Up</button>
    </div>

    <!-- form closed -->
    <?php echo form_close(); ?>
</div>