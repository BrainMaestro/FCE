<?php
	
	$course_no = 1; 
	function count_scale($scale, $question, $crn) {
		$con = mysqli_connect("localhost", "root", "", "fce");
    	if (mysqli_connect_errno()) {
        	echo "Failed to connect to MySQL: " . mysqli_connect_errno();
    	}	
		$query = mysqli_query($con, "SELECT count($question) from evaluation where $question='$scale' and crn='$crn'"); 
		while ($row = mysqli_fetch_array($query)) {
			echo $row[0];
		}
    }
	
	function avg_question($question, $crn) {
		$con = mysqli_connect("localhost", "root", "", "fce");
    	if (mysqli_connect_errno()) {
        	echo "Failed to connect to MySQL: " . mysqli_connect_errno();
    	}	
		$query = mysqli_query($con, "SELECT round(avg($question), 2) from evaluation where crn = '$crn'");
		while ($row = mysqli_fetch_array($query)) {
            echo $row[0];
        }
	}
	
	function avg_course($crn) {
		$con = mysqli_connect("localhost", "root", "", "fce");
    	if (mysqli_connect_errno()) {
        	echo "Failed to connect to MySQL: " . mysqli_connect_errno();
    	}
		$query = mysqli_query($con, "SELECT round((avg(q1)+avg(q2)+avg(q3)+avg(q4)+avg(q5))/5, 2) from evaluation where crn = '$crn'");
		while ($row = mysqli_fetch_array($query)) {
            echo $row[0];
        }
	}
	
	function avg_instructor($crn) {
		$con = mysqli_connect("localhost", "root", "", "fce");
    	if (mysqli_connect_errno()) {
        	echo "Failed to connect to MySQL: " . mysqli_connect_errno();
    	}
		$query = mysqli_query($con, "SELECT round((avg(q6)+avg(q7)+avg(q8)+avg(q9)+avg(q10)+avg(q11)+avg(q12))/7, 2) from evaluation where crn = '$crn'");
		while ($row = mysqli_fetch_array($query)) {
            echo $row[0];
        }
	}
	
	function avg_student($crn) {
		$con = mysqli_connect("localhost", "root", "", "fce");
    	if (mysqli_connect_errno()) {
        	echo "Failed to connect to MySQL: " . mysqli_connect_errno();
    	}
		$query = mysqli_query($con, "SELECT round((avg(q13)+avg(q14)+avg(q15)+avg(q16)+avg(q17)+avg(q18))/6, 2) from evaluation where crn = '$crn'");
		while ($row = mysqli_fetch_array($query)) {
            echo $row[0];
        }
	}
?>