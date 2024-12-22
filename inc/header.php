<?php
if(!isset($_SESSION)) session_start();
include "./lib/middleware.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-xWtA/MSrKnMtS/ENhFqDx65VRbTE4U3KyiiIFeNrL4a6PyVrfEam+VGQw6LH0znQPowVUS2VhtGK957ZWNMI/" crossorigin="anonymous">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#f57c3b',
          }
        }
      }
    }
  </script>
</head>

<body>