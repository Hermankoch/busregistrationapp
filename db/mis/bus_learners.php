<?php
session_start();

include_once ('../../config/config.php');
include_once (ROOT_PATH . 'db/dbconn.php');

function getBusLearners()
{
    global $db;

    // Check if headers have already been sent
    if (headers_sent($filename, $linenum)) {
        die("Headers already sent in $filename on line $linenum");
    }

    // Set headers for JSON response
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    try {
        $query = 'SELECT * FROM learners WHERE PickupID IS NOT NULL OR DropoffID IS NOT NULL';
        $statement = $db->prepare($query);
        $statement->execute();
        $busLearners = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        // Output the JSON-encoded data
        echo json_encode([
            'status' => 200,
            'message' => 'Data fetched successfully',
            'data' => $busLearners
        ], JSON_THROW_ON_ERROR);
        exit();
    } catch (Exception $e) {
        // Output the JSON-encoded error message
        echo json_encode([
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage(),
            'data' => []
        ], JSON_THROW_ON_ERROR);
        exit();
    }

}
// Call the function to send the JSON response
getBusLearners();

