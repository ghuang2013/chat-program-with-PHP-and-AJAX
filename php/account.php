<?php
require_once('php/database_connect.php');

session_start();
$username='';

if(isset($_POST['sign_up'])){
    $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

    $query = "INSERT INTO Users (username,password) VALUES (?,?)";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('ss',$username,$password);
    $stmt->execute();
    $stmt->close();
}
else if (isset($_POST['login'])){
    $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    
    $query = "SELECT username FROM Users where username = ? and password = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('ss',$username,$password);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows){
        $_SESSION['username'] = $username;
    }
    $stmt->free_result();
    $stmt->close();
}
