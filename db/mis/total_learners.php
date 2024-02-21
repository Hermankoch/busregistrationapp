<?php
include_once('../../config/config.php');
include_once(ROOT_PATH . 'db/dbconn.php');

function getTotalLearners()
{
    Global $db;
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    try {
        $query = 'SELECT BusRouteID, SeatLimit, SeatsForPickup, SeatsForDropOff, ';
        $query .= '((SeatLimit - SeatsForPickup)* 5) AS MorningTotalLearners, ';
        $query .= '((SeatLimit - SeatsForDropOff)* 5) AS AfternoonTotalLearners ';
        $query .= 'FROM availableseats ORDER BY BusRouteID';
        $statement = $db->query($query);
        $totalLearners = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return json_encode([
            'status' => 200,
            'message' => 'Data fetched successfully',
            'data' => $totalLearners
        ], JSON_THROW_ON_ERROR);
    }catch (Exception $e) {
        return json_encode([
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage(),
            'data' => []
        ], JSON_THROW_ON_ERROR);
    }
}

echo getTotalLearners();