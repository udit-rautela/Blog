<?php
    require 'config/constants.php';


    $username_email = $_SESSION['signin-data']['username_email'] ?? null;
    $password = $_SESSION['signin-data']['password'] ?? null;

    unset($_SESSION['signin-data']['']);
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

<section class="form_section">
    <div class="container form_section-container">
        <h2>Sign in</h2>
        <?php if(isset($_SESSION['signup-success'])) : ?>
        <div class="alert_message success">
            <p>
                <?= $_SESSION['signup-success'];
                unset($_SESSION['signup-success']);
                ?>  
            </p>
        </div>
        <?php elseif(isset($_SESSION['signin'])) : ?>
        <div class="alert_message error">
            <p>
                <?= $_SESSION['signin'];
                unset($_SESSION['signin']);  
                ?>  
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
            <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or email">
            <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
            <button type="submit" name="submit" class="btn" >Sign in</button>
            <small>Don't have an account?<a href="signup.php">Sign up<c/a></small>
        </form>
    </div>
</section>
<script src="./js/main.js"></script>
</body>
</html>