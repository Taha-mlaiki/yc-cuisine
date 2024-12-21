<?php
include "./lib/validateInput.php";
include "./inc/connectDB.php";
if (isset($_POST["create"])) {
    $name = validateInput($_POST["name"]);
    $descritpion = validateInput($_POST["description"]);
    $image = validateInput($_POST["image"]);
    if (!$name || !$descritpion || !$image) {
        exit();
    }
    $stm = $conn->prepare("INSERT INTO dish (name,description,image_url) VALUES (?,?,?)");
    $stm->bind_param("sss", $name, $descritpion, $image);
    $stm->execute();
}

if (isset($_POST["edit"])) {
    
}
