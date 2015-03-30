<?php
include_once '../includes/db_connect.php';

if (isset($_POST['submitS'])) {
    define("UPLOAD_DIR", "./");
 
    if (!empty($_FILES["excelFile"])) {
        $excelFile = $_FILES["excelFile"];
     
        if ($excelFile["error"] !== UPLOAD_ERR_OK) {
            echo "<p>An error occurred.</p>";
            exit;
        }
     
        // ensure a safe filename
        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $excelFile["name"]);
     
        // don't overwrite an existing file
        $i = 0;
        $parts = pathinfo($name);
        while (file_exists(UPLOAD_DIR . $name)) {
            $i++;
            $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
        }
     
        // preserve file from temporary directory
        $success = move_uploaded_file($excelFile["tmp_name"],
            UPLOAD_DIR . $name);
        if (!$success) { 
            echo "<p>Unable to save file.</p>";
            exit;
        }
     
        // set proper permissions on the new file
        chmod(UPLOAD_DIR . $name, 0644);
    }

    include_once '../includes/reader/excel_reader2.php';
    include_once '../includes/reader/SpreadsheetReader.php';
    $reader = new SpreadsheetReader(UPLOAD_DIR . $name);
    $sheets = $reader -> Sheets();
    foreach ($sheets as $index => $value) {

        $reader -> ChangeSheet($index);

        foreach ($reader as $row) {
        	if ($row[0] == 'COURSE CODE')
        		continue;

	    	if ($stmt = $mysqli->prepare("INSERT INTO sections_interface VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
	    		$desg = substr($row[0], 0, 3);
	    		$result = $mysqli->query("SELECT school FROM course_groups WHERE course_designation = '$desg'")->fetch_assoc();
	    		$none = 'None';
	    		$empty = '';
	    		$stmt->bind_param('issssssisss', $row[3], $row[0], $row[2], $result['school'], $row[1], $row[7], $row[8], $row[9], $row[6], $none, $empty);
	        	$stmt->execute(); 
	        }
    	}
    }  
    unlink(UPLOAD_DIR . $name); // Deletes file
    header("Location: ./process_sections.php");
    exit();
}
?>