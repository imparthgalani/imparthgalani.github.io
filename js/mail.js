$('#CDetails').click(function () {

	var valid = true;

	var Name = $('#Name').val();
	var Email = $('#Email').val();
	var Subject = $('#Subject').val();
	var Message = $('#Message').val();


	$(".error").remove();

	//Name validation
	if ((Name != undefined) && Name === "") {
		$("#Name").css("outline", "1px solid red");
		$('#Name').after('<span class="error">Please! Enter Full Name.</span>');
		valid = false;
	} else {
		$("#Name").css("outline", "1px solid #007bff");
	}

	//Email validation
	if ((Email != undefined) && Email === "") {
		$("#Email").css("outline", "1px solid red");
		$('#Email').after('<span class="error">Please! Enter Email Address.</span>');
		valid = false;
	} else {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!(regex.test(Email))) {

			$("#Email").css("outline", "1px solid red");
			$('#Email').after('<span class="error">Please! Enter Valid Email Address.</span>');

			valid = false;
		} else {
			$("#Email").css("outline", "1px solid #007bff");
		}
	}

	//Subject validation
	if ((Subject != undefined) && Subject === "") {
		$("#Subject").css("outline", "1px solid red");
		$('#Subject').after('<span class="error">Please! Enter Subject.</span>');
		valid = false;
	} else {
		$("#Subject").css("outline", "1px solid #007bff");
	}

	//Message validation
	if ((Message != undefined) && Message === "") {
		$("#Message").css("outline", "1px solid red");
		$('#Message').after('<span class="error">Please! Enter Short Message.</span>');
		valid = false;
	} else {
		$("#Message").css("outline", "1px solid #007bff");
	}

	return valid;


});



// function sendEmail() {
// 	var name = $('#Name').val();
// 	var email = $('#Email').val();
// 	var subject = $('#Subject').val();
// 	var message = $('#Message').val();


// 	var Body = 'Name: ' + name + '<br>Email: ' + email + '<br>Subject: ' + subject + '<br>Message: ' + message;
// 	//console.log(name, phone, email, message);

// 	Email.send({
// 			Host: "smtp.gmail.com",
// 			Username: "pgalani193@rku.ac.in",
// 			Password: "stoatajahvolkazw",
// 			To: email, // sbhikadiya892@rku.ac.in //parthgalani250@gmail.com //slakhani062@rku.ac.in
// 			From: "pgalani193@rku.ac.in",
// 			Subject: subject,
// 			Body: Body,
// 		})
// 		.then(
// 			message => {
// 				//console.log (message);
// 				if (message == 'OK') {
// 					alert('Your mail has been send. Thank you for connecting.');
// 				} else {
// 					console.error(message);
// 					alert('There is error at sending message. ')
// 				}

// 			}
// 		);

// }