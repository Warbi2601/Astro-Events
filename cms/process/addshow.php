<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

//variable declarations
$sVenue = safeString($_POST['venue']);
$sDate = safeString($_POST['dp']);
$sTicketPrice = safeString($_POST['ticketPrice']);
$sTicketsAvailable = safeString($_POST['ticketsAvailable']);
$EventID = safeString($_POST['eventID']);

//Format date for the database
$formattedDate = date_create_from_format('m/d/Y g:i a', $sDate);
$dateForDB = date("Y-m-d H:i:s", $formattedDate->getTimestamp());

$VenueID = (int)$sVenue;
$EventID = (int)$EventID;

//add event code
$sql = "INSERT INTO `SHOW`(DateTime, VenueID, EventID, TicketsAvailable, TicketPrice) VALUES(:DateTime, :VenueID, :EventID, :TicketsAvailable, :TicketPrice)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':DateTime', $dateForDB, PDO::PARAM_STR);
$stmt->bindParam(':VenueID', $sVenue, PDO::PARAM_INT);
$stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
$stmt->bindParam(':TicketsAvailable', $sTicketsAvailable, PDO::PARAM_STR);
$stmt->bindParam(':TicketPrice', $sTicketPrice, PDO::PARAM_STR);

$stmt->execute();

header('Location: ../../event.php?id=' . $EventID);

//ensure no more code is ran
exit();

?>