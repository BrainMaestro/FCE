<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

// checkUser("secretary", "helper");

$crn = $_GET['crn'];
$status = checkSectionStatus($crn, $mysqli);

$rows = $mysqli->query("SELECT * FROM sections WHERE crn='$crn' and locked='0'")->num_rows;

if (($status == true) || ($rows == 0)) {
	header("Location: $_SESSION[user_type].php");
	
}

if (!isset($_SESSION['user']) || !(in_array($_SESSION['user'], array("helper", "secretary")))) {
	header("Location: ../index.php");
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

<title>Section</title>
<!-- Bootstrap -->
<link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
     <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../css/style.custom.css" rel='stylesheet' type='text/css' />
<!-- start plugins -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<!--font-Awesome-->
   	<link rel="stylesheet" href="../fonts/css/font-awesome.min.css">
<!--font-Awesome-->

<!-- start slider -->
<link href="../css/slider.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../js/modernizr.custom.28468.js"></script>
<script type="text/javascript" src="../js/jquery.cslider.js"></script>

<script type="text/javascript">
			$(function() {

				$('#da-slider').cslider({
					autoplay : true,
					bgincrement : 450
				});

			});
		</script>
		
<!-- Owl Carousel Assets -->
<link href="css/owl.carousel.css" rel="stylesheet">
<script src="js/owl.carousel.js"></script>
		<script>
			$(document).ready(function() {

				$("#owl-demo").owlCarousel({
					items : 4,
					lazyLoad : true,
					autoPlay : true,
					navigation : true,
					navigationText : ["", ""],
					rewindNav : false,
					scrollPerPage : false,
					pagination : false,
					paginationNumbers : false,
				});

			});
		</script>
		<!-- //Owl Carousel Assets -->

</head>
<body>
<div class="header_bg1">
<div class="container">
	<div class="row header">
		<div class="logo navbar-left">
			<h1><a>Faculty Course Evaluation</a></h1>
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
                <?php
                list_roles('');
                $crn = $_GET['crn'];
    			$row = $mysqli->query("SELECT mid_evaluation, final_evaluation FROM sections WHERE crn='$crn'")->fetch_assoc();
                $eval_type = ($row['mid_evaluation'] == '0') ? "mid" : "final";
                $row = $mysqli->query("SELECT * FROM sections WHERE crn='$crn'")->fetch_assoc();
                $row3 = $mysqli->query("SELECT count(crn) AS filled FROM evaluations WHERE crn='$crn' AND eval_type='$eval_type'")->fetch_assoc();
                echo "<li><span style='background: #3B3B3B;'><span class='red'>Evaluations</span>: $row3[filled]/$row[enrolled]</span></li>";
                echo "<li><span style='background: #3B3B3B;'><span class='red'>Keys Given Out</span>: <span id='given'></span></span></li>";
                ?>
		      </ul>
		    </div>
		</nav>
	</div>
	<div class="clearfix"></div>
</div>
</div>
<div class="clearfix"></div>
<div class='row para text-center'>
	<div class="col-xs-4 size-before"></div>
	<div class="col-xs-4 size-panel">
		<table width="100%" class="not-center evaltable">
			<caption><h3>Section Details</h3><hr></caption>
			<tbody>
				<?php
		    	$row = $mysqli->query("SELECT * FROM sections WHERE crn='$crn'")->fetch_assoc();
				$term = ($row['mid_evaluation'] == '0') ? "Midterm" : "Final";

				echo "<tr><td>CRN</td>";
				echo "<td>$crn</td></tr>";
				echo "<tr><td>Course Code</td>";
				echo "<td>$row[course_code]</td></tr>";
				echo "<tr><td>Course Title</td>";
				echo "<td>$row[course_title]</td></tr>";
				echo "<tr><td>Evaluation</td>";
				echo "<td>$term Evaluation</td></tr>";
				echo "<tr><td>Instructor(s)</td>";
				$assignment = $mysqli->query("SELECT * FROM course_assignments WHERE crn='$row[crn]'");
				echo "<td>";
				for($j = 0; $j < $assignment->num_rows; $j++) {
					$row2 = $assignment->fetch_assoc();
					$faculty = $mysqli->query("SELECT name FROM users WHERE email='$row2[faculty_email]'")->fetch_assoc();
					echo "$faculty[name]<br>";
				}
				echo "</td></tr>";
				if ($_SESSION['user'] == "secretary") {
				$row_helper = $mysqli->query("SELECT password FROM helper_user WHERE crn='$crn'")->fetch_assoc();
				echo "<tr><td>Helper Account</td><td>Email: helper@aun.edu.ng<br />Password: <span style='font-family: monospace; color:black;''>$row_helper[password]</span></td></tr>";
			}
				?>
				<tr>
				
				</tr>
			</tbody>
		</table>
	</div>
</div>


<div class="main_bg"><!-- start main -->
	<div class="container">
	<div class="main row para">
		<div class="col-xs-3 size-before"></div>
		<div class="col-xs-6 text-center size-panel">
		<h1 id="key1" style="font-family: monospace; color:black;" value=""> null</h1>
			<!--<p id="given" value=""> null </p>
			<h4 class="da-link text-center" id="given" value=""> null </h4>-->
			<script type="text/javascript">
			
			//function displayKeys() {
				//document.getElementsByName('key1').innerHTML=comment;
			//}
			
			var global_key = 0;
			
			function getKeys(key2) {
				var keyvalues = document.getElementsByName('items[]');
				var keys_array = [];
				var givenout = document.getElementsByName('items_stat[]')
				var given_out = []
				var given_count = 0;
				
				global_key += parseInt(key2);
				
				if (global_key > keyvalues.length - 1) {
					global_key = 0;
				}
				if (global_key < 0) {
					global_key = keyvalues.length - 1;
				}
				
				for (var i = 0; i < keyvalues.length; i++) {
					keys_array.push(keyvalues[i].value);
					given_out.push(givenout[i].value)
					if (givenout[i].value == 'Yes')
						given_count++;
				}
				
				var sn = parseInt(global_key) + 1;
				var isGiven = "<br>Given out: " + given_out[global_key];
				document.getElementById('key1').innerHTML = 
				"<span style='color:grey; font-size:0.45em;'>(" + sn + ")<br></span><span class='size-input' style=' font-size: 2em;'>" + keys_array[global_key] +
				"</span><span style='color:grey; font-size:0.45em;'>" + isGiven + "<br></span>";
				//document.getElementById('sn1').innerHTML = parseInt(global_key) + 1;
				document.getElementById('given').innerHTML = given_count;
			}
			</script>
			<div class="text-center" height='10%'>
				<input width='30px'  name='previous_key' type='image' src="../images/back.png" onclick='getKeys(-1)'>
				<input width='30px'  name='next_key' type='image' src="../images/next.png" onclick='getKeys(1)'>
			</div>
			</div>

	</div>

		<div class="main row para">
			<div class="col-xs-3 size-before"></div>
			<div class="col-xs-6 text-center border4 size-panel">
				<table width="100%" class="not-center evaltable">
					<caption><h3>Key Details</h3><hr></caption>
					<thead>
						<th>S/N</th>
						<th>Key</th>
						<th>Given Out</th>
						<th>Used</th>
					</thead>
					<tbody>
						<?php
						$result = $mysqli->query("SELECT * FROM accesskeys WHERE key_crn='$crn' AND key_eval_type='$eval_type'");
						for($i = 0; $i < $result->num_rows; $i++) {
							$row = $result->fetch_assoc();
							$sn = $i+1;
							echo "<tr><td>$sn</td>";
							echo "<td  style='font-family: monospace;'>$row[key_value]</td>";
							$given_out = ($row['given_out'] == 1) ? "Yes" : "No";
							$used = ($row['used'] == 1) ? "Yes" : "No";
							echo "<td>$given_out</td>";
							echo "<td>$used</td></tr>";
							echo "<input type='hidden' name='items[]' value='$row[key_value]'>";
							echo "<input type='hidden' name='items_stat[]' value='$given_out'>";
						}
						?>
					</tbody>
				</table>
				<script>getKeys("0")</script>
				<br><br>
				<?php
				if ($_SESSION['user'] == "secretary")
				echo "<form action='secretary.php' method='post'>
					 <input type='hidden' name='crn' value='$crn'>
					<input class='black-btn size-input' name='submit' type='submit' value='lock'>
				</form>";
				?>
			</div>
		</div>
		<div class="text-center">
		</div>
	</div>
</div><!-- end main -->
<FOOTER>
        <div class="footer_bg"><!-- start footer -->
            <div class="container">
                <div class="row  footer">
                    <div class="copy text-center">
                        <p class="link"><span>&#169; All rights reserved | Design by&nbsp;<a href="../thankyou.php"> The FCE Team</a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </FOOTER>
</body>
</html>