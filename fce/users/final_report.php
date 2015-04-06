<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

// if ((!isset($_SESSION['user_type'])) || ($_SESSION['user_type'] == "secretary")){
// 	session_destroy();
//     session_start();
// 	$_SESSION['err'] = "You do not have access";
// 	header("Location: ../index.php");
// }

$course_no = $_GET['crn'];
$eval_type = "final";
checkEvaluations($course_no, $eval_type, $mysqli);
protectReports($course_no, $_SESSION['user'], $mysqli);
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

<title>Final Report</title>
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
            <h1><a href="../index.php">Faculty Course Evaluation</a></h1>
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
                    <li class='active'><a href="../index.php"><img src="../images/back.png" alt="Back to Home" style="width:18px;height:18px"></a></li>
                    <?php
                    list_roles('');
                    ?>
                </ul>
            </div>
        </nav>
    </div>
    <div class="clearfix"></div>
</div>
</div>
<div class='row para text-center'>
    <div class="col-xs-4"></div>
    <div class="col-xs-4">
        <table width="100%" class="not-center evaltable">
            <caption><h3>Report Details</h3><hr></caption>
            <tbody>
                <?php
                $row = $mysqli->query("SELECT * FROM sections WHERE crn='$course_no'")->fetch_assoc();
                $term = ($row['mid_evaluation'] == '0') ? "Midterm" : "Final";

                echo "<tr><td>CRN</td>";
                echo "<td>$course_no</td></tr>";
                echo "<tr><td>Course Code</td>";
                echo "<td>$row[course_code]</td></tr>";
                echo "<tr><td>Course Title</td>";
                echo "<td>$row[course_title]</td></tr>";
                echo "<tr><td>Report</td>";
                echo "<td>$term Evaluation Report</td></tr>";
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
                <tr>
                    <td>Scale</td>
                    <td>5 = excellent (exceptional, exemplary)<br>
                    4 = very good (high quality, better than average)<br>
                    3 = good (reasonable well done, acceptable)<br>
                    2 = margin (slightly below average, needs improvement)<br>
                    1 = poor (far below average, not acceptable)</td>
                </tr>
                <?php
                    $count_crn = $course_no;    
                    $count_eval_type = $eval_type;
                    $count_response = $mysqli->query("SELECT count(crn) AS filled FROM evaluations WHERE crn='$count_crn' AND eval_type='$count_eval_type'")->fetch_assoc();
                    $count_registered = $mysqli->query("SELECT enrolled FROM sections WHERE crn='$count_crn'")->fetch_assoc();
                    echo "<tr><td>Total Response</td><td>$count_response[filled]</td>";
                    echo "<tr><td>Total Enrolled</td><td>$count_registered[enrolled]</td>";    
                ?>
            </tbody>
        </table>
        <?php echo "<a target='_blank' href='./print_final.php?crn=$course_no'>Print Report Here</a>"; ?>
    </div>
</div>
<div class="clearfix"></div>
<div class="main_bg"><!-- start main -->
    <div class="container">
        <div class="main row para">
                <table align="center" class="para evaltable" width="100%">
                        <tr>
                            <th class="w5"></th>
                            <th class="w65"><strong>Course</strong></th>
                            <th class="w5">1</th>
                            <th class="w5">2</th>
                            <th class="w5">3</th>
                            <th class="w5">4</th>
                            <th class="w5">5</th>
                            <th class="w5">AVG</th>
                        </tr>
                        <tr>
                            <td class="w5">1</td>
                            <td class="w65"><strong>Organization</strong> (Course was well organized, material was presented in a logical sequence, instructional time was used effectively and important points emphasized.</td>
                            <td class="w5"><?php echo count_scale(1,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q1', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">2</td>
                            <td class="w65"><strong>Learning Outcomes and Objectives</strong> (Goals and educational objectives were clear, faculty expectations of students were clear, grading policy was clearly explained)</td>
                            <td class="w5"><?php echo count_scale(1,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q2', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">3</td>
                            <td class="w65"><strong>Content </strong>(Course content facilitated student ability to achieve course goals and objectives, and when applicable, was relevant to career preparation)</td>
                            <td class="w5"><?php echo count_scale(1,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q3', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">4</td>
                            <td class="w65"><strong>Assessment </strong>(Material on exams was related to material covered either in class or in course assignments, students were treated equitably)</td>
                            <td class="w5"><?php echo count_scale(1,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q4', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">5</td>
                            <td class="w65"><strong>Overall </strong>(The course objectives were met)</td>
                            <td class="w5"><?php echo count_scale(1,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q5', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <th class="w5"></th>
                            <th class="w65"><strong>Instructor</strong></th>
                            <th class="w5">1</th>
                            <th class="w5">2</th>
                            <th class="w5">3</th>
                            <th class="w5">4</th>
                            <th class="w5">5</th>
                            <th class="w5">AVG</th>
                        </tr>
                        <tr>
                            <td class="w5">6</td>
                            <td class="w65"><strong>Organization </strong>(Instructor presented material in an organized fashion; emphasized important points) </td>
                            <td class="w5"><?php echo count_scale(1,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q6', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">7</td>
                            <td class="w65"><strong>Clarity </strong>(Instructor communicated effectively, explained well, presented content clearly, and gave comprehensible response to  questions)</td>
                            <td class="w5"><?php echo count_scale(1,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q7', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">8</td>
                            <td class="w65"><strong>Enthusiasm </strong>(Instructor was dynamic and energetic, stimulated learner interest, and enjoyed teaching)</td>
                            <td class="w5"><?php echo count_scale(1,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q8', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">9</td>
                            <td class="w65"><strong>Up to Date </strong>(Instructor discussed recent development in the field, directed students to current reference materials, and provided additional materials to cover current topics)</td>
                            <td class="w5"><?php echo count_scale(1,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q9', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">10</td>
                            <td class="w65"><strong>Contribution </strong>(Instructor discussed recent development in the field, directed students to current reference materials, and provided additional materials to cover current topics)</td>
                            <td class="w5"><?php echo count_scale(1,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q10', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">11</td>
                            <td class="w65"><strong>Professionalism </strong>(Instructor demonstrated role model qualities that were of use to students)</td>
                            <td class="w5"><?php echo count_scale(1,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q11', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">12</td>
                            <td class="w65"><strong>Attitude </strong>(Instructor was concerned about students learning the material, encourages class participation, was receptive to different perspectives)</td>
                            <td class="w5"><?php echo count_scale(1,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q12', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <th class="w5"></th>
                            <th class="w65"><strong>Student</strong></th>
                            <th class="w5">1</th>
                            <th class="w5">2</th>
                            <th class="w5">3</th>
                            <th class="w5">4</th>
                            <th class="w5">5</th>
                            <th class="w5">AVG</th>
                        </tr>
                        <tr>
                            <td class="w5">13</td>
                            <td class="w65">I attended and participated in class sessions</td>
                            <td class="w5"><?php echo count_scale(1,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q13', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">14</td>
                            <td class="w65">I completed assignments on time</td>
                            <td class="w5"><?php echo count_scale(1,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q14', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">15</td>
                            <td class="w65">I learned the required information for the course</td>
                            <td class="w5"><?php echo count_scale(1,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q15', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">16</td>
                            <td class="w65">I used my laptop and technology successfully in this course.</td>
                            <td class="w5"><?php echo count_scale(1,'q16', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q16', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q16', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q16', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q16', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q16', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">17</td>
                            <td class="w65">I used the library as part of this class</td>
                            <td class="w5"><?php echo count_scale(1,'q17', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q17', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q17', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q17', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q17', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q17', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">18</td>
                            <td class="w65">I used at least one learning support program (writing center, math, lab, tutor, etc)</td>
                            <td class="w5"><?php echo count_scale(1,'q18', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(2,'q18', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(3,'q18', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(4,'q18', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo count_scale(5,'q18', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php echo avg_question('q18', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <th class="w5"></th>
                            <th class="w65"><strong>RATING AVERAGES</strong></th>
                        </tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65">Course</td>
                            <td class="w5"><?php echo avg_course($course_no, $eval_type, $mysqli);?></td>
                        </tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65">Instructor</td>
                            <td class="w5"><?php echo avg_instructor($course_no, $eval_type, $mysqli);?></td>
                        </tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65">Student</td>
                            <td class="w5"><?php echo avg_student($course_no, $eval_type, $mysqli);?></td>
                        </tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65">Total</td>
                            <td class="w5"><?php echo avg_final($course_no, $eval_type, $mysqli);?></td>
                    
                        </tr>
                    </table>

            </div>

        </div>
            </div>
</div><!-- end main -->
<FOOTER>
        <div class="footer_bg"><!-- start footer -->
            <div class="container">
                <div class="row  footer">
                    <div class="copy text-center">
                        <p class="link"><span>&#169; All rights reserved | Design by&nbsp;<a href="../thankyou.php#fceteam"> The FCE Team</a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </FOOTER>
</body>
</html>