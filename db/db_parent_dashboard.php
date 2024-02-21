<?php
// Add database connection
require_once('dbconn.php');

// Retrieve student data linked to parent
function getStudentData($parentID) {
    global $db;


    $query = "
    SELECT 
        learners.*, 
        MAX(CASE WHEN waitinglist.PickupOrDropOff = 'Pickup' THEN waitinglist.BusStopID ELSE NULL END) AS PickupWaitingList,
        MAX(CASE WHEN waitinglist.PickupOrDropOff = 'DropOff' THEN waitinglist.BusStopID ELSE NULL END) AS DropOffWaitingList
    FROM 
        learners
    LEFT JOIN 
        waitinglist ON waitinglist.LearnerID = learners.LearnerID
    WHERE 
        learners.ParentID = :parentID
    GROUP BY 
        learners.LearnerID
";


    $statement = $db->prepare($query);
    $statement->bindValue(':parentID', $parentID);
    $statement->execute();
    return $statement->fetchAll();
}