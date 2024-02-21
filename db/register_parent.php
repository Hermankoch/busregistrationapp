<?php
include_once ('../config/config.php');
include_once ('db_functions.php');
include_once ('dbconn.php');

session_start();
$_SESSION['old']['name'] = $_POST['name'] ?? '';
$_SESSION['old']['surname'] = $_POST['surname'] ?? '';
$_SESSION['old']['phone'] = $_POST['phone'] ?? '';
$_SESSION['old']['email'] = $_POST['email'] ?? '';

if (isset($_POST['name'], $_POST['surname'], $_POST['phone'], $_POST['email'], $_POST['password'])) {
    $errors = [];
    $name = $_POST['name'];
    //validate name
    $regex = '/^[a-zA-Z]+$/';
    if (!preg_match($regex, $name)) {
        $errors['name'] = 'Name must only contain letters and be at least 1 character long.';
    }


    $surname = $_POST['surname'];
    $regex = '/^[a-zA-Z]{2,}$/';
    if (!preg_match($regex, $surname)) {
        $errors['surname'] = 'Surname must only contain letters and be at least 2 characters long.';
    }

    $phone = $_POST['phone'];
    $regex = '/^[0-9]{10}$/';
    if (!preg_match($regex, $phone)) {
        $errors['phone'] = 'Phone number must only contain numbers and be 10 characters long.';
    }

    $email = $_POST['email'];
    $regex = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/';
    if (!preg_match($regex, $email)) {
        $errors['email'] = 'Email must be a valid email address.';
    }

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $regex = '/^.{8,}$/';
    if (!preg_match($regex, $_POST['password'])) {
        $errors['password'] = 'Password must be at least 8 characters long.';
    }

    if(count($errors) > 0){
        $_SESSION['errors'] = $errors;
        header('location: ' . BASE_URL . 'parent_registration.php');
        exit();
    }
    // Check if email already exists
    if(checkParent($email)){
        $_SESSION['errors'] = ['email' => 'Email already exists'];
        header('location: ' . BASE_URL . 'parent_registration.php');
        exit();
    }

    // Insert parent
    $parentID = importParent($name, $surname, $phone, $email, $password);
    if($parentID > 0) {
        $_SESSION['user_id'] = $parentID;
        $_SESSION['user_type'] = 'parent';
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_surname'] = $surname;

        unset($_SESSION['old']);

        header('location: ' . BASE_URL . 'student_application.php');
        exit();
    }

    $_SESSION['errors'] = ['parent' => 'Parent not inserted'];
    header('location: ' . BASE_URL . 'parent_registration.php');
    exit();
}

