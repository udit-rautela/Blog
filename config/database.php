<?php
    require 'config/constants.php';

    // database connection 
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if(mysqli_connect_errno()) 
    {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " : " . mysqli_connect_errno();
        exit($msg);
    } 
