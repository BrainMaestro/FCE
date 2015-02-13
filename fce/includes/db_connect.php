<?php
include_once 'psl-config.php';  

session_start();

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli->connect_error) {
	$_SESSION['err'] = "Unable to connect to MySQL";
    header("Location: ../index.php");
    exit();
}