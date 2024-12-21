<?php
include "./lib/validateInput.php";
include "./inc/connectDB.php";

$errors = [];

$username  = $email = $password = "";
$toast = null;
if (isset($_POST['signup'])) {
    $errors["usernameError"] =  $errors["emailError"] = $errors["passwordError"] = $errors["account"] = null;

    $username = validateInput($_POST["username"]);
    $email = validateInput($_POST["email"]);
    $password = validateInput($_POST["password"]);
    if (empty($username)) {
        $errors["usernameError"] = "Username is required";
    }
    if (empty($email)) {
        $errors["emailError"] = "Email is required";
    }
    if (empty($password)) {
        $errors["passwordError"] = "Password is required";
    }
    if (empty(array_filter($errors))) {
        $stm = $conn->prepare("SELECT * FROM user WHERE username=? OR email = ?");
        $stm->bind_param("ss", $username, $email);
        $stm->execute();
        $stm->store_result();
        if ($stm->num_rows > 0) {
            $errors["account"] = "Username or email already exits";
        } else {
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $stm = $conn->prepare("INSERT INTO user (username , email, password) VALUES (?,?,?)");
            $stm->bind_param("sss", $username, $email, $hashedPass);
            if ($stm->execute()) {
                $toast = ' <div
                class="w-64 notification z-50 h-10 flex items-center justify-between duration-300 px-3 top-5 fixed transition right-5 translate-x-72 bg-white rounded-md border-l-4 border-green-600">
                    <p class="text-sm text-neutral-800 font-bold">
                        You signed up successfully
                    </p>
                <img src="../assets/accept.png" alt="" class="w-4" />
            </div>
            ';
            }
            $username  = $email = $password = "";
        }
    }
}
