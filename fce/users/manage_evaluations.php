<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

checkUser("admin");
$_SESSION['user'] = 'admin';
$semester = getCurrentSemester();

if (isset($_POST['submit'])) {
	$array = preg_split("/[,]+/", $_POST['eval']);
	$column = $array[0];
	$value = $array[1];
	$update = ($value == "Locked") ? "Open" : "Done";
	if ($update == "Done") {
		$result = $mysqli->query("SELECT crn FROM sections WHERE crn in (SELECT DISTINCT(key_crn) FROM accesskeys)");
		for ($i=0;$i<$result->num_rows;$i++) {
			$row =  $result->fetch_assoc();
			finalLockSection($row['crn'],$column,$mysqli);
		}
	}
	$mysqli->query("UPDATE semesters SET $column = '$update' WHERE semester='$semester'");
}
?>
<!DOCTYPE HTML>
<html>
<head>

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

<title>Admin | Manage Evaluations</title>
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
			<h1><a>Faculty Course Evaluation</a></h1>
		</div>
		<div class="h_search navbar-right">
			<?php
				$t=time();
				// echo(date("g:i A D, M d, Y",$t));
			?>
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
                list_roles('admin');
                ?>
                </ul>
		    </div>
		</nav>
	</div>
</div>
</div>
<div class="text-center">
	<br></br>
	<a href="./admin_add_user.php"><button class='black-btn'>Add User</button></a>
	<a href="./admin_add_section.php"><button class='black-btn'>Add Section</button></a>
	<a href="./admin_manage_user.php"><button class='black-btn'>Manage User</button></a>
	<a href="./statistics.php"><button class='black-btn'>Statistics</button></a>
	<a href="./manage_evaluations.php"><button class='link-active black-btn'>Evaluations</button></a>
</div>
<div class="main_bg "><!-- start main -->
	<div class="container ">
		<div class="main row para">	
            <div class="col-xs-4 text-center"></div>		
			<div class="col-xs-4 text-center">
				<form action="" method='post'>
					<table width='100%' class='evaltable para dean_form not-center'>
						<caption><h3><?php echo $semester; ?></h3><hr></caption>
						<thead>
							<th></th>
						</thead>
						<tbody>
		                <?php
		                $row = $mysqli->query("SELECT * FROM semesters WHERE semester='$semester'")->fetch_assoc();
		                $mid_disabled = ($row['mid'] == 'Done') ? "disabled" : "";
		                $final_disabled = ($row['final'] == 'Done') ? "disabled" : "";
		                $final_disabled = ($row['mid'] == "Open") ? "disabled" : $final_disabled;
		                $mid_disabled = ($row['final'] == "Open") ? "disabled" : $mid_disabled;
		                echo "<tr>";
						echo "<td><input type='radio' name='eval' $mid_disabled value='mid,$row[mid]' required></td>";
		                echo "<td>Midterm Evaluation</td>";
		                echo "<td name='status'>$row[mid]</td>";
		                echo "</tr>";
		                echo "<tr>";
						echo "<td><input type='radio' name='eval' $final_disabled value='final,$row[final]' required></td>";
		                echo "<td>Final Evaluation</td>";
		                echo "<td name='status'>$row[final]</td>";
		                echo "</tr>";
						?>
						</tbody>
					</table>
					<script type="text/javascript">
					var values = document.getElementsByName('status');
					for (var i = 0; i < values.length; i++) {
						var color;
						switch (values[i].innerHTML) {
							case "Locked": color = "red"; break;
							case "Open": color = "green"; break;
							default: color = "";
						}
						values[i].style.color = color;
					};
					</script>
					<br><br>
					<button class="black-btn size-input" type="submit" name="submit">Lock | Unlock</button>
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
                        <p class="link"><span>&#169; All rights reserved | Design by&nbsp;<a href="../thankyou.php"> The FCE Team</a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </FOOTER>
</body>
</html>