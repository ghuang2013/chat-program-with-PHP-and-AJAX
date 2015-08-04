<?php
require_once('database_connect.php');

session_start();
$username='';

if(isset($_POST['sign_up'])){
    $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

    $hashed = crypt($password);

    $query = "INSERT INTO Users (username,password) VALUES (?,?)";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('ss',$username,$hashed);
    
    $stmt->execute();
    $stmt->close();
}
else if (isset($_POST['login'])){
    $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    
    $query = "SELECT password FROM Users where username = ? LIMIT 1";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if ($hashed_password === crypt($password, $hashed_password)) {
        $_SESSION['username'] = $username;
    }
    $stmt->close();
}
