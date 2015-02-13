<?php
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
	
	/*
	//This method filters html input from input may be harmful
	function fix_string($string) {
		return htmlentities(mysql_fix_string($string));
	}
	
	//This method filters php or mysql input that may be harmful
	function mysql_fix_string($string) {
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}
		return mysql_real_escape_string($string);
	}
	*/
	
	session_start();
	if (isset($_POST['key_value'])){ //Checking to see if any key has been submitted
		$key_value = $_POST['key_value']; //calling functions that handle siffing of input
		$get_key = $mysqli->prepare("SELECT * FROM AccessKeys WHERE key_value = ?"); //Mysql query to determine if the key exists
		
		$get_key->bind_param('s', $key_value);
		$get_key->execute();
		$get_key->store_result();
		$get_key->bind_result($key_value1, $given_out, $used, $key_eval_type, $key_crn);
		
		$get_key->fetch();
		
		if (!$get_key) die("Database access failed: " . mysql_error()); //Message given when there is an error
		
		if ($get_key->num_rows == 1 and $given_out == 0) { //if key is found, only one row should be gotten and the key has not been given out
			$_SESSION['crn'] = $key_crn; //The class for which evaluation is to be done is stored for later use when storing evaluation
			$_SESSION['key_value'] = $key_value1; //the key used is stored as a session
			$_SESSION['start'] = time(); //taking in logged in time
			$_SESSION['expire'] = $_SESSION['start'] + (10); //ending session an hour and thirty minutes later
			
			$mysqli->query("UPDATE AccessKeys SET given_out = '1' WHERE key_value = '$key_value1'");
			
			header("Location: $key_eval_type" . "_evaluation.php"); // Take the class to the correct evaluation form based on the eval type
		}
		else {
			header('Location: index2.html?err=Key is used or incorrect'); //Error when the key is not found in the database
		}
	}
?>