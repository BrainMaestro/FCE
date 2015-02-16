<?php
    include_once '../includes/db_connect.php';
    include_once '../includes/functions.php';
    
    checkUser("admin");
	
    if (isset($_POST['submit'])) {

    if ($stmt = $mysqli->prepare("INSERT INTO Section VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
        $locked = '1';
        $mid_evaluation = '0';
        $final_evaluation = '0';
        $semester = getCurrentSemester();
        $stmt->bind_param('isssssiiii', $_POST['crn'],$_POST['course_code'],$_POST['faculty_email'],$semester,$_POST['school'],
            $_POST['course_title'], $locked, $mid_evaluation, $final_evaluation, $_POST['enrolled']); 
        $stmt->execute(); 
        //header("Location: ./admin.php");
    } else {
        $_SESSION['err'] = "Database error: cannot prepare statement";
        header("Location: ../index.php");
        exit();
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Admin | Add Section</title>
<!-- Favicon Kini -->
        <link rel="apple-touch-icon" sizes="57x57" href="../images/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="../images/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="../images/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="../images/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="../images/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="../images/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="../images/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="../images/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="../images/favicons/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="../images/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="../images/favicons/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="../images/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="../images/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="../images/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="../images/favicons/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!-- End of Favicon Kini -->
<!-- Bootstrap -->
<link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="../css/style.custom.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
     <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- start plugins -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<!--font-Awesome-->
    <link rel="stylesheet" href="fonts/css/font-awesome.min.css">
<!--font-Awesome-->
</head>
<body>
<div class="header_bg1">
<div class="container">
    <div class="row header">
        <div class="logo navbar-left">
            <h1><a href="index.html">Faculty Course Evaluation</a></h1>
        </div>
        <div class="h_search navbar-right">
			<form action="../includes/logout.php" method="post">
				<button class='black-btn margin' name='logout' value='logout'>Logout</button>
			</form>
		</div>
    </div>
    <div class="row h_menu">
        <nav class="navbar navbar-default navbar-left" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a>Admin</a></li>
                <?php
                $semester = getCurrentSemester();
                $school = $_SESSION['school'];
                $name = $_SESSION['name'];
                echo "<li><a>$semester</a></li>";
                echo "<li><a>$school</a></li>";
                echo "<li><a>$name</a></li>";
                ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
</div>
<div class="main_bg"><!-- start main -->
    <div class="container">
        <div class="main row para"> 
            <div class="col-xs-4 images_1_of_4 bg1 text-center"></div>      
                <div class="col-xs-4 text-center border adminAdd">
                <form method="POST" action="./admin_add_section.php">
                        <h2>Add Section Details</h2><br />
                        <label>CRN </label><br /><input type="text" class="round" name="crn" placeholder="Ex: 201497" required="required"/> <br /><br />
                        <label>Course Code </label> <br /><input type="text" class="round" name="course_code" placeholder="Ex: CSC 232" required="required"/> <br /><br />
                        <label>Faculty Email </label><br /> <input type="text" class="round" name="faculty_email" placeholder="Ex: a.b@aun.edu.ng" required="required"/> <br /><br />
                        <!-- <label>Semester </label> <br /><input type="text" class="round" name="semester" placeholder="Ex: Spring 2015" required="required"/> <br /> -->
                        <label>School </label><br /><select class="input-sm" name="school" required="required">
                            <option selected value="">--Choose School--</option>
                            <?php
                            $result = $mysqli->query("SELECT * FROM school");

                            for ($i = 0; $i < $result->num_rows; $i++) {
                                $row = $result->fetch_array();
                                echo "<option value='$row[0]'>$row[0]</option>";
                            }
                            ?>
                        </select><br /><br />
                        <label>Course Title </label> <br /><input type="text" class="round" name="course_title" placeholder="Ex: Discrete Structures I" required="required"/> <br /><br />
                        <label>Enrolled</label><br /><input name="enrolled" class="round" type="text" placeholder="Ex: 5" required="required"/><br /><br />

                        <button class="black-btn" name="submit">Add Section</button>
                </form>
                
            </div>  
            <div class="col-xs-4 images_1_of_4 bg1 text-center"></div>
        </div>
        
    </div>
</div><!-- end main -->
<FOOTER>
        <div class="footer_bg"><!-- start footer -->
            <div class="container">
                <div class="row  footer">
                    <div class="copy text-center">
                        <p class="link"><span>&#169; All rights reserved | Design by&nbsp;<a href="#"> The FCE Team</a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </FOOTER>
</body>
</html>