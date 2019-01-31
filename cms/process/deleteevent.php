<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

//variable declarations
$sEventID = (int)safeString($_POST['eventID']);

//validation that the user is definitely an administrator


//first delete all shows linked to that event
$sql = "DELETE FROM `SHOW` WHERE EventID = :EventID";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':EventID', $sEventID, PDO::PARAM_INT);

$stmt->execute();

//then delete all artists linked to that event
$sql = "DELETE FROM `eventartist` WHERE EventID = :EventID";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':EventID', $sEventID, PDO::PARAM_INT);

$stmt->execute();

//then delete the event
$sql = "DELETE FROM EVENTS WHERE ID = :EventID";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':EventID', $sEventID, PDO::PARAM_INT);

$stmt->execute();

header("Location: ../../index.php");

//ensure no more code is ran
exit();

?>