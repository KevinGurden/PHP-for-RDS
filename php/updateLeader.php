<?php
/*
 * Update a leader's scores
 */
header('Access-Control-Allow-Origin: *');

$uuid = $_GET['uuid'];
$score7 = $_GET['score7']; $date7 = $_GET['date7'];
if(isset($_GET['scoreall']) && isset($_GET['dateall'])) {
    $scoreall = $_GET['scoreall'];
    $dateall = $_GET['dateall'];
    $plus = ",scoreall='$scoreall',dateall='$dateall'";
} else {
    $plus = "";
};
    
// Include db connect class
require_once __DIR__ . '/db_config.php';

// connecting to db
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
};


// Update a leader entry into the table
$scores = "score7='$score7',date7='$date7'$plus";
$insert = "UPDATE leaders SET $scores WHERE uuid='$uuid'";
error_log("$insert");
$result = mysqli_query($con, $insert) or die(mysqli_error($con));
?>