<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

//variable declarations
$sName = safeString($_POST['name']);

//validation for if there is already a genre with the exact same name
$sql = "SELECT Name FROM GENRE WHERE Name = :Name";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':Name', $sName, PDO::PARAM_STR);
$stmt->execute();

$row = $stmt->fetchObject();

if($stmt->rowCount() > 0) {
    $_SESSION['Error'] = 'The Genre ' . $sName . ' already exists';
    header('Location: ../../admin.php');
    //ensure no more code is ran
    exit();
}

//add artist code
$sql = "INSERT INTO GENRE(Name) VALUES(:Name)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':Name', $sName, PDO::PARAM_STR);
$stmt->execute();

$_SESSION['Success'] = $sName . ' successfully added to the list of genres';

header('Location: ../../admin.php');

//ensure no more code is ran
exit();

?>