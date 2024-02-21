<?php
include_once ('../../config/config.php');
include_once (ROOT_PATH . 'db/dbconn.php');

function getBusLearners()
{
    Global $db;
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    try {
        $query = 'SELECT * FROM learners WHERE PickupID IS NOT NULL OR DropoffID IS NOT NULL';
        $statement = $db->prepare($query);
        $statement->execute();
        $busLearners = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return json_encode([
            'status' => 200,
            'message' => 'Data fetched successfully',
            'data' => $busLearners
        ], JSON_THROW_ON_ERROR);
    } catch (Exception $e) {
        return json_encode([
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage(),
            'data' => []
        ], JSON_THROW_ON_ERROR);
    }
}
echo getBusLearners();