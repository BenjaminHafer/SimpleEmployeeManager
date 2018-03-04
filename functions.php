<?php
	
	require_once('../resources/db_connection.php');
	require_once('../resources/preparedStatements.php');
	$db = db_connect();

	function sanitize($input) {
		$data = trim($input);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}	

	function disableEmployee($emp_id, $status) {
		global $db;
		$success = preparedEmployeeUpdateStatus($db, $emp_id, $status);
		return $success;
	}

	function getEmployees() {
		global $db;
		return preparedEmployeesSelect($db);
	}
	/**
	 * @param $employees contains emp_lname, emp_fname, emp_loc, emp_status
	 */
	function buildEmployeeList($employees = false) {
		$table = '<table class="employees_list" id="employees_table">
					<tr>
						<th onClick="sortTable(0)">Enable/Disable</th>
						<th onClick="sortTable(1)">Employee Name</th>
						<th onClick="sortTable(2)">Location</th>
						<th onClick="sortTable(3)">Status</th>
						<th>Actions</th>
					</tr>';
		foreach ($employees as $employee) {
			$table .= buildEmployeeRow($employee);
		}
		$table .= "</table";
		return $table;
	}
	function buildEmployeeRow($employee) {
		$row = '<tr class="employee_row" data-emp_id="'.$employee['emp_id'].'" '. ($employee['emp_status'] == '0' ? 'style="background-color: yellow;"' : "") . '>';
		$row .= '<td><input class="emp_check" type="checkbox" name="enable_disable "'. ($employee['emp_status'] == '1' ? 'checked' : '') .'></td>';
		$row .= '<td>' . $employee['emp_lname'] . ', ' . $employee['emp_fname'] . '</td>';
		$row .= '<td>' . $employee['emp_loc'] . '</td>';
		$row .= '<td class="emp_status">' . ($employee['emp_status'] == '1' ? 'Active' : 'Inactive') . '</td>';
		$row .= '<td><a href="edit.php?emp_id='.urlencode($employee['emp_id']).'"><button>Edit</button></a></td>';
		$row .= '</tr>';

		return $row;
	}

	function buildEditForm($id, $fname, $lname) {
		global $db;

		$row = preparedEmployeeSelect($db, $id);
		$editForm = '<form class="edit_form" id="edit_emp_form" onsubmit="return validateForm()" action="updateEmployee.php" method="post" >';
		$editForm .= '<input type="hidden" name="emp_id" value="' . $row['emp_id'] . '"/>';
		$editForm .= 'Employee Last name: <input type="text" name="emp_lname" id="emp_lname" value="'.$row['emp_lname'] .'" required>';
		$editForm .= "<br>";
		$editForm .= 'Employee First name: <input type="text" name="emp_fname" id="emp_fname" value="'.$row['emp_fname'] .'" required>';
		$editForm .= "<br>";
		$editForm .= 'Employee State: <input type="text" name="emp_state" id="emp_state" value="'.$row['emp_state'] .'" required>';
		$editForm .= "<br>";
		$editForm .= 'Employee City: <input type="text" name="emp_city" id="emp_city" value="'.$row['emp_city'] .'" required>';
		$editForm .= "<br>";
		$editForm .= 'Employee Status: <select name="emp_status" id="emp_status">
											<option value=1 '.($row['emp_status'] == '1' ? 'selected="selected"' : '').'>Active</option>
											<option value=0 '.($row['emp_status'] == '0' ? 'selected="selected"' : '').'>Inactive</option>
										</select>';
		$editForm .= '<br><input id="btn_submit" type="submit" value="Submit">';
		$editForm .= '<input id="btn_back" type="button" value="Back" onClick="history.back()">';
		$editForm .= '</form>';
		
		return $editForm;
	}

	function buildAddForm() {
		$addForm = '<form class="edit_form" id="edit_emp_form" onsubmit="return validateForm()" action="processNewEmployee.php" method="post">';
		
		$addForm .= 'Employee Last name: <input type="text" name="emp_lname" id="emp_lname" required>';
		$addForm .= "<br>";
		$addForm .= 'Employee First name: <input type="text" name="emp_fname" id="emp_fname" required>';
		$addForm .= "<br>";
		$addForm .= 'Employee State: <input type="text" name="emp_state" id="emp_state" required>';
		$addForm .= "<br>";
		$addForm .= 'Employee City: <input type="text" name="emp_city" id="emp_city" required>';
		$addForm .= "<br>";
		$addForm .= 'Employee Status: <select name="emp_status" id="emp_status">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>';
		$addForm .= '<br><input id="btn_submit" type="submit" value="Submit">';
		$addForm .= '<input id="btn_back" type="button" value="Back" onClick="history.back()">';
		$addForm .= '</form>';

		return $addForm;
	}
	function processEmployeeUpdate($employee) {
		global $db;
		/**
		 * the first and last name can be directly written in
		 * we need to query db to see if city and state changed and whether or not 
		 * a new location is being added
		 * 
		 */
		$state = $employee['emp_state'];
		$city = $employee['emp_city'];
		$location = preparedLocationSelect($db, $state, $city);
		//not a new location update employee with location['loc_id']
		if (isset($location['loc_id'])) {
			$success = preparedEmployeeUpdate($db, $employee, $location['loc_id']);
			if ($success) {
				return '1';
			} else {
				error_log("Employee update failed.", 0);
			}

		} else {
			$locationSuccess = preparedLocationInsert($db, $state, $city);
			if ($locationSuccess) {
				$location = preparedLocationSelect($db, $state, $city);
				if (isset($location['loc_id'])) {
					$success = preparedEmployeeUpdate($db, $employee, $location['loc_id']);
					if ($success) {
						return '1';
					} else {
						error_log("Couldn't update employee",0);
					}
				}
			} else {
				error_log("failed to insert location", 0);
			}

		}
		return $location;
	}

	function addEmployee($emp_fname, $emp_lname, $emp_city, $emp_state, $emp_status) {
		global $db;

		$location = preparedLocationSelect($db, $emp_state, $emp_city);
		if (isset($location['loc_id'])) {
			$success = preparedEmployeeInsert($db, $emp_lname, $emp_fname, $emp_status, $location['loc_id']);
			if ($success) {
				return "1";
			} else {
				error_log("failed insert employee with existing location", 0);
			}
			
		} else {
			$locationSuccess = preparedLocationInsert($db, $emp_state, $emp_city);
			if ($locationSuccess) {
				$location = preparedLocationSelect($db, $emp_state, $emp_city);
				if (isset($location['loc_id'])) {
					$success = preparedEmployeeInsert($db, $emp_lname, $emp_fname, $emp_status, $location['loc_id']);
					if ($success) {
						return "1";
					} else {
						error_log("failed to insert new location and employee", 0);
					}
				}
			} else {
				error_log("failure to insert new location", 0);
			}	
		}

	}
?>



