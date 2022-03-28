<?php

function convert_links($content)
{
    $image_pattern = '/(https?:\/\/.*\.(?:png|jpg|gif))/i';
    $url_regex = '~(http|https|ftp|ftps)s?://[a-z0-9.-]+\.[a-z]{2,3}(/\S*)?~i';

    $string = preg_replace($image_pattern, '', $content);
    $output = preg_replace($url_regex, '<a href="$0">$0</a>', $string);
    return $output;
}

function get_image_links($content)
{
    $image_pattern = '/\bhttps?:\/\/\S+(?:png|jpg|gif)\b/';
    preg_match_all($image_pattern, $content, $matches);
    return $matches;
}
?>

<div class="overlay"></div>
<div class="profile-container">
    <div class="profile-info">
        <div class="user-avatar-container">
            <?php if ($user_info->avatar) : ?>
                <img src="<?php echo $user_info->avatar; ?>" alt="user avatar">
            <?php else : ?>
                <img src="<?php echo base_url('assets/img/default_avatar.jpg'); ?>" alt="user avatar">
            <?php endif; ?>
        </div>

        <div class="profile-data">
            <h1><?php echo $user_info->first_name . " " . $user_info->last_name; ?></h1>
            <span>@<?php echo $user_info->username ?></span>

            <div class="profile-stats">
                <a href="<?php echo base_url(); ?>index.php/People?type=following">
                    <div class="stat">
                        <span><?php echo $stats["following"] ?></span>
                        <h3>Following</h4>
                    </div>
                </a>
                <a href="<?php echo base_url(); ?>index.php/People?type=followers">
                    <div class="stat">
                        <span><?php echo $stats["followers"] ?></span>
                        <h3>Followers</h4>
                    </div>
                </a>
                <a href="<?php echo base_url(); ?>index.php/People?type=friends">
                    <div class="stat">
                        <span><?php echo $stats["friends"] ?></span>
                        <h3>Friends</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="create-post">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h2>Create Post</h2>
            <?php
            echo form_open("Posts/create_post");
            ?>
            <textarea id="post-message" name="post-message" rows="10" cols="50" placeholder="What's on your mind shenal?"></textarea>
            <?php echo form_error('post-message', "<div class='alert'>", "</div>") ?>
            <div class="form-element">
                <button>Post</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

    <div class="message-box">
        <div class="message-heading">
            <h3>Post a message</h3>
        </div>
        <form action="/action_page.php">
            <div class="user-info">
                <?php if ($user_info->avatar) : ?>
                    <img src="<?php echo $user_info->avatar; ?>" alt="user avatar">
                <?php else : ?>
                    <img src="<?php echo base_url('assets/img/default_avatar.jpg'); ?>" alt="user avatar">
                <?php endif; ?>
                <div class="message-container">
                    <input type="text" id="message" name="message" placeholder="Whats on you mind shenal?" disabled>
                </div>
            </div>
        </form>
    </div>

    <?php foreach (array_keys($posts) as $key) : ?>
        <div class="post-box">
            <div class="user-info">
                <?php if ($user_info->avatar) : ?>
                    <img src="<?php echo $user_info->avatar; ?>" alt="user avatar">
                <?php else : ?>
                    <img src="<?php echo base_url('assets/img/default_avatar.jpg'); ?>" alt="user avatar">
                <?php endif; ?>

                <div class="user-profile-names">
                    <h3><?php echo $posts[$key]->first_name . " " . $posts[$key]->last_name; ?></h3>
                    <span>@<?php echo $posts[$key]->username ?></span>
                </div>
                <p><?php echo $posts[$key]->created_at ?></p>
            </div>

            <div class="user-message">
                <P><?php echo convert_links($posts[$key]->post_description) ?></P>
            </div>

            <?php $links = get_image_links($posts[$key]->post_description)[0] ?>

            <?php if ($links > 0) : ?>
                <div class="post-images-container">
                    <?php foreach (array_keys($links) as $key) : ?>
                        <img src="<?php echo $links[$key] ?>" />
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</div>