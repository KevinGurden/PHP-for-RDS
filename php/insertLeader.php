<?php
/*
 * Create a leader entry
 */
header('Access-Control-Allow-Origin: *');

$uuid = $_GET['uuid'];
$name = $_GET['name'];
$score7 = $_GET['score7']; $date7 = $_GET['date7'];
$scoreAll = $_GET['scoreAll']; $dateAll = $_GET['dateAll'];
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
$insert = "INSERT INTO leaders(uuid,name,score7,date7,scoreall,dateall,city,area,country,model);
$result = mysqli_query($con, $insert) or die(mysql_error());
?>
