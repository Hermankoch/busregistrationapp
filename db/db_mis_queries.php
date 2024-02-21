<?php
require_once('dbconn.php');
function waitingList ()
{
    Global $db;
    $query = 'SELECT * FROM waitinglist, learners WHERE waitinglist.LearnerID = learners.LearnerID';
    $statement = $db->prepare($query);
    $waitingList = $statement->fetchAll();
    return json_encode($waitingList);
}