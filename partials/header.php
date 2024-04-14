<?php
    require 'config/database.php';

    // fetch current user from database 
    if(isset($_SESSION['user-id'])){
        $id = filter_var($_SESSION['user-id'],FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT `users`.`avatar` FROM `users` WHERE `users`.`id` = $id";
        $result = mysqli_query($connection, $query);
        $avatar = mysqli_fetch_assoc($result);
    } 
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Blogging website</title>
        <!-- fontawesome CDN -->
        <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer"
        />
        <!-- iconscout CDN -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
        <!-- montserrat font  -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <!-- own CSS "style.css" link -->
        <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    </head>
    <body>
        <!-- -------------------------------------------------------  -->
        <!-- NAVBAR START -->
        <nav>
            <div class="container nav_container">
                <a href="<?= ROOT_URL ?>" class="nav_logo">BLOGGER</a>
                <ul class="nav_items">
                    <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                    <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                    <li><a href="<?= ROOT_URL ?>Services.php">Services</a></li>
                    <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                    <?php if(isset($_SESSION['user-id'])) : ?>
                        <li class="nav_profile"> 
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/' . $avatar['avatar']?>">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <?php else : ?>
                    <li><a href="<?=  ROOT_URL ?>signin.php">Signin</a></li>
                    <?php endif ?>
                </ul>
    
                <button id="open_nav-btn"><i class="fa-solid fa-bars"></i></button>
                <button id="close_nav-btn"><i class="fa-solid fa-x"></i></button>
            </div>
        </nav>
        
        <!-- NAVBAR END -->
        <!-- --------------------------------------------------------  -->
