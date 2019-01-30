<?php
    //includes
    include("../../includes/sessions.inc.php");
    include("../../includes/conn.inc.php");
    include("../../includes/functions.inc.php");
    require("../../includes/user.inc.php");

    $id = isset($_GET['id']) ? (int)$_GET['id'] : "";

    $sql = "SELECT * FROM images WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ID', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $imageData = $row["0"]["Data"];
    header("content-type: image/png");
    echo $imageData;


    // $row = $stmt->fetchObject();
    // header('Content-Type: ' . $row->Mime);

    // $returnyBoi = $row->Data;
    // echo $returnyBoi;
?>