<?php
include_once 'db_connect.php';

session_start();
if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    if ($stmt = $mysqli->prepare("SELECT name, user_type, password, school FROM User WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email); 
        $stmt->execute();    
        $stmt->store_result();

        $stmt->bind_result($name, $usertype, $db_password, $school);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
        	if ($db_password == $password) {
        		
        		//One can add session variables here

        		if ($usertype == "admin") {
        			header("Location: ../Admin/home.html");
        			exit();

        		} elseif($usertype == "topOga") {
        			header("Location: ../TopOga/home.html");
        			exit();

        		} elseif($usertype == "dean") {
        			header("Location: ../Dean/home.html");
        			exit();

        		} elseif($usertype == "secretary") {
        			header("Location: ../Secretary/home.html");
        			exit();

        		} elseif($usertype == "faculty") {
        			header("Location: ../Faculty/home.html");
        			exit();

        		} else {
        			header("Location: ../index.html?err=Something horrible has happened");
        			exit();
        		}

        	} else {
        		header("Location: ../index.html?err=Wrong Password");
        		exit();
        	}
        } else {
        	header("Location: ../index.html?err=No User");
        	exit();
        }
    } else {
        header("Location: ../index.html?err=Database error: cannot prepare statement");
        exit();
    }

} else { 
    header('Location: ../index.html?err=Could not process login');
    exit();
} 