<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

if (isset($_POST['sbmt_mid'])) {
    $eval_type= $_POST['eval_type'];
    $course_no = $_POST['crn'];  
} else {
    $eval_type = $_SESSION['eval_type'];
    $course_no = $_SESSION['crn'];
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>FCE Report</title>
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
                        <li><a>Course Report</a></li>
                        <?php
                        $result = $mysqli->query("SELECT semester FROM section WHERE crn='$course_no'");
                        $result = $result->fetch_assoc();
                        $school = $_SESSION['school'];
                        $name = $_SESSION['name'];
                        echo "<li><a>$result[semester]</a></li>";
                        echo "<li><a>$school</a></li>";
                        echo "<li><a>$name</a></li>";
                        if ($eval_type == 'mid') {
                            echo "<li><a>midterm evaluation</a></li>";
                        }
                        else {
                            echo "<li><a>$eval_type" . " evaluation</a></li>";
                        }
                        echo "<li><a>CRN: $course_no</a></li>";
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
        <div class="main row">

                <table align="center" class="para" width="100%">
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
                            <td class="w65"><strong>Professor's Adherence to time </strong>(Professor arrives in the classroom on time.</td>
                            <td class="w5"><?php count_scale(1,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q1', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q1', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">2</td>
                            <td class="w65"><strong>Professor's preparedness to Teach </strong>(My professor arrives in the classroom prepared)</td>
                            <td class="w5"><?php count_scale(1,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q2', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q2', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">3</td>
                            <td class="w65"><strong>Professor's Accessibility in Class </strong>(My professor is accessible in class)</td>
                            <td class="w5"><?php count_scale(1,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q3', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q3', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">4</td>
                            <td class="w65"><strong>Professor's Availability in Class </strong>(My professor is available during office hours)</td>
                            <td class="w5"><?php count_scale(1,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q4', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q4', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">5</td>
                            <td class="w65"><strong>Asking Questions in Class </strong>(I feel comfortable asking questions during class)</td>
                            <td class="w5"><?php count_scale(1,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q5', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q5', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">6</td>
                            <td class="w65"><strong>Explanation of Concepts </strong>(My professor explains the material and concepts well) </td>
                            <td class="w5"><?php count_scale(1,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q6', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q6', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">7</td>
                            <td class="w65"><strong>Professor's Teaching Consistency </strong>(My professor is consistent in his teaching )</td>
                            <td class="w5"><?php count_scale(1,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q7', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q7', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">8</td>
                            <td class="w65"><strong>Use of e-Book </strong>(My professor uses e-books)</td>
                            <td class="w5"><?php count_scale(1,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q8', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q8', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">9</td>
                            <td class="w65"><strong>Use of Digital Instructional Technologies </strong>(My professor uses other digital instructional technology such as Electronic Journal Articles, Youtube, TED Talks, computer programs, videos, online resources, or social media)</td>
                            <td class="w5"><?php count_scale(1,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q9', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q9', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">10</td>
                            <td class="w65"><strong>Learning compliance with the Syllabus </strong>(I am learning what is in the course description/syllabus)</td>
                            <td class="w5"><?php count_scale(1,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q10', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q10', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">11</td>
                            <td class="w65"><strong>Use of Digital Skills </strong>(I am using digital and other on-line skills in this course)</td>
                            <td class="w5"><?php count_scale(1,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q11', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q11', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">12</td>
                            <td class="w65"><strong>Relevance of Assignments </strong>(My professor’s assignments are relevant to the course)</td>
                            <td class="w5"><?php count_scale(1,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q12', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q12', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">13</td>
                            <td class="w65"><strong>Grading Policies </strong>My professors grading policies are fair and consistent with the syllabus</td>
                            <td class="w5"><?php count_scale(1,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q13', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q13', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">14</td>
                            <td class="w65"><strong>Relevance of Course content to future career prospects </strong>My professor relates course content and skills to my future career</td>
                            <td class="w5"><?php count_scale(1,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q14', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q14', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5">15</td>
                            <td class="w65"><strong>American Style Education </strong>My professor teaches in accordance with the interactive American style of education that is the way AUN claims to be different</td>
                            <td class="w5"><?php count_scale(1,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(2,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(3,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(4,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php count_scale(5,'q15', $course_no, $eval_type, $mysqli)?></td>
                            <td class="w5"><?php avg_question('q15', $course_no, $eval_type, $mysqli)?></td>
                        </tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w70"><strong>TOTAL AVERAGE</strong></td>
                            <td class="w5"><strong><?php avg_midterm($course_no, $eval_type, $mysqli) ?></strong></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5">></td>
                        </tr>
                    </table>
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