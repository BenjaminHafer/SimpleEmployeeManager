
$(document).ready(function() {
	var submitBtn = $('#btn_submit');
	var states ={
	    "AL": "Alabama",
	    "AK": "Alaska",
	    "AS": "American Samoa",
	    "AZ": "Arizona",
	    "AR": "Arkansas",
	    "CA": "California",
	    "CO": "Colorado",
	    "CT": "Connecticut",
	    "DE": "Delaware",
	    "DC": "District Of Columbia",
	    "FM": "Federated States Of Micronesia",
	    "FL": "Florida",
	    "GA": "Georgia",
	    "GU": "Guam",
	    "HI": "Hawaii",
	    "ID": "Idaho",
	    "IL": "Illinois",
	    "IN": "Indiana",
	    "IA": "Iowa",
	    "KS": "Kansas",
	    "KY": "Kentucky",
	    "LA": "Louisiana",
	    "ME": "Maine",
	    "MH": "Marshall Islands",
	    "MD": "Maryland",
	    "MA": "Massachusetts",
	    "MI": "Michigan",
	    "MN": "Minnesota",
	    "MS": "Mississippi",
	    "MO": "Missouri",
	    "MT": "Montana",
	    "NE": "Nebraska",
	    "NV": "Nevada",
	    "NH": "New Hampshire",
	    "NJ": "New Jersey",
	    "NM": "New Mexico",
	    "NY": "New York",
	    "NC": "North Carolina",
	    "ND": "North Dakota",
	    "MP": "Northern Mariana Islands",
	    "OH": "Ohio",
	    "OK": "Oklahoma",
	    "OR": "Oregon",
	    "PW": "Palau",
	    "PA": "Pennsylvania",
	    "PR": "Puerto Rico",
	    "RI": "Rhode Island",
	    "SC": "South Carolina",
	    "SD": "South Dakota",
	    "TN": "Tennessee",
	    "TX": "Texas",
	    "UT": "Utah",
	    "VT": "Vermont",
	    "VI": "Virgin Islands",
	    "VA": "Virginia",
	    "WA": "Washington",
	    "WV": "West Virginia",
	    "WI": "Wisconsin",
	    "WY": "Wyoming"
	};
	submitBtn.on('click', function(e) {
		var valid = true,
			alertMessage = '',
			fname = $('#emp_fname').val(),
			lname = $('#emp_lname').val(),
			state = $('#emp_state').val(),
			city = $('#emp_city').val(),
			status = $('#emp_status').val();
		if (!(/^[a-zA-Z]+$/.test(fname))) {
			valid = false;
			alertMessage += 'First name should only contain letters.\n';
		}
		if (!(/^[a-zA-Z]+$/.test(lname))) {
			valid = false;
			alertMessage += 'Last name should only contain letters.\n';
		}
		if (!(/^[a-zA-Z]+$/.test(state))) {
			valid = false;
			alertMessage += 'State should only contain letters.\n';
		}
		if (!states.hasOwnProperty(state.toUpperCase()) && Object.values(states).indexOf(state) <= -1) {
			valid = false;
			alertMessage += 'Please use US states or abbreviations';
		}
		if (!(/^[a-zA-Z]+$/.test(city))) {
			valid = false;
			alertMessage += 'City should only contain letters.\n';
		}
		if (!(/^[0|1]+$/.test(parseInt(status)))) {
			valid = false;
			alertMessage += 'Status should be zero or one.\n';
		}
		if (!valid) {
			alert(alertMessage);
			e.preventDefault();
		}
	});
});
