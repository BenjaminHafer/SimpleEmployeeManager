<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Edit Employee</title>
		<link rel="stylesheet" type="text/css" href="css/edit.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="js/validateForm.js"></script>
	</head>
	<body>
		<div style="background-color: #3578a8; height: 10%; width: 100%; margin-top: 0px;">
			<h1>Fast Burger INC.</h1>
		</div>
		<div class="container">
			<h1>Edit Employee</h1>
		<?php
			require_once('functions.php');
			
			$form = buildEditForm($_GET['emp_id']);
			echo $form;
		?>
		</div>
	</body>
</html>

