<?php
/*
 * Following code will list all the products
 */
header('Access-Control-Allow-Origin: *');

header('Content-Type: text/html');
$diff = filter_input(INPUT_GET, 'diff', FILTER_SANITIZE_NUMBER_INT);
error_log("getRandomLink: diff1 = $diff");
$diffhigh = ($diff/1000) + 0.1;  // Set higher limit on difficulty
$difflow = ($diff/1000) - 0.1;   // .. and for lower
error_log("getRandomLink: diffhigh = $diffhigh and difflow = $difflow");

// Array for JSON response
$response = array();

// Include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// Get a random link from the links table
$select = "SELECT * FROM links WHERE anstype='T' AND difficulty BETWEEN $difflow AND $diffhigh ORDER BY RAND() LIMIT 1";
$result = mysql_query($select) or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    header('Content-Type: application/json');
    // looping through all results
    $response["links"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["songtitleA"] = $row["songtitleA"];
        $product["artistA"] = $row["artistA"];
        $product["itemA"] = $row["itemA"];
        $product["songtitleB"] = $row["songtitleB"];
        $product["artistB"] = $row["artistB"];
        $product["itemB"] = $row["itemB"];
        $product["linktype"] = $row["linktype"];
        $product["extra"] = $row["extra"];

        // push single link into final response array
        array_push($response["links"], $product);
    }
    // success
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
