<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

//variable declarations
$sName = safeString($_POST['name']);

//validation for if there is already an artist with the exact same name
$sql = "SELECT Name FROM ARTIST WHERE Name = :Name";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':Name', $sName, PDO::PARAM_STR);
$stmt->execute();

$row = $stmt->fetchObject();

if($stmt->rowCount() > 0) {
    $_SESSION['Error'] = $sName . ' already exists';
    header('Location: ../../admin.php');
    //ensure no more code is ran
    exit();
}

//add artist code
$sql = "INSERT INTO ARTIST(Name) VALUES(:Name)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':Name', $sName, PDO::PARAM_STR);
$stmt->execute();

$_SESSION['Success'] = $sName . ' successfully added to the list of artists';

header('Location: ../../admin.php');

//ensure no more code is ran
exit();

?>