<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Events Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/mobile.css" />
    <link rel="stylesheet" media="only screen and (min-width : 600px)" href="css/desktop.css">
</head>
<body>
        <div class="container">
                <div class="headBar">

                    <div class="flexItem1">
                        <a href="login.html"><span class="loginBtn">Login</span></a>
                    </div>

                    <div class="flexItem2">
                        <h1 class="websiteTitle">Events Website</h1>
                    </div>

                    <div class="flexItem3">
                        <span class="burgerMenu" onclick="openNav()">&#9776;</span>
                        <div id="mySidenav" class="sidenav">
                            <nav>
                                <ul>
                                    <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                                    <li><a href="index.html" class="pageCheck">About Me</a></li>
                                    <li><a href="Qualifications.html" class="slideHover">Qualifications</a></li>
                                    <li><a href="WorkExperience.html" class="slideHover">Work Experience</a></li>
                                    <li><a href="Recommendations.html" class="slideHover">Recommendations</a></li>
                                    <li><a href="PreviousProjects.html" class="slideHover">Previous Projects</a></li>
                                    <li><a href="CV.html" class="slideHover">CV</a></li>
                                    <li><a href="ContactMe.php" class="slideHover">Contact Me</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <h1>Create Account</h1>

                <form action="cms/process/createaccountscript.php" method="POST">
    
    <div class="inputBox">
    <span class="requiredField">*</span>
    <input type="email" name="email" id="email" placeholder="Email">
    <br/>
    </div>
                
    <div class="inputBox">
    <span class="requiredField">*</span>
    <input type="text" name="username" id="username" placeholder="Username">
    <br/>
    </div>

    <div class="inputBox">
    <span class="requiredField">*</span>
    <input type="password" name="password" id="password" placeholder="Password">
    <br/>
    </div>

    <div class="inputBox">
    <span class="requiredFieldBtn">*</span>
    <input type="submit" value="Create Account" class="btnStandard">
    <br/>
    </div>

</form>
    
    <script src="JS/jquery-3.2.1.min.js"></script>
    <script src="JS/jquery.js"></script>
</body>
</html>