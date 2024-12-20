<?php

if(isset($_POST["signout"])){
    session_destroy();
    header("location: index.php");
    exit();
}