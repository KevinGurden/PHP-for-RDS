<?php
/*
 * Retrun all links from a particular song */
header('Access-Control-Allow-Origin: *');

$songid = $_GET['songid']; //filter_input(INPUT_GET, 'songid', FILTER_SANITIZE_NUMBER_INT);
$artist = $_GET['artist']; //$artistp = filter_input(INPUT_GET, 'artist', FILTER_SANITIZE_STRING);
    header('Content-Type: text/html');
error_log("getSongLinks: songid=$songid, artistp=$artistp");
/* $artist = str_replace("_"," ",$artistp);  // Get rid of underscores
error_log("getSongLinks: songid=$songid, artist=$artist");*/
$difflow = $_GET('difflow'); //filter_input(INPUT_GET, 'difflow', FILTER_SANITIZE_NUMBER_FLOAT); //$difflow = floatval($difflow/1000); // Passed at x1000 to avoid decimals
$diffhigh = $_GET('diffhigh'); //filter_input(INPUT_GET, 'diffhigh', FILTER_SANITIZE_NUMBER_FLOAT); //$diffhigh = floatval($diffhigh/1000); // Ditto
$avoidLTs = $_GET('avoidlts'); //filter_input(INPUT_GET, 'avlts', FILTER_SANITIZE_STRING);
$avoidSongs = $_GET('avoidsongs'); filter_input(INPUT_GET, 'avsongs', FILTER_SANITIZE_STRING);
    
header('Content-Type: text/html');
error_log("getSongLinks: songid=$songid, artist=$artist, difflow=$difflow, diffhigh=$diffhigh, avoidLTs=$avoidLTs, avoidSongs=$avoidSongs");

// Array for JSON response
$response = array();

// Include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// Get link from the links table
if ($avoidLTs!="") {$avoidLTs = "AND LOCATE(linktype, '$avoidLTs')=0";};
if ($avoidSongs!="") {$avoidSongs = "AND LOCATE(songidB, '$avoidSongs')=0";};
$select = "SELECT * FROM links WHERE songidA=$songid AND artistA='$artist' AND (difficulty BETWEEN $difflow AND $diffhigh) $avoidLTs $avoidSongs";
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
        $product["difficulty"] = $row["difficulty"];

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
