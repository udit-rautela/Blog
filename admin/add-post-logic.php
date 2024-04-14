<?php 
require 'config/database.php';

if (isset($_POST['submit'])){
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //  is_featured will be zero when unchecked 
    $is_featured = $is_featured == 1 ? 1 : 0;

    // validate form data 
    if(!$title){
        $_SESSION['add-post'] = "enter post title";
    }
    elseif(!$category_id){
        $_SESSION['add-post'] = "enter post category";
    }
    elseif(!$body){
        $_SESSION["add-post"] = "enter post body";
    }
    elseif(!$thumbnail['name']){
        $_SESSION['add-post'] = "choose a thumbnail for the post .";
    }
    else{
        // make the image name unique 
        $time = time(); 
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // checking the extensions & size of the thumbnail image 
        $allowed_files = ['png','jpg','jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);   
        move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
        if(in_array($extension, $allowed_files)){
            // check size
            if($thumbnail['size'] < 2_00_00_00_00){
                // upload thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);   
            }
            else{
                $_SESSION['add-post'] = "File size is larger than the limit .";
            }
        }
        else{
            $_SESSION['add-post'] = "Thumbnail should be png, jpg, jpeg";
        }

    }

    // if any problem occurs in filling the add post page . 
    if(isset($_SESSION['add-post'])){
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URL .'admin/add-post.php');
        die();
    }
    else{
        // set is_featured of all post to 0 if is_featured is 1
        if($is_featured == 1){
            $zero_all_is_featured_query = "UPDATE `posts` SET `posts`.`is_featured` = 0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }
        // insert post into database 
        $query = "INSERT INTO `posts`(`title`, `body`, `thumbnail`,`category_id`,`author_id`,`is_featured`) VALUES('$title','$body','$thumbnail_name', $category_id, $author_id,$is_featured)";
        $result = mysqli_query($connection, $query);
        // if no error occurs then redirect to blog page 
        if(!mysqli_errno($connection)){
            $_SESSION['add-post-success'] = "New post added successfully .";
            header("location:". ROOT_URL . "admin/");
            die();  
        }
    }
}
// if mysqli_errorno throws error than back to add-post.php
header("location:". ROOT_URL . "admin/add-post.php");
die(); 