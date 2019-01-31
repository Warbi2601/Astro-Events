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
                            <li><a href="index.php" class="pageCheck">Home</a></li>
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
                            <li><a href="index.php" class="pageCheck">Home</a></li>
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

<main id="app">
    <div class="pageContainer">
    <div class="pageWrapper">
        <div class="indexHeader">
        <?php
            if(isset($_SESSION['login'])) { 
                
                echo "<h3>You are logged in!</h3>";
                
                if(isset($_SESSION['User'])) {
                    
                    //logic for showing the welcome message with the users username and date last logged in
                    $User = $_SESSION['User'];
                    $UserUsername = $User->getUsername();
                    $UserLastLoginDate = $User->getLastLoginDate();
                    
                    $dateToBeFormatted = new DateTime($UserLastLoginDate);
                    $displayDate = $dateToBeFormatted->format('D jS M Y');
                    $time = $dateToBeFormatted->format('H:i a');
                    
                    echo '<p>Welcome Back ' . $UserUsername . '! You last logged in on ' . $displayDate . ' at ' . $time . ' </p>';
                }
            }
            else {
                header("Location: Login.php");
            }
        ?>
        </div>
        
        <h3>Featured Events</h3>


        <?php
            //get 6 random events
            $sql = "SELECT ID, Name, Picture
            FROM EVENTS
            ORDER BY RAND()
            LIMIT 6;";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
            $stmt->execute();
        ?>

<div id="featuredEventsCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#featuredEventsCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#featuredEventsCarousel" data-slide-to="1"></li>
    <li data-target="#featuredEventsCarousel" data-slide-to="2"></li>
    <li data-target="#featuredEventsCarousel" data-slide-to="3"></li>
    <li data-target="#featuredEventsCarousel" data-slide-to="4"></li>
    <li data-target="#featuredEventsCarousel" data-slide-to="5"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">

<?php 
    $active = " active";
    
    while($row = $stmt->fetchObject()){
            echo '
            <div class="item' . $active . '">
                <a href="event.php?id=' .  $row->ID . '">
                    <img class="slideshowImg" src="images/' . $row->Picture . '" alt="' . $row->Name . '">
                    <div id="carousel-caption" class="carousel-caption">
                    <h4>' . $row->Name . '</h4>
                </a>
              </div>
            </div>
            ';
            $active = "";
    }
?>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#featuredEventsCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#featuredEventsCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<button data-toggle="collapse" data-target="#searchFilters" class="btnStandard form-control" id="searchFiltersTab">Search Filters</button>

<div id="searchFilters" class="collapse in">
<div class="panel panel-default">
  <div class="panel-body">
    <div class="col-md-4">
        <div class="formLabel"><label>Search:</label></div>
    </div>

    <div class="col-md-4">
        <div class="formLabel"><label>Artist:</label></div>
    </div>

    <div class="col-md-4">
        <div class="formLabel"><label>Genre:</label></div>
    </div>


    <div class="col-md-4 col-sm-12 filter">
        <input type="search" v-model="searchString" class="form-control" placeholder="Search for an event">
    </div>

    <!-- Artist Dropdown Menu -->
    <div class="col-md-4 col-sm-12 filter" id="artistDropdown">
        <select class="form-control" name="artist" id="artist" v-on:change="searchEvents" v-model="artist">
            <!-- Dropdown inserted here by js -->
        </select>
    </div>

    <!-- Genre Dropdown Menu -->
    <div class="col-md-4 col-sm-12 filter" id="genreDropdown">
        <select class="form-control" name="genre" id="genre" v-on:change="searchEvents" v-model="genre">
            <!-- Dropdown inserted here by js -->
        </select>
    </div>
    </div>
</div>
</div>

    <div class="flex-container">
            <a v-for="event in events" class="flex-item" v-bind:href="'event.php?id=' + event.eventID">
                <p class="eventTitle">{{event.eventName}}</p>
                <!-- <img src="images/EltonJohn.png" alt="" class="eventImg"> -->
                <img v-bind:src="'images/' + event.eventPicture" alt="event.eventName" class="eventImg">
            </a>
    </div>

    </div>
    </div>
</div>
</main>

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

    <script src="js/vue.min.js"></script>
    <script>

        var vm = new Vue({     
            el: '#app',     
            data: {        
                events: [],     
                searchString : "",
                genre : "",
                artist : ""
            },
            watch: {
                searchString: function() {
                    
                    //Applys filters
                    var varsToSend = {};
                    if(vm.searchString != "") varsToSend["searchString"] = vm.searchString;
                    if(vm.artist != "") varsToSend["searchArtist"] = vm.artist;
                    if(vm.genre != "") varsToSend["searchGenre"] = vm.genre;

                    $.post('cms/db-get/searchEvents.php', varsToSend, function(data) {
                        vm.events = data;    

                    }, 'json');
                },
            }, 
            methods: {  
                searchEvents : function () {
                    
                    //Applys filters
                    var varsToSend = {};
                    if(vm.searchString != "") varsToSend["searchString"] = vm.searchString;
                    if(vm.artist != "") varsToSend["searchArtist"] = vm.artist;
                    if(vm.genre != "") varsToSend["searchGenre"] = vm.genre;

                    $.post('cms/db-get/searchEvents.php', varsToSend, function(data) {
                        vm.events = data;    

                    }, 'json');  
                }  
            }
        });

        $(document).ready(function() {
            vm.searchEvents();
        });

    </script>
</body>

</html>