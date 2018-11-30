<?php
require("conn.inc.php");

class User {
    private $ID;
    private $Username;
    private $Email;
    private $Admin;
    private $LastLoginDate;
    private $EmailValidated;

    function __construct($ID, $pdo) {
        //find user in the database by ID and create the user object

        $sql = "SELECT * FROM Users WHERE ID = :ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetchObject();

        $this->ID = $row->ID;
        $this->Username = $row->Username;
        $this->Email = $row->Email;
        $this->Admin = $row->Admin;
        $this->LastLoginDate = $row->LastLoginDate;
        $this->EmailValidated = $row->EmailValidated;
    }

    function getID() {
        return $this->ID;
    }

    function getUsername() {
        return $this->Username;
    }

    function getEmail() {
        return $this->Email;
    }

    function getAdmin() {
        return $this->Admin;
    }

    function getLastLoginDate() {
        return $this->LastLoginDate;
    }

    function getEmailValidated() {
        return $this->EmailValidated;
    }
}
?>