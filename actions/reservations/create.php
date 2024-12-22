<?php
    include "./inc/connectDB.php";
    include "./lib/validateInput.php";
    session_start();

if(isset($_POST["create"])){
    if($_GET["menuId"]){
        $date = validateInput($_POST["reservation_date"]) ?? null;
        $time = validateInput($_POST["reservation_time"]) ?? null;
        $people = validateInput($_POST["num_people"]) ?? null;
        $menuId = validateInput($_POST["id"]) ?? null;
        $userId = $_SESSION["id"];

        if(!$date || !$time || !$people){
            echo "Fields are required";
            exit();
        }
        $stm = $conn->prepare("INSERT INTO reservation (date,time,number_of_people,menu_id,user_id) VALUES(?,?,?,?,?)");
        $stm->bind_param("sssss",$date,$time,$people,$menuId,$userId);
        $stm->execute();
        if($stm){
            echo "reservation created";
        }
    }
}