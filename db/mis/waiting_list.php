<?php
include_once ('../../config/config.php');
include_once (ROOT_PATH . 'db/dbconn.php');

function getWaitingList ()
{
    Global $db;
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    try {
        //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = 'SELECT * FROM waitinglist, learners WHERE waitinglist.LearnerID = learners.LearnerID ORDER BY ListDate';
        $statement = $db->query($query);
        $waitingList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return json_encode([
            'status' => 200,
            'message' => 'Data fetched successfully',
            'data' => $waitingList
        ], JSON_THROW_ON_ERROR);
    } catch (PDOException $e) {
         return json_encode([
             'status' => 500,
             'message' => 'Database error: ' . $e->getMessage(),
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
echo getWaitingList();