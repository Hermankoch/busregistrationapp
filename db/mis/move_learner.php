<?php
include_once('../../config/config.php');
include_once(ROOT_PATH . 'db/dbconn.php');
require_once (ROOT_PATH.'classes/MyPHPMailer.php');
use classes\MyPHPMailer;

echo moveLearner(json_decode(file_get_contents("php://input"), true));
function checkAvailableSeats($learnerArr)
{
    global $db;
    $column = 'SeatsForDropOff';
    if ($learnerArr['PickupOrDropOff'] === 'Pickup') {
        $column = 'SeatsForPickup';
    }
    // 1A to 1 and cast to int
    $busRouteId = (int)(substr($learnerArr['BusStopID'],0,1));
    $query = 'SELECT * FROM availableseats WHERE BusRouteID = :busRouteId';
    $statement = $db->prepare($query);
    $statement->bindValue(':busRouteId', $busRouteId);
    $statement->execute();
    $availableSeats = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    if(array_key_exists($column, $availableSeats) === false){
        throw new Exception('No available seats for the given BusStopID');
    }
    if ($availableSeats[$column] === 0) {
        throw new Exception('No available seats for the given BusStopID');
    }
    return $availableSeats;
}

function removeFromWaitingList($learnerArr)
{
    global $db;
    $query = 'DELETE FROM waitinglist WHERE WaitingListID = :WaitingListID';
    $statement = $db->prepare($query);
    $statement->bindValue(':WaitingListID', $learnerArr['WaitingListID']);
    $statement->execute();
    $statement->closeCursor();
    if ($statement->rowCount() === 0) {
        throw new Exception('No data found for the given WaitingListID');
    }
}

function moveLearner($learnerArr)
{
    global $db;
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    try {
        // Check if there is space
        checkAvailableSeats($learnerArr);
        //throw new Exception(json_encode($learnerArr));
        // -1 from available seats
        updateAvailableSeats($learnerArr);
        // Remove from waiting list
        removeFromWaitingList($learnerArr);
        // Add bus stop to learner
        updateLearner($learnerArr['LearnerID'], $learnerArr['PickupOrDropOff'], $learnerArr['BusStopID']);
        // Send email notification
        // sendEmailNotification($learnerArr);

        return json_encode([
            'status' => 200,
            'message' => 'Learner moved successfully',
            'data' => []
        ], JSON_THROW_ON_ERROR);
    } catch (Exception $e) {
        return json_encode([
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage(),
            'data' => []
        ], JSON_THROW_ON_ERROR);
    }
}

function updateLearner($learnerId, $pickupOrDropOff, $busStopId)
{
    global $db;
    $column = 'DropOffID';
    if ($pickupOrDropOff === 'Pickup') {
        $column = 'PickupID';
    }
    $query = 'UPDATE learners SET ' . $column . ' = :BusStopID WHERE LearnerID = :LearnerID';
    $statement = $db->prepare($query);
    $statement->bindValue(':BusStopID', $busStopId);
    $statement->bindValue(':LearnerID', $learnerId);
    $statement->execute();
    $statement->closeCursor();

    if ($statement->rowCount() === 0) {
        throw new Exception('No data found for the given LearnerID');
    }
}

function updateAvailableSeats($learnerArr)
{
    global $db;
    $column = 'SeatsForDropOff';
    if ($learnerArr['PickupOrDropOff'] === 'Pickup') {
        $column = 'SeatsForPickup';
    }
    // 1A to 1 and cast to int
    $busRouteId = (int)$learnerArr['BusStopID'][0];
    $query = 'UPDATE availableseats SET ' . $column . ' = ' . $column.' -1 WHERE BusRouteID = :busRouteId AND ' . $column . ' > 0';
    $statement = $db->prepare($query);
    $statement->bindValue(':busRouteId', $busRouteId);
    $statement->execute();
    $statement->closeCursor();
    if ($statement->rowCount() === 0) {
        throw new Exception('No available seats for the given BusStopID');
    }
}

function sendEmailNotification($learnerArr){
    $guardian = ['Email' => '', 'Name' => '', 'Surname' => ''];
    if($learnerArr['ParentID'] !== null){
        $parent = getParent($learnerArr['ParentID']);
        $guardian['Email'] = $parent['Email'];
        $guardian['Name'] = $parent['Name'];
        $guardian['Surname'] = $parent['Surname'];
    } else {
        $admin = getAdmin($learnerArr['AdminID']);
        $guardian['Email'] = $admin['Email'];
        $guardian['Name'] = $admin['Name'];
        $guardian['Surname'] = $admin['Surname'];
    }
    $subject = 'Learner moved from waiting list';
    $to = $guardian['Email'];
    $body = '<p>Dear '.$guardian['Name'].' '. $guardian['Surname'].'</p>';
    $body .= '<p>Your learner has been moved from the waiting list to the bus route.</p>';
    $body .= '<p>Bus route information:</p>';
    $body .= '<p>Bus stop: '.$learnerArr['BusStopID']. ' '.$learnerArr['PickupOrDropOff'].'</p>';
    $body .= '<p>Please note this is only for either the morning/pickup or afternoon/dropoff.<br>As space becomes available your learner will be moved for the other route as well.</p>';
    $body .= '<p>Kind regards,<br>Impumelelo High School</p>';
    $mail = new MyPHPMailer();
    if(!$mail->sendEmail($to, $subject, $body)){
        throw new Exception('Error sending email');
    }
}

function getParent($parentId)
{
    global $db;
    $query = 'SELECT * FROM parents WHERE ParentID = :ParentID';
    $statement = $db->prepare($query);
    $statement->bindValue(':ParentID', $parentId);
    $statement->execute();
    $parent = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    if (!$parent) {
        throw new Exception('No data found for the given ParentID');
    }
    return $parent;
}

function getAdmin($adminId)
{
    global $db;
    $query = 'SELECT AdminID, Initials AS Name, Surname, Email FROM administrators WHERE AdminID = :AdminID';
    $statement = $db->prepare($query);
    $statement->bindValue(':AdminID', $adminId);
    $statement->execute();
    $admin = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    if (!$admin) {
        throw new Exception('No data found for the given AdminID');
    }
    return $admin;
}