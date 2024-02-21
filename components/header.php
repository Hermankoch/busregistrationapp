<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Bus Registration</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- icons -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/icons/fontawesome/css/all.min.css">
    <?php
    session_start();
    if (!isset($_SESSION['user_type'])){
        $_SESSION['user_type'] = 'guest';
    }
    ?>
</head>
<body>