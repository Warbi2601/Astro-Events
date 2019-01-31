<?php
header('Content-Type: application/json');
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");

$sID = $_POST['id'];

$EventID = (int)$sID;

$sql = "SELECT * FROM events where ID = :EventID";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetchObject();

$eventArray = array(
    "Name" => $row->Name, 
    "Details" => $row->Details, 
    "ArtistID" => $row->ArtistID, 
    "GenreID" => $row->GenreID,
    "Picture" => $row->Picture
);

echo json_encode($eventArray, true);
?>