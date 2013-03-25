
	
	
	$("#dialog_account_form").dialog({
	    title: "Create New Account",
	    height: 675,
	    maxHeight: 675,
	    width: 850,
	    maxWidth: 850,
	    modal: true,
	    autoOpen: false,
	    close: function() {
	    	$(this).dialog("close");
	    	clearForm();
	    }
	});
		 
	//Resizes the dialog box when the window is resized by calling the resizeDialog function 
	$(window).resize(function () {
	    resizeDialog();
	});
	
	$('#userPass').tooltip();
	
	$("#user-table").tablesorter();

	function newAccount() {
		$( "#dialog_account_form" ).dialog({ title: "Create New Account" });
		$("#dialog_account_form").dialog("option", "buttons", [
		
		    {
		        text: "Save",
		        height: "50",
		        width: "100",
		        click: function () {
		        	saveAccount();	
		        }
		    },
		    
		    {
		    	text: "Delete",
		    	height: "50",
		    	width: "100",
		    	disabled: true,
		    	click: function() {
		    		deleteAccount();
		    		$(this).dialog("close");
		    		clearForm();
		    	}
		    },
		    
		    {
		    	
		    	text: "Cancel",
		    	height: "50",
		    	width: "100",
		    	click: function() {
		    		$(this).dialog("close");
		    		clearForm();
		    	}
		    },
		    
		]);
		$("#dialog_account_form").dialog("open");
		resizeDialog(); //Sets the initial size of the dialog based on the browser size when the dialog is opened.
	}
	
	function openUser(id) {
		$("#userID").val(id);
		
		$.ajax({
				type: "POST",
				url: "manageAccount/getUserInfo",
				data: { "id" : id
					
				},
				success: function(data) {
					var info = eval("(" + data + ")");
					$("#userType").val(info['user_admin']);
					$("#userUName").val(info['user_username']);
					$("#userFName").val(info['user_fname']);
					$("#userLName").val(info['user_lname']);
					$("#userAddress").val(info['user_address']);
					$("#userCity").val(info['user_city']);
					$("#userProvince").val(info['user_prov']);
					$("#userPCode").val(info['user_pcode']);
					$("#userHPhone").val(info['user_hphone']);
					$("#userCPhone").val(info['user_cphone']);
					$("#userNotes").val(info['user_notes']);
				}, 
				error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
			});
		
		$("#dialog_account_form" ).dialog({ title: "Viewing User Account" });
		$("#dialog_account_form").dialog("option", "buttons", [
		
		    {
		        text: "Save",
		        height: "50",
		        width: "100",
		        click: function () {
		        	saveAccount();	
		        }
		    },
		    
		    {
		    	text: "Delete",
		    	height: "50",
		    	width: "100",
		    	click: function() {
		    		if(confirm("Are you sure you want to delete this user?\n" +
		    					"This will permanently remove them from the database...")) {
		    			deleteAccount();
		    		}
		    		$(this).dialog("close");
		    		clearForm();
		    	}
		    },
		    
		    {
		    	
		    	text: "Cancel",
		    	height: "50",
		    	width: "100",
		    	click: function() {
		    		$(this).dialog("close");
		    		clearForm();
		    	}
		    },
		    
		]);
		$("#dialog_account_form").dialog("open");
		resizeDialog(); //Sets the initial size of the dialog based on the browser size when the dialog is opened.
	}
	
	function saveAccount() {
		var id = $("#userID").val();
		var type = $("#userType").val();
		var username = $("#userUName").val();
		var password = $("#userPass").val();
		var fname = $("#userFName").val();
		var lname = $("#userLName").val();
		var address = $("#userAddress").val();
		var city = $("#userCity").val();
		var prov = $("#userProvince").val();
		var pcode = $("#userPCode").val();
		var hphone = $("#userHPhone").val();
		var cphone = $("#userCPhone").val();
		var notes = $("#userNotes").val();
		
		//If there are no characters in username, alert the user and don't return from the function.
		if(username == 0) {
			alert("You must input a username to save an account");
			return;
		}
		
		$.ajax({
			type: "POST",
			url: "manageAccount/saveAccount",
			data: { "id" : id,        	 	"type" : type, 		"username" : username,
					"password" : password,	"fname" : fname,	"lname" : lname,   
					"address" : address, 	"city" : city,		"prov" : prov,     
					"pcode" : pcode,		"hphone" : hphone,	"cphone" : cphone, 
					"notes" : notes 	
			},
			success: function(data) {
				if(data == "error") {
					alert("You must set a valid password when creating a new account");
				}
				else if(data == "existing") {
					alert("This username is already in use!");
				}
				else {
					$("#alert-data").val(data);
					document.getElementById("alert-form").submit();
				}
			}, 
			error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
		});
	}
	
	function deleteAccount() {
		var id = $("#userID").val();
			
		$.ajax({
			type: "POST",
			url: "manageAccount/deleteAccount",
			data: { "id" : id},
			success: function(data) {
				$("#alert-data").val(data);
				document.getElementById("alert-form").submit();
			}, 
			error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
		});
	}
	
	function resizeDialog() {
		var timerid;
		(timerid && clearTimeout(timerid));
	        timerid = setTimeout(function () {
	            //uncomment to test alert("Do Resize");
	            $("#dialog_account_form").dialog("option","width",$(window).width()*0.9);
	            $("#dialog_account_form").dialog("option","height",$(window).height()*0.9);
	            if($(".ui-dialog").width() > 850) {
	            	$("#dialog_account_form").dialog("option","width", 850);
	            } 
	            if($(".ui-dialog").height() > 675) {
	            	$("#dialog_account_form").dialog("option","height", 675);
	            }
	            $("#dialog_account_form").dialog("option","position","center");
	        }, 200);
	}
	
	//Clears all entrys from the dialog form so that nothing carries over from the last opened dialog.
	function clearForm() {
		$("#userID").val("");
		$("#userType").val("Employee");
		$("#userUName").val("");
		$("#userPass").val("");
		$("#userFName").val("");
		$("#userLName").val("");
		$("#userAddress").val("");
		$("#userCity").val("Lethridge");
		$("#userProvince").val("AB");
		$("#userPCode").val("");
		$("#userHPhone").val("403-");
		$("#userCPhone").val("403-");
		$("#userNotes").val("");
	}
