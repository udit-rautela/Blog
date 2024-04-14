<?php 
 require 'config/database.php';

 // GET form data if submit button was clicked . 
 if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT); 
    $avatar = $_FILES['avatar'];
    
    // validate input values 
    if (!$firstname) {
        $_SESSION['add-user'] = "Please enter your first name : ";
    }
    elseif (!$lastname) {
        $_SESSION["add-user"] = "Please enter your last name : ";
    }
    elseif (!$username) {
        $_SESSION["add-user"] = "Please enter your user name : ";
    }
    elseif (!$email) {
        $_SESSION["add-user"] = "Please enter your email address : ";
    }
    elseif (strlen($createpassword) < 8 || strlen($confirmpassword) <8) {
        $_SESSION["add-user"] = " Password should contain at least 8 characters  : ";
    }
    elseif (!$avatar['name'] ) {
        $_SESSION["add-user"] = "Please add avatar : ";
    }
    else{
        // checking if password match or not 
        if($createpassword !== $createpassword ){
            $_SESSION[""] = "Passwords do not match";
        }
        else{
            // hashing passwords 
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
            
            // check if username or email already exist or not
            $user_check_query = "SELECT * FROM `users` WHERE `users`.`username`= '$username' OR `users`.`email` = '$email' ";
            $user_check_result = mysqli_query($connection,$user_check_query);
            if(mysqli_num_rows($user_check_result) > 0)
            {
                $_SESSION['add-user'] = "Username or Email already exist ";
            }
            else
            {
                // proceed ahead to avatar 
                $time = time();   // to make unique image name of every avatar . 
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name']; //this will pick the avatar array name that is displayed by vardump($avatar);
                $avatar_destination_path = '../images/'.$avatar_name;
                // to check if files are of correct format 
                $allowed_files = ['png', 'jpg', 'jpeg']; 
                $extention = explode('.', $avatar_name); 
                $extention = end($extention);  
                
                if(in_array($extention, $allowed_files))
                {
                    // check size of avatar size .
                    if($avatar['size'] < 10000000000)
                    { // upload avatar 
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }
                    else{ 
                        $_SESSION['add-user'] = 'file size should be less than 1mb';
                    }
                }
                else{ // if avatar is of some other format .
                    $_SESSION['add-user'] = 'file should be png, jpg, jpeg .';
                }
            }
        } 
    }
    // redirecting to signup page if there is any problem
    if(isset($_SESSION['add-user'])){
        // pass from data back to signup page 
        $_SESSION['add-user-data'] = $_POST; 
        header('location:' . ROOT_URL .'admin/add-user.php');
        die();
    }
    else{
        // proceed to add user 
        $insert_user_query = "INSERT INTO `users` (`firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `is_admin`) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', '$is_admin')";

        // 
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if(!mysqli_errno($connection)){
            // redirect to login page with success message 
            $_SESSION['add-user-success'] = " $firstname added successfully .";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }


}
 else{
    // if button was not clicked then go to signup page .
    header('location:' . ROOT_URL .'admin/add-user.php');
    die();
 }