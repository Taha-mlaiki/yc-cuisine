<?php
include "./lib/validateInput.php";
include "./inc/connectDB.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["delete"])) {
        $menu_id = validateInput($_POST["menu_id"]);
        if (empty($menu_id) || !is_numeric($_POST["menu_id"])) {
            echo "No id selected";
            exit();
        }
            $stm = $conn->prepare("DELETE FROM menu WHERE id = ?");
            $stm->bind_param("s", $menu_id);
            $stm->execute();
            $stm = $conn->prepare("DELETE FROM menu_dish WHERE menu_id = ?");
            $stm->bind_param("s", $menu_id);
            $stm->execute();
            if(!$stm){
                echo "Something went wrong while deleting menu";
            }
        return ;
    }

    $name = validateInput($_POST["name"] ?? '');
    $description = validateInput($_POST["description"] ?? '');
    $image = validateInput($_POST["image"] ?? '');
    $dishes = $_POST['dishes'] ?? [];
    $id = $_POST['id'] ?? null;


    if (empty($name) || empty($description) || empty($image) || empty($dishes)) {
        echo "Missing required fields.";
        exit();
    }

    try {
        if (isset($_POST["create"])) {
            // Create a new menu
            $stm = $conn->prepare("INSERT INTO menu (name, description, image) VALUES (?, ?, ?)");
            $stm->bind_param("sss", $name, $description, $image);
            $stm->execute();
            $menu_id = $conn->insert_id;
        } elseif (isset($_POST["edit"])) {
            if (empty($id)) {
                echo "No ID selected for editing.";
                exit();
            }
            // Update existing menu
            $stm = $conn->prepare("UPDATE menu SET name = ?, description = ?, image = ? WHERE id = ?");
            $stm->bind_param("sssi", $name, $description, $image, $id);
            $stm->execute();
            $menu_id = $id;
        } else {
            echo "Invalid operation.";
            exit();
        }

        if (isset($menu_id)) {

            if (isset($_POST["edit"])) {
                $deleteStmt = $conn->prepare("DELETE FROM menu_dish WHERE menu_id = ?");
                $deleteStmt->bind_param("i", $menu_id);
                $deleteStmt->execute();
            }

            // insert new dish relationships
            foreach ($dishes as $dishId) {
                $dishStmt = $conn->prepare("INSERT INTO menu_dish (menu_id, dish_id) VALUES (?, ?)");
                $dishStmt->bind_param("ii", $menu_id, $dishId);
                $dishStmt->execute();
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
