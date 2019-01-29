<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

//variable declarations
$sEventID = safeString($_POST['eventID']);
$sEventName = safeString($_POST['name']);
$sEventDetails = safeString($_POST['details']);
$sGenre = safeString($_POST['genre']);
$sArtist = safeString($_POST['artist']);

$GenreID = (int)$sGenre;
$ArtistID = (int)$sArtist;
$EventID = (int)$sEventID;

//edit event code

$sql = "UPDATE EVENTS SET Name = :Name, Details = :Details, ArtistID = :ArtistID, GenreID = :GenreID WHERE ID = :EventID";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':Name', $sEventName, PDO::PARAM_STR);
$stmt->bindParam(':Details', $sEventDetails, PDO::PARAM_STR);
$stmt->bindParam(':ArtistID', $ArtistID, PDO::PARAM_INT);
$stmt->bindParam(':GenreID', $GenreID, PDO::PARAM_INT);
$stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);

$stmt->execute();

header("Location: ../../admin.php");

//ensure no more code is ran
exit();

?>