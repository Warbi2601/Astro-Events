<?php
//includes
include("../../includes/user.inc.php");
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

$User = $_SESSION['User'];
$userID = (int)$User->getID();

//variable declarations
$showID = (int)safeString($_POST['showID']);
$numOfTicketsLeft = (int)safeString($_POST['numofTicketsLeft']);
$numOfTicketsToBuy = (int)safeString($_POST['numOfTickets']);
$ticketPrice = (float)safeString($_POST['ticketPrice']);

$ticketsLeft = $numOfTicketsLeft - $numOfTicketsToBuy;
$costOfPurchase = (string)($ticketPrice * $numOfTicketsToBuy);

//Validation to double check the event hasn't sold out
$sql = "SELECT TicketsAvailable, EventID FROM `SHOW` WHERE ID = :ID";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ID', $showID, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetchObject();

if($row->TicketsAvailable < $numOfTicketsToBuy) {
    header('Location: ../../event.php?id=' . $row->EventID);

    $_SESSION['Error'] = "You selected more tickets than are available for this show";

    //ensure no more code is ran
    exit();
}

if($row->TicketsAvailable <= 0){
    header('Location: ../../event.php?id=' . $row->EventID);

    //ensure no more code is ran
    exit();
}

//buy tickets code

$sql = "UPDATE `SHOW` SET TicketsAvailable = :TicketsAvailable WHERE ID = :ID";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':TicketsAvailable', $ticketsLeft, PDO::PARAM_INT);
$stmt->bindParam(':ID', $showID, PDO::PARAM_INT);
$stmt->execute();

//Update purchases table
$sql = "INSERT INTO PURCHASES(ShowID, UserID, Cost, NumberOfTickets) VALUES(:ShowID, :UserID, :Cost, :NumberOfTickets)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ShowID', $showID, PDO::PARAM_INT);
$stmt->bindParam(':UserID', $userID, PDO::PARAM_INT);
$stmt->bindParam(':Cost', $costOfPurchase, PDO::PARAM_STR);
$stmt->bindParam(':NumberOfTickets', $numOfTicketsToBuy, PDO::PARAM_INT);
$stmt->execute();

$_SESSION['showID'] = $pdo->lastInsertId();

header("Location: ../../purchase.php");

//ensure no more code is ran
exit();

?>