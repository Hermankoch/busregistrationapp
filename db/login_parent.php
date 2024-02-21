<?php
include_once ('../config/config.php');
include_once ('dbconn.php');

// Send back to login if email and password not set
if(!isset($_POST['email'], $_POST['password'])){
    header('location: ' . BASE_URL . 'parent_login.php');
    exit();
}

$email = $_POST['email'];

//check against database
$statement = 'SELECT parentid, email, password, name, surname FROM parents WHERE email = :email';
$statement = $db->prepare($statement);
$statement->bindValue(':email', $email);
$statement->execute();
$parent = $statement->fetch(PDO::FETCH_ASSOC);

if(!$parent && !password_verify($_POST['password'], $parent['password'])){
    header('location: ' . BASE_URL . 'parent_login.php?error=Your email or password does not match our records');
    exit();
}

session_start();
$_SESSION['user_id'] = $parent['parentid'];
$_SESSION['user_type'] = 'parent';
$_SESSION['user_email'] = $parent['email'];
$_SESSION['user_name'] = $parent['name'];
$_SESSION['user_surname'] = $parent['surname'];

header('location: ' . BASE_URL . 'parent/dashboard.php');
exit();
