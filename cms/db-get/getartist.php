<?php
header('Content-Type: application/json');
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");

$sql = "SELECT * FROM Artist ORDER BY Name ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$artistArray = array();

while($row = $stmt->fetchObject()) {
    array_push($artistArray, array("artistID" => $row->ID, "artistName" => $row->Name));
}

echo json_encode($artistArray, true);
?>