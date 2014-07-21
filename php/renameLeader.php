<?php
/*
 * Rename a players name in the leader board
 */
header('Access-Control-Allow-Origin: *');

$newname = $_GET['name'];
$uuid = $_GET['uuid'];
    
// Array for JSON response
$response = array();

// Include db connect class
require_once __DIR__ . '/db_config.php';

// connecting to db
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
};


// Get link from the links table
$select = "UPDATE leaders SET name='$newname' WHERE uuid='$uuid'";
$result = mysqli_query($con, $select) or die(mysqli_error($con));
?>
