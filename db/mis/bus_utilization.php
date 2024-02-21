<?php
include_once ('../../config/config.php');
include_once (ROOT_PATH . 'db/dbconn.php');

function getAvailableSeats()
{
    Global $db;
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    try {
        $query = 'SELECT BusRouteID, SeatLimit, SeatsForPickup, SeatsForDropOff, ';
        $query .= 'ROUND(((SeatLimit - SeatsForPickup) * 100.0 / SeatLimit), 2) AS PickupUtilization, ';
        $query .= 'ROUND(((SeatLimit - SeatsForDropOff) * 100.0 / SeatLimit), 2) AS DropOffUtilization ';
        $query .= 'FROM availableseats ORDER BY BusRouteID';

        $statement = $db->query($query);
        $availableSeats = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return json_encode([
            'status' => 200,
            'message' => 'Data fetched successfully',
            'data' => $availableSeats
        ], JSON_THROW_ON_ERROR);
    } catch (Exception $e) {
        return json_encode([
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage(),
            'data' => []
        ], JSON_THROW_ON_ERROR);
    }
}
echo getAvailableSeats();