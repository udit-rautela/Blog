<?php 
 require 'config/database.php';

 // GET signup data if signup button was clicked . 
 if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    
    // validate input values 
    if (!$firstname) {
        $_SESSION['signup'] = "Please enter your first name : ";
    }
    elseif (!$lastname) {
        $_SESSION["signup"] = "Please enter your last name : ";
    }
    elseif (!$username) {
        $_SESSION["signup"] = "Please enter your user name : ";
    }
    elseif (!$email) {
        $_SESSION["signup"] = "Please enter your email address : ";
    }
    elseif (strlen($createpassword) < 8 || strlen($confirmpassword) <8) {
        $_SESSION["signup"] = " Password should contain at least 8 characters  : ";
    }
    elseif (!$avatar['name'] ) {
        $_SESSION["signup"] = "Please add avatar : ";
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
                $_SESSION['signup'] = "Username or Email already exist ";
            }
            else
            {
                // proceed ahead to avatar 
                $time = time();   // to make unique image name of every avatar . 
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name']; //this will pick the avatar array name that is displayed by vardump($avatar);
                $avatar_destination_path = 'images/'.$avatar_name;
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
                        $_SESSION['signup'] = 'file size should be less than 1mb';
                    }
                }
                else{ // if avatar is of some other format .
                    $_SESSION['signup'] = 'file should be png, jpg, jpeg .';
                }
            }
        } 
    }
    // redirecting to signup page if there is any problem
    if(isset($_SESSION['signup'])){
        // pass from data back to signup page 
        $_SESSION['signup-data'] = $_POST; 
        header('location:' . ROOT_URL .'signup.php');
        die();
    }
    else{
        // proceed to add user 
        $insert_user_query = "INSERT INTO `users` (`firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `is_admin`) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0 )";

        // 
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if(!mysqli_errno($connection)){
            // redirect to login page with success message 
            $_SESSION['signup-success'] = "Signup successful, you are now registered . Please log in";
            header('location: ' . ROOT_URL.'signin.php');
            die();
        }
    }


}
 else{
    // if button was not clicked then go to signup page .
    header('location:' . ROOT_URL .'signup.php');
    die();
 }