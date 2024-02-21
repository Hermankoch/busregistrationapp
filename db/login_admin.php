<?php
include_once ('../config/config.php');
include_once ('dbconn.php');

// Send back to login if email and password not set
if(!isset($_POST['email'], $_POST['password'])){
    header('location: ' . BASE_URL . 'admin_login.php');
    exit();
}

$email = $_POST['email'];

//check against database
$statement = 'SELECT adminid, email, password, initials, surname FROM administrators WHERE email = :email';
$statement = $db->prepare($statement);
$statement->bindValue(':email', $email);
$statement->execute();
$admin = $statement->fetch(PDO::FETCH_ASSOC);

if(!$admin && !password_verify($_POST['password'], $admin['password'])){
    header('location: ' . BASE_URL . 'admin_login.php?error=Your email or password does not match our records');
    exit();
}

session_start();
$_SESSION['user_id'] = $admin['adminid'];
$_SESSION['user_type'] = 'admin';
$_SESSION['user_email'] = $admin['email'];
$_SESSION['user_initials'] = $admin['initials'];
$_SESSION['user_surname'] = $admin['surname'];

header('location: ' . BASE_URL . 'admin/dashboard.php');
exit();

