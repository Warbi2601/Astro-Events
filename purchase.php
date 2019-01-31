<?php
require("includes/user.inc.php");
require("includes/sessions.inc.php");
require("includes/authorize.inc.php");
?>

<!doctype <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Astro Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="css/mobile.css" />
    <link rel="stylesheet" media="only screen and (min-width : 600px)" href="css/desktop.css">
</head>

<body>
    <div class="contentWrapper">
        <header>
            <div class="headBarContainer">
                <div class="headBar">

                    <div class="flexItem1">
                        <?php
            //logic for populating the "My Account" dropdown depending on whether the user is logged in or not
                if(isset($_SESSION['login'])){
                    echo '
                        <div class="dropdown">
                            <a class="fas fa-user-astronaut dropdown-toggle userColor" href="#" role="button" id="dropdownMenuLink" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <ul class="dropdown-menu">
                                <li><a href="cms/process/logoutscript.php">Logout</a></li>
                                <li><a href="myaccount.php">My Account</a></li>';

                    //logic for showing the admin button to admins only
                    $User = $_SESSION['User'];
                    $UserAdmin = $User->getAdmin();

                    if($UserAdmin == 1)
                    {
                        echo '
                                <li class="divider"></li>
                                <li><a href="admin.php">Admin</a></li>
                        ';
                    }
                    
                    echo '
                            </ul>
                        </div>
                        ';
                }
                else {
                    echo '
                        <div class="dropdown">
                            <a class="fas fa-user-astronaut dropdown-toggle userColor" href="#" role="button" id="dropdownMenuLink" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <ul class="dropdown-menu">
                                <li><a href="login.php">Login</a></li>
                                <li class="divider"></li>
                                <li><a href="createaccount.php">Create Account</a></li>
                            </ul>
                        </div>
                        ';
                  header("Location: Login.php");
                }
            ?>
                    </div>

                    <div class="flexItem2">
                        <h1 class="websiteTitle">Astro Events</h1>
                        <p class="websiteSubtitle">Events that are out of this world</p>
                    </div>

                    <div class="flexItem3">
                        <span class="burgerMenu" onclick="openNav()">&#9776;</span>
                        <div id="mySidenav" class="sidenav">
                            <nav class="transparentNav">
                                <ul>
                                    <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                                    <li><a href="index.php" class="slideHover">Home</a></li>
                                    <?php
                                        if($UserAdmin == 1)
                                        {
                                            echo '<li><a href="admin.php" class="slideHover">Admin</a></li>';
                                        }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div id="stickyBar">
                        <nav class="transparentNav" id="stickyNav">
                            <ul>
                                <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                                <li><a href="index.php" class="stickySlideHover">Home</a></li>
                                <?php
                                    if($UserAdmin == 1)
                                    {
                                        echo '<li><a href="admin.php" class="stickySlideHover">Admin</a></li>';
                                    }
                                ?>
                            </ul>
                        </nav>
                    </div>

                </div>
        </header>
        <div class="pageContainer">
<div class="pageWrapper">

            <?php

      if(isset($_SESSION['purchaseID'])) {
        $LastInsertID = $_SESSION['purchaseID'];
        $showID = $_SESSION['showID'];
        unset($_SESSION['purchaseID']);        
        unset($_SESSION['showID']);
              $sql = "SELECT p.Cost as Cost, p.NumberOfTickets as NumberofTickets, p.DateTime as DateTime, 
              s.TicketsAvailable as TicketsAvailable, v.Name as VenueName, v.Location as VenueLocation, p.EventName as EventName
              FROM PURCHASES as p
              INNER JOIN `SHOW` as s
              ON :ShowID = s.ID
              INNER JOIN VENUE as v
              ON s.VenueID = v.ID
              WHERE p.ID = :LastInsertID";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ShowID', $showID, PDO::PARAM_INT);
        $stmt->bindParam(':LastInsertID', $LastInsertID, PDO::PARAM_INT);
        
        $stmt->execute();

        $row = $stmt->fetchObject();

        $dateToBeFormatted = new DateTime($row->DateTime);
        $displayDate = $dateToBeFormatted->format('D jS M Y');
        $time = $dateToBeFormatted->format('H:i a');

        $message = 'Congratulations, you now have ' . $row->NumberofTickets . ' ticket(s) to go and see ' . $row->EventName . ' at ' . $row->VenueName . ", " . $row->VenueLocation . ' on ' . $displayDate . ' at ' . $time . '. You have been charged £' . $row->Cost . '.
          There are now ' . $row->TicketsAvailable . ' tickets left for the event.';

        if($row->TicketsAvailable < 100) {
          $message = $message . "If your friends haven't got tickets then let them know as there is less than 100 left!";
        }
      }
      else {
        header("Location: index.php");
        exit();
      }

      echo '
        <div class="purchase">
            <h3>Thank you for your purchase!</h3>
            <p>' . $message . '</p>
        </div>
      ';
    ?>
        </div>
    </div>
    </div>

    <footer>
        <p class="lastUpdated">Page Last Updated: </p>
        <p>Copyright &copy; Josh Warburton 2018</p>
        <!-- <div class="footerlogo">
            <a href="https://www.linkedin.com/in/joshwarburton/"><img src="Images/LinkedIn.png" alt="" width="40"
                    height="40">
                <a href="https://github.com/Warbi2601"><img src="Images/GitHub.png" alt="" width="40" height="40"></a>
        </div> -->
    </footer>

    <script src="JS/jquery-3.2.1.min.js"></script>
    <script src="JS/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>