<?php

$authRoutes = [
    "index.php",
    "signup.php"
];

$userRoutes = [
    "home.php",
    "historique.php",
    "menuDetails.php",
];

$adminRoutes = [
    "dashboard.php",
    "menus.php",
    "plat.php"
];

$currentPage = basename($_SERVER["PHP_SELF"]);

$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;


// if the user already auth and and the current page is an auth page
// redirect him to the home page
if ($role && in_array($currentPage, $authRoutes)) {
    header("location: home.php");
}

//  if the user is not loged in and the page is admin page or user page
// redirect him to login page
if (!$role && (in_array($currentPage, $userRoutes) || in_array($currentPage, $adminRoutes))) {
    header("location: index.php");
    exit;
}
if ($role == "user" && in_array($currentPage, $adminRoutes)) {
    header("location: home.php");
}

