<?php
    //ini_set('display_errors', 1);
    header('Content-Type: application/json');
    include('../../includes/conn.inc.php');
    include('../../includes/functions.inc.php');

    $sSearchString = null;
    $sSearchArtist = null;
    $sSearchGenre = null;

    if(isset($_POST['searchString'])) $sSearchString = safeString($_POST['searchString']);
    if(isset($_POST['searchArtist'])) $sSearchArtist = (int)safeString($_POST['searchArtist']);
    if(isset($_POST['searchGenre'])) $sSearchGenre = (int)safeString($_POST['searchGenre']);

    if($sSearchArtist != null) {
        //Get the artist name
        $sql = "SELECT Name FROM ARTIST WHERE ID = :ID ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ID', $sSearchArtist, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchObject();
        $sSearchArtist = $row->Name;
    }

    if($sSearchGenre != null) {
        //Get the  genre name
        $sql = "SELECT Name FROM GENRE WHERE ID = :ID ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ID', $sSearchGenre, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchObject();
        $sSearchGenre = $row->Name;
    }

    $sSearchArtist = "%".$sSearchArtist."%";
    $sSearchGenre = "%".$sSearchGenre."%";
    $sSearchString = "%".$sSearchString."%";

    $sql = "SELECT e.ID as ID, e.Name as Name, i.Data as Data
    FROM EVENTS as e
    INNER JOIN images as i
    ON i.ID = e.ImageID
    INNER JOIN Artist as a
    ON a.ID = e.ArtistID
    INNER JOIN Genre as g
    ON g.ID = e.GenreID
    WHERE e.Name LIKE :searchString AND a.Name LIKE :searchArtist AND g.Name LIKE :searchGenre";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':searchString', $sSearchString, PDO::PARAM_STR);
    $stmt->bindParam(':searchArtist', $sSearchArtist, PDO::PARAM_STR);
    $stmt->bindParam(':searchGenre', $sSearchGenre, PDO::PARAM_STR);
    $stmt->execute();

    $returnAr = array();
    while($row = $stmt->fetchObject()){
        array_push($returnAr, array("eventID" => $row->ID, "eventName" => $row->Name, "eventPicture" => base64_encode($row->Data)));
    }
    echo json_encode($returnAr);
?>