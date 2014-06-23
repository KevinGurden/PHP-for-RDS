<?php
/*
 * Rename a players name in the leader board
 */
header('Access-Control-Allow-Origin: *');

$newName = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING); $newName = str_replace("%_%"," ",$newName);  // Get rid of underscores
$uuid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    
// Array for JSON response
$response = array();

// Include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// Get link from the links table
$select = "UPDATE leaders SET name=$newName WHERE uuid=$uuid";
$result = mysql_query($select) or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    header('Content-Type: application/json');
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    header('Content-Type: application/json');
    $response["success"] = 0;
    $response["message"] = "No links found ($select)";
    header('Content-Type: text/html');
    error_log($response["message"]);

    // echo no users JSON
    echo json_encode($response);
}
?>
