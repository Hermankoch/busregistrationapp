<?php
include_once ('../config/config.php');
include_once ('dbconn.php');
include_once ('db_functions.php');
//require_once (ROOT_PATH.'classes/MyPHPMailer.php');
//use classes\MyPHPMailer;

session_start();

// Student application processing
// Check if the form has been submitted
unset($_SESSION['errors'], $_SESSION['old']);
$_SESSION['old']['name'] = $_POST['name'] ?? '';
$_SESSION['old']['surname'] = $_POST['surname'] ?? '';
$_SESSION['old']['phone'] = $_POST['phone'] ?? '';
$_SESSION['old']['grade'] = $_POST['grade'] ?? '';
$_SESSION['old']['bus_route_morning'] = $_POST['bus_route_morning'] ?? '';
$_SESSION['old']['bus_route_afternoon'] = $_POST['bus_route_afternoon'] ?? '';

if (isset($_POST['name'], $_POST['surname'], $_POST['phone'], $_POST['grade'], $_POST['bus_route_morning'], $_POST['bus_route_afternoon'])) {
    $errors = [];

    $name = $_POST['name'];
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

    $grade = $_POST['grade'];
    $regex = '/^[8-9]|1[0-2]$/';
    if (!preg_match($regex, $grade)) {
        $errors['grade'] = 'Grade must be between 8 and 12.';
    }

    if($_POST['bus_route_morning'] === 'none' && $_POST['bus_route_afternoon'] === 'none'){
        $errors['bus_route'] = 'Please select at least one route that is not none';
    }

    if(count($errors) > 0){
        $_SESSION['errors'] = $errors;
        header('location: ' . BASE_URL . 'student_application.php');
        exit();
    }

    $busNrM = (int)$_POST['bus_route_morning'][0];
    $busNrA = (int)$_POST['bus_route_afternoon'][0];

    // Get bus route capacity
    // Todo: if one of the routes is none add logic to only check the other route
    if($_POST['bus_route_morning'] == $_POST['bus_route_afternoon']){
        $morning = checkBusCapacity($busNrM);
        $afternoon = $morning;
    } else {
        $morning = checkBusCapacity($busNrM);
        $afternoon = checkBusCapacity($busNrA);
    }

    $linkedID['columnName'] = 'ParentID';
    if($_SESSION['user_type'] === 'admin'){
        $linkedID['columnName'] = 'AdminID';
    }

    $linkedID['ID'] = $_SESSION['user_id'];
    // Import the learner to get the ID
    $learner = importLearner($name, $surname, $phone, $grade, $linkedID);
    $infoArr = [];

    $busRouteInfoEmail = '';
    // Check if there is pickup space or add to waitinglist
    if($morning['SeatsForPickup'] > 0){
        // Update bus route and learner
        updateBusRoute($busNrM, 'SeatsForPickup');
        updateLearner($learner, 'PickupID', $_POST['bus_route_morning']);
        $busRouteInfoEmail = '<p>Morning pickup: '.$_POST['bus_route_morning'] . '</p>';
    } else {
        // Add to waiting list
        $infoArr['morning'] = 'Learner added to waiting list for morning pickup.';
        addToWaitingList($learner,$_POST['bus_route_morning'], 'Pickup');
        $busRouteInfoEmail = '<p>Waiting list for morning: '.$_POST['bus_route_morning'] .'</p>';
    }

    // Check if there is dropoff space or add to waitinglist
    if($afternoon['SeatsForDropOff'] > 0){
        //update bus route and learner
        updateBusRoute($busNrA, 'SeatsForDropOff');
        updateLearner($learner, 'DropOffID', $_POST['bus_route_afternoon']);
        $busRouteInfoEmail .= '<p>Afternoon drop-off: '.$_POST['bus_route_afternoon'] . '</p>';
    } else {
        //add to waiting list
        $infoArr['afternoon'] = 'Learner added to waiting list for afternoon drop-off.';
        addToWaitingList($learner,$_POST['bus_route_afternoon'], 'DropOff');
        $busRouteInfoEmail .= '<p>Waiting list for afternoon: '.$_POST['bus_route_afternoon'] .'</p>';
    }

    $_SESSION['success'] = 'Student application submitted successfully.';
    if(count($infoArr) > 0){
        $_SESSION['info'] = $infoArr;
    }

    //Send email to user logged in that filed the application
//    $mail = new MyPHPMailer();
//    $subject = 'Student application submitted';
//    $to = $_SESSION['user_email'];
//    $body = '<p>Dear ' . ($_SESSION['user_name'] ?? $_SESSION['user_initials']) .' '. $_SESSION['user_surname'] . ',</p>';
//    $body .= '<p>Your student application has been received.</p>';
//    $body .= '<p>'.$name.' ' .$surname.' Grade '. $grade.'</p>';
//    $body .= '<p>Bus route information:</p>';
//    $body .= $busRouteInfoEmail;
//    $body .= '<p>Kind regards,<br>Impumelelo High School</p>';
//    $mail->sendEmail($to, $subject, $body);

    unset($_SESSION['old']);
    if($_SESSION['user_type'] === 'admin'){
        header('location: ' . BASE_URL . 'admin/dashboard.php');
        exit();
    }

    header('location: ' . BASE_URL . 'parent/dashboard.php');
    exit();
}

