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

////////////////////

$sql = "SELECT s.DateTime as DateTime, s.VenueID as VenueID, e.Name as EventName
FROM `SHOW` as s
INNER JOIN Events as e
ON s.EventID = e.ID
WHERE s.ID = :ID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ID', $showID, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetchObject();


//Save variables to be put in the purchases table
$pDateTime = $row->DateTime;
$pVenueID = $row->VenueID;
$pEventName = $row->EventName;

////////////////////////

//Update purchases table
$sql = "INSERT INTO PURCHASES(UserID, VenueID, EventName, DateTime, Cost, NumberOfTickets) VALUES(:UserID, :VenueID, :EventName, :DateTime, :Cost, :NumberOfTickets)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':UserID', $userID, PDO::PARAM_INT);
$stmt->bindParam(':VenueID', $pVenueID, PDO::PARAM_INT);
$stmt->bindParam(':EventName', $pEventName, PDO::PARAM_STR);
$stmt->bindParam(':DateTime', $pDateTime, PDO::PARAM_STR);
$stmt->bindParam(':Cost', $costOfPurchase, PDO::PARAM_STR);
$stmt->bindParam(':NumberOfTickets', $numOfTicketsToBuy, PDO::PARAM_INT);
$stmt->execute();

$_SESSION['purchaseID'] = $pdo->lastInsertId();
$_SESSION['showID'] = $showID;

header("Location: ../../purchase.php");

//ensure no more code is ran
exit();

?>