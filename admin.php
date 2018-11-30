<?php
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
    <header>
    <div class="headBarContainer">
        <div class="headBar">

            <div class="flexItem1">
            <?php
                if(isset($_SESSION['login'])){
                    echo '
                        <div class="dropdown">
                            <a class="fas fa-user-astronaut dropdown-toggle userColor" href="#" role="button" id="dropdownMenuLink" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <ul class="dropdown-menu">
                                <li><a href="cms/process/logoutscript.php">Logout</a></li>
                                <li><a href="#">My Account</a></li>
                                <li class="divider"></li>
                                <li><a href="admin.php">Admin</a></li>
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
                            <li><a href="Qualifications.html" class="slideHover">Events List</a></li>
                            <li><a href="WorkExperience.html" class="slideHover">Artists</a></li>
                            <li><a href="Recommendations.html" class="slideHover">Admin</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
</header>


        <div class="whiteBackground">
            <div class="text">
        
                <h1>Admin</h1>
                <div id="modal-container">
                    <div class="modal-background">
                        <div class="modal">

                            <!-- Content created here dynamically using jQuery -->

                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="buttons">
                        <div id="addEvent" class="button">Add Event</div>
                        <div id="editEvent" class="button">Edit Event</div>
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

    <!-- GREAT EXAMPLE OF USING A PHP VARIABLE IN JS -->

    <!-- <script type="text/javascript">

        $(document).ready(function() {
            debugger;
            
            ?php
    $_SESSION['test'] = array(
        0 => "Mon", 
        1 => "Tue", 
        2 => "Wed", 
        3 => "Thu",
        4 => "Fri", 
        5 => "Sat",
        6 => "Sun",
    )
?>


        var jArray = ?php echo json_encode($_SESSION['test']); ?>;

        for(var i=0; i<jArray.length; i++){
            alert(jArray[i]);
        }
    });

    </script> -->

<!-- GREAT EXAMPLE OF AN AJAX CALL TO GET DATA FROM JS TO PHP (See "test.inc.php") FOR SERVER SIDE CODE -->

    <!-- <script>

        $(document).ready(function() {

            $.ajax({
                type: "POST",
                url: 'includes/test.inc.php',
                data: { userID : 4 },
                success: function(data)
                {
                    alert("success!");
                }
            });
        });
        </script> -->
</body>

</html>