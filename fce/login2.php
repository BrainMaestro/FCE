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
		//if ($get_key = $mysqli->prepare("SELECT key_value, key_eval_type, key_crn, given_out FROM AcessKeys WHERE key_value = ?")) {//Mysql query to determine if the key exists
		$get_key = $mysqli->prepare("SELECT * FROM AccessKeys WHERE key_value = ?"); //Mysql query to determine if the key exists
		//$get_key = $mysqli->prepare("SELECT key_value, key_eval_type, key_crn, given_out FROM AccessKeys WHERE key_value = ?"); //Mysql query to determine if the key exists
		
		$get_key->bind_param('s', $key_value);
		$get_key->execute();
		$get_key->store_result();
		$get_key->bind_result($key_value1, $given_out, $used, $key_eval_type, $key_crn);
		//$get_key->bind_result($key_value1, $given_out, $used, $key_eval_type, $key_crn);
		
		$get_key->fetch();
		
		if (!$get_key) die("Database access failed: " . mysql_error()); //Message given when there is an error
		//$rows_get_key = mysql_num_rows($get_key); //Getting the number of rows returned from query
		//$get_key_values = mysql_fetch_row($get_key); //getting and storing the values of row returned in an array
		
		if ($get_key->num_rows == 1 and $given_out == 0) { //if key is found, only one row should be gotten and the key has not been given out
			$_SESSION['crn'] = $key_crn; //The class for which evaluation is to be done is stored for later use when storing evaluation
			$_SESSION['key_value'] = $key_value1; //the key used is stored as a session
			$_SESSION['start'] = time(); //taking in logged in time
			$_SESSION['expire'] = $_SESSION['start'] + (90 * 60); //ending session an hour and thirty minutes later
			
			$mysqli->query("UPDATE AccessKeys SET given_out = '1' WHERE key_value = '$key_value1'");
			
			if ($key_eval_type == "mid") { //check to determine evaluation type like midterm evaluation
				header("Location: mid_evaluation.php"); //page that is returned based on check
			}
			elseif ($key_eval_type == "final") { //check to determine evaluation type like final evaluation
				header("Location: final_evaluation.php"); //page that is returned based on check
			}
			else {
				header("Location: index2.html?err=Evaluation Not Found"); //Error given when tan unknown evaluation type is gotten
			}
		}
		else {
			header('Location: index2.html?err=Key is used or incorrect'); //Error when the key is not found in the database
		}
	}
?>