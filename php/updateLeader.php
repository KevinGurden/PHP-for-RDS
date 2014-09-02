<?php
/*
 * Update a leader's scores
 */
header('Access-Control-Allow-Origin: *');

$uuid = $_GET['uuid'];
$score7 = $_GET['score7']; $date7 = $_GET['date7']; $level7 = $_GET['level7'];
if(isset($_GET['scoreall']) && isset($_GET['dateall']) && isset($_GET['levelall'])) {
    $scoreall = $_GET['scoreall']; $dateall = $_GET['dateall']; $levelall = $_GET['levelall'];
    $plus = ",scoreall=$scoreall,dateall='$dateall',levelall='$levelall'";
} else {
    $plus = "";
};
if(isset($_GET['gamesplayed'])) {
    $gamesplayed = $_GET['gamesplayed'];
    $played = ",gamesplayed=$gamesplayed";
} else {
    $played = ",gamesplayed=0";
};
    
// Include db connect class
require_once __DIR__ . '/db_config.php';

// connecting to db
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
};


// Update a leader entry into the table
$scores = "gamesplayed=$gamesplayed,score7=$score7,date7='$date7',level7='$level7'$plus$played";
$insert = "UPDATE leaders SET $scores WHERE uuid='$uuid'";
error_log("$insert");
$result = mysqli_query($con, $insert) or die(mysqli_error($con));
?>