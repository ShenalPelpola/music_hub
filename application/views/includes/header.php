<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Hub</title>
    <script src="https://kit.fontawesome.com/8000e3b164.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>" />
</head>

<body>
    <main>
        <div class="home-overlay"></div>

        <div class="header-container">
            <header>
                <div class="nav-container">
                    <div class="nav-logo">
                        <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="app logo" />
                        <h3>Music Hub</h3>
                    </div>
                    <div class="nav-links">
                        <ul>
                            <?php if (!$this->session->userdata('authorized')) : ?>
                                <li><a href="<?php echo base_url(); ?>home">Home</a></li>
                                <li><a href="#" class="btn-link login">Log in</a></li>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('authorized')) : ?>
 				<li><a href="<?php echo base_url(); ?>index.php/User/timeline_view">Timeline</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/People/search">People</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/User?user_id=<?php echo $this->session->userdata('user_id') ?>">Profile</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/Authentication/logout">Logout</a></li>                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </header>
        </div>