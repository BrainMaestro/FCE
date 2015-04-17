<?php
    include_once '../includes/db_connect.php';
    include_once '../includes/functions.php';
    
    checkUser("admin");
    // total no of students, sections
    $row = $mysqli->query("SELECT SUM(enrolled), COUNT(crn) FROM sections")->fetch_array();
    $total_students = $row[0];
    $total_sections = $row[1];

    //total no of responses
    $row2 = $mysqli->query("SELECT COUNT(crn) FROM evaluations WHERE eval_type = 'mid'")->fetch_array();
    $mid_responses = $row2[0];
    $row3 = $mysqli->query("SELECT COUNT(crn) FROM evaluations WHERE eval_type = 'final'")->fetch_array();
    $final_responses = $row3[0];

    //total section evaluated so far
    $row4 = $mysqli->query("SELECT COUNT(crn) FROM sections WHERE mid_evaluation = 1")->fetch_array();
    $mid_eval = $row4[0];
    $row5 = $mysqli->query("SELECT COUNT(crn) FROM sections WHERE final_evaluation = 1")->fetch_array();
    $final_eval = $row5[0];

    // SELECT a.crn,a.type,a.total,s.course_code,s.class_time FROM averages a inner join sections s on (a.crn=s.crn) join course_assignments c on (s.crn = c.crn) where a.total in (select max(total) from averages where type='final')
    //duplicate rows with classes with two instructors


    //best section
    $row6 = $mysqli->query("SELECT a.crn,a.type,a.total,s.course_code,s.class_time FROM averages a inner join sections s on (a.crn=s.crn) where a.total in (select max(total) from averages where type='mid')");
    $row7 = $mysqli->query("SELECT a.crn,a.type,a.total,s.course_code,s.class_time FROM averages a inner join sections s on (a.crn=s.crn) where a.total in (select max(total) from averages where type='final')");

    //worst section
    $row8 = $mysqli->query("SELECT a.crn,a.type,a.total,s.course_code,s.class_time FROM averages a inner join sections s on (a.crn=s.crn) where a.total in (select min(total) from averages where type='mid')");
    $row9 = $mysqli->query("SELECT a.crn,a.type,a.total,s.course_code,s.class_time FROM averages a inner join sections s on (a.crn=s.crn) where a.total in (select min(total) from averages where type='final')");

    //best department
    $row10 = $mysqli->query("SELECT avg(total), substr(s.course_code, 1, 3) dept FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'mid' group by dept having avg(total) = (SELECT max(avgs) FROM (SELECT avg(total) avgs FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'mid' group by substr(s.course_code, 1, 3)) as new_derived_table)");
    $row11 = $mysqli->query("SELECT avg(total), substr(s.course_code, 1, 3) dept FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'final' group by dept having avg(total) = (SELECT max(avgs) FROM (SELECT avg(total) avgs FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'final' group by substr(s.course_code, 1, 3)) as new_derived_table)");

    //worst department
    $row12 = $mysqli->query("SELECT avg(total), substr(s.course_code, 1, 3) dept FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'mid' group by dept having avg(total) = (SELECT min(avgs) FROM (SELECT avg(total) avgs FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'mid' group by substr(s.course_code, 1, 3)) as new_derived_table)");
    $row13 = $mysqli->query("SELECT avg(total), substr(s.course_code, 1, 3) dept FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'final' group by dept having avg(total) = (SELECT min(avgs) FROM (SELECT avg(total) avgs FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'final' group by substr(s.course_code, 1, 3)) as new_derived_table)");

    //best school
    $row14 = $mysqli->query("SELECT avg(total), school FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'mid' group by school having avg(total) = (SELECT max(avgs) FROM (SELECT avg(total) avgs FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'mid' group by school) as new_derived_table)");
    $row15 = $mysqli->query("SELECT avg(total), school FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'final' group by school having avg(total) = (SELECT max(avgs) FROM (SELECT avg(total) avgs FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'final' group by school) as new_derived_table)");

    //worst school
    $row16 = $mysqli->query("SELECT avg(total), school FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'mid' group by school having avg(total) = (SELECT min(avgs) FROM (SELECT avg(total) avgs FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'mid' group by school) as new_derived_table)");
    $row17 = $mysqli->query("SELECT avg(total), school FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'final' group by school having avg(total) = (SELECT min(avgs) FROM (SELECT avg(total) avgs FROM averages a inner join sections s on (a.crn=s.crn) where a.type = 'final' group by school) as new_derived_table)");

    //best (individual criteria)
    function mid_best($question, $mysqli) {
        $row18 = $mysqli->query("SELECT a.crn,$question,c.faculty_email,u.name,s.course_code FROM averages a inner join course_assignments c on (a.crn = c.crn) inner join users u on (c.faculty_email = u.email) inner join sections s on (s.crn = a.crn) where $question in (select max($question) from averages where type='mid')");
        for ($i=0; $i < $row18->num_rows; $i++) {
            $criteria = $row18->fetch_array();
            echo "$criteria[3]<br>";
        }
    }
    function final_best($question, $mysqli) {
        $row18 = $mysqli->query("SELECT a.crn,$question,c.faculty_email,u.name,s.course_code FROM averages a inner join course_assignments c on (a.crn = c.crn) inner join users u on (c.faculty_email = u.email) inner join sections s on (s.crn = a.crn) where $question in (select max($question) from averages where type='final')");
        for ($i=0; $i < $row18->num_rows; $i++) {
            $criteria = $row18->fetch_array();
            echo "$criteria[3]<br>";
        }
    }
    //worst (individual criteria)
    function mid_worst($question, $mysqli) {
        $row18 = $mysqli->query("SELECT a.crn,$question,c.faculty_email,u.name,s.course_code FROM averages a inner join course_assignments c on (a.crn = c.crn) inner join users u on (c.faculty_email = u.email) inner join sections s on (s.crn = a.crn) where $question in (select min($question) from averages where type='mid')");
        for ($i=0; $i < $row18->num_rows; $i++) {
            $criteria = $row18->fetch_array();
            echo "$criteria[3]<br>";
        }
    }
    function final_worst($question, $mysqli) {
        $row18 = $mysqli->query("SELECT a.crn,$question,c.faculty_email,u.name,s.course_code FROM averages a inner join course_assignments c on (a.crn = c.crn) inner join users u on (c.faculty_email = u.email) inner join sections s on (s.crn = a.crn) where $question in (select min($question) from averages where type='final')");
        for ($i=0; $i < $row18->num_rows; $i++) {
            $criteria = $row18->fetch_array();
            echo "$criteria[3]<br>";
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Admin | Statistics</title>
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
<body onload="show_group()">
<div class="header_bg1">
<div class="container">
    <div class="row header">
        <div class="logo navbar-left">
            <h1><a href="index.html">Faculty Course Evaluation</a></h1>
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
                    <li class='active'><a href="./admin.php"><img src="../images/back.png" alt="Back to Home" style="width:18px;height:18px"></a></li>
                    <?php
                    list_roles('');
                    $semester = getCurrentSemester();
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
    <a href="./admin_add_section.php"><button class=' black-btn'>Add Section</button></a>
    <a href="./admin_manage_user.php"><button class='black-btn'>Manage User</button></a>
    <a href="./statistics.php"><button class='link-active black-btn'>Statistics</button></a>
    <a href="./manage_evaluations.php"><button class='black-btn'>Evaluations</button></a>
	<br><br>
    <a><button class='black-btn' id="group_btn"  onclick="show_group()">GROUP</button></a>
    <button class=' black-btn'id="mid_criteria_btn" onclick="show_mid_criteria()">CRITERIA (MIDTERM)</button>
    <button class='black-btn' id="final_criteria_btn" onclick="show_final_criteria()">CRITERIA (FINAL)</button>
</div>
<div class="main_bg"><!-- start main -->
    <div class="container">
        <div class="main row para">
            <div class="col-xs-12 text-center thankyouMsg">
            <div id="group">
                <table class="not-center evaltable" width="70%" align="center">
                    <caption><h4 id="fceteam">Statistics</h3></caption>
                    <thead class="text-center">
                        <th>Inquiry</th>
                        <th colspan="3">Result</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>Midterm</td>
                            <td>Final</td>
                        </tr>
                        <tr>
                            <td>% Responses</td>
                            <td><?php echo round(($mid_responses/$total_students)*100, '2')."% (".$mid_responses." out of ".$total_students." students)";?></td>
                            <td><?php echo round(($final_responses/$total_students)*100, '2')."% (".$final_responses." out of ".$total_students." students)";?></td>
                        </tr>
                        <tr>
                            <td>% Evaluated sections</td>
                            <td><?php echo round(($mid_eval/$total_sections)*100, '2')."% (".$mid_eval." out of ".$total_sections." sections)";?></td>
                            <td><?php echo round(($final_eval/$total_sections)*100, '2')."% (".$final_eval." out of ".$total_sections." sections)";?></td>
                        </tr>
                        <tr>
                            <td>Best Section</td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row6->num_rows; $i++) {
                                        $mid_best_section = $row6->fetch_array();
                                        echo "$mid_best_section[3] $mid_best_section[4] ($mid_best_section[2])<br>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row7->num_rows; $i++) {
                                        $final_best_section = $row7->fetch_array();
                                        echo "$final_best_section[3] $final_best_section[4] ($final_best_section[2])<br>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Worst Section</td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row8->num_rows; $i++) {
                                        $mid_worst_section = $row8->fetch_array();
                                        echo "$mid_worst_section[3] $mid_worst_section[4] ($mid_worst_section[2])<br>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row9->num_rows; $i++) {
                                        $final_worst_section = $row9->fetch_array();
                                        echo "$final_worst_section[3] $final_worst_section[4] ($final_worst_section[2])<br>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Best Department</td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row10->num_rows; $i++) {
                                        $mid_best_dept = $row10->fetch_array();
                                        echo "$mid_best_dept[1] ($mid_best_dept[0])<br>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row11->num_rows; $i++) {
                                        $final_best_dept = $row11->fetch_array();
                                        echo "$final_best_dept[1] ($final_best_dept[0])<br>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Worst Department</td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row12->num_rows; $i++) {
                                        $mid_worst_dept = $row12->fetch_array();
                                        echo "$mid_worst_dept[1] ($mid_worst_dept[0])<br>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row13->num_rows; $i++) {
                                        $final_worst_dept = $row13->fetch_array();
                                        echo "$final_worst_dept[1] ($final_worst_dept[0])<br>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Best School</td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row14->num_rows; $i++) {
                                        $mid_best_sch = $row14->fetch_array();
                                        echo "$mid_best_sch[1] ($mid_best_sch[0])<br>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row15->num_rows; $i++) {
                                        $final_best_sch = $row15->fetch_array();
                                        echo "$final_best_sch[1] ($final_best_sch[0])<br>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Worst School</td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row16->num_rows; $i++) {
                                        $mid_worst_sch = $row16->fetch_array();
                                        echo "$mid_worst_sch[1] ($mid_worst_sch[0])<br>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    for ($i=0; $i < $row17->num_rows; $i++) {
                                        $final_worst_sch = $row17->fetch_array();
                                        echo "$final_worst_sch[1] ($final_worst_sch[0])<br>";
                                    }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
<br><br>
<div id="mid_criteria">
                <table class="not-center evaltable" width="100%">
                                <tr>
                                    <th>Criteria</th>
                                    <th>Best</th>
                                    <th>Worst</th>
                                </tr>
                                <tr>
                                    <td class="w65"><strong>Professor's Adherence to time </strong>(Professor arrives in the classroom on time.</td>
                                    <td><?php mid_best('q1', $mysqli);?></td>
                                    <td><?php mid_worst('q1', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65"><strong>Professor's preparedness to Teach </strong>(My professor arrives in the classroom prepared)</td>
                                    <td><?php mid_best('q2', $mysqli);?></td>
                                    <td><?php mid_worst('q2', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65"><strong>Professor's Accessibility in Class </strong>(My professor is accessible in class)</td>
                                    <td><?php mid_best('q3', $mysqli);?></td>
                                    <td><?php mid_worst('q3', $mysqli);?></td>
                                </tr>
                                <tr>
                                    <td class="w65"><strong>Professor's Availability in Class </strong>(My professor is available during office hours)</td>
                                    <td><?php mid_best('q4', $mysqli);?></td>
                                    <td><?php mid_worst('q4', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65"><strong>Asking Questions in Class </strong>(I feel comfortable asking questions during class)</td>
                                    <td><?php mid_best('q5', $mysqli);?></td>
                                    <td><?php mid_worst('q5', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65"><strong>Explanation of Concepts </strong>(My professor explains the material and concepts well) </td>
                                    <td><?php mid_best('q6', $mysqli);?></td>
                                    <td><?php mid_worst('q6', $mysqli);?></td>
                                </tr>
                                <tr>
                                    <td class="w65"><strong>Professor's Teaching Consistency </strong>(My professor is consistent in his teaching )</td>
                                    <td><?php mid_best('q7', $mysqli);?></td>
                                    <td><?php mid_worst('q7', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65"><strong>Use of e-Book </strong>(My professor uses e-books)</td>
                                    <td><?php mid_best('q8', $mysqli);?></td>
                                    <td><?php mid_worst('q8', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65"><strong>Use of Digital Instructional Technologies </strong>(My professor uses other digital instructional technology such as Electronic Journal Articles, Youtube, TED Talks, computer programs, videos, online resources, or social media)</td>
                                    <td><?php mid_best('q9', $mysqli);?></td>
                                    <td><?php mid_worst('q9', $mysqli);?></td>
                                </tr>    
                                <tr>
                                    <td class="w65"><strong>Learning compliance with the Syllabus </strong>(I am learning what is in the course description/syllabus)</td>
                                    <td><?php mid_best('q10', $mysqli);?></td>
                                    <td><?php mid_worst('q10', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65"><strong>Use of Digital Skills </strong>(I am using digital and other on-line skills in this course)</td>
                                    <td><?php mid_best('q11', $mysqli);?></td>
                                    <td><?php mid_worst('q11', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65"><strong>Relevance of Assignments </strong>(My professor's assignments are relevant to the course)</td>
                                    <td><?php mid_best('q12', $mysqli);?></td>
                                    <td><?php mid_worst('q12', $mysqli);?></td>
                                </tr>
                                <tr>
                                    <td class="w65"><strong>Grading Policies </strong>My professors grading policies are fair and consistent with the syllabus</td>
                                    <td><?php mid_best('q13', $mysqli);?></td>
                                    <td><?php mid_worst('q13', $mysqli);?></td>
                                </tr>
                                <tr>
                                    <td class="w65"><strong>Relevance of Course content to future career prospects </strong>My professor relates course content and skills to my future career</td>
                                    <td><?php mid_best('q14', $mysqli);?></td>
                                    <td><?php mid_worst('q14', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65"><strong>American Style Education </strong>My professor teaches in accordance with the interactive American style of education that is the way AUN claims to be different</td>
                                    <td><?php mid_best('q15', $mysqli);?></td>
                                    <td><?php mid_worst('q15', $mysqli);?></td>
                                </tr> 
                            </table>
                        </div>
            <div id="final_criteria">
                <table class="not-center evaltable" width="100%">
                                <tr>
                                    <th>Criteria</th>
                                    <th>Midterm</th>
                                    <th>Final</th>
                                </tr>
                                <tr>
                                    <td class="w65"><strong>Organization</strong> (Course was well organized, material was presented in a logical sequence, instructional time was used effectively and important points emphasized.</td>
                                    <td><?php final_best('q1', $mysqli);?></td>
                                    <td><?php final_worst('q1', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65"><strong>Learning Outcomes and Objectives</strong> (Goals and educational objectives were clear, faculty expectations of students were clear, grading policy was clearly explained)</td>
                                    <td><?php final_best('q2', $mysqli);?></td>
                                    <td><?php final_worst('q2', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65"><strong>Content </strong>(Course content facilitated student ability to achieve course goals and objectives, and when applicable, was relevant to career preparation)</td>
                                    <td><?php final_best('q3', $mysqli);?></td>
                                    <td><?php final_worst('q2', $mysqli);?></td>
                                </tr>
                                <tr>
                                    <td class="w65"><strong>Assessment </strong>(Material on exams was related to material covered either in class or in course assignments, students were treated equitably)</td>
                                    <td><?php final_best('q4', $mysqli);?></td>
                                    <td><?php final_worst('q4', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65"><strong>Assessment </strong>(Material on exams was related to material covered either in class or in course assignments, students were treated equitably)</td>
                                    <td><?php final_best('q5', $mysqli);?></td>
                                    <td><?php final_worst('q5', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65"><strong>Organization </strong>(Instructor presented material in an organized fashion; emphasized important points) </td>
                                    <td><?php final_best('q6', $mysqli);?></td>
                                    <td><?php final_worst('q6', $mysqli);?></td>
                                </tr>
                                <tr>
                                    <td class="w65"><strong>Clarity </strong>(Instructor communicated effectively, explained well, presented content clearly, and gave comprehensible response to  questions)</td>
                                    <td><?php final_best('q7', $mysqli);?></td>
                                    <td><?php final_worst('q7', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65"><strong>Enthusiasm </strong>(Instructor was dynamic and energetic, stimulated learner interest, and enjoyed teaching)</td>
                                    <td><?php final_best('q8', $mysqli);?></td>
                                    <td><?php final_worst('q8', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65"><strong>Up to Date </strong>(Instructor discussed recent development in the field, directed students to current reference materials, and provided additional materials to cover current topics)</td>
                                    <td><?php final_best('q9', $mysqli);?></td>
                                    <td><?php final_worst('q9', $mysqli);?></td>
                                </tr>    
                                <tr>
                                    <td class="w65"><strong>Contribution </strong>(Instructor discussed recent development in the field, directed students to current reference materials, and provided additional materials to cover current topics)</td>
                                    <td><?php final_best('q10', $mysqli);?></td>
                                    <td><?php final_worst('q10', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65"><strong>Professionalism </strong>(Instructor demonstrated role model qualities that were of use to students)</td>
                                    <td><?php final_best('q11', $mysqli);?></td>
                                    <td><?php final_worst('q11', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65"><strong>Attitude </strong>(Instructor was concerned about students learning the material, encourages class participation, was receptive to different perspectives)</td>
                                    <td><?php final_best('q12', $mysqli);?></td>
                                    <td><?php final_worst('q12', $mysqli);?></td>
                                </tr>
                                <tr>
                                    <td class="w65">I attended and participated in class sessions</td>
                                    <td><?php final_best('q13', $mysqli);?></td>
                                    <td><?php final_worst('q13', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65">I completed assignments on time</td>
                                    <td><?php final_best('q14', $mysqli);?></td>
                                    <td><?php final_worst('q14', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65">I learned the required information for the course</td>
                                    <td><?php final_best('q15', $mysqli);?></td>
                                    <td><?php final_worst('q15', $mysqli);?></td>
                                </tr>
                                <tr>
                                    <td class="w65">I used my laptop and technology successfully in this course.</td>
                                    <td><?php final_best('q16', $mysqli);?></td>
                                    <td><?php final_worst('q16', $mysqli);?></td>
                                </tr>
                                <tr>    
                                    <td class="w65">I used the library as part of this class</td>
                                    <td><?php final_best('q16', $mysqli);?></td>
                                    <td><?php final_worst('q16', $mysqli);?></td>
                                </tr> 
                                <tr> 
                                    <td class="w65">I used at least one learning support program (writing center, math, lab, tutor, etc)</td>
                                    <td><?php final_best('q16', $mysqli);?></td>
                                    <td><?php final_worst('q16', $mysqli);?></td>
                                </tr> 
                            </table>
                        </div>
            </div>
        </div>
    </div>
</div><!-- end main -->
<script>
    function show_group() {
        document.getElementById('group').style.display="";
        document.getElementById('mid_criteria').style.display="none";
        document.getElementById('final_criteria').style.display="none";

        document.getElementById("group_btn").setAttribute("class", "link-active black-btn");
        document.getElementById("mid_criteria_btn").setAttribute("class", "black-btn");
        document.getElementById("final_criteria_btn").setAttribute("class", "black-btn");
    }
    function show_mid_criteria() {
        document.getElementById('group').style.display="none";
        document.getElementById('mid_criteria').style.display="";
        document.getElementById('final_criteria').style.display="none";

        document.getElementById("mid_criteria_btn").setAttribute("class", "link-active black-btn");
        document.getElementById("group_btn").setAttribute("class", "black-btn");
        document.getElementById("final_criteria_btn").setAttribute("class", "black-btn");
    }
    function show_final_criteria() {
        document.getElementById('group').style.display="none";
        document.getElementById('mid_criteria').style.display="none";
        document.getElementById('final_criteria').style.display="";

        document.getElementById("mid_criteria_btn").setAttribute("class", "black-btn");
        document.getElementById("group_btn").setAttribute("class", "black-btn");
        document.getElementById("final_criteria_btn").setAttribute("class", "link-active black-btn");
    }
</script>
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