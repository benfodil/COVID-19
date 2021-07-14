<?php
$host    = "localhost";
$user    = "root";
$pass    = "root";
$db_name = "covid";
$connect = @mysqli_connect("$host","$user","$pass","$db_name");
mysqli_query($connect,"SET NAMES 'utf8'");
mysqli_query($connect,'SET CHARACTER SET utf8');
?>