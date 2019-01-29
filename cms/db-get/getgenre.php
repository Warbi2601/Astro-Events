<?php
header('Content-Type: application/json');
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");

$sql = "SELECT * FROM Genre";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$genreArray = array();

while($row = $stmt->fetchObject()) {
    array_push($genreArray, array("genreID" => $row->ID, "genreName" => $row->Name));
}


echo json_encode($genreArray, true);
?>