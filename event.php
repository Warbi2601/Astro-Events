<?php
require("includes/user.inc.php");
require("includes/sessions.inc.php");
require("includes/authorize.inc.php");
include("includes/conn.inc.php");

//Get Event SQL
$sID = $_GET['id'];
$EventID = (int)$sID;

$sql = "SELECT events.Name as EventName, events.Details as EventDetails, events.Picture as EventPicture, genre.Name as GenreName, artist.Name as ArtistName
FROM events
INNER JOIN genre
ON events.GenreID = genre.ID
INNER JOIN artist
ON events.ArtistID = artist.ID
WHERE events.ID = " . $EventID;

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Astro Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
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

    <div id="modal-container">
        <div class="modal-background">
            <div class="modal" id="modal">
                <div id="ModalContent"></div>

                <!-- Content created here dynamically using jQuery -->

            </div>
        </div>
    </div>

    <div class="pageContainer">
    <div class="pageWrapper">

        <?php
        //Validation for if the user tried to buy more tickets than are available
            if(isset($_SESSION['Error']))
            {
                echo '
                <div class="alert alert-danger">
                    <strong>Error! - </strong>' . $_SESSION['Error'] . '</a>
                </div>';

                unset($_SESSION['Error']);
            }

        //Doesn't display the CMS buttons if the user isn't an admin
            if($UserAdmin == 1)
            {
                echo '
                    <div class="content">
                        <div class="buttons">
                            <div id="editEvent" class="button" eventID="' . $EventID . '">Edit Event</div>
                            <div id="addShow" class="button" eventID="' . $EventID . '">Add Show to Event</div>
                        </div>
                    </div>
                ';
            }
        ?>


        <div class="eventHeader">
            <div class="eventPicture">
                <img src="images/<?php echo $row[0]['EventPicture'];?>" alt="" class="eventImg">
            </div>
            <div class="eventDetails">
                <h3><?php echo $row[0]['EventName'];?></h3>
                <h5><?php echo $row[0]['ArtistName'];?></h5>
                <h5><?php echo $row[0]['GenreName'];?></h5>
            </div>
        </div>

        <div class="eventDetailsPara">
            <h3><strong>Event Details</strong></h3>
            <p><?php echo $row[0]['EventDetails'];?></p>
        </div>

        <?php
            //Get Shows SQL
            $sql = "SELECT s.ID as ShowID, e.Name as EventName, s.DateTime as DateTime, s.TicketsAvailable as TicketsAvailable, s.TicketPrice as TicketPrice, v.ID as VenueID, v.Name as VenueName, v.Location as VenueLocation
            FROM `show` as s
            INNER JOIN venue as v
            ON s.VenueID = v.ID
            INNER JOIN events as e
            ON s.EventID = e.ID
            WHERE e.ID = " . $EventID;

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php

        $counter = 0;

            foreach ($row as $value) {
                $formattedDate = date_create_from_format('Y-m-d H:i:s', $value['DateTime']);
                $showDateTimestamp = $formattedDate->getTimestamp();
                $currentTimestamp = time();
                if($showDateTimestamp > $currentTimestamp){
                    $counter += 1;
                }
            }
            echo '<div class="showsTitle"><h3>' . $counter . ' Upcoming Shows</h3></div>';
        ?>

        <form action="cms/process/createevent.php" method="POST" id="showsForm">
            <div class="showsContainer">
                <?php
                    foreach ($row as $value) {
                    $formattedDate = date_create_from_format('Y-m-d H:i:s', $value['DateTime']);
                    $showDateTimestamp = $formattedDate->getTimestamp();
                    $currentTimestamp = time();
                    $day = date('d', $showDateTimestamp);
                    $month = date('M', $showDateTimestamp);
                    $year = date('Y', $showDateTimestamp);

                    //Validation for if a show is sold out
                    $ticketsLeft = (int)$value['TicketsAvailable'];
                    $soldOut = false;

                    if($ticketsLeft <= 0) {
                        $ticketsLeft = 0;
                        $ticketsLeftString = '<span class="showText soldOut"><strong>This show has sold out!</strong></span>';
                        $soldOut = true;
                    } else {
                        $ticketsLeftString = '<span class="showText">Tickets Left: ' . $value['TicketsAvailable'] . '</span>';
                    }

                    if($soldOut) {
                        $btn = '<input id="' . $value['ShowID'] . '" soldOut="true" type="submit" value="Sold Out!" class="btnStandard buyTickets" id="soldOut" disabled>';
                    } else {
                        $btn = '<input id="' . $value['ShowID'] . '" soldOut="false" numOfTickets="' . $value['TicketsAvailable'] . '" ticketPrice="' . $value['TicketPrice'] . '" type="submit" value="Get Tickets!" class="btnStandard buyTickets">';
                    }

                    if($showDateTimestamp > $currentTimestamp){
                        $dateForDisplay = date("d/m/Y g:i a", $formattedDate->getTimestamp());
                        echo '
                                <div class="showsItem">
                                    <div class="showDate">
                                        <span class="showText dateNo">' . $day . '</span>
                                        <span class="showText">' . $month . '</span>
                                        <span class="showText">' . $year . '</span>
                                    </div>

                                    <div class="showDetails">
                                        <span class="showText highlightedText"><strong>' . $value['EventName'] . '</strong></span>
                                        <span class="showText highlightedText"><a href="venue.php?venueID=' . $value['VenueID'] . '"><strong>' . $value['VenueName'] . ', ' . $value['VenueLocation'] . '</a></strong></span>
                                        '. $ticketsLeftString . '
                                        <span class="showText">Price: £' . $value['TicketPrice'] . '</span>
                                    </div>
                                    <div class="showBtn">
                                        ' . $btn . '
                                    </div>
                                </div>
                            ';
                    }
                }
                ?>
            </div>
            <!-- <span class="showText">' . $dateForDisplay . '</span> -->
        </form>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-ui-timepicker-addon@1.6.3/dist/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>