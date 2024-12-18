<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "cuisine";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    echo "Error" . mysqli_connect_error();
}

