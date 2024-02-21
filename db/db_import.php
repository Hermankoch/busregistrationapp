<?php
//************************
// This file is to import the first test data.
//***********************

// Add a password to run the file for the first time
$password = 'DNkosi123@';
if(!isset($_POST['password']) || $_POST['password'] != $password){
    echo '<form action="db_import.php" method="POST">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" value="Submit">
          </form>';
    exit();
}

echo '<p>Importing data...</p>';


// Add database connection
require_once('dbconn.php');

// Include parent and learner functions that will be reused (importParent, importLearner)
require_once('db_functions.php');

// Include array with 3 bus routes and their data
require_once('db_populate_busses.php');
// Import bus route data
importBusData($busArr);

// Include array with 35 learners (10 for 1AB, 15 for 2AB, 10 for 3AB)
require_once('db_populate_learners.php');

//Import administrator data
$insertIdAdmin = importAdmin('D', 'Nkosi','DNkosi123@', 'dnkosi.impumelelo.high.school@hermankoch.co.za');
if($insertIdAdmin>0) {
    echo '<p>Admin data inserted with ID: ' . $insertIdAdmin . '</p>';
} else {
    echo '<p>Admin data not inserted</p>';
}

// Import parent data
$insertIdParent = importParent('Jane', 'Johnson', '0833780166', 'jane.johnson@hermankoch.co.za', password_hash('JaneJohnson123@', PASSWORD_DEFAULT));
if($insertIdParent>0) {
    echo '<p>Parent data inserted with ID: ' . $insertIdParent . '</p>';
} else {
    echo '<p>Parent data not inserted</p>';
}


function importBusData($busArr) {
    foreach ($busArr as $busRoute) {
        $insertIdBusRoute = importBusRoutes($busRoute['BusRouteID'], $busRoute['BusRouteName']);
        if($insertIdBusRoute > 0) {
            echo '<p>Bus route data inserted with ID: ' . $insertIdBusRoute . '</p>';

            importSeatLimit($busRoute['BusRouteID'], $busRoute['seatLimit'], $busRoute['seatsAvailable']);
            echo '<p>Bus seat limit data inserted</p>';
            //Add bus route location data 6 x Bus stops, pickup times, drop off times
            foreach ($busRoute['LocationNames'] as $stopNumber => $stopLocation) {
                $insertIdBusStop = importBusStops($stopNumber, $stopLocation, $insertIdBusRoute);
                if($insertIdBusStop>0) {
                    importPickUpTimes($stopNumber, $busRoute['pickupTimes'][$stopNumber]);
                    importDropOffTimes($stopNumber, $busRoute['dropOffTimes'][$stopNumber]);
                    echo '<p>Bus pickup/dropOff '.$stopNumber.' inserted</p>';
                } else {
                    echo '<p>Bus route location data not inserted for this bus</p>';
                }
            }
        } else {
            echo '<p>Bus route data not inserted</p>';
        }
    }
}

// Import seat limit
function importSeatLimit($busRouteId, $seatLimit, $seatsAvailable) {
    global $db;
    $query = 'INSERT INTO availableseats (BusRouteID, SeatsForPickup, SeatsForDropOff, SeatLimit)';
    $query .= 'VALUES (:busRouteId, :seatsForPickup, :seatsForDropOff, :seatLimit)';
    $statement = $db->prepare($query);
    $statement->bindValue(':busRouteId', $busRouteId);
    $statement->bindValue(':seatsForPickup', $seatsAvailable);
    $statement->bindValue(':seatsForDropOff', $seatsAvailable);
    $statement->bindValue(':seatLimit', $seatLimit);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;
}


//Import administrator data
function importAdmin($initials, $surname, $password, $email) {
    global $db;
    $query = 'INSERT INTO administrators (Initials, Surname, Password, Email) VALUES (:initials, :surname, :password, :email)';
    $statement = $db->prepare($query);
    $statement->bindValue(':initials', $initials);
    $statement->bindValue(':surname', $surname);
    $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
    $statement->bindValue(':email', $email);
    $result = $statement->execute();
    $statement->closeCursor();
    if($result){
        return $db->lastInsertId();
    }
    return 0;
}

function importBusRoutes($busRouteID, $routeName) {
    global $db;
    $query = 'INSERT INTO busroutes (BusRouteID, RouteName) VALUES (:busrouteid, :routename)';
    $statement = $db->prepare($query);
    $statement->bindValue(':busrouteid', $busRouteID);
    $statement->bindValue(':routename', $routeName);
    $result = $statement->execute();
    $statement->closeCursor();
    if($result){
        return $busRouteID;
    }
    return 0;
}

function importBusStops($busStopID, $locationName, $busRouteID) {
    global $db;
    $query = 'INSERT INTO busstops (BusStopID, LocationName, BusRouteID) VALUES (:busstopid, :locationname, :busrouteid)';
    $statement = $db->prepare($query);
    $statement->bindValue(':busstopid', $busStopID);
    $statement->bindValue(':locationname', $locationName);
    $statement->bindValue(':busrouteid', $busRouteID);
    $result = $statement->execute();
    $statement->closeCursor();
    if($result){
        return $busRouteID;
    }
    return 0;
}

function importPickUpTimes($busStopID, $pickUpTime) {
    global $db;
    $query = 'INSERT INTO pickuptimes (BusStopID, Time) VALUES (:busStopID, :pickupTime)';
    $statement = $db->prepare($query);
    $statement->bindValue(':busStopID', $busStopID);
    $statement->bindValue(':pickupTime', $pickUpTime);
    $result = $statement->execute();
    $statement->closeCursor();
    if($result){
        return $db->lastInsertId();
    }
    return 0;
}
function importDropOffTimes($busStopID, $dropOffTime) {
    global $db;
    $query = 'INSERT INTO dropofftimes (BusStopID, Time) VALUES (:busStopID, :dropOffTime)';
    $statement = $db->prepare($query);
    $statement->bindValue(':dropOffTime', $dropOffTime);
    $statement->bindValue(':busStopID', $busStopID);
    $result = $statement->execute();
    $statement->closeCursor();
    if($result){
        return $db->lastInsertId();
    }
    return 0;
}

