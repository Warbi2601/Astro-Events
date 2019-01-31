<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

//variable declarations
$sEventName = safeString($_POST['name']);
$sEventDetails = safeString($_POST['details']);
$sGenre = safeString($_POST['genre']);
$sArtist = safeString($_POST['artist']);
$sPicture = safeString($_POST['picture']);

$GenreID = (int)$sGenre;
$ArtistID = (int)$sArtist;

//add event code

$sql = "INSERT INTO EVENTS(Name, Details, Picture, ArtistID, GenreID) VALUES(:Name, :Details, :Picture, :ArtistID, :GenreID)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':Name', $sEventName, PDO::PARAM_STR);
$stmt->bindParam(':Details', $sEventDetails, PDO::PARAM_STR);
$stmt->bindParam(':Picture', $sPicture, PDO::PARAM_STR);
$stmt->bindParam(':ArtistID', $ArtistID, PDO::PARAM_INT);
$stmt->bindParam(':GenreID', $GenreID, PDO::PARAM_INT);

$stmt->execute();

$EventID = $pdo->lastInsertId();

$sql = "INSERT INTO EVENTARTIST(EventID, ArtistID) VALUES(:EventID, :ArtistID)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
$stmt->bindParam(':ArtistID', $ArtistID, PDO::PARAM_INT);

$stmt->execute();

header("Location: ../../admin.php");

//ensure no more code is ran
exit();

?>