<?php
//includes
include("../../includes/sessions.inc.php");
include("../../includes/conn.inc.php");
include("../../includes/functions.inc.php");

$_SESSION['loginError'] = 1;

$sql = "SELECT Admin FROM Users WHERE Username = ";

$stmt = $pdo->prepare($sql);
$stmt->execute();

if($stmt->Admin == 1)
{
    $row = $stmt->fetchObject();
    if(password_verify($sPassword, $row->PasswordHash))
    {
        if($row->EmailValidated == false)
        {
            $_SESSION['loginError'] = 2;
        }
        else 
        {
            //Update last login date
            $sql = "UPDATE Users SET LastLoginDate = :currentDate WHERE Username = :Username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Username', $sUsername, PDO::PARAM_STR);
            $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
            $stmt->execute();
            
            //Logs in and starts user session
            unset($_SESSION['loginError']);
            $_SESSION['login'] = true;
            $referer = "index.php";
        }
    }
}

    header("Location: ../../$referer");

//ensure no more code is ran
exit();

?>