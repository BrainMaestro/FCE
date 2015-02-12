<?php
	include_once 'db_connect.php';
	
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
	
	session_start():
	if (isset($_POST['key'])){ //Checking to see if any key has been submitted
		$key = fix_string($_POST['key']); //calling functions that handle siffing of input
		$get_key = mysql_query("SELECT key, key_eval_type, key_crn FROM AcessKeys 
								WHERE key = '$key'"); //Mysql query to determine if the key exists
		
		if (!$get_key) die("Database access failed: " . mysql_error()); //Message given when there is an error
		$rows_get_key = mysql_num_rows($get_key); //Getting the number of rows returned from query
		
		if ($rows_get_key == 1) { //if key is found, only one row should be gotten
			$get_key_values = mysql_fetch_row($get_key); //getting and storing the values of row returned in an array
			$_SESSION['crn'] = $get_key_values[2]; //The class for which evaluation is to be done is stored for later use when storing evaluation
			
			if ($get_key_values[1] == "mid") { //check to determine evaluation type like midterm evaluation
				header("Location: mid_evaluation.php"); //page that is returned based on check
			}
			elseif ($get_key_values[1] == "final") { //check to determine evaluation type like final evaluation
				header("Location: fin_evaluation.php"); //page that is returned based on check
			}
			else {
				header("Location: ../index.html?err=Evaluation Not Found"); //Error given when tan unknown evaluation type is gotten
			}
		}
		else {
			header('Location: ../index.html?err=Key is incorrect'); //Error when the key is not found in the database
		}
	}
?>