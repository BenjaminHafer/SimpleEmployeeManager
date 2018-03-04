<?php
	function preparedEmployeeInsert($db, $emp_lname, $emp_fname, $emp_status, $loc_id) {
		if ($stmt = mysqli_prepare($db, "INSERT INTO employees 
												(emp_lname, emp_fname, emp_loc_id, emp_status)
												VALUES (?,?,?,?)")) {
			mysqli_stmt_bind_param($stmt, "ssii", sanitize($emp_lname), sanitize($emp_fname), sanitize($loc_id), sanitize($emp_status));
			mysqli_stmt_execute($stmt);

			if ( mysqli_stmt_affected_rows($stmt) == '1') {

				return '1';
			} else {
				return '0';
			}
		}
	}
	function preparedEmployeeUpdate($db, $employee, $loc_id) {
		if ($stmt = mysqli_prepare($db, "UPDATE employees
										SET emp_lname=?, emp_fname=?, emp_status=?, emp_loc_id=?
										WHERE emp_id=?")) {
			mysqli_stmt_bind_param($stmt,
				"ssiii",
				sanitize($employee['emp_lname']),
				sanitize($employee['emp_fname']),
				sanitize($employee['emp_status']),
				sanitize($loc_id),
				sanitize($employee['emp_id']));
			mysqli_stmt_execute($stmt);
			
			if ( mysqli_stmt_affected_rows($stmt) == '1') {
				return '1';
			} else {
				return '0';
			}
		}

	}
	function preparedEmployeeUpdateStatus($db, $emp_id, $status) {
		if ($stmt = mysqli_prepare($db, "UPDATE employees
										SET emp_status=?
										WHERE emp_id=?")) {
			mysqli_stmt_bind_param($stmt, "ii", sanitize($status), sanitize($emp_id));
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			if ( mysqli_stmt_affected_rows($stmt) == '1') {
				return '1';
			} else {
				return '0';
			}
		}
	}
	function preparedEmployeesSelect($db) {
		$users = [];
		if ($stmt = mysqli_prepare($db, 
			"SELECT e.emp_id, e.emp_lname, e.emp_fname, e.emp_status, l.loc_city, l.loc_state
			FROM employees AS e 
			LEFT JOIN locations AS l ON e.emp_loc_id = l.loc_id
			ORDER BY e.emp_lname, e.emp_fname")) {
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $id, $lname, $fname, $status, $city, $state);
			while (mysqli_stmt_fetch($stmt)) {
				$users[] = [
					'emp_id' => $id,
					'emp_lname' => $lname,
					'emp_fname' => $fname,
					'emp_status' => $status,
					'emp_loc' => $state . ', ' . $city  
				];
			}
			mysqli_stmt_close($stmt);
			return $users;
		}
	}
	function preparedEmployeeSelect($db, $id) {

		if ($stmt = mysqli_prepare($db, "SELECT employees.emp_id, employees.emp_lname, employees.emp_fname, employees.emp_status, locations.loc_city, locations.loc_state FROM employees 
			LEFT JOIN locations ON employees.emp_loc_id = locations.loc_id
			WHERE employees.emp_id=?")) {
			mysqli_stmt_bind_param($stmt, "i", sanitize($id));
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $id, $lname, $fname, $status, $city, $state);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			$user = [
				'emp_id' => $id,
				'emp_lname' => $lname,
				'emp_fname' => $fname,
				'emp_status' => $status,
				'emp_city' => $city,
				'emp_state' => $state,
				'emp_status' => $status  
			];
			
			return $user;

		}
	}
	function preparedLocationSelect($db, $state, $city) {
		if ($stmt = mysqli_prepare($db, "SELECT loc_id, loc_city, loc_state FROM locations WHERE loc_state=?
												AND loc_city=?")) {
			//bind parameters for markers
			mysqli_stmt_bind_param($stmt, "ss", sanitize($state), sanitize($city));
			//execute
			mysqli_stmt_execute($stmt);
			//bind results
			mysqli_stmt_bind_result($stmt, $loc_id, $loc_city, $loc_state);
			// fetch results and close statement
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			$location = ['loc_id'=> $loc_id, 'loc_city' => $loc_city, 'loc_state' => $loc_state];
			if ($loc_id) {
				return $location;
			} else {
				return false;
			}
		}
	}
	function preparedLocationInsert($db, $state, $city) {
		if ($stmt = mysqli_prepare($db, "INSERT INTO locations (loc_state, loc_city)
										VALUES (?,?)")) {
			mysqli_stmt_bind_param($stmt, 'ss', sanitize(strtoupper($state)), sanitize($city));
			mysqli_stmt_execute($stmt);
			if ( mysqli_stmt_affected_rows($stmt) == '1') {
				return '1';
			} else {
				return '0';
			}

		}
	}
?>