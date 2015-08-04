<?php
require_once('database_connect.php');
session_start();

if(isset($_POST['name']) AND isset($_POST['msg']) AND isset($_POST['time'])){
    $query = 'INSERT INTO msg(username,msg,time) VALUES(?,?,?)';
    $stmt = $connect->prepare($query);
    
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $msg = filter_var($_POST['msg'],FILTER_SANITIZE_STRING);
    $time = filter_var($_POST['time'],FILTER_SANITIZE_STRING);
    
    $stmt->bind_param('sss',$name, $msg, $time);
    $stmt->execute();
    $stmt->close();
    exit;
}else if(isset($_POST['refresh'])){
    $query = "SELECT username,msg,time FROM(SELECT * FROM Msg ORDER BY postID DESC LIMIT 50) TMP ORDER BY postID ASC";
    $stmt = $connect->prepare($query);
    $stmt->execute();
    
    $stmt->bind_result($name,$msg,$time);
    while ($stmt->fetch()) {
        $now = date("F j, Y, g:i a",time());  
        if($_SESSION AND $name === $_SESSION['username']){
            echo "<div style='display:inline-flex'><h4><strong>$name</strong></h4><h4 class='bubble_from' style='margin-left: 50px;'>$msg <p id='time'>$now</p></h4></div>";
        }else{
             echo "<div style='display:inline-flex'><h4 class='bubble_to' style='margin-right: 50px;'>$msg <p id='time'>$now</p></h4><h4><strong>$name</strong></h4></div>";
        }
    }
    $stmt->close();
    exit;
}
