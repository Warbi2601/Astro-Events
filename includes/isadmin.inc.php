<?php
    // check if the user is an admin login and redirect if not
    include("user.inc.php");

    $User = $_SESSION['User'];
    $UserAdmin = $User->getAdmin();

    if($UserAdmin != 1)
    {
        header('Location: ../index.php');
    }
    exit();
?>