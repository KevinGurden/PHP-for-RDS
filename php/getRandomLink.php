<?php
/*
 * Following code will list all the products
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$diff = filter_input(INPUT_GET, 'diff', FILTER_SANITIZE_NUMBER_FLOAT);
$diffhigh = $diff + 0.1;
$difflow = $diff - 0.1;
    
// Array for JSON response
$response = array();

// Include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// Get a random link from the links table
$result = mysql_query(
    "SELECT * FROM links WHERE anstype='T' AND difficulty BETWEEN $difflow AND $diffhigh ORDER BY RAND() LIMIT 1") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
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
    // no products found
    $response["success"] = 0;
    $response["message"] = "No products found";

    // echo no users JSON
    echo json_encode($response);
}
?>
