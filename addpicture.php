<?php
    require("includes/user.inc.php");
    require("includes/sessions.inc.php");
    require("includes/authorize.inc.php");
    // include("includes/conn.inc.php");
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
                            <li><a href="index.php" class="stickySlideHover">Home</a></li>
                            <li><a href="Qualifications.html" class="stickySlideHover">Events List</a></li>
                            <li><a href="WorkExperience.html" class="stickySlideHover">Artists</a></li>
                            <li><a href="Recommendations.html" class="stickySlideHover">Admin</a></li>
                        </ul>
                </nav>
            </div>

        </div>
</header>

<?php
// // // $con=mysqli_connect("localhost","root","","events-website-new");

// // //     if(isset($_POST['btn'])) {
// // //         $imageName = mysqli_real_escape_string($con ,$_FILES["myfile"]["name"]);
// // //         $imageData = file_get_contents($_FILES["myfile"]["tmp_name"]);
// // //         $imageType = mysqli_real_escape_string($con, $_FILES["myfile"]["type"]);

// // //         $stmt = $pdo->prepare('INSERT INTO images (Name, Mime, Data) VALUES (:Name, :Mime, :Data)');
// // //         $stmt->bindParam(':Data', $imageData, PDO::PARAM_LOB);
// // //         $stmt->bindParam(':Name', $imageName);
// // //         $stmt->bindParam(':Mime', $imageType);
// // //         $stmt->execute(array('Name' => $imageName, 'Data' => $imageData, 'Mime' => $imageType));
// // //         echo "Image Uploaded";


// // //         $res = mysqli_query($con, "SELECT * FROM images"); 
// // //         while ($row = mysqli_fetch_assoc($res)) 
// // //         {                                                  
// // //         echo "<img src=data:image/png;base64," . (base64_encode(($row['Data']))) . " style='width:60px;height:60px;'>";
// // //         }
// // //     }

?>



<?php
    // if(isset($_POST['btn'])) {
    //     $name = $_FILES['myfile']['name'];
    //     $type = $_FILES['myfile']['type'];
    //     $data = base64_encode(file_get_contents($_FILES['myfile']['tmp_name']));

    //     $sql = "INSERT INTO images(Name, Mime, Data) VALUES(:Name, :Mime, :Data)";

    //     $stmt = $pdo->prepare($sql);
    //     $stmt->bindParam(':Name', $name, PDO::PARAM_STR);
    //     $stmt->bindParam(':Mime', $type, PDO::PARAM_STR);
    //     $stmt->bindParam(':Data', $data, PDO::PARAM_STR);
    //     $stmt->execute();
    // }

?>
     <!-- <img src='cms/process/viewimage.php?id=17' alt=''> -->

<?php
    // $sql = "SELECT * FROM images where ID = 15";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute();

    // $row = $stmt->fetchObject();

    // $blobimg = $row->Data;
    // $blobimg = base64_encode($blobimg);

    // echo '<img src ="data:image/png;base64,'. $blobimg .'"/>';

    // while($row = $stmt->fetchObject()){

    // echo "<img src='data:" . $row->Mime . ";base64," . base64_decode($row->Data) . "' alt='' class='eventImg'>";
    // }
    
    
    // while($row = $stmt->fetchObject()){
    // $blobby = $row->Data;
    //     echo '
    //         <img src="data:image/png;base64,' . base64_encode($blobby) . '">
    // ';
    // }
?>

<!-- <img src="cms/process/viewimage.php?id=2" /> -->

<!-- <form method="POST" enctype="multipart/form-data"> -->
    <!-- <input type="file" name="myfile" id="event-image"> -->
    <!-- <button name="btn" >Upload</button> -->
<!-- </form> -->


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

    <script>
        // var image;

        // var input = document.getElementById('event-image');
        // input.addEventListener('change', convertImage);

        // function convertImage() {
        //     var file = input.files[0];
        //     if(file) {
        //         const reader = new FileReader();

        //         reader.onload = () => {
        //             image = reader.result;
        //             debugger;
        //             $.post('cms/process/addimage.php', { image: image },
        //             function (data) {
        //                 console.dir(data);
        //             });
        //         }
        //         reader.readAsDataURL(file);
        //     }
        // }
    </script>

    <script src="JS/jquery-3.2.1.min.js"></script>
    <script src="JS/jquery.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-ui-timepicker-addon@1.6.3/dist/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>