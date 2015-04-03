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
        $row18 = $mysqli->query("SELECT crn,$question FROM averages where $question in (select max($question) from averages where type='mid')");
        for ($i=0; $i < $row18->num_rows; $i++) {
            $criteria = $row18->fetch_array();
            echo "$criteria[0]<br>";
        }
    }
    //mid_best('q1', $mysqli);
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
<body>
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
</div>
<div class="main_bg"><!-- start main -->
    <div class="container">
        <div class="main row para">
            <div class="col-xs-12 text-center thankyouMsg">
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
                            <td><?php echo round(($mid_responses/$total_students)*100, '2');?>%</td>
                            <td><?php echo round(($final_responses/$total_students)*100, '2');?>%</td>
                        </tr>
                        <tr>
                            <td>% Evaluated sections</td>
                            <td><?php echo round(($mid_eval/$total_sections)*100, '2');?>%</td>
                            <td><?php echo round(($final_eval/$total_sections)*100, '2');?>%</td>
                        </tr>
                        <tr>
                            <td>% Instructors</td>
                            <td></td>
                            <td></td>
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
<br><br>
                <table class="not-center evaltable" width="100%">
                                <tr>
                                    <td colspan="19">Best(Individual criteria)</td>
                                </tr>
                                <tr>
                                    <td>Midterm</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Final</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="19">Worst(Individual criteria)</td>
                                </tr>
                                <tr>
                                    <td>Midterm</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Worst</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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