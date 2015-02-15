<?php
	$result1 = $mysqli->query("SELECT * FROM accesskeys WHERE key_crn='$crn' AND key_eval_type='$eval_type'");
	$keyArray1 = [];
	
	echo "<div class='slider_bg'>";
	echo "<div class='container'>";
	echo "<div id='da-slider' class='da-slider text-center'>";
	
	for($i = 0; $i < $result1->num_rows; $i++) {
		$row = $result1->fetch_assoc();
		$sn = $i+1;
		
		echo "<div class='da-slide'>";
		echo "<p>$sn</p>";
		echo "<h2>$row[key_value]</h2>";
		echo "</div>";
	}

	echo "</div></div></div>";
?>

<?php
include_once '../includes/db_connect.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Section</title>
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
<!----font-Awesome----->
   	<link rel="stylesheet" href="fonts/css/font-awesome.min.css">
<!----font-Awesome----->		

</head>
<body>
<div class="header_bg1">
<div class="container">
	<div class="row header">
		<div class="logo navbar-left">
			<h1><a href="../index.php">Faculty Course Evaluation</a></h1>
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
		      <li><a>Section</a></li>
                <?php
                $crn = $_GET['crn'];
                $eval_type = $_GET['eval_type'];
                $row = $mysqli->query("SELECT * FROM section WHERE crn='$crn'")->fetch_assoc();
                echo "<li><a>$row[course_code]</a></li>";
                echo "<li><a>$row[school]</a></li>";
                $row2 = $mysqli->query("SELECT name FROM user WHERE email='$row[faculty_email]'")->fetch_assoc();
                echo "<li><a>$row[semester]</a></li>";
                echo "<li><a>$row[course_title]</a></li>";
                echo "<li><a>$row2[name]</a></li>";
                //$row3 = $mysqli->query("SELECT count(crn) AS filled FROM evaluation WHERE crn='$crn' AND eval_type='$eval_type'")->fetch_assoc();
                //echo "<li><a><span class='red'>Evaluations</span>: $row3[filled]/$row[enrolled]</a></li>";

                ?>
		      </ul>
		    </div>
		</nav>
	</div>
	<div class="clearfix"></div>
</div>
</div>

<script type="text/javascript">
	document.write("<div class='slider_bg'>");
	document.write("<div class='container'>");
	document.write("<div id='da-slider' class='da-slider'>");
	
	displayKeys();
	
	function getnum() {
		var num = 1;
		return num
	}
	
	function increaseKey() {
		var num = getnum();
		var keyvalues = document.getElementsByName('items[]');
		
		if (num > keyvalues.length) {
			num = 0;
		}
		else {
			num++;
		}
		
		return num;
	}
	
	function decreaseKey() {
		var num = getnum();
		num--
		return num;
	}
	
	function displayKeys() {
		
		var keyvalues = document.getElementsByName('items[]');
		var keys_array = [];
		num = 2;
		
		/*var num = getnum();
		if (num > keyvalues.length) {
			num = 0;
		}
		if (num < 0) {
			num = keyvalues.length;
		}*/
		
		for (var i = 0; i < keyvalues.length; i++) {
			keys_array.push(keyvalues[i].value);
		}
		
		document.write("<div class='da-slide'>");
		document.write("<p>" + num + "</p>");
		document.write("<h2>" + keys_array + "</h2>");
		document.write("</div>");
	}
	
	document.write("</div></div></div>");
	
	
	document.write("<div class='text-center'>");
	document.write("<input class='black-btn' name='previous_key' type='button' value='Previous Key' onclick='this.innerHTML=Date()'>"); 
	document.write("<input class='black-btn' name='next_key' type='button' value='Next Key' onclick=' return increaseKey(this)'>"); 
	document.write("</div>");

</script>

<div class="main_bg"><!-- start main -->
	<div class="container">
		<div class="main row para">
			<div class="col-md-8 blog_left">
				<table width="100%">
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
						$keyArray = []; // For storing the keys to display boldly
						for($i = 0; $i < $result->num_rows; $i++) {
							$row = $result->fetch_assoc();
							$sn = $i+1;
							echo "<tr><td>$sn</td>";
							echo "<td name='items[]' value='$row[key_value]' style='font-family: monospace;'>$row[key_value]</td>";
							$given_out = ($row['given_out'] == 1) ? "Yes" : "No";
							$used = ($row['used'] == 1) ? "Yes" : "No";
							echo "<td>$given_out</td>";
							echo "<td>$used</td></tr>";
						}
						?>
					</tbody>
				</table>
				<form action="secretary.php" method="post"> <!-- Sends back to secretary page and locks class -->
					<?php
					echo "<input type='hidden' name='crn' value='$crn'>";
					echo "<input type='hidden' name='eval_type' value='$eval_type'>";
					?>
					<input class='black-btn' name='submit' type="submit" value='lock'>
				</form>
			</div>
		</div>
	</div>
</div><!-- end main -->
<div class="footer_bg"><!-- start footer -->
	<div class="container">
		<div class="row  footer">
			<div class="copy text-center">
				<p class="link"><span>&#169; All rights reserved | Design by&nbsp;<a href="http://w3layouts.com/"> W3Layouts</a></span></p>
			</div>
		</div>
	</div>
</div>
</body>
</html>