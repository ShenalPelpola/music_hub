<div class="create-profile-main">
    <div class="create-profile-container">
        <h1>CREATE YOUR PROFILE</h1>
        <?php
        echo form_open("User/create_profile_view", array('class' => 'form'));
        ?>
        <div class="row">
            <div class="column">
                <label for="name">User Avatar</label>
                <input type="text" name="avatar" id="avatar" placeholder="Url of a avatar">
                <?php echo form_error('avatar', "<div class='alert'>", "</div>") ?>
            </div>

            <div class="column">
                <label for="name">First Name</label>
                <input type="text" name="fname" id="fname" placeholder="Your first name here">
                <?php echo form_error('fname', "<div class='alert'>", "</div>") ?>
            </div>
            <div class="column">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname" placeholder="Your last name here">
                <?php echo form_error('lname', "<div class='alert'>", "</div>") ?>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <label for="subject">Music Genre </label>
                <p> * Hold down the Ctrl (windows) or Command (Mac) button to
                    select multiple options</p>

                <select name="music-genre[]" id="music-genre" multiple>
                    <?php foreach (array_keys($music_genres) as $key) : ?>
                        <option value="<?php echo $music_genres[$key]->id ?>"><?php echo $music_genres[$key]->genre ?></option>
                    <?php endforeach; ?>
                </select>

                <?php echo form_error('music-genre[]', "<div class='alert'>", "</div>") ?>
            </div>
        </div>
        <button class="create-profile-button">Create</button>

        <?php echo form_close(); ?>
    </div>
</div>