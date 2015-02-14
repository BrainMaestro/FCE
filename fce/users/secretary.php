<?php
include_once '../includes/functions.php';
    // $con = mysqli_connect("localhost", "root", "", "fce");
    // if (mysqli_connect_errno()) {
    //     echo "Failed to connect to MySQL: " . mysqli_connect_errno();
    // }
    // $crn_array = array();
    // $course_code_array = array();
    // $email = $_SESSION['email'];   
    // $query = mysqli_query($con, "SELECT crn, course_code, school, semester from section where faculty_email='$email'"); 
    // while ($row = mysqli_fetch_array($query)) {
    //     array_push($crn_array, $row[0]);
    //     array_push($course_code_array, $row[1]);
    //     $sch = $row[2];
    //     $sem = $row[3];
    // }
    
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Secretary</title>
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
<link href="../css/style.custom.css" rel="stylesheet" type="text/css" media="all" />
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
			<h1><a href="../index.php">Faculty Course Evaluation</a></h1>
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
                <li><a>Secretary</a></li>
                <?php
                $semester = getCurrentSemester();
                $school = $_SESSION['school'] = 'SAS';
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
		<div class="row para"><br><br>
			<div class="col-xs-4 left h_search">
				<form action="secretary.php" method='post'>
					<select name="status" class="input-sm" required>
	                    <option selected value="">--Choose Section Status--</option>
	                    <option value="1">Locked</option>
	                    <option value="0">Unlocked</option>
	                    <option value="%">All</option>
	                </select>
					<input type="submit" name="filter" value="submit">
				</form>	
			</div>	

			<div class="h_search col-xs-4 right">
				<form>
					<input type="text" class="text" value="Search course" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search course';}">
					<input type="submit" value="search">
				</form>
			</div>
		</div>

		<div class="main row para">
			<div class="col-xs-12">		
			
				<!-- <div class="clearfix"></div>
				<div style="height:25px"></div> -->
				<form action="section.php" method="post">
					<table width="100%">
						<caption><h3>Sections</h3><hr></caption>
						<thead>
							<tr>
								<th></th>
								<th>CRN</th>
								<th>Course Code</th>
								<th>Course Title</th>
								<th>Instructor</th>
								<th>Enrolled</th>
								<th>Status</th>
								<th>Midterm Evaluation</th>
								<th>Final Evaluation</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$result = $mysqli->query("SELECT * FROM section");

						if (isset($_POST['filter'])) {
							$status = $_POST['status'];
							$result = $mysqli->query("SELECT * FROM section WHERE locked LIKE '$status'");
						}

						for($i = 0; $i < $result->num_rows; $i++) {
							$row = $result->fetch_assoc();
							echo "<tr>";
							echo "<td><input type='radio' name='crn' value='$row[crn]' required></td>";
							echo "<td>$row[crn]</td>";
							echo "<td>$row[course_code]</td>";
							echo "<td>$row[course_title]</td>";
							$row2 = $mysqli->query("SELECT name FROM user WHERE email='$row[faculty_email]'")->fetch_assoc();
							echo "<td>$row2[name]</td>";
							echo "<td>$row[enrolled]</td>";
							$locked = ($row['locked'] == 1) ? "Locked" : "Unlocked";
							$color = ($locked == "Locked") ? "red" : "green";
							$midterm = ($row['mid_evaluation'] == 1) ? "Done" : "Not Done";
							$final = ($row['final_evaluation'] == 1) ? "Done" : "Not Done";
							echo "<td class='$color'>$locked</td>";
							echo "<td>$midterm</td>";
							echo "<td>$final</td></tr>";
						}
						echo '</tbody></table>';

						if (isset($status)) {
							if ($status == 1)
                    			echo "<button class='fa-btn btn-1 btn-1e' name='submit' value='unlock'>Unlock</button>";
                    		elseif ($status == 0)
                    			echo "<button class='fa-btn btn-1 btn-1e' name='submit' value='lock'>Lock</button>";
						}
						?>
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