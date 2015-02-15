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

    if ($stmt = $mysqli->prepare("INSERT INTO Evaluation(crn, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, eval_type)
		VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
        $eval_type = "mid";
        $crn = $_SESSION['crn'];
        $stmt->bind_param('iiiiiiiiiiiiiiiis', $crn,$_POST['q1'],$_POST['q2'],$_POST['q3'],$_POST['q4'],$_POST['q5'],$_POST['q6'],
            $_POST['q7'],$_POST['q8'],$_POST['q9'],$_POST['q10'],$_POST['q11'],$_POST['q12'],$_POST['q13'],$_POST['q14'],$_POST['q15'],$eval_type); 
        $stmt->execute(); 
		setKey($_SESSION['key_value'], "used", $mysqli);
		session_destroy();
		header("Location: ./thankyou.html");
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
        <title>FCE Mid Evaluation</title>
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
                        <li><a>Mid Evaluation Form</a></li>
                        <?php
                        $crn = $_SESSION['crn'];
                        $key_value = $_SESSION['key_value'];
                        $semester = getCurrentSemester();
                        $result = $mysqli->query("SELECT course_code, faculty_email, course_title, semester FROM section where crn='$crn'");
                        $row = $result->fetch_assoc();
                        $result2 = $mysqli->query("SELECT name from user WHERE email='$row[faculty_email]'");
                        $row2 = $result2 ->fetch_assoc();
                        echo "<li><a>$row[semester]</a></li>";
                        echo "<li><a>$row[course_code]</a></li>";
                        echo "<li><a>$row[course_title]</a></li>";
                        echo "<li><a>$row2[name]</a></li>";
                        echo "<li><a>Key: $key_value</a></li>";
                        echo "<li><a>Time Left: <span id='time' class='error'>00:00</span></a></li>";
                        echo "<script>startTimer();</script>";
                        ?>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                    <!-- start soc_icons -->
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="main row para">
                          <div class="col-md-5 images_1_of_4 bg1">
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
                            <td class="w70"><strong class="thead">Evaluation</strong></td>
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
                        <!--<tr ><td></td></tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w70"><strong class="thead">Instructor</strong></td>
                            <td class="w5">1</td>
                            <td class="w5">2</td>
                            <td class="w5">3</td>
                            <td class="w5">4</td>
                            <td class="w5">5</td>
                        </tr>-->
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
                    <button class="fa-btn btn-1 btn-1e" name='submit'>SUBMIT</button>
                </form>
                </div>
            </div>
        </div>

    <FOOTER>
        <div class="footer_bg"><!-- start footer -->
            <div class="container">
                <div class="row  footer">
                    <div class="copy text-center">
                        <p class="link"><span>&#169; All rights reserved | Design by&nbsp;<a href="http://w3layouts.com/"> W3Layouts</a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </FOOTER>
</body>
</html>