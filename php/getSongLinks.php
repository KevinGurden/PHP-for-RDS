<?php
/*
 * Retrun all links from a particular song 
 */
header('Access-Control-Allow-Origin: *');

$songid = $_GET['songid'];
$artist = $_GET['artist'];
$difflow = $_GET['difflow'];
$diffhigh = $_GET['diffhigh'];
$avoidLTs = $_GET['avoidlts'];
$avoidSongs = $_GET['avoidsongs'];
    
//header('Content-Type: text/html');
//error_log("getSongLinks: songid=$songid, artist=$artist, difflow=$difflow, diffhigh=$diffhigh, avoidLTs=$avoidLTs, avoidSongs=$avoidSongs");

// Array for JSON response
$response = array();

// Include db connect class
require_once __DIR__ . '/db_connect.php';

error_log("getSongLinks connect");

// connecting to db
$db = new DB_CONNECT();

error_log("getSongLinks query");

// Get link from the links table
if ($avoidLTs!="") {$avoidLTs = "AND LOCATE(linktype, '$avoidLTs')=0";};
if ($avoidSongs!="") {$avoidSongs = "AND LOCATE(songidB, '$avoidSongs')=0";};
$select = "SELECT * FROM links WHERE songidA=$songid AND artistA='$artist' AND (difficulty BETWEEN $difflow AND $diffhigh) $avoidLTs $avoidSongs";
$result = mysql_query($select) or die(mysql_error());

error_log("getSongLinks done query");
    
// check for empty result
if (mysql_num_rows($result) > 0) {
    header('Content-Type: application/json');
    // looping through all results
    $response["links"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["songidA"] = $row["songidA"];
        $product["songtitleA"] = $row["songtitleA"]; $product["artistA"] = $row["artistA"];
        $product["itemA"] = $row["itemA"]; $product["arttypeA"] = $row["arttypeA"];
        $product["songidB"] = $row["songidB"];
        $product["songtitleB"] = $row["songtitleB"]; $product["artistB"] = $row["artistB"];
        $product["itemB"] = $row["itemB"]; $product["arttypeB"] = $row["arttypeB"];
        $product["linktype"] = $row["linktype"]; $product["extra"] = $row["extra"];
        $product["difficulty"] = $row["difficulty"]; $product["anstype"] = $row["anstype"];
        $product["need"] = $row["need"]; $product["incorrect"] = $row["incorrect"];

        // push single link into final response array
        array_push($response["links"], $product);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
    error_log("getSongLinks sent");
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
