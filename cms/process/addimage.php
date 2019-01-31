<?php
// //includes
// include("../../includes/sessions.inc.php");
// include("../../includes/conn.inc.php");
// include("../../includes/functions.inc.php");

// //variable declarations
// $imgBlob = $_POST['image'];
// $name = "menarena.png";
// $mime = "image/png";

// //add event code
// $sql = "INSERT INTO images(Name, Mime, Data) VALUES(:Name, :Mime, :Data)";

// $stmt = $pdo->prepare($sql);
// $stmt->bindParam(':Name', $name, PDO::PARAM_STR);
// $stmt->bindParam(':Mime', $mime, PDO::PARAM_STR);
// $stmt->bindParam(':Data', $imgBlob, PDO::PARAM_STR);
// $stmt->execute();

// header('Location: ../../index.php');

// //ensure no more code is ran
// exit();

?>