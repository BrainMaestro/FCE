<?php
include_once 'db_connect.php';
include_once 'functions.php';

// session_start();
// goBack($mysqli);
if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    if ($email == "helper@aun.edu.ng") {
        if($stmt = $mysqli->prepare("SELECT crn FROM helper_user WHERE password = ?")) {
            $stmt->bind_param('s', $password);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($crn);
            $stmt->fetch();
            if ($stmt->num_rows == 1) {
                $_SESSION['name'] = "Evaluation Helper";
                $_SESSION['school'] = "FCE";
                $_SESSION['email'] = $email;
                $_SESSION['roles'] = array("helper");
                $_SESSION['user'] = "helper";
                $_SESSION['page'] = "./users/section.php?crn=$crn";
                header("Location: ../users/section.php?crn=$crn");
                exit();

            }
        }
    }
    if ($stmt = $mysqli->prepare("SELECT name, password, school FROM users WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email); 
        $stmt->execute();    
        $stmt->store_result();

        $stmt->bind_result($name, $db_password, $school);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
        	if ($db_password == $password) {

                $_SESSION['name'] = $name;
                $_SESSION['school'] = $school;
                $_SESSION['email'] = $email;

                $roles_array = array();
                $roles = $mysqli->query("SELECT user_role from user_roles where user_email = '$email' order by 1");
                    for($i = 0; $i < $roles->num_rows; $i++) {
                        $row = $roles->fetch_assoc();
                        array_push($roles_array, $row['user_role']);
                    }
                $_SESSION['roles'] = $roles_array;
                $main_role = $_SESSION['roles'][0];
                $_SESSION['user_type'] = $main_role; //for the goBack function, which btw also has to change
                if ($main_role == "admin") {
                    header("Location: ../users/$main_role.php"); // Simple statement that works for all user types
                    exit();
                } else {
                    if ($db_password == "fce") {
                        header("Location: ../change_password.php");
                        exit();
                    } else {
                        header("Location: ../users/$main_role.php");
                        exit();
                    }
                }
        	}
             else {
                $_SESSION['errl'] = "wrong Email or Password";
        		header("Location: ../index.php");
        	}
        } else {
            $_SESSION['errl'] = "No Such User";
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['errl'] = "database error: cannot prepare statement";
        header("Location: ../index.php");
    }

} else { 
    $_SESSION['errl'] = "could not process login";
    header("Location: ../index.php");
} 