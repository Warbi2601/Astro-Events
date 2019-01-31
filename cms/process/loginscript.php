<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");
require("../../includes/user.inc.php");

//variable declarations
$sUsername = safeString($_POST['username']);
$sPassword = safeString($_POST['password']);
date_default_timezone_set('Europe/London');
$currentDate = date("Y-m-d H:i:s");

$_SESSION['loginError'] = 1;
$referer = "login.php";

//login code

$sql = "SELECT ID, Username, PasswordHash, EmailValidated FROM Users WHERE Username = :Username";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':Username', $sUsername, PDO::PARAM_STR);
$stmt->execute();

if($stmt->rowcount() != 0)
{
    $row = $stmt->fetchObject();
    if(password_verify($sPassword, $row->PasswordHash))
    {
        // if($row->EmailValidated == false)
        // {
        //     $_SESSION['loginError'] = 2;
        // }
        // else 
        // {

            //Logs in and creates user object (before the Last Login Date is updated)
            $User = new User($row->ID, $pdo);

            //Save the user object into the session variable
            $_SESSION['User'] = $User;

            //Update last login date
            $sql = "UPDATE Users SET LastLoginDate = :currentDate WHERE Username = :Username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Username', $sUsername, PDO::PARAM_STR);
            $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
            $stmt->execute();

            unset($_SESSION['loginError']);
            $_SESSION['login'] = true;
            
            $referer = "index.php";
        // }
    }
}

    header("Location: ../../$referer");

//ensure no more code is ran
exit();

?>