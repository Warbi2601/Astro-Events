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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
                            <li><a href="Qualifications.html" class="slideHover">Events List</a></li>
                            <li><a href="WorkExperience.html" class="slideHover">Artists</a></li>
                            <li><a href="Recommendations.html" class="slideHover">Admin</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div id="stickyBar">
                <nav class="transparentNav" id="stickyNav">
                        <ul>
                            <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                            <li><a href="index.php" class="pageCheck">Home</a></li>
                            <li><a href="Qualifications.html" class="slideHover">Events List</a></li>
                            <li><a href="WorkExperience.html" class="slideHover">Artists</a></li>
                            <li><a href="Recommendations.html" class="slideHover">Admin</a></li>
                        </ul>
                </nav>
            </div>

        </div>
</header>

<div class="pageContainer">
<div class="pageWrapper">

    <div class="showsTitle">
        <h3>My Purchases</h3>
    </div>

    <div id="showsForm">
        <div class="showsContainer">
            <?php

                $User = $_SESSION['User'];
                $userID = (int)$User->getID();
                $sql = "SELECT p.Cost as Cost, p.NumberOfTickets as NumberofTickets, p.Cost as Cost, s.DateTime as DateTime, 
                        s.TicketsAvailable as TicketsAvailable, v.ID as VenueID, v.Name as VenueName, v.Location as VenueLocation, e.Name as EventName
                        FROM PURCHASES as p
                        INNER JOIN `SHOW` as s
                        ON p.ShowID = s.ID
                        INNER JOIN Events as e
                        ON s.EventID = e.ID
                        INNER JOIN VENUE as v
                        ON s.VenueID = v.ID
                        WHERE p.UserID = :UserID";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':UserID', $userID, PDO::PARAM_INT);
                    
                    $stmt->execute();

                    $row = $stmt->fetchObject();

                while($row = $stmt->fetchObject()){
                    $formattedDate = date_create_from_format('Y-m-d H:i:s', $row->DateTime);
                    $showDateTimestamp = $formattedDate->getTimestamp();
                    $day = date('d', $showDateTimestamp);
                    $month = date('M', $showDateTimestamp);
                    $year = date('Y', $showDateTimestamp);
                    
                    echo '
                            <div class="showsItem">
                                <div class="showDate">
                                    <span class="showText dateNo">' . $day . '</span>
                                    <span class="showText">' . $month . '</span>
                                    <span class="showText">' . $year . '</span>
                                </div>
                                
                                <div class="showDetails">
                                    <span class="showText highlightedText"><strong>' . $row->EventName . '</strong></span>
                                    <span class="showText highlightedText"><a href="venue.php?venueID=' . $row->VenueID . '"><strong>' . $row->VenueName . ', ' . $row->VenueLocation . '</strong></a></span>
                                    <span class="showText">Tickets Bought: ' . $row->NumberofTickets . '</strong></span>
                                    <span class="showText">Cost: £' . $row->Cost . '</span>
                                </div>
                            </div>
                        ';
            }
            ?>
        </div>
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