<?php
    //includes
    include("../../includes/sessions.inc.php");
    include("../../includes/conn.inc.php");
    include("../../includes/functions.inc.php");

    //variable declarations
    $sName = safeString($_POST['name']);
    $sLocation = safeString($_POST['location']);
    $sDescription = safeString($_POST['description']);
    $sPicture = safeString($_POST['picture']);


    //validation for if there is already a genre with the exact same name
    $sql = "SELECT Name FROM VENUE WHERE Name = :Name";

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
    $sql = "INSERT INTO VENUE(Name, Location, Description, Picture) VALUES(:Name, :Location, :Description, :Picture)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':Name', $sName, PDO::PARAM_STR);
    $stmt->bindParam(':Location', $sLocation, PDO::PARAM_STR);
    $stmt->bindParam(':Description', $sDescription, PDO::PARAM_STR);
    $stmt->bindParam(':Picture', $sPicture, PDO::PARAM_STR);
    $stmt->execute();

    $_SESSION['Success'] = $sName . ' successfully added';

    header('Location: ../../admin.php');

    //ensure no more code is ran
    exit();
?>