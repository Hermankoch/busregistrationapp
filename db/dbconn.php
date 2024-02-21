<?php
// Contain the database connection
$dsn = 'mysql:host=localhost;dbname=bus_db';
$username = 'root';
$password = '';

try {
  $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  $errorMsg = $e->getMessage();
  if(env === 'dev'){
    echo '<p>Database Connection Error: '.$errorMsg.'</p>';
  }
}

