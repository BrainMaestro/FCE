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
            $mysqli->query("INSERT into AccessKeys VALUES ('$key', '0', '0', '$eval_type', '$crn')");
        } while ($mysqli->connect_errno); // Loop continues if there was a failure in inserting a key
    }
}

// Method that deletes keys after use
function deleteKeys($crn, $eval_type, $mysqli) {

    $mysqli->query("DELETE FROM AccessKeys WHERE key_crn='$crn' AND key_eval_type='$eval_type'");
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

//Method that checks if time to use a key has expired
function checkSessionKeys() {
	$now = time(); //checking time when page is opened
	 
	if ($now > $_SESSION['expire']){
		session_destroy();
        session_start();
		$_SESSION['err'] = "Your session has expired";
		header("Location: ../index.php");
	}
}

function unlockSection($crn, $eval_type, $mysqli) {
    $result = $mysqli->query("SELECT * FROM section WHERE crn='$crn'");
    $row = $result->fetch_assoc();

    // Checks if the type of evaluation for which the section is to be unlocked has already occurred
    // Will include error messages eventually
    if ($eval_type == 'final') { 
        if ($row['final_evaluation'] == '1')
            return;
    }
    else {
        if ($row['mid_evaluation'] == '1')
            return;
    }

    $mysqli->query("UPDATE section SET locked='0' WHERE crn='$crn'");
    insertKeys($crn, $eval_type, $mysqli);
    header("Location: ../section.php");
}

function lockSection($crn, $eval_type, $mysqli) {
    $sql = "UPDATE section SET locked='1', ";

    // Sets the type of evaluation that was completed as done
    if ($eval_type == 'final')
        $sql .= "final_evaluation = '1'";
    else
        $sql .= "mid_evaluation = '1'";

    $sql .= " WHERE crn='$crn'";
    $mysqli->query($sql);
    deleteKeys($crn, $eval_type, $mysqli);
}
?>

