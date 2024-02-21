<?php
include_once('../../config/config.php');
include_once(ROOT_PATH . 'db/dbconn.php');

function removeLearner($learnerArr)
{
    global $db;
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    try {
        $query = 'UPDATE learners SET '.$learnerArr['column'].' = NULL WHERE LearnerID = :LearnerID';
        $statement = $db->prepare($query);
        $statement->bindValue(':LearnerID', $learnerArr['LearnerID']);
        $statement->execute();
        $statement->closeCursor();
        if ($statement->rowCount() === 0) {
            throw new Exception('No data found for the given LearnerID');
        }
        addBusSpace($learnerArr['column'], $learnerArr['BusStopID']);
        return json_encode([
            'status' => 200,
            'message' => 'Learner removed successfully',
            'data' => []
        ], JSON_THROW_ON_ERROR);
    } catch (Exception $e) {
        return json_encode([
            'status' => 500,
            'message' => $e->getMessage(),
            'data' => []
        ], JSON_THROW_ON_ERROR);
    }
}

function addBusSpace($type, $busStopId)
{
    $busRouteId = (int)substr($busStopId, 0, 1);
    $column = 'SeatsForDropoff';
    if($type === 'PickupID')
    {
        $column = 'SeatsForPickup';
    }
    global $db;
    $query = 'UPDATE availableseats SET '.$column.' = '.$column.' + 1 WHERE BusRouteID = :busRouteId';
    $statement = $db->prepare($query);
    $statement->bindValue(':busRouteId', $busRouteId);
    $result = $statement->execute();
    $statement->closeCursor();
    if(!$result)
    {
        throw new Exception('Error updating available seats');
    }
}

echo removeLearner(json_decode(file_get_contents("php://input"), true));