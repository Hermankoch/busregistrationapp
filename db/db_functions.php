<?php
// Contains the functions for CRUD operations

function importParent($name, $surname, $phone, $email, $password) {
    global $db;
    $query = 'INSERT INTO parents (Name, Surname, PhoneNumber, Email, Password) VALUES (:name, :surname, :phone, :email, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':surname', $surname);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':email', strtolower($email));
    $statement->bindValue(':password', $password);
    $statement->execute();
    if($statement){
        return $db->lastInsertId();
    }else {
        return 0;
    }
}
function importLearner($name, $surname, $phone, $grade, $linkedID, $pickupID = null, $dropOffID = null) {
    global $db;
    $query = 'INSERT INTO learners (Name, Surname, PhoneNumber, Grade, '.$linkedID['columnName'].', PickupID, DropOffID)';
    $query .= ' VALUES (:name, :surname, :phone, :grade, :linkedID, :pickupID, :dropOffID)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':surname', $surname);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':grade', $grade);
    $statement->bindValue(':linkedID', $linkedID['ID']);
    $statement->bindValue(':pickupID', $pickupID);
    $statement->bindValue(':dropOffID', $dropOffID);
    $statement->execute();
    if($statement){
        return $db->lastInsertId();
    }else {
        return 0;
    }
}
function getMorningBusRoutes(){
    global $db;
    $query = 'SELECT busstops.BusStopID, busstops.LocationName, pickuptimes.Time FROM busstops, pickuptimes WHERE busstops.BusStopID = pickuptimes.BusStopID';
    $statement = $db->prepare($query);
    $statement->execute();
    $busMorningInfo = $statement->fetchAll();
    $statement->closeCursor();
    return $busMorningInfo;
}

function getAfternoonBusRoutes(){
    global $db;
    $query = 'SELECT busstops.BusStopID, busstops.LocationName, dropofftimes.Time FROM busstops, dropofftimes WHERE busstops.BusStopID = dropofftimes.BusStopID';
    $statement = $db->prepare($query);
    $statement->execute();
    $busAfternoonInfo = $statement->fetchAll();
    $statement->closeCursor();
    return $busAfternoonInfo;
}

// Check if there is open space on the bus
function checkBusCapacity($busRouteId){
    global $db;
    $query = 'SELECT * FROM availableseats WHERE BusRouteID = :busRouteId';
    $statement = $db->prepare($query);
    $statement->bindValue(':busRouteId', $busRouteId);
    $statement->execute();
    $busStopInfo = $statement->fetch();
    $statement->closeCursor();
    return $busStopInfo;
}

function updateBusRoute($busRouteId, $column){
    global $db;
    $query = 'UPDATE availableseats SET '.$column.' = '.$column.' - 1 WHERE BusRouteID = :busRouteId';
    $statement = $db->prepare($query);
    $statement->bindValue(':busRouteId', $busRouteId);
    $statement->execute();
    $statement->closeCursor();
}

function addToWaitingList($learnerID, $busStopID, $pickupDropOff){
    global $db;
    $query = 'INSERT INTO waitinglist (LearnerID, BusStopID, PickupOrDropOff, ListDate) VALUES (:learnerID, :busStopID, :pickupDropOff, CURRENT_TIMESTAMP)';
    $statement = $db->prepare($query);
    $statement->bindValue(':learnerID', $learnerID);
    $statement->bindValue(':busStopID', $busStopID);
    $statement->bindValue(':pickupDropOff', $pickupDropOff);
    $statement->execute();
    $statement->closeCursor();
}

function updateLearner($learnerID, $column, $value){
    global $db;
    $query = 'UPDATE learners SET '.$column.' = :value WHERE LearnerID = :learnerID';
    $statement = $db->prepare($query);
    $statement->bindValue(':learnerID', $learnerID);
    $statement->bindValue(':value', $value);
    $statement->execute();
    $statement->closeCursor();
}

function checkParent($email){
    global $db;
    $query = 'SELECT * FROM parents WHERE Email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', strtolower($email));
    $statement->execute();
    $parentInfo = $statement->fetch();
    $statement->closeCursor();
    return $parentInfo;
}