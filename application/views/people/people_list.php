<div class="container">
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
                        <?php if ($status === "followed") : ?>
                            <span><i class="fas fa-user-check"></i>&nbsp&nbspFollowed</span>
                        <?php elseif ($status === "follower") : ?>
                            <span><i class="fas fa-user"></i>&nbsp&nbspFollower</span>
                        <?php elseif ($status === "friend") : ?>
                            <span><i class="fas fa-user-friends"></i>&nbsp&nbspFriend</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>