<?php
include "./lib/validateInput.php";
include "./inc/connectDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["delete"])) {
        $dish_id = validateInput($_POST["dish_id"]);
        if (empty($dish_id) || !is_numeric($_POST["dish_id"])) {
            echo "No id selected";
            exit();
        }
        $stm = $conn->prepare("DELETE FROM dish WHERE id = ?");
        $stm->bind_param("s", $dish_id);
        $stm->execute();
        $stm = $conn->prepare("DELETE FROM menu_dish WHERE dish_id = ?");
        $stm->bind_param("s", $dish_id);
        $stm->execute();
        if (!$stm) {
            echo "Something went wrong while deleting a dish";
        }
        return;
    }
    $name = validateInput($_POST["name"]);
    $descritpion = validateInput($_POST["description"]);
    $image = validateInput($_POST["image"]);
    if (!$name || !$descritpion || !$image) {
        exit();
    }
    if (isset($_POST["create"])) {
        $stm = $conn->prepare("INSERT INTO dish (name,description,image_url) VALUES (?,?,?)");
        $stm->bind_param("sss", $name, $descritpion, $image);
        $stm->execute();
    } elseif (isset($_POST["edit"])) {
        if (!isset($_POST["id"])) {
            echo "no id selected";
            exit();
        }
        $id =  $_POST["id"];
        $stm = $conn->prepare("UPDATE dish SET name = ?,description = ?,image_url = ? WHERE id=?");
        $stm->bind_param("ssss", $name, $descritpion, $image, $id);
        $stm->execute();
    }
}
