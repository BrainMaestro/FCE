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
                $row3 = $mysqli->query("SELECT count(crn) AS filled FROM evaluation WHERE crn='$crn' AND eval_type='$eval_type'")->fetch_assoc();
                echo "<li><a><span class='red'>Evaluations</span>: $row3[filled]/$row[enrolled]</a></li>";

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
							echo "<td style='font-family: monospace;'>$row[key_value]</td>";
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