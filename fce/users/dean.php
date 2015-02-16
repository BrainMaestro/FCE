<?php
	include '../includes/db_connect.php';
	include '../includes/functions.php';
	
    	if (isset($_POST['submit'])) { //form from the admin page
    		$course_code_array = array(); 
    		$sch = $_POST['school'];
    		$semester = $_POST['semester'];
			$result = $mysqli->query("SELECT distinct(course_code) from section where school = '$sch' and semester = $semester");
	        for($i = 0; $i < $result->num_rows; $i++) {
                $row = $result->fetch_array();
                array_push($course_code_array, $row[0]);
            }
    	} else { //what loads for the dean
	    	$course_code_array = array();
	    	$email = $_SESSION['email'];   
			$result = $mysqli->query("SELECT distinct(course_code) from section where school = (select school from user where email = '$email')");
			for($i = 0; $i < $result->num_rows; $i++) {
                $row = $result->fetch_array();
                array_push($course_code_array, $row[0]);
            }
  		}
?>
<!DOCTYPE HTML>
<html>
<head>

<!--Favicon Kini -->
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

<title> Dean</title>
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
   	<link rel="stylesheet" href="../fonts/css/font-awesome.min.css">
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
		<div class="clearfix"></div>
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
		    		<li><a>Dean</a></li>
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
	<div class="clearfix"></div>
</div>
</div>
<div class="main_bg"><!-- start main -->
	<div class="container">
		<div class="main row">
			<div class="col-md-8 blog_left">
			<?php
			$i = 0;
        	while ($i < count($course_code_array)) {
        		
        		echo '<div class="border2">';
				echo "<h4><a>$course_code_array[$i]</a></h4>";
				//Final
				echo '<div class="border3">'; 
        		$result = $mysqli->query("SELECT crn, faculty_email from section where course_code = '$course_code_array[$i]'");
				for($i = 0; $i < $result->num_rows; $i++) {
                	$row = $result->fetch_array();
					echo "<form class='dean_form' action='final_report.php' method='post'>";
					echo "<input type='text' style='width:20px' value='final' name='eval_type' readonly> - ";
					echo "<input type='text' value='$row[0]' name='crn' style='width:20px' readonly> - ";
					echo "<span>$row[1]</span>";
            		echo "<a><input type='submit' name='sbmt_final' value='View Report'></a><br>";
            		echo '</form>';
        		}
        		echo '</div>';
        		//Midterm
        		echo '<div class="border3">';
        		$result = $mysqli->query("SELECT crn, faculty_email from section where course_code = '$course_code_array[$i]'");
				for($i = 0; $i < $result->num_rows; $i++) {
                	$row = $result->fetch_array();
					echo "<form class='dean_form' action='midterm_report.php' method='post'>";
					echo "<input type='text' value='mid' style='width:18px' name='eval_type' readonly>term - ";
					echo "<input type='text' value='$row[0]' name='crn' style='width:20px' readonly> - ";
            		echo "<span>$row[1]</span>";
            		echo "<a><input type='submit' name='sbmt_mid' value='View Report'></a><br>";
            		echo '</form>';
        		}
        		echo '</div>';
        		echo '</div>';
        		$i++;
        	} 
			?>
			</div>
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