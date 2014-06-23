<?php
/*
 * Get the leader board. Either for 7 days or all time
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$days = filter_input(INPUT_GET, 'days', FILTER_SANITIZE_STRING);
$loc = filter_input(INPUT_GET, 'loc', FILTER_SANITIZE_STRING); $loc = str_replace("_"," ",$loc);
    
// Array for JSON response
$response = array();

// Include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// Get a list of leaders
$cols = "area,city,country,date7,score7,dateall,scoreall,name,uuid";
$locs = "CONCAT(city,'>',area,'>',country)='$loc' OR CONCAT(area,'>',country)='$loc' OR country='$loc'";
$result = mysql_query(
    "SELECT $cols FROM leaders WHERE $locs ORDER BY score$days DESC LIMIT 50") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    $response["leaders"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["area"] = $row["area"];
        $product["city"] = $row["city"];
        $product["country"] = $row["country"];
        $product["date7"] = $row["date7"];
        $product["score7"] = $row["score7"];
        $product["dateall"] = $row["dateall"];
        $product["scoreall"] = $row["scoreall"];
        $product["name"] = $row["name"];
        $product["uuid"] = $row["uuid"];

        // push single link into final response array
        array_push($response["leaders"], $product);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no leaders found
    $response["success"] = 0;
    $response["message"] = "No leaders found";

    // echo no users JSON
    echo json_encode($response);
}
?>