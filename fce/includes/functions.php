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
    $result = $mysqli->query("SELECT enrolled FROM section WHERE crn = '$crn'");
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
    $result = $mysqli->query("SELECT * FROM section WHERE crn='$crn'");
    $row = $result->fetch_assoc();

    // Checks if the type of evaluation for which the section is to be unlocked has already occurred
    $eval_type = 'mid';

    if ($row['mid_evaluation'] == '1' && $row['final_evaluation'] == '1') { 
        $_SESSION['err'] = "Class cannot be unlocked again";
        return;
    }
    elseif ($row['mid_evaluation'] == '1')
        $eval_type = 'final';

    $mysqli->query("UPDATE section SET locked='0' WHERE crn='$crn'");
    insertKeys($crn, $eval_type, $mysqli);
    header("Location: ../users/section.php?crn=$crn");
}

function lockSection($crn, $mysqli) {
    $sql = "UPDATE section SET locked='1', ";

    $row = $mysqli->query("SELECT mid_evaluation, final_evaluation FROM section WHERE crn='$crn'")->fetch_assoc();
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
}

function count_scale($scale, $question, $crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT count($question) FROM evaluation WHERE $question='$scale' 
     AND crn='$crn' AND eval_type = '$eval_type'");

    while ($row = $result->fetch_array())
        echo $row[0];
}

function avg_question($question, $crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round(avg($question), 2) from evaluation where crn = '$crn'
     and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
        echo $row[0];
}

function avg_course($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round((avg(q1)+avg(q2)+avg(q3)+avg(q4)+avg(q5))/5, 2) from evaluation where 
                                        crn = '$crn' and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
        echo $row[0];
}

function avg_instructor($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round((avg(q6)+avg(q7)+avg(q8)+avg(q9)+avg(q10)+avg(q11)+avg(q12))/7, 2) from 
                                        evaluation where crn = '$crn'  and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
        echo $row[0];
}

function avg_student($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round((avg(q13)+avg(q14)+avg(q15)+avg(q16)+avg(q17)+avg(q18))/6, 2) from evaluation 
                                        where crn = '$crn'  and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
        echo $row[0];
}

function avg_midterm($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT round((avg(q1)+avg(q2)+avg(q3)+avg(q4)+avg(q5)+avg(q6) +avg(q7)+avg(q8)+avg(q9)+avg(q10)+avg(q11)+avg(q12)+avg(q13)+avg(q14)+avg(q15))/15, 2)
                                from evaluation where crn = '$crn' and eval_type = '$eval_type'");
    
    while ($row = $result->fetch_array())
        echo $row[0];
}

//Method to check if user has acess to page
function checkUser($page){
	if(!isset($_SESSION['email'])) {
		$_SESSION['errl'] = "You do not have access";
        header("Location: ../index.php");
    }
	
	// if ($page != $_SESSION['user_type']) {
	// 	session_destroy();
 //        session_start();
	// 	$_SESSION['errl'] = "You do not have access";
	// 	header("Location: ../index.php");
	// }
}
function list_roles() {
    for($i = 0; $i < count($_SESSION['roles']); $i++) {
        $a = $_SESSION['roles'][$i];
        echo "<li><a href=$a.php>$a</a></li>";
    }
}

//Method to check if a class has been locked for restriction
function checkSectionStatus($sec_crn, $mysqli) {
	$status = $mysqli->query("SELECT locked FROM section WHERE crn='$sec_crn'")->fetch_assoc();
	
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

    if (isset($_SESSION['email'])) {
        $user_type = $_SESSION['user_type'];
        header("Location: ./users/$user_type.php"); // Take the user to the correct page form based on the user type
    }

    elseif (isset($_SESSION['key_value'])) {
        $key_value = $_SESSION['key_value'];
        $eval_type = $_SESSION['eval_type'];
        header("Location: ../$eval_type" . "_evaluation.php"); // Take the class to the correct evaluation form based on the eval type
    }
}

?>

