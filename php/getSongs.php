<?php
/*
 * Get a list of songs */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Array for JSON response
$response = array();

// Include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// Get a list of songs
$result = mysql_query(
    "SELECT songtitle,artist FROM songs") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    $response["songs"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["songid"] = $row["songid"];
        $product["songtitle"] = $row["songtitle"];
        $product["artist"] = $row["artist"];

        // push single link into final response array
        array_push($response["songs"], $product);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no songs found
    $response["success"] = 0;
    $response["message"] = "No products found";

    // echo no users JSON
    echo json_encode($response);
}
?>
