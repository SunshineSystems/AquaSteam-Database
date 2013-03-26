	/**
	 * @file login.js
	 * @brief Contains all the javascript functions for the login_view.php page.
	 */
	
	/**  
	 * When the "Enter" key is clicked for each of these fields
	 * it emulates the sign-in button being pressed 
	 */
	$("#loginUsername").keydown(function(event) {
		if(event.keyCode == 13) {
			$("#signin-button").click();
		}
	});
	
	$("#loginPassword").keydown(function(event) {
		if(event.keyCode == 13) {
			$("#signin-button").click();
		}
	});
	
	/*
	 * This function grabs the text boxs and passes them into the checkCredentials controller function to be verifeid
	 * If successful, it redirects the user to the main menu.
	 */
	function verifyLogin() {
		var username = $("#loginUsername").val();
        var password = $("#loginPassword").val();
        
        $.ajax({
			type: "POST",
			url:  home + "index.php/login/checkCredentials",
			data: { "username" : username,
					"password" : password
			},
			success: function(data) {
				if(data == 1) { 
					window.location = home + "index.php/mainmenu";
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
