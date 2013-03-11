	
	// If the user hits "Enter" in the username/password texboxes, it'll emulate a click of the signin button.
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
					/*window.location = home + "index.php/mainmenu";*/ //Will reenable once the success check is working. 
				}
			}, 
			error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
		});
	}
