<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

// session_start();

checkSessionKeys();

if (!isset($_SESSION['key_value'])) {
	$_SESSION['err'] = "You do not have access";
	header("Location: index.php");
}

if (isset($_POST['submit'])) {
	
	$crn = $_SESSION['crn'];
	$status = checkSectionStatus($crn, $mysqli);
	if ($status == true) {
		session_destroy();
		header("Location: index.php");
	}
	
    if ($stmt = $mysqli->prepare("INSERT INTO evaluations(crn, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, eval_type)
		VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
        $eval_type = "mid";
        $crn = $_SESSION['crn'];
        $stmt->bind_param('iiiiiiiiiiiiiiiis', $crn,$_POST['q1'],$_POST['q2'],$_POST['q3'],$_POST['q4'],$_POST['q5'],$_POST['q6'],
            $_POST['q7'],$_POST['q8'],$_POST['q9'],$_POST['q10'],$_POST['q11'],$_POST['q12'],$_POST['q13'],$_POST['q14'],$_POST['q15'],$eval_type); 
        $stmt->execute(); 
		setKey($_SESSION['key_value'], "used", $mysqli);
		session_destroy();
		header("Location: ./thankyou.php");
    } else {
		$_SESSION['err'] = "Database error: cannot prepare statement";
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE HTML>
<html>
    <head>
	
		<!-- Favicon Kini -->
        <link rel="apple-touch-icon" sizes="57x57" href="images/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="images/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="images/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="images/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="images/favicons/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="images/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="images/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="images/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="images/favicons/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!-- End of Favicon Kini -->
	
        <title>Mid Evaluation</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
       <![endif]-->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <!-- start plugins -->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <!-- start slider -->
        <link href="css/slider.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/style.custom.css" rel='stylesheet' type='text/css' />
        <script type="text/javascript" src="js/modernizr.custom.28468.js"></script>
        <script type="text/javascript" src="js/jquery.cslider.js"></script>
        <!--font-Awesome-->
        <link rel="stylesheet" href="fonts/css/font-awesome.min.css">
        <!--font-Awesome-->
        <script type="text/javascript">
        function startTimer() {
            //var fiveMinutes = 60 * 30,
			var fiveMinutes = 6000,
                display = document.getElementById("time"),
                mins, seconds;
            setInterval(function() {
                mins = parseInt(fiveMinutes / 60)
                seconds = parseInt(fiveMinutes % 60);
                seconds = seconds < 10 ? "0" + seconds : seconds;
                mins = mins < 10 ? "0" + mins : mins;

                display.innerHTML = mins + ":" + seconds;
                fiveMinutes--;

                if (fiveMinutes < 0) {
                    //fiveMinutes = 60 * 30;
					windows.location.href = 'index.php';
                }
            }, 1000);
        }
        </script>
    </head>
    <body>
        <div class="header_bg">
            <div class="container">
                <div class="row header">
                    <div class="logo navbar-left">
                        <h1><a href="index.php">Faculty Course Evaluation</a></h1>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="container">
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
                        <!-- <li><a>Mid Evaluation Form</a></li>
                        <?php
                        // echo "<li><a>Time Left: <span id='time' class='error'>00:00</span></a></li>";
                        // echo "<script>startTimer();</script>";
                        ?> -->
                        </ul>
                    </div><!-- /.navbar-collapse -->
                    <!-- start soc_icons -->
                </nav>
            </div>
        </div>
        <div class='row para text-center'>
            <div class="col-xs-4"></div>
            <div class="col-xs-4">
                <table width="100%" class="not-center evaltable">
                    <caption><h3>Course Details</h3><hr></caption>
                    <tbody>
                        <?php
                        $crn = $_SESSION['crn'];
                        $key_value = $_SESSION['key_value'];
                        $row = $mysqli->query("SELECT * FROM sections WHERE crn='$crn'")->fetch_assoc();
                        $eval_type = ($row['mid_evaluation'] == '0') ? "mid" : "final";
                        $term = ($row['mid_evaluation'] == '0') ? "Midterm" : "Final";

                        echo "<tr><td>CRN</td>";
                        echo "<td>$crn</td></tr>";
                        echo "<tr><td>Course Code</td>";
                        echo "<td>$row[course_code]</td></tr>";
                        echo "<tr><td>Course Title</td>";
                        echo "<td>$row[course_title]</td></tr>";
                        echo "<tr><td>Instructor(s)</td>";
                        $assignment = $mysqli->query("SELECT * FROM course_assignments WHERE crn='$row[crn]'");
                        echo "<td>";
                        for($j = 0; $j < $assignment->num_rows; $j++) {
                            $row2 = $assignment->fetch_assoc();
                            $faculty = $mysqli->query("SELECT name FROM users WHERE email='$row2[faculty_email]'")->fetch_assoc();
                            echo "$faculty[name]<br>";
                        }
                        echo "</td></tr>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container">
            <div class="main row para">
                <div class="col-md-5">
                    <div class="banner-msg">

                    Using the criteria below, please evaluate the course taken during this semester. Your responses will be used to assist in more effective and efficient course delivery. Please select appropriate columns numbers
                    1-5, to each questions 1-15. <br>For each response, please use the following scale.<br>
                    5 = excellent (exceptional, exemplary)<br>
                    4 = very good (high quality, better than average)<br>
                    3 = good (reasonable well done, acceptable)<br>
                    2 = margin (slightly below average, needs improvement)<br>
                    1 = poor (far below average, not acceptable)<br><br>
                    </div>
                    <form action="./mid_evaluation.php" method="POST">
                    <table class="evaltable">
                        <tr>
                            <td class="w5"></td>
                            <td class="w70"><strong class="thead">Midterm Evaluation</strong></td>
                            <td class="w5">1</td>
                            <td class="w5">2</td>
                            <td class="w5">3</td>
                            <td class="w5">4</td>
                            <td class="w5">5</td>
                        </tr>
                        <tr>
                            <td class="w5">1</td>
                            <td class="w70"><strong>Professor's Adherence to time </strong>(Professor arrives in the classroom on time.</td>
                            <td class="w5"><input type="radio" name="q1" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q1" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q1" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q1" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q1" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">2</td>
                            <td class="w70"><strong>Professor's preparedness to Teach </strong>(My professor arrives in the classroom prepared)</td>
                            <td class="w5"><input type="radio" name="q2" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q2" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q2" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q2" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q2" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">3</td>
                            <td class="w70"><strong>Professor's Accessibility in Class </strong>(My professor is accessible in class)</td>
                            <td class="w5"><input type="radio" name="q3" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q3" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q3" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q3" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q3" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">4</td>
                            <td class="w70"><strong>Professor's Availability in Class </strong>(My professor is available during office hours)</td>
                            <td class="w5"><input type="radio" name="q4" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q4" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q4" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q4" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q4" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">5</td>
                            <td class="w70"><strong>Asking Questions in Class </strong>(I feel comfortable asking questions during class)</td>
                            <td class="w5"><input type="radio" name="q5" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q5" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q5" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q5" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q5" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">6</td>
                            <td class="w70"><strong>Explanation of Concepts </strong>(My professor explains the material and concepts well) </td>
                            <td class="w5"><input type="radio" name="q6" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q6" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q6" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q6" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q6" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">7</td>
                            <td class="w70"><strong>Professor's Teaching Consistency </strong>(My professor is consistent in his teaching )</td>
                            <td class="w5"><input type="radio" name="q7" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q7" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q7" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q7" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q7" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">8</td>
                            <td class="w70"><strong>Use of e-Book </strong>(My professor uses e-books)</td>
                            <td class="w5"><input type="radio" name="q8" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q8" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q8" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q8" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q8" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">9</td>
                            <td class="w70"><strong>Use of Digital Instructional Technologies </strong>(My professor uses other digital instructional technology such as Electronic Journal Articles, Youtube, TED Talks, computer programs, videos, online resources, or social media)</td>
                            <td class="w5"><input type="radio" name="q9" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q9" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q9" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q9" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q9" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">10</td>
                            <td class="w70"><strong>Learning compliance with the Syllabus </strong>(I am learning what is in the course description/syllabus)</td>
                            <td class="w5"><input type="radio" name="q10" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q10" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q10" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q10" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q10" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">11</td>
                            <td class="w70"><strong>Use of Digital Skills </strong>(I am using digital and other on-line skills in this course)</td>
                            <td class="w5"><input type="radio" name="q11" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q11" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q11" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q11" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q11" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">12</td>
                            <td class="w70"><strong>Relevance of Assignments </strong>(My professor’s assignments are relevant to the course)</td>
                            <td class="w5"><input type="radio" name="q12" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q12" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q12" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q12" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q12" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">13</td>
                            <td class="w70"><strong>Grading Policies </strong>My professors grading policies are fair and consistent with the syllabus</td>
                            <td class="w5"><input type="radio" name="q13" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q13" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q13" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q13" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q13" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">14</td>
                            <td class="w70"><strong>Relevance of Course content to future career prospects </strong>My professor relates course content and skills to my future career </td>
                            <td class="w5"><input type="radio" name="q14" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q14" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q14" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q14" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q14" value="5" required="required"></td>
                        </tr>
                        <tr>
                            <td class="w5">15</td>
                            <td class="w70"><strong>American Style Education </strong>My professor teaches in accordance with the interactive American style of education that is the way AUN claims to be different</td>
                            <td class="w5"><input type="radio" name="q15" value="1" required="required"></td>
                            <td class="w5"><input type="radio" name="q15" value="2" required="required"></td>
                            <td class="w5"><input type="radio" name="q15" value="3" required="required"></td>
                            <td class="w5"><input type="radio" name="q15" value="4" required="required"></td>
                            <td class="w5"><input type="radio" name="q15" value="5" required="required"></td>
                        </tr>
                    </table>
                
                    <br>

                    <!-- <textarea class="eval" rows="3" cols="160" placeholder="Other suggestion(s) to improve the course? Please take time to fill out this section"></textarea> -->
                    <button class="black-btn" name='submit'>SUBMIT</button>
                </form>
                </div>
            </div>
        </div>

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