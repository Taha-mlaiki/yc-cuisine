<?php
include "./lib/validateInput.php";
include "./inc/connectDB.php";

$errors = [];

$email = $password = "";

$toast = null;
if (isset($_POST['login'])) {

    $errors["emailError"] = $errors["passwordError"] = $errors["account"] = null;

    $email = validateInput($_POST["email"]);
    $password = validateInput($_POST["password"]);
    if (empty($email)) {
        $errors["emailError"] = "Email is required";
    }
    if (empty($password)) {
        $errors["passwordError"] = "password is required";
    }
    if (empty(array_filter($errors))) {
        $stm = $conn->prepare(
            "SELECT user.id, user.username, user.email, user.password, 
            (SELECT name FROM role WHERE id = user.role_id) AS role 
            FROM user WHERE email = ?"
        );
        $stm->bind_param("s", $email);
        $stm->execute();
        $result = $stm->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if (!password_verify($password, $data["password"])) {
                $errors["account"] = "Email or password Invalid!";
            } else {
                $_SESSION["username"] =  $data["username"];
                $_SESSION["email"] =  $data["email"];
                $_SESSION["role"] = $data["role"];
            }
        } else {
            $errors["account"] = "Account does not exist";
        }
    }
}
