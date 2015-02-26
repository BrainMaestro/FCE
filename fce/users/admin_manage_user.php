<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

checkUser("admin");
$_SESSION['user'] = 'admin';
$_SESSION['success'] = '';
$_SESSION['success2'] = '';
if (isset($_POST['add_role'])) {
	$email = $_POST['email'];
	$role = $_POST['usertype'];
	$check = $mysqli->query("SELECT * from user_roles where user_email = '$email' and user_role = '$role'");
	if ($check->num_rows == 0) { 
	    if ($mysqli->query("INSERT INTO user_roles VALUES ('$email', '$role')")) {
	        $_SESSION['success'] = "Grant role successful";
	    } else {
	        $_SESSION['success'] = "Grant role unsuccessful";
	    }
	} else {
		$_SESSION['success'] = "Role has already been granted to user";
	}
}
if (isset($_POST['remove_role'])) {
	$email = $_POST['email'];
	$role = $_POST['usertype'];
	$check = $mysqli->query("SELECT * from user_roles where user_email = '$email' and user_role = '$role'");
	if ($check->num_rows != 0) { 
	    if ($mysqli->query("DELETE from user_roles where user_email = '$email' and user_role = '$role'")) {
	        $_SESSION['success2'] = "Revoke role successful";
	    } else {
	        $_SESSION['success2'] = "Revoke role unsuccessful";
	    }
	} else {
		$_SESSION['success2'] = "Role was never granted to user";
	}
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

<title>Admin | Home</title>
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
                $semester = getCurrentSemester();
                $school = $_SESSION['school'];
                ?>
                </ul>
		    </div>
		</nav>
	</div>
</div>
</div>
<div class="main_bg "><!-- start main -->
	<div class="container ">
		<div class="main row para">
			<div class="col-xs-3 text-center border" style="height:270px">
				<form action="" method='post'>
	                Leave search bar empty to get all roles<br><br><br>
	         
	                <input type="text" name="search" class="round" placeholder="Ex: Faculty">
					<br /><br /><p></p><p></p>
					<button class="black-btn" type="submit" name="role_filter">GET USERS</button>
				</form>
			</div>
            

            <div class="col-xs-2">
            </div>

			<div class="col-xs-3 text-center border" style="height:270px">
            	<form action="" method='post'>
	            	Assign roles to users<br>
	            	<br /><input type="text" class="round" name="email" placeholder="Ex: abdulmajid.alaedu@aun.edu.ng" required="required"/> <br /><br />

	                    <select class="input-sm" name="usertype" required="required">
	                        <option selected value="">--Choose User Type--</option>
	                        <option value="executive">Executive</option>
	                        <option value="faculty">Faculty</option>
	                        <option value="secretary">Secretary</option>
	                        <option value="admin">Admin</option>
	                        <option value="dean">Dean</option>
	                    </select><br /></p>
	                    <button class="black-btn" type="submit" name="add_role">GRANT ROLE</button>
	                    <p><?php echo $_SESSION['success']; ?></p>
	            </form>
            </div>

			<div class="col-xs-1 text-center">
            </div>

            <div class="col-xs-3 text-center border" style="height:270px">
            	<form action="" method='post'>
	            	Retract roles from users<br>
	            	<br /><input type="text" class="round" name="email" placeholder="Ex: abdulmajid.alaedu@aun.edu.ng" required="required"/> <br /><br />

	                    <select class="input-sm" name="usertype" required="required">
	                        <option selected value="">--Choose User Type--</option>
	                        <option value="executive">Executive</option>
	                        <option value="faculty">Faculty</option>
	                        <option value="secretary">Secretary</option>
	                        <option value="admin">Admin</option>
	                        <option value="dean">Dean</option>
	                    </select><br /></p>
	                    <button class="black-btn" type="submit" name="remove_role">REVOKE ROLE</button>
	                    <p><?php echo $_SESSION['success2']; ?></p>
	            </form>
            </div>
        </div>
			

            <div class="text-center">
			
			<?php
			
		    $search = '%';

			if (isset($_POST['role_filter'])) {  
		    	$search = $_POST['search'];
		    

	    		$result = $mysqli->query("SELECT name, email, user_role FROM users, user_roles  WHERE (users.email = user_roles.user_email) and user_role LIKE '%$search%'");
			    
			    if ($result->num_rows == 0)
					echo "<h4 class='error'>No user matches your search criteria</h4>";
				elseif (isset($_SESSION['err'])) {
					echo "<h4 class='error'>$_SESSION[err]</h4>";
					unset($_SESSION['err']);
				}
				else {
				echo "<table width='100%' class='evaltable para dean_form not-center'>
				<caption><h3>Reports</h3><hr></caption>
					<thead>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
					</thead><tbody>";

				for($i = 0; $i < $result->num_rows; $i++) {
	            	$row = $result->fetch_assoc();
		          
		        	echo '<tr>';
					echo "<td>$row[name]</td>";
					echo "<td>$row[email]</td>";
					echo "<td>$row[user_role]</td>";
		        	echo '</tr>';
				}
	        	echo '</tbody></table><hr>';
	        	}
	        }
			?>

			</div>	
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