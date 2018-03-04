<?php
	require_once('functions.php');
	// print_r($_POST);
	$firstName = sanitize($_POST['emp_fname']);
	$lastName = sanitize($_POST['emp_lname']);
	$city = sanitize($_POST['emp_city']);
	$state = sanitize($_POST['emp_state']);
	$status = sanitize($_POST['emp_status']);
	$result = addEmployee($firstName, $lastName, $city, $state, $status);
	if ($result == '1') {
		header('Location: index.php');
	} else {
		//handle insert error message here
	}
	
?>