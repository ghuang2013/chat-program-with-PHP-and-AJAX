<?php
require_once('database_connect.php');
session_start();

if(isset($_POST['name']) && isset($_POST['msg']) && sset($_POST['time'])){
    $query = 'INSERT INTO msg(username,msg,time) VALUES(?,?,?)';
    $stmt = $connect->prepare($query);
    $stmt->bind_param('sss',$_POST['name'], $_POST['msg'], $_POST['time']);
    $stmt->execute();
    $stmt->close();
    exit;
}else if(isset($_POST['refresh'])){
    $query = 'SELECT username,msg,time FROM Msg LIMIT 50';
    $stmt = $connect->prepare($query);
    $stmt->execute();
    $stmt->bind_result($name,$msg,$time);
    while ($stmt->fetch()) {
        $now = date("F j, Y, g:i a",$time);  
        if($_SESSION AND $name === $_SESSION['username']){
            echo "<div style='display:inline-flex'><h4><strong>$name</strong></h4><h4 class='bubble_from' style='margin-left: 50px;'>$msg <p id='time'>$now</p></h4></div>";
        }else{
             echo "<div style='display:inline-flex'><h4 class='bubble_to' style='margin-right: 50px;'>$msg <p id='time'>$now</p></h4><h4><strong>$name</strong></h4></div>";
        }
    }
    $stmt->close();
    exit;
}
