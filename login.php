<?php
require("includes/sessions.inc.php");
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

                <h1>Login</h1>

                    <?php
                    if(isset($_SESSION['loginError']))
                    {
                        switch($_SESSION['loginError'])
                        {   
                            case 1 :   
                                echo "
                                <div class=\"alert alert-danger\">
                                    <strong>Error!</strong> The Username or Password you entered was invalid</a>
                                </div>";
                                break;
                            case 2 :   
                                echo "
                                <div class=\"alert alert-danger\">
                                    <strong>Error!</strong> You need to confirm your email before you can login</a>
                                </div>";
                                break;
                            case 3 :   
                                echo "
                                <div class=\"alert alert-danger\">
                                    <strong>Error!</strong> You must be logged in to view that page</a>
                                </div>";
                                break;
                        } 

                        unset($_SESSION['loginError']);
                    }
                ?>

                <div class="form">
                <form action="cms/process/loginscript.php" method="POST">

                    <div class="inputBox">
                        <span class="requiredField">*</span>
                        <input type="text" name="username" id="username" placeholder="Username" required>
                        <br />
                    </div>

                    <div class="inputBox">
                        <span class="requiredField">*</span>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <br />
                    </div>

                    <div class="inputBox">
                        <span class="requiredFieldBtn">*</span>
                        <input type="submit" value="Login" class="btnStandard" required>
                        <br />
                    </div>

                </form>

                </div>

                <div class="createAccountLink">
                    <p>Not got an account with us? <a href="createaccount.php">Create an account here!</a></p>
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