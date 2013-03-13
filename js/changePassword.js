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
	
	function verifyChangePassword() {
		var oldPassword = $("#oldPassword").val();
        var newPassword = $("#newPassword").val();
        var retypeNewPassword = $("#retypeNewPassword").val();
        
        $.ajax({
			type: "POST",
			url:  home + "index.php/changepassword/checkCredentials",
			data: { "oldPassword" : oldPassword,
					"newPassword" : newPassword,
					"retypeNewPassword" : retypeNewPassword,
			},
			success: function(data) {
				if(data == 1) { 
					changePassword($id, newPassword);
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