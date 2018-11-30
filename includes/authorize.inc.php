<?php
// check if session login and redirect if not
if(!isset($_SESSION['login'])){
    $_SESSION['loginError'] = 3;
    header('Location: login.php');
    exit;
}
?>