<?php
/**
 * This file is responsible for updating current employees
 */
	require_once('functions.php');
	$id = sanitize($_POST['emp_id']);
	$lname = sanitize($_POST['emp_lname']);
	$fname = sanitize($_POST['emp_fname']);
	$state = sanitize($_POST['emp_state']);
	$city = sanitize($_POST['emp_city']);
	$status = sanitize($_POST['emp_status']);
	$employee = [
		'emp_id' => $id,
		'emp_fname' => $fname,
		'emp_lname' => $lname,
		'emp_city' => $city,
		'emp_state' => $state,
		'emp_status' => $status
	];
	$result = processEmployeeUpdate($employee);
	if ($result) {
		header('Location: index.php');
	} else {
		//log error here
	}


?>