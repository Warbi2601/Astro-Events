<?php
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");
$sUsername = safeString($_POST['username']);
$sPassword = safeString($_POST['password']);
$sEmail = safeString($_POST['email']);
$isAdmin = false;
$currentDate = date("Y-m-d H:i:s");

$sql = "INSERT INTO Users(Username, PasswordHash, Email, Admin, LastLoginDate)
VALUES(:Username, :PasswordHash, :Email, :isAdmin, :currentDate)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':Username', $sUsername, PDO::PARAM_STR);
$stmt->bindParam(':PasswordHash', $sPassword, PDO::PARAM_STR);
$stmt->bindParam(':Email', $sEmail, PDO::PARAM_STR);
$stmt->bindParam(':isAdmin', $isAdmin, PDO::PARAM_BOOL);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();

header("Location:../../index.php");

exit();
?>