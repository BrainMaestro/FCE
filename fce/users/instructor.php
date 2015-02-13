<?php
    include 'avg.php';
?>
<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>FCE Instructor</title>
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.custom.css" rel='stylesheet' type='text/css' />
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
<!----font-Awesome----->
   	<link rel="stylesheet" href="fonts/css/font-awesome.min.css">
<!----font-Awesome----->
</head>
<body>
<div class="header_bg1">
<div class="container">
	<div class="row header">
		<div class="logo navbar-left">
			<h1><a href="index.html">Faculty Course Evaluation</a></h1>
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
			<div class="col-md-8 blog_left">
				<h3>FACULTY EVALUATION RESULT</h3>

				<table align="center" class="para" width="100%" border="1">
                        <tr>
                            <td class="w5"></td>
                            <td class="w65"><strong>Course</strong></td>
                            <td class="w5">1</td>
                            <td class="w5">2</td>
                            <td class="w5">3</td>
                            <td class="w5">4</td>
                            <td class="w5">5</td>
                            <td class="w5">AVG</td>
                        </tr>
                        <tr>
                            <td class="w5">1</td>
                            <td class="w65"><strong>Organization</strong> (Course was well organized, material was presented in a logical sequence, instructional time was used effectively and important points emphasized.</td>
                            <td class="w5"><?php count_scale(1,'q1', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q1', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q1', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q1', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q1', $course_no)?></td>
                            <td class="w5"><?php avg_question('q1', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">2</td>
                            <td class="w65"><strong>Learning Outcomes and Objectives</strong> (Goals and educational objectives were clear, faculty expectations of students were clear, grading policy was clearly explained)</td>
                            <td class="w5"><?php count_scale(1,'q2', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q2', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q2', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q2', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q2', $course_no)?></td>
                            <td class="w5"><?php avg_question('q2', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">3</td>
                            <td class="w65"><strong>Content </strong>(Course content facilitated student ability to achieve course goals and objectives, and when applicable, was relevant to career preparation)</td>
                            <td class="w5"><?php count_scale(1,'q3', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q3', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q3', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q3', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q3', $course_no)?></td>
                            <td class="w5"><?php avg_question('q3', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">4</td>
                            <td class="w65"><strong>Assessment </strong>(Material on exams was related to material covered either in class or in course assignments, students were treated equitably)</td>
                            <td class="w5"><?php count_scale(1,'q4', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q4', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q4', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q4', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q4', $course_no)?></td>
                            <td class="w5"><?php avg_question('q4', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">5</td>
                            <td class="w65"><strong>Overall </strong>(The course objectives were met)</td>
                            <td class="w5"><?php count_scale(1,'q5', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q5', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q5', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q5', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q5', $course_no)?></td>
                            <td class="w5"><?php avg_question('q5', $course_no)?></td>
                        </tr>
                        <tr ><td></td></tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65"><strong>Instructor</strong></td>
                            <td class="w5">1</td>
                            <td class="w5">2</td>
                            <td class="w5">3</td>
                            <td class="w5">4</td>
                            <td class="w5">5</td>
                            <td class="w5">AVG</td>
                        </tr>
                        <tr>
                            <td class="w5">6</td>
                            <td class="w65"><strong>Organization </strong>(Instructor presented material in an organized fashion; emphasized important points) </td>
                            <td class="w5"><?php count_scale(1,'q6', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q6', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q6', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q6', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q6', $course_no)?></td>
                            <td class="w5"><?php avg_question('q6', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">7</td>
                            <td class="w65"><strong>Clarity </strong>(Instructor communicated effectively, explained well, presented content clearly, and gave comprehensible response to  questions)</td>
                            <td class="w5"><?php count_scale(1,'q7', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q7', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q7', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q7', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q7', $course_no)?></td>
                            <td class="w5"><?php avg_question('q7', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">8</td>
                            <td class="w65"><strong>Enthusiasm </strong>(Instructor was dynamic and energetic, stimulated learner interest, and enjoyed teaching)</td>
                            <td class="w5"><?php count_scale(1,'q8', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q8', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q8', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q8', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q8', $course_no)?></td>
                            <td class="w5"><?php avg_question('q8', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">9</td>
                            <td class="w65"><strong>Up to Date </strong>(Instructor discussed recent development in the field, directed students to current reference materials, and provided additional materials to cover current topics)</td>
                            <td class="w5"><?php count_scale(1,'q9', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q9', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q9', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q9', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q9', $course_no)?></td>
                            <td class="w5"><?php avg_question('q9', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">10</td>
                            <td class="w65"><strong>Contribution </strong>(Instructor discussed recent development in the field, directed students to current reference materials, and provided additional materials to cover current topics)</td>
                            <td class="w5"><?php count_scale(1,'q10', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q10', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q10', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q10', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q10', $course_no)?></td>
                            <td class="w5"><?php avg_question('q10', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">11</td>
                            <td class="w65"><strong>Professionalism </strong>(Instructor demonstrated role model qualities that were of use to students)</td>
                            <td class="w5"><?php count_scale(1,'q11', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q11', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q11', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q11', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q11', $course_no)?></td>
                            <td class="w5"><?php avg_question('q11', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">12</td>
                            <td class="w65"><strong>Attitude </strong>(Instructor was concerned about students learning the material, encourages class participation, was receptive to different perspectives)</td>
                            <td class="w5"><?php count_scale(1,'q12', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q12', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q12', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q12', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q12', $course_no)?></td>
                            <td class="w5"><?php avg_question('q12', $course_no)?></td>
                        </tr>
                        <tr ><td></td></tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65"><strong>Student</strong></td>
                            <td class="w5">1</td>
                            <td class="w5">2</td>
                            <td class="w5">3</td>
                            <td class="w5">4</td>
                            <td class="w5">5</td>
                            <td class="w5">AVG</td>
                        </tr>
                        <tr>
                            <td class="w5">13</td>
                            <td class="w65">I attended and participated in class sessions</td>
                            <td class="w5"><?php count_scale(1,'q13', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q13', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q13', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q13', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q13', $course_no)?></td>
                            <td class="w5"><?php avg_question('q13', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">14</td>
                            <td class="w65">I completed assignments on time</td>
                            <td class="w5"><?php count_scale(1,'q14', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q14', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q14', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q14', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q14', $course_no)?></td>
                            <td class="w5"><?php avg_question('q14', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">15</td>
                            <td class="w65">I learned the required information for the course</td>
                            <td class="w5"><?php count_scale(1,'q15', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q15', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q15', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q15', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q15', $course_no)?></td>
                            <td class="w5"><?php avg_question('q15', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">16</td>
                            <td class="w65">I used my laptop and technology successfully in this course.</td>
                            <td class="w5"><?php count_scale(1,'q16', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q16', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q16', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q16', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q16', $course_no)?></td>
                            <td class="w5"><?php avg_question('q16', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">17</td>
                            <td class="w65">I used the library as part of this class</td>
                            <td class="w5"><?php count_scale(1,'q17', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q17', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q17', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q17', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q17', $course_no)?></td>
                            <td class="w5"><?php avg_question('q17', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5">18</td>
                            <td class="w65">I used at least one learning support program (writing center, math, lab, tutor, etc)</td>
                            <td class="w5"><?php count_scale(1,'q18', $course_no)?></td>
                            <td class="w5"><?php count_scale(2,'q18', $course_no)?></td>
                            <td class="w5"><?php count_scale(3,'q18', $course_no)?></td>
                            <td class="w5"><?php count_scale(4,'q18', $course_no)?></td>
                            <td class="w5"><?php count_scale(5,'q18', $course_no)?></td>
                            <td class="w5"><?php avg_question('q18', $course_no)?></td>
                        </tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65"><strong>RATING AVERAGES</strong></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                        </tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65">Course</td>
                            <td class="w5"><?php avg_course($course_no);?></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                        </tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65">Instructor</td>
                            <td class="w5"><?php avg_instructor($course_no);?></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                        </tr>
                        <tr>
                            <td class="w5"></td>
                            <td class="w65">Student</td>
                            <td class="w5"><?php avg_student($course_no);?></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                            <td class="w5"></td>
                        </tr>
                    </table>
			</div>
			<div class="col-md-4 blog_right news_letter">
				<h4>School of Arts and Sciences</h4>
				<h5>Fall 2015</h5>
				
				<form>
					<select name="" class="input-sm">
	                    <option selected value="">--Choose Evaluation Type--</option>
	                    <option value="">Midterm</option>
	                    <option value="">Final</option>
	                </select>
					<div class="clearfix"></div>
					<div style="height:25px"></div>
					<select name="" class="input-sm">
	                    <option selected value="">--Choose Course--</option>
	                    <option value="">Course A</option>
	                    <option value="">Course B</option>
	                </select>
					<div class="clearfix"></div>
					<span  class="fa-btn btn-1 btn-1e "><input type="submit" value="SUBMIT"></span>
				</form>
			</div>
					
			</div>
			<div class="clearfix"></div>
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