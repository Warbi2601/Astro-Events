<?php
header('Content-Type: application/json');
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");

$sql = "SELECT * FROM venue ORDER BY Name ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$venueArray = array();

while($row = $stmt->fetchObject()) {
    array_push($venueArray, array("venueID" => $row->ID, "venueName" => $row->Name, "venueLocation" => $row->Location));
}


echo json_encode($venueArray, true);
?>