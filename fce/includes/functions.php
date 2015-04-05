<?php

// Method that generates keys for use
function generateKeys() {

    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; // Acceptable character string

    for ($i = 0; $i < 10; $i++)
        $characters .= $characters; // Increases the length of the string for more possibilities

    return substr(str_shuffle($characters), 0, 5); // Shuffles the string and returns a substring of 5 characters
}

// Method that inserts keys for use
function insertKeys($crn, $eval_type, $mysqli) {

    $keyArray = []; // Array to keep track of generated keys
    $result = $mysqli->query("SELECT enrolled FROM sections WHERE crn = '$crn'");
    $row = $result->fetch_assoc();
    $enrolled = $row['enrolled']; // Number of students in section and therefore, number of keys to be generated

    for($i = 0; $i < $enrolled; $i++) {
        $key = null; // Key variable
        
        do {
            $key = generateKeys();
        } while (in_array($key, $keyArray)); // Loop continues if key is found in array so that keys are always distinct

        $keyArray[] = $key; // Adds the key to the array

        do {
            $mysqli->query("INSERT into accesskeys VALUES ('$key', '0', '0', '$eval_type', '$crn')");
        } while ($mysqli->connect_errno); // Loop continues if there was a failure in inserting a key
    }
}

// Method that deletes keys after use
function deleteKeys($crn, $eval_type, $mysqli) {

    $mysqli->query("DELETE FROM accesskeys WHERE key_crn='$crn' AND key_eval_type='$eval_type'");
}

// Method that gets the current semester from the server time
function getCurrentSemester() {

    $semester = ''; // Semester variable
    date_default_timezone_set('Africa/Lagos'); // Sets the time zone to the accepted Nigerian timezone
    $month = date('n'); // Gets the current month as a number without leading zeros EX: 1
    $year = date('Y'); // Gets the current year

    // Appends the appropriate semester type based on the month
    if (($month >= 1) && ($month <= 5)) // Between January and May
        $semester .= "Spring ";
    elseif (($month >= 8) && ($month <= 12)) // Between August and December
        $semester .= "Fall ";
    else
        $semester .= "Summer ";

    $semester .= $year; // Appends the year. Ex: Spring 2015

    return $semester;
}

function setKey($key_value, $status, $mysqli) {
    $mysqli->query("UPDATE accesskeys SET $status = '1' WHERE key_value = '$key_value'");
}

//Method that checks if time to use a key has expired
function checkSessionKeys() {
	$now = time(); //checking time when page is opened
	 
	if ($now > $_SESSION['expire']){
		session_destroy();
        session_start();
		$_SESSION['erre'] = "Your session has expired";
		header("Location: index.php");
	}
}

function unlockSection($crn, $mysqli) {
    $result = $mysqli->query("SELECT * FROM sections WHERE crn='$crn'");
    $row = $result->fetch_assoc();

    // Checks if the type of evaluation for which the section is to be unlocked has already occurred
    $eval_type = 'mid';

    if ($row['mid_evaluation'] == '1' && $row['final_evaluation'] == '1') { 
        $_SESSION['err'] = "Class cannot be unlocked again";
        return;
    }
    elseif ($row['mid_evaluation'] == '1')
        $eval_type = 'final';

    $mysqli->query("UPDATE sections SET locked='0' WHERE crn='$crn'");
    insertKeys($crn, $eval_type, $mysqli);
    header("Location: ../users/section.php?crn=$crn");
}

function lockSection($crn, $mysqli) {
    $sql = "UPDATE sections SET locked='1', ";

    $row = $mysqli->query("SELECT mid_evaluation, final_evaluation FROM sections WHERE crn='$crn'")->fetch_assoc();
    $eval_type = "";

    // Sets the type of evaluation that was completed as done
    if ($row['mid_evaluation'] == '0') {
        $sql .= "mid_evaluation = '1'";
        $eval_type = "mid";
    }
    else {
        $sql .= "final_evaluation = '1'";
        $eval_type = "final";
    }

    $sql .= " WHERE crn='$crn'";
    $mysqli->query($sql);
    deleteKeys($crn, $eval_type, $mysqli);

    //
    $avg_q = array();
    for ($i=0; $i < 18; $i++) {
        $j = $i+1;
        $question = "q$j"; 
        $avg_q[$i] = avg_question($question, $crn, $eval_type, $mysqli);
    }
    $course = avg_course($crn, $eval_type, $mysqli);
    $instructor = avg_instructor($crn, $eval_type, $mysqli);
    $student = avg_student($crn, $eval_type, $mysqli);
    $total_mid = avg_midterm($crn, $eval_type, $mysqli);
    $total_final = avg_final($crn, $eval_type, $mysqli);
    
    $sql2 =  "INSERT INTO averages VALUES ('$crn', '$eval_type', '$avg_q[0]', '$avg_q[1]', '$avg_q[2]', '$avg_q[3]', '$avg_q[4]', '$avg_q[5]', '$avg_q[6]', '$avg_q[7]'
                    , '$avg_q[8]', '$avg_q[9]', '$avg_q[10]', '$avg_q[11]', '$avg_q[12]', '$avg_q[13]', '$avg_q[14]', '$avg_q[15]', '$avg_q[16]', '$avg_q[17]'";

    if ($eval_type == 'mid') {
        $sql2 .= ",'','','','$total_mid')";
        if (!$mysqli->query($sql2)) {
            die('Error:'.$mysqli->error);
        }
    } else {
        $sql2 .= ",'$course','$instructor','$student','$total_final')";
        if (!$mysqli->query($sql2)) {
            die('Error:'.$mysqli->error);
        }
    }
}

function count_scale($scale, $question, $crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT count($question) FROM evaluations WHERE $question='$scale' 
     AND crn='$crn' AND eval_type = '$eval_type'"); 

    while ($row = $result->fetch_array())
       // echo $row[0];
        return $row[0];
}

function avg_question($question, $crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round(avg($question), 2) from evaluations where crn = '$crn'
     and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
       // echo $row[0];
        return $row[0];
}

function avg_course($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round((avg(q1)+avg(q2)+avg(q3)+avg(q4)+avg(q5))/5, 2) from evaluations where 
                                        crn = '$crn' and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
       // echo $row[0];
        return $row[0];
}

function avg_instructor($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round((avg(q6)+avg(q7)+avg(q8)+avg(q9)+avg(q10)+avg(q11)+avg(q12))/7, 2) from 
                                        evaluations where crn = '$crn'  and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
      //  echo $row[0];
        return $row[0];
}

function avg_student($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round((avg(q13)+avg(q14)+avg(q15)+avg(q16)+avg(q17)+avg(q18))/6, 2) from evaluations 
                                        where crn = '$crn'  and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
       // echo $row[0];
        return $row[0];
}

function avg_midterm($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round((avg(q1)+avg(q2)+avg(q3)+avg(q4)+avg(q5)+avg(q6) +avg(q7)+avg(q8)+avg(q9)+avg(q10)+avg(q11)+avg(q12)+avg(q13)+avg(q14)+avg(q15))/15, 2)
                                from evaluations where crn = '$crn' and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
      //  echo $row[0];
        return $row[0];
}
function avg_final($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round((avg(q1)+avg(q2)+avg(q3)+avg(q4)+avg(q5)+avg(q6) +avg(q7)+avg(q8)+avg(q9)+avg(q10)+avg(q11)+avg(q12)+avg(q13)+avg(q14)+avg(q15)+avg(q16)+avg(q17)+avg(q18))/18, 2)
                                from evaluations where crn = '$crn' and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
       // echo $row[0];
        return $row[0];
}

//Method to check if user has acess to page
function checkUser($page){
	if(!loggedIn() || !in_array($page, $_SESSION['roles'])) {
        session_destroy();
        session_start();
		$_SESSION['errl'] = "You do not have access";
        header("Location: ../index.php");
    }
}

function list_roles($role) {
    for($i = 0; $i < count($_SESSION['roles']); $i++) {
        $a = $_SESSION['roles'][$i];
        if ($a == $role)
            echo "<li class='active'><a href=$a.php>$a</a></li>";
        else
            echo "<li><a href=$a.php>$a</a></li>";

    }
    $semester = getCurrentSemester();
    echo "<li><span>Semester: $semester</span></li>";
    echo "<li><span>School: $_SESSION[school]</span></li>";
    echo "<li><span>Name: $_SESSION[name]</span></li>";
}

//Method to check if a class has been locked for restriction
function checkSectionStatus($sec_crn, $mysqli) {
	$status = $mysqli->query("SELECT locked FROM sections WHERE crn='$sec_crn'")->fetch_assoc();
    if ($status['locked'] == 1) {
		return true;
	}
	else {
		return false;
	}
}

// Method to check if a user is already logged in. Sends the user back if the
// Also checks if an evaluation has already been started.
function goBack($mysqli) {

    if (loggedIn()) {
        $user_type = $_SESSION['user_type'];
        header("Location: ./users/$user_type.php"); // Take the user to the correct page form based on the user type
    }

    elseif (isset($_SESSION['key_value'])) {
        $key_value = $_SESSION['key_value'];
        $eval_type = $_SESSION['eval_type'];
        header("Location: ../$eval_type" . "_evaluation.php"); // Take the class to the correct evaluation form based on the eval type
    }
}

// Method to check if a user is logged into the system
function loggedIn() {
    return isset($_SESSION['email']);
}

function checkEvaluations($crn, $eval_type, $mysqli) {
    $count_response = $mysqli->query("SELECT count(crn) AS filled FROM evaluations WHERE crn='$crn' AND eval_type='$eval_type'")->fetch_assoc();
    
    if ($count_response['filled'] == 0) {
        $_SESSION['err'] = "This report is empty";
        header("Location: ../index.php");
    }
}

function protectReports($crn, $user, $mysqli) {
    $section = $mysqli->query("SELECT * FROM sections WHERE crn='$crn'")->fetch_assoc();
    $result = $mysqli->query("SELECT faculty_email FROM course_assignments WHERE crn='$crn'");
    $instructors = [];
    for($i = 0; $i < $result->num_rows; $i++) {
        $instructors[] = $result->fetch_array()[0];
    }

    switch ($user) {
        case 'faculty':
            if (!in_array($_SESSION['email'], $instructors)) {
                $_SESSION['err'] = "You do not have access to view another faculty member's report";
                header("Location: ../index.php");
            }
            break;

        case 'dean':
            if ($_SESSION['school'] != $section['school']) {
                $_SESSION['err'] = "You do not have access to view a report from another school";
                header("Location: ../index.php");
            }
            break;

        case 'secretary':
            $_SESSION['err'] = "As a secretary, you do not have access to view reports";
            header("Location: ../index.php");
            break;
        
        default:
            break;
    }
}

function findSectionError($crn, $mysqli) {
    $result = $mysqli->query("SELECT * FROM sections_interface WHERE crn='$crn'")->fetch_assoc();
    $err = "None";
    $err_col = "";

    if (strlen($result['crn']) != 7) {
        $err = "CRN is too long or too short";
        $err_col = "crn";
    }
    elseif (strlen($result['course_code']) < 7) {
        $err = "Course code is too short";
        $err_col = "course_code";
    }
    elseif ($result['semester'] != getCurrentSemester()) {
        $err = "Not current semester (". getCurrentSemester() .")";
        $err_col = "semester";
    }
    elseif ($mysqli->query("SELECT * FROM schools WHERE school = '$result[school]'")->num_rows == 0) {
        $err = "School does not exist";
        $err_col = "school";
    }
    elseif (strlen($result['course_title']) < 1) {
        $err = "Course title is too short";
        $err_col = "course_title";
    }
    elseif (strlen($result['class_time']) < 1) {
        $err = "No class time set";
        $err_col = "class_time";
    }
    elseif (strlen($result['location']) < 1) {
        $err = "No location set";
        $err_col = "location";
    }
    elseif (strlen($result['enrolled']) < 1 || $result['enrolled'] == 0) {
        $err = "Incorrect number of enrolled students";
        $err_col = "enrolled";
    }
    elseif (strlen($result['faculty']) < 1 || $result['faculty'] == "(0 records)") {
        $err = "No instructor set";
        $err_col = "faculty";
    }
    else {
        $faculty = explode(", ", $result['faculty']);
        for ($i = 0; $i < count($faculty); $i++) {
            if ($mysqli->query("SELECT * FROM users WHERE name = '$faculty[$i]'")->num_rows == 0) {
                $err = "Instructor \'$faculty[$i]\' is not in the system";
                $err_col = "faculty";
                break;
            }

        }
    }
    $mysqli->query("UPDATE sections_interface SET error_message='$err', error_column='$err_col' WHERE crn='$crn'");

}

function addSection($row, $mysqli) {
    if ($stmt = $mysqli->prepare("INSERT INTO sections VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
        $locked = '1';
        $mid_evaluation = '0';
        $final_evaluation = '0';
        $stmt->bind_param('issssssiiii', $row['crn'],$row['course_code'],$row['semester'],$row['school'],
            $row['course_title'],$row['class_time'],$row['location'], $locked, $row['enrolled'], $mid_evaluation, $final_evaluation); 
        $stmt->execute(); 
        $faculty = explode(", ", $row['faculty']);
        for ($i = 0; $i < count($faculty); $i++) {
            $result = $mysqli->query("SELECT email FROM users WHERE name = '$faculty[$i]'")->fetch_assoc();
            $mysqli->query("INSERT INTO course_assignments VALUES('$row[crn]', '$result[email]')");
        }
        $mysqli->query("DELETE FROM sections_interface WHERE crn='$row[crn]'");
    }
}

function addSectionInterface($row, $mysqli) {
    if ($stmt = $mysqli->prepare("INSERT INTO sections_interface VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
        $desg = substr($row[0], 0, 3);
        $result = $mysqli->query("SELECT school FROM course_groups WHERE course_designation = '$desg'")->fetch_assoc();
        $none = 'None';
        $empty = '';
        $stmt->bind_param('issssssisss', $row[3], $row[0], $row[2], $result['school'], $row[1], $row[7], $row[8], $row[9], $row[6], $none, $empty);
        $stmt->execute(); 
    }
}

?>

