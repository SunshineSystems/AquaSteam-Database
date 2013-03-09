
	
	
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
		alert("i'll save this account, but i need to be coded first!");
	}
	
	function deleteAccount() {
		alert("I'll delete this account, but i need to be coded first!")
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
