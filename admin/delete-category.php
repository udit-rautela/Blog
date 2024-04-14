<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    

    // update category_id of posts that belong to this category to the uncategorized category .
    //  9 is the uncategorized category .
    $update_query = "UPDATE `posts` SET `category_id` = 9 WHERE `category_id`=$id";
    $update_result = mysqli_query($connection, $update_query);

    if(!mysqli_errno($connection)){
    // delete category 
    $query = "DELETE FROM `categories` WHERE `categories`.`id`=$id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $_SESSION['delete-category-success'] = "category deleted successfully";
    }
}
header('location:' . ROOT_URL .'admin/manage-categories.php');
die(); 