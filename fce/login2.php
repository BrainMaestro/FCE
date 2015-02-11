<?php
	include_once 'db_connect.php';
	
	session_start():
	if (isset($_POST['key'])){
		//$key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_key)
		$key = $_POST['key'];
		$result = mysql_query("SELECT * FROM AcessKeys WHERE key = '$key'");
		
		if (!$result) die("Database access failed: " . mysql_error());
		$rows = mysql_num_rows($result);
		
		if ($key == $row[0]) {
			$result2 = mysql_query("SELECT evaluation_type FROM AcessKeys, Section, Evaluation
			WHERE jey_crn = $row[0] AND key_crn = Section.crn 
			AND Section.crn = Evaluation.crn");
			
			if (!$result2) die("Database access failed: " . mysql_error());
			$rows2 = mysql_num_rows($result2);
			
			if ($rows2[0] == "mid") {
				header("Location: mid_evaluation.php");
			}
			elseif ($rows2[0] == "final") {
				header("Location: fin_evaluation.php");
			}
			else {
				header("Location: ../index.html?err=Evaluationn Not Found");
        		exit();
			}
		}
		else {
			header('Location: ../index.html?err=Key is incorrect');
		}
	}
?>