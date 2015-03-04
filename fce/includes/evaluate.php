<?php
	include_once './db_connect.php';
	include_once './functions.php';
	
	goBack($mysqli);
	if (isset($_POST['key_value'])){ //Checking to see if any key has been submitted
		$key_value = $_POST['key_value']; //calling functions that handle siffing of input
		$get_key = $mysqli->prepare("SELECT * FROM accessKeys WHERE key_value = ?"); //Mysql query to determine if the key exists
		
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
			$_SESSION['expire'] = $_SESSION['start'] + (300); //ending session thirty minutes later
			$_SESSION['eval_type'] = $key_eval_type;
			
        	setKey($key_value1, "given_out", $mysqli);
			
			header("Location: ../$key_eval_type" . "_evaluation.php"); // Take the class to the correct evaluation form based on the eval type
		}
		else {
			$_SESSION['erre'] = "the key was used or incorrect";
			header('Location: ../index.php'); //Error when the key is not found in the database
		}
	}
?>