<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

$email_encoded = $_GET['id'];
$email_decoded = base64_decode(strtr($email_encoded, '-_', '+/'));

    //create account code
    $sql = "UPDATE Users SET EmailValidated = true WHERE Email = $email_decoded";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
?>