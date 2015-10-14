/* 
	author: istockphp.com
*/
jQuery(function($) {
	var validation_holder;
	
	$("form#register_form input[name='submit']").click(function() {
	
	var validation_holder = 0;
	
		var fname 			= $("form#register_form input[name='fname']").val();
		var lname 			= $("form#register_form input[name='lname']").val();
		var email 			= $("form#register_form input[name='email']").val();
		var email_regex 	= /^[\w%_\-.\d]+@[\w.\-]+.[A-Za-z]{2,6}$/; // reg ex email check	
		var password 		= $("form#register_form input[name='password']").val();
		var repassword 		= $("form#register_form input[name='repassword']").val();
		var phone 			= $("form#register_form input[name='phone']").val();
		var phone_regex		= /^[0-9]{4,20}$/; // reg ex phone check	
		var month 			= $("form#register_form select[name='month']").val(); // month
		var day 			= $("form#register_form select[name='day']").val(); // day
		var year 			= $("form#register_form select[name='year']").val(); // year
		var gender 			= $("form#register_form input[name='gender']");
		
		/* validation start */	
		if(fname == "") {
			$("span.val_fname").html("This field is required.").addClass('validate');
			validation_holder = 1;
		} else {
			$("span.val_fname").html("");
			}
		if(lname == "") {
			$("span.val_lname").html("This field is required.").addClass('validate');
			validation_holder = 1;
		} else {
			$("span.val_lname").html("");
			}
		if(email == "") {
			$("span.val_email").html("This field is required.").addClass('validate');
			validation_holder = 1;
		} else {
			if(!email_regex.test(email)){ // if invalid email
				$("span.val_email").html("Invalid Email!").addClass('validate');
				validation_holder = 1;
			} else {
				$("span.val_email").html("");
			}
		}
		if(password == "") {
			$("span.val_pass").html("This field is required.").addClass('validate');
			validation_holder = 1;
		} else {
				$("span.val_pass").html("");
			}
		if(repassword == "") {
			$("span.val_pass2").html("This field is required.").addClass('validate');
			validation_holder = 1;
		} else {
			if(password != repassword) {
				$("span.val_pass2").html("Password does not match!").addClass('validate');
				validation_holder = 1;
			} else {
				$("span.val_pass2").html("");
			}
		}
		if(phone == "") {
			$("span.val_phone").html("This field is required.").addClass('validate');
			validation_holder = 1;
		} else {
			if(!phone_regex.test(phone)){ // if invalid phone
				$("span.val_phone").html("Invalid Phone Number!").addClass('validate');
				validation_holder = 1;
			
			} else {
				$("span.val_phone").html("");
			}
		}
		if((month == "") || (day == "") || (year == "")) {
			$("span.val_bday").html("This field is required.").addClass('validate');
			validation_holder = 1;
		} else {
				$("span.val_bday").html("");
			}
		
		if(gender.is(':checked') == false) {
			$("span.val_gen").html("This field is required.").addClass('validate');
			validation_holder = 1;
		} else {
				$("span.val_gen").html("");
			}
		if(validation_holder == 1) { // if have a field is blank, return false
			$("p.validate_msg").slideDown("fast");
			return false;
		}  validation_holder = 0; // else return true
		/* validation end */	
	}); // click end 

}); // jQuery End