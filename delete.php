<?php
	require_once('functions.php');
	$status =  sanitize($_POST['status']);
	$emp_id = sanitize($_POST['emp_id']);
	$response = disableEmployee($emp_id, $status);
?>