	/**
	 * @file changePassword.js
	 * @brief Contains all the javascript functions for the changePassword_view.php page.
	 */
	
	/**  
	 * When the "Enter" key is clicked for each of these fields
	 * it emulates the changepassword button being pressed 
	 */
	$("#oldPassword").keydown(function(event) {
		if(event.keyCode == 13) {
			$("#changePasswordButton").click();
		}
	});
	
	$("#newPassword").keydown(function(event) {
		if(event.keyCode == 13) {
			$("#changePasswordButton").click();
		}
	});
	
	$("#retypeNewPassword").keydown(function(event) {
		if(event.keyCode == 13) {
			$("#changePasswordButton").click();
		}
	});
	
	/**
	 * This function gets the values of the password boxes and posts that data to the "checkCredentials" controller function
	 * to be validated. If successful, alerts a success message and loads login page. If not successful, alerts an error message. 
	 */
	function verifyChangePassword() {
		var oldPassword = $("#oldPassword").val();
        var newPassword = $("#newPassword").val();
        var retypeNewPassword = $("#retypeNewPassword").val();
        
        $.ajax({
			type: "POST",
			url:  "changepassword/checkCredentials",
			data: { "oldPassword" : oldPassword,
					"newPassword" : newPassword,
					"retypeNewPassword" : retypeNewPassword,
			},
			success: function(data) {
				if(data == 1) {
					alert("Password successfully changed!\nPlease log in with the new password");
					var url = home + "index.php";
					window.location = url;
				}
				else {
					$("#error-div").html(data);
				}
			}, 
			error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
		});
	}