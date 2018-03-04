$(document).ready(function() {

	$(".emp_check").change(function() {
		var emp_status, emp_id;
		emp_id = $(this).closest('tr').attr('data-emp_id');
		if (this.checked) {
			emp_status = '1';
			$(this).closest('tr').find('.emp_status').html('Active');
			$(this).closest('tr').css('background-color', '#cbd0d3');

		} else { 
			emp_status = '0';
			$(this).closest('tr').find('.emp_status').html('Inactive');
			$(this).closest('tr').css('background-color', 'yellow');
		}
		$.post("delete.php",
			{
				status: emp_status,
				emp_id: emp_id
			},
			function(success) {
				if (!success) {
					setTimeout(function() {
						alert("Failed to update status.");
					}, 3000);
				}
			});
	});
});

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("employees_table");
  switching = true;
  // Set the sorting direction
  dir = "asc"; 
  while (switching) {
	// Start by saying: no switching is done:
	switching = false;
	rows = table.getElementsByTagName("TR");
	for (i = 1; i < (rows.length - 1); i++) {
	  shouldSwitch = false;
	  x = rows[i].getElementsByTagName("TD")[n];
	  y = rows[i + 1].getElementsByTagName("TD")[n];
	  if (dir == "asc") {
		if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
		  shouldSwitch= true;
		  break;
		}
	  } else if (dir == "desc") {
		if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
		  shouldSwitch= true;
		  break;
		}
	  }
	}
	if (shouldSwitch) {
	  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
	  switching = true;
	  switchcount ++; 
	} else {
	  /* If no switching has been done AND the direction is "asc",
	  set the direction to "desc" and run the while loop again. */
	  if (switchcount == 0 && dir == "asc") {
		dir = "desc";
		switching = true;
	  }
	}
  }
}