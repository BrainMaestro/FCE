<?php
	include_once 'db_connect.php';
	
	session_start():
	if (isset($_POST['key'])){
		//$key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_key)
		$key = $_POST['key'];
		$result = mysql_query("SELECT key, key_eval_type FROM AcessKeys 
								WHERE key = '$key'");
		
		if (!$result) die("Database access failed: " . mysql_error());
		$rows = mysql_num_rows($result);
		
		if ($rows == 1) {
			$result2 = mysql_fetch_row($result);
			if ($result2[1] == "mid") {
				header("Location: mid_evaluation.php");
			}
			elseif ($result2[1] == "final") {
				header("Location: fin_evaluation.php");
			}
			else {
				header("Location: ../index.html?err=Evaluation Not Found");
        		exit();
			}
		}
		else {
			header('Location: ../index.html?err=Key is incorrect');
			exit();
		}
	}
?>