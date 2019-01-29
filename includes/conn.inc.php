<?php 
    // $dsn = 'mysql:host=localhost;dbname=b7030988_db2'; 
    // $user = 'b7030988'; 
    // $password = ''; 

    $user = 'root';
    $password = '';
    $dsn = 'mysql:host=localhost;dbname=events-website-new';
    
    try
    { 
        $pdo = new PDO($dsn, $user, $password); 
        $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $pdo ->exec("SET CHARACTER SET utf8"); 
    } 
    catch (PDOException $e)
    {
        echo 'Connection failed again: ' . $e->getMessage();
    } 
?>