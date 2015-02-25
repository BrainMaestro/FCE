<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

checkUser("secretary");
    
if (isset($_POST['submit'])) {

	if ($_POST['submit'] == 'lock')
		lockSection($_POST['crn'], $mysqli);
	else
		unlockSection($_POST['crn'], $mysqli);
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
                <?php
                list_roles('secretary');
                $semester = getCurrentSemester();
                // $school = $_SESSION['school'];
                // $name = $_SESSION['name'];
                // echo "<li><a>$semester</a></li>";
                // echo "<li><a>$school</a></li>";
                // echo "<li><a>$name</a></li>";
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
            <div class="col-xs-4 text-center"></div>		
			<div class="col-xs-4 text-center border">
				<form action="secretary.php" method='post'>
	                Leave search bar empty to search all sections<br><br>
					<select name="status" class="input-sm" required>
	                    <option selected value="1">Locked</option>
	                    <option value="0">Unlocked</option>
	                    <option value="%">All</option>
	                </select><br><br>
					<input type="text" class="round" name="search" placeholder="Ex: AUN 101"><br><br>
					<input class="black-btn" type="submit" name="filter" value="search">
				</form>	
			</div>	
            <div class="col-xs-4 text-center"></div>
		</div>

		<div class="row para">
			<div class="col-xs-12 text-center">		
				<form action="secretary.php" method="post">
					<?php
					$result = $mysqli->query("SELECT * FROM sections WHERE locked = '1' AND semester = '$semester'");
					$status = '1';
					$caption = 'Locked ';
					$color = 'red';

					if (isset($_POST['filter'])) {
						$status = $_POST['status'];
						$sql = "SELECT * FROM sections WHERE locked LIKE '$status'";

						if (isset($_POST['search']))
							$sql .= " AND course_code LIKE '%$_POST[search]%'";
						$sql .= " AND semester = '$semester'";
						$result = $mysqli->query($sql);

						switch ($status) { // Colors the table caption like the status column
						case '0':
							$caption = 'Unlocked ';
							$color = 'green';
							break;

						case '1':
							$caption = 'Locked ';
							$color = 'red';
							break;
						
						default:
							$caption = 'All ';
							$color = '';
							break;
						}
					}

					echo "<table width='100%' class='not-center evaltable'>
					<caption><h3 class='$color'>$caption Sections</h3><hr></caption>
					<thead>";
						if ($status != '%')
							echo "<th></th>";
						echo "<th>CRN</th>
						<th>Course Code</th>
						<th>Course Title</th>
						<th>Instructor</th>
						<th>Class Time</th>
                        <th>Location</th>
						<th>Enrolled</th>
						<th>Status</th>
						<th>Midterm Evaluation</th>
						<th>Final Evaluation</th>";
						if ($status == '0')
							echo "<th>Section Keys</th>";
					echo "</thead>
					<tbody>";

					for($i = 0; $i < $result->num_rows; $i++) {
						$row = $result->fetch_assoc();
						echo "<tr>";
						if ($status != '%')
							echo "<td><input type='radio' name='crn' value='$row[crn]' required></td>";
						echo "<td>$row[crn]</td>";
						echo "<td>$row[course_code]</td>";
						echo "<td>$row[course_title]</td>";
						$assignment = $mysqli->query("SELECT * FROM course_assignments WHERE crn='$row[crn]'");
						echo "<td>";
						for($j = 0; $j < $assignment->num_rows; $j++) {
							$row2 = $assignment->fetch_assoc();
							$faculty = $mysqli->query("SELECT name FROM users WHERE email='$row2[faculty_email]'")->fetch_assoc();
							echo "$faculty[name]<br>";
						}
						echo "</td>";
						echo "<td>$row[class_time]</td>";
                        echo "<td>$row[location]</td>";
						echo "<td>$row[enrolled]</td>";
						$locked = ($row['locked'] == 1) ? "Locked" : "Unlocked";
						$color = ($locked == "Locked") ? "red" : "green";
						$midterm = ($row['mid_evaluation'] == 1) ? "Done" : "Not Done";
						$final = ($row['final_evaluation'] == 1) ? "Done" : "Not Done";
						echo "<td class='$color'>$locked</td>";
						echo "<td>$midterm</td>";
						echo "<td>$final</td>";
						if ($status == '0')
							echo "<td><a href='section.php?crn=$row[crn]' target='_blank'>$row[course_code] Keys</a></td>";
						else
						echo "</tr>";
					}
					echo '</tbody></table><hr>';

					if (isset($status) && $status !== '%' && $result->num_rows > 0) {
						if ($status == 1)
                			echo "<button class='black-btn margin' name='submit' value='unlock'>Unlock</button>";
                		elseif ($status == 0)
                			echo "<button class='black-btn margin' name='submit' value='lock'>Lock</button>";
					}

					if ($result->num_rows == 0)
						echo "<h4 class='error'>No section matches your search criteria</h4>";
					elseif (isset($_SESSION['err'])) {
						echo "<h4 class='error'>$_SESSION[err]</h4>";
						unset($_SESSION['err']);
					}
					?>
				</form>

			</div>
		</div>
	</div>
</div><!-- end main -->
<FOOTER>
        <div class="footer_bg"><!-- start footer -->
            <div class="container">
                <div class="row  footer">
                    <div class="copy text-center">
                        <p class="link"><span>&#169; All rights reserved | Design by&nbsp;<a href="thankyou.php#fceteam"> The FCE Team</a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </FOOTER>
</body>
</html>