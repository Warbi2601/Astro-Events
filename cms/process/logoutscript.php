<?php
//includes
include("../../includes/sessions.inc.php");

//logout code
if(isset($_COOKIE[session_name()])){
    // match PHPSESSID settings
    setcookie(session_name(), '', time()-3600, '/events-website/', 'localhost', 0, 1);
    // clear the Session cookie
    }
$_SESSION = array();
// empty the array
session_destroy();
//destroy the session
header("location:../../login.php");
//to redirect
exit();

?>