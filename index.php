<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Employee Listing</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/handleEmployeeTable.js"></script>
</head>
<body>
	<div style="background-color: #3578a8; height: 10%; width: 100%; margin-top: 0px;">
		<h1>Fast Burger INC.</h1>
	</div>
	<div class="container">
		<h1>Employee Listing</h1>
		
		<div class="table_container">
			<form id="add_employee" action="add.php">
				<input id="btn_add_employee" type="submit" value="New Employee" />
			</form>
			<?php
				require_once('functions.php');
				$employees = getEmployees();
				$table = buildEmployeeList($employees);
				echo $table;
			?>
		</div>
	</div> 
</body>
</html>



