<?php
require('../fpdf17/fpdf.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php'; 
if ((!isset($_SESSION['user_type'])) || ($_SESSION['user_type'] == "secretary")){
    session_destroy();
    session_start();
    $_SESSION['err'] = "You do not have access";
    header("Location: ../index.php");
}

$course_no = $_GET['crn'];
$eval_type = "mid";

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    //$this->Image('header.jpg',10,6,275,18);
    // Arial bold 15
    $this->SetFont('Courier','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    // $this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(0);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Courier','',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().' of {nb}',0,0,'R');
}
}
$row = $mysqli->query("SELECT * FROM sections WHERE crn='$course_no'")->fetch_assoc();
$term = "Midterm";
// Instanciation of inherited class
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->Image('../images/header.jpg',10,6,275,18);
$pdf->SetFont('Courier','B',11);
$pdf->Ln(14);
$pdf->Cell(0,10,'Faculty Course Evaluation Report.',0,1,'C');
$pdf->SetFont('Courier','',10);
$pdf->Cell(135,4,'CRN:',0,0,'R');
$pdf->Cell(230,4,$course_no,0,1,'L');
$pdf->Cell(135,4,'Course Code:',0,0,'R');
$pdf->Cell(230,4,$row['course_code'],0,1,'L');
$pdf->Cell(135,4,'Course Title:',0,0,'R');
$pdf->Cell(230,4,$row['course_title'],0,1,'L');
$pdf->Cell(135,4,'Report:',0,0,'R');
$pdf->Cell(230,4,"$term Evaluation Report",0,1,'L');
$pdf->Cell(135,4,'Instructor(s):',0,0,'R');

$teachers = '';
$assignment = $mysqli->query("SELECT * FROM course_assignments WHERE crn='$row[crn]'");
                for($j = 0; $j < $assignment->num_rows; $j++) {
                    $row2 = $assignment->fetch_assoc();
                    $faculty = $mysqli->query("SELECT name FROM users WHERE email='$row2[faculty_email]'")->fetch_assoc();
                    $teachers.=$faculty['name'].", "; 
                }
$teachers = rtrim($teachers, ', ');
$pdf->Cell(230,4,$teachers,0,1,'L');
$count_crn = $course_no;    
$count_eval_type = $eval_type;
$count_response = $mysqli->query("SELECT count(crn) AS filled FROM evaluations WHERE crn='$count_crn' AND eval_type='$count_eval_type'")->fetch_assoc();
$count_registered = $mysqli->query("SELECT enrolled FROM sections WHERE crn='$count_crn'")->fetch_assoc();
$pdf->Cell(135,4,'Total Enrolled:',0,0,'R');
$pdf->Cell(230,4,$count_registered['enrolled'],0,1,'L');
$pdf->Cell(135,4,'Total Evaluation(s):',0,0,'R');
$pdf->Cell(230,4,$count_response['filled'],0,1,'L');
$pdf->Cell(135,4,'Scale:',0,0,'R');
$pdf->Cell(230,4,'5 (excellent), 4 (very good), 3 (good), 2 (margin), 1 (poor)',0,1,'L');
$pdf->Ln(14);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(8,4,'',0);
$pdf->Cell(200,4,"Criteria",0);
$pdf->Cell(8,4,'1',0);
$pdf->Cell(8,4,'2',0);
$pdf->Cell(8,4,'3',0);
$pdf->Cell(8,4,'4',0);
$pdf->Cell(8,4,'5',0);
$pdf->Cell(20,4,'Average',0);
$pdf->Ln(6);
$pdf->SetFont('Courier','',10);

$pdf->Cell(8,4,'1',0);
$pdf->Cell(200,4,"Professor's Adherence to time (Professor arrives in the classroom on time).",0);
$pdf->Cell(8,4,count_scale(1,'q1', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q1', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q1', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q1', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q1', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q1', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'2',0);
$pdf->Cell(200,4,"Professor's preparedness to Teach (My professor arrives in the classroom prepared).",0);
$pdf->Cell(8,4,count_scale(1,'q2', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q2', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q2', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q2', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q2', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q2', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'3',0);
$pdf->Cell(200,4,"Professor's Accessibility in Class (My professor is accessible in class).",0);
$pdf->Cell(8,4,count_scale(1,'q3', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q3', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q3', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q3', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q3', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q3', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'4',0);
$pdf->Cell(200,4,"Professor's Availability in Class (My professor is available during office hours).",0);
$pdf->Cell(8,4,count_scale(1,'q4', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q4', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q4', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q4', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q4', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q4', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'5',0);
$pdf->Cell(200,4,"Asking Questions in Class (I feel comfortable asking questions during class).",0);
$pdf->Cell(8,4,count_scale(1,'q5', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q5', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q5', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q5', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q5', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q5', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'6',0);
$pdf->Cell(200,4,"Explanation of Concepts (My professor explains the material and concepts well).",0);
$pdf->Cell(8,4,count_scale(1,'q6', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q6', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q6', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q6', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q6', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q6', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'7',0);
$pdf->Cell(200,4,"Professor's Teaching Consistency (My professor is consistent in his teaching).",0);
$pdf->Cell(8,4,count_scale(1,'q7', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q7', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q7', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q7', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q7', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q7', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'8',0);
$pdf->Cell(200,4,"Use of e-Book (My professor uses e-books).",0);
$pdf->Cell(8,4,count_scale(1,'q8', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q8', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q8', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q8', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q8', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q8', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'9',0);
$pdf->Cell(200,4,"Use of Digital Instructional Technologies.",0);
$pdf->Cell(8,4,count_scale(1,'q9', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q9', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q9', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q9', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q9', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q9', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'10',0);
$pdf->Cell(200,4,"Learning compliance with the Syllabus.",0);
$pdf->Cell(8,4,count_scale(1,'q10', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q10', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q10', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q10', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q10', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q10', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'11',0);
$pdf->Cell(200,4,"Use of Digital Skills (I am using digital and other on-line skills in this course).",0);
$pdf->Cell(8,4,count_scale(1,'q11', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q11', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q11', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q11', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q11', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q11', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'12',0);
$pdf->Cell(200,4,"Relevance of Assignments (My professor's assignments are relevant to the course).",0);
$pdf->Cell(8,4,count_scale(1,'q12', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q12', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q12', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q12', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q12', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q12', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'13',0);
$pdf->Cell(200,4,"Grading Policies My professors grading policies are fair and consistent with the syllabus.",0);
$pdf->Cell(8,4,count_scale(1,'q13', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q13', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q13', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q13', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q13', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q13', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();

$pdf->Cell(8,4,'14',0);
$pdf->Cell(200,4,"Relevance of Course content to future career prospects.",0);
$pdf->Cell(8,4,count_scale(1,'q14', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q14', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q14', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q14', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q14', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q14', $course_no, $eval_type, $mysqli),0);
$pdf->Ln();


$pdf->Cell(8,4,'15',0);
$pdf->Cell(200,4,"American Style Education.",0);
$pdf->Cell(8,4,count_scale(1,'q15', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(2,'q15', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(3,'q15', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(4,'q15', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(8,4,count_scale(5,'q15', $course_no, $eval_type, $mysqli),0);
$pdf->Cell(20,4,avg_question('q15', $course_no, $eval_type, $mysqli),0);
$pdf->Ln(6);

$pdf->Cell(8,4,'',0);
$pdf->SetFont('Courier','B',10);
$pdf->Cell(200,4,"Total Average",0);
$pdf->Cell(8,4,avg_midterm($course_no, $eval_type, $mysqli),0);
$pdf->SetFont('Courier','',10);
$pdf->Cell(8,4,'',0);
$pdf->Cell(8,4,'',0);
$pdf->Cell(8,4,'',0);
$pdf->Cell(8,4,'',0);
$pdf->Cell(20,4,'',0);
$pdf->Ln();

$pdf->Output();