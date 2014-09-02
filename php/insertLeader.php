<?php
/*
 * Create a leader entry
 */
header('Access-Control-Allow-Origin: *');

$uuid = $_GET['uuid']; $name = $_GET['name'];
if(isset($_GET['gamesplayed']) && $_GET['level7']) && $_GET['levelall'])) {
    $gamesplayed = $_GET['gamesplayed']; $level7 = $_GET['level7']; $levelall = $_GET['levelall'];
    $pluscols = ", gamesplayed, level7,    levelall";
    $plusvals = ",$gamesplayed,'$level7','$levelall'"
} else {
    $pluscols = ""
    $plusvals = "";
};
$score7 = $_GET['score7']; $date7 = $_GET['date7'];
$scoreall = $_GET['scoreall']; $dateall = $_GET['dateall'];
$city = $_GET['city']; $area = $_GET['area']; $country = $_GET['country'];
$model = $_GET['model'];
    
// Include db connect class
require_once __DIR__ . '/db_config.php';

// connecting to db
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
};


// Insert a leader into the table
$cols = "  uuid,   name,  score7,  date7,  scoreall,  dateall,   city,   area,   country,  model";
$vals = "'$uuid','$name',$score7,'$date7',$scoreall,'$dateall','$city','$area','$country','$model'";
$insert = "INSERT INTO leaders($cols$pluscols) VALUES($vals$plusvals)";
$result = mysqli_query($con, $insert) or die(mysqli_error($con));
error_log("$result: from $insert");
?>
