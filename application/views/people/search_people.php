<?php

if (!($this->session->userdata('authorized')) || !($this->session->userdata('profile_created'))) {
    redirect("/Home");
}
?>

<div class="container">
    <?php
    echo form_open("People/search");
    ?>

    <div class="music-search-container">
        <select name="searched-music-genre" id="searched-music-genre">
            <?php foreach (array_keys($music_genres) as $key) : ?>
                <option value="<?php echo $music_genres[$key]->id ?>"><?php echo $music_genres[$key]->genre ?></option>
            <?php endforeach; ?>
        </select>
        <button class="search-people" type="submit"><i class="fa fa-search"></i> Search</button>
    </div>

    <?php echo form_close(); ?>


    <?php if (count($users) > 0) : ?><h3 class="liked-genre">People who like <?php echo $users[0]->genre ?></h3><?php endif; ?>

    <div class="people-grid">
        <?php if (isset($users)) : ?>
            <?php foreach (array_keys($users) as $key) : ?>
                <div class="people-card">

                    <div class="friend-avatar-container">
                        <?php if ($users[$key]->avatar) : ?>
                            <img src="<?php echo $users[$key]->avatar; ?>" alt="user avatar">
                        <?php else : ?>
                            <img src="<?php echo base_url('assets/img/default_avatar.jpg'); ?>" alt="user avatar">
                        <?php endif; ?>
                    </div>

                    <div class="friend-info-container">
                        <a href="<?php echo base_url(); ?>index.php/User?user_id=<?php echo $users[$key]->id ?>">
                            <h4><?php echo $users[$key]->first_name . " " . $users[$key]->last_name; ?></h4>
                        </a>
                        <span><?php echo $users[$key]->username ?></span>
                    </div>

                    <div class="friend-button-container">
                        <?php if ($users[$key]->follow_status === 0 || $users[$key]->follow_status === -1) : ?>
                            <?php
                            echo form_open("People/follow_user");
                            echo form_hidden('following_id', $users[$key]->id);
                            echo form_hidden('submitted_page', "search");
                            ?>
                            <button>Follow</button>
                            <?php echo form_close(); ?>
                        <?php else : ?>
                            <span><i class="fas fa-user-check"></i>&nbsp&nbspFollowed</span>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>
</div>