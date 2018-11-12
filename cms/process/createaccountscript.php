<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

//variable declarations
$sUsername = safeString($_POST['username']);
$sPassword = safeString($_POST['password']);
$passwordRepeat = safeString($_POST['passwordRepeat']);
$sEmail = validateEmail($_POST['email']);
$isAdmin = false;
$currentDate = date("Y-m-d H:i:s");

//mail variables
$emailSubject = "Events Website - Please Confirm Your Email";

$email_encoded = rtrim(strtr(base64_encode($sEmail), '+/', '-_'), '=');

$emailMsg = "localhost/events-website/cms/process/confirmemail.php?id=$email_encoded";

//password hashing
$hashedPassword = password_hash($sPassword, PASSWORD_BCRYPT);

//Check all required fields have been filled out

if($sUsername == "" || $sPassword == "" || $passwordRepeat == "" || $sEmail == "")
{
    $_SESSION['regError'] = 5;
    $referer = "createaccount.php";  
    header("Location: ../../".$referer);
    exit;
}

//Email Validation
if(!$sEmail)
{  
    $_SESSION['errorReg'] = 1;  
    $referer = "createaccount.php";  
    header("Location: ../../".$referer);  
    exit; 
}

if($sPassword != $passwordRepeat)
{
    $_SESSION['regError'] = 2;
    $referer = "createaccount.php";  
    header("Location: ../../".$referer);  
    exit;
}

$sql= "SELECT * FROM Users WHERE Username = :Username OR Email = :Email"; 
$stmt = $pdo->prepare($sql); 
$stmt->bindParam(':Username', $sUsername, PDO::PARAM_STR);
$stmt->bindParam(':Email', $sEmail, PDO::PARAM_STR); 
$stmt->execute(); 

if($stmt->rowCount() == 1)
//Matching details in DB
{  
    $row = $stmt->fetchobject();
    if($row->Email == $sEmail)
    //Email is matching
    {
        $_SESSION['regError'] = 3;  
    }
    else {
        //Username is matching
        $_SESSION['regError'] = 4;  
    }
    $referer = "createaccount.php";  
    header("Location: ../../".$referer);
    exit;  
}
else
{  
    //create account code
    $sql = "INSERT INTO Users(Username, PasswordHash, Email, Admin, LastLoginDate)
    VALUES(:Username, :PasswordHash, :Email, :isAdmin, :currentDate)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':Username', $sUsername, PDO::PARAM_STR);
    $stmt->bindParam(':PasswordHash', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(':Email', $sEmail, PDO::PARAM_STR);
    $stmt->bindParam(':isAdmin', $isAdmin, PDO::PARAM_BOOL);
    $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
    $stmt->execute();

    mail($sEmail, $emailSubject, $emailMsg);

    //redirect
    header("Location:../../login.php");

    //ensure no more code is ran
    exit();
}

?>