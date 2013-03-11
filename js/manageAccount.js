
	
	
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
	    }
	});
		 
	//Resizes the dialog box when the window is resized by calling the resizeDialog function 
	$(window).resize(function () {
	    resizeDialog();
	});

	function newAccount() {
		$( "#dialog_account_form" ).dialog({ title: "Create New Account" });
		$("#dialog_account_form").dialog("option", "buttons", [
		
		    {
		        text: "Save",
		        height: "50",
		        width: "100",
		        click: function () {
		        	saveAccount();
		        	$(this).dialog("close");	
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
		    	}
		    },
		    
		    {
		    	
		    	text: "Cancel",
		    	height: "50",
		    	width: "100",
		    	click: function() {
		    		$(this).dialog("close");
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
				$("#accounts-table").html(data);
				
				//$("#alert-data").val(data);
				//document.getElementById("alert-form").submit();
			}, 
			error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
		});
	}
	
	function deleteAccount() {
		("I'll delete this account, but i need to be coded first!")
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
