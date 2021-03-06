	/**
	 * @file customer.js
	 * @brief This page contains all the javascript functions for the cutsomer_view.php page 
	 */
	
	var tagArray = new Array();
	var searchField = "cust_fname";
	var sorter = [[0,0],[1,0]]; //Sets which column will be sorted by default
	
	/** 
	 *Gets the data that we got from the database, and puts the first/last name of each customer
	 *Into a string which is used for the autocomplete. Also replaces null values with empty strings
	 *so "null" isn't displayed in the autocomplete
	 */
	for(var i=0;  i < custNum; i++) {
		if (obj[i]['cust_fname'] == null) {
			obj[i]['cust_fname'] = "";
		}
		if (obj[i]['cust_lname'] == null) {
			obj[i]['cust_lname'] = "";
		}
		tagArray[i] = obj[i]['cust_fname'] + " " + obj[i]['cust_lname'];
	}
	
	// Removes duplicate elements from the array, so autocomplete only displays unique values.
	tagArray = eliminateDuplicates(tagArray);
	
	/**
	 * Creates the initial autoComplete by using the tagArray created above
	 */
	$(function() {
		$("#searchbar").autocomplete({
			source: tagArray
		});
	});
	
	/**
	 * If the user hits "Enter" in the searchbar, it runs the onclick event of the search button.
	 */
	$("#searchbar").keydown(function(event) {
		if(event.keyCode == 13) {
			$("#id_search_button").click();
			$( "#searchbar" ).autocomplete( "close" ); //Hides the autocomplete on enter so it's not in the way
		}
	});
	
	/**
	 * Resizes the dialog box when the window is resized by calling the resizeDialog function 
	 */
	$(window).resize(function () {
	    resizeDialog();
	});
	
	/**
	 * When the New Customer button is clicked, it gets the value of the cust ID box and passes it to the openCustomer(id) function
	 */
	$('#new-cust-btn').click(function() {
		var id = $('#new-cust-btn').val();
		openCustomer(id);
	});
	
	/**
	 * Creates the dialog that contains our customer information form.
	 */
	$("#dialog_customer_form").dialog({
	    title: "Create New Customer",
	    height: 735,
	    width: 850,
	    modal: true,
	    autoOpen: false,
	    resizable: false,
	    close: function() {
	    	$(this).dialog("close");
	    	clearForm();
	    }
	});
	
	/**
	 * Sets the customers page as active on the header menu
	 */
	$(".active").removeClass("active");
	$("#customerLink").addClass("active");
	
	/**
	 * This function loads the search depending on the search catagory 
	 */
	function loadSearch() {
		var searchType = $("#searchType").val();
		switch(searchType) {
			case "name": //if the catagory was Name
				for(var i=0;  i < custNum; i++) {
					if (obj[i]['cust_fname'] == null) {
						obj[i]['cust_fname'] = "";
					}
					if (obj[i]['cust_lname'] == null) {
						obj[i]['cust_lname'] = "";
					}
					tagArray[i] = obj[i]['cust_fname'] + " " + obj[i]['cust_lname'];
				}
				searchField = "cust_fname";
				sorter = [[0,0],[1,0]]; 
				break;
			case "company":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_company'];
				}
				searchField = "cust_company";
				sorter = [[2,0]];
				break;
			case "city":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_city'];
				}
				searchField = "cust_city";
				sorter = [[4,0]];
				break;
			case "address":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_address'];
				}
				searchField = "cust_address";
				sorter = [[3,0]];
				break;
			case "phone":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_hphone'];
				}
				for(var i=0;  i < custNum; i++) {
					tagArray.push(obj[i]['cust_bphone'])
				}
				for(var i=0;  i < custNum; i++) {
					tagArray.push(obj[i]['cust_cphone'])
				}
				searchField = "cust_hphone";
				sorter = [[5,0]];
				break;
		}
		
		/**
		 * Replaces NULL values with an empty string, otherwise the autocomplete breaks.
		 */
		for(var i=0; i<tagArray.length; i++) {
			if(tagArray[i] == null) {
				tagArray[i] = "";
			}
		}
		
		tagArray = eliminateDuplicates(tagArray);
		
		$("#searchbar").autocomplete( "destroy" ); // Need to destroy the autocomplete in order to make a new one
		
		$(function() {
			$("#searchbar").autocomplete({
				source: tagArray
			});
		});
	}
	
	/**
	 * This function gets the values from the search box and posts that data to the showresults controller function
	 * If successful, returns a string of html to the id_result_table div.
	 */
	function getSearchResults() {
		$(function() {
			var searchQuery = $("#searchbar").val();
			if(searchQuery == "") {
				alert("Please input something to search by");
				return;
			}
			
			$.ajax({
				type: "POST",
				url: home + "index.php/customer/showresults",
				data: { "searchQ" : searchQuery,
					    "searchType" : searchField
					
				},
				success: function(data) {
					$("#id_result_table").html(data);
					$("#result-table").tablesorter({
						sortList: sorter
					});
				}, 
				error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
			});
		});
	}
	
	/**
	 * This function creates the buttons and sets their functions on the form when creating a new customer
	 */
	function newCustomer() {
		//Need to implement buttons like this, in order to format properly
		$( "#dialog_customer_form" ).dialog({ title: "Create New Customer" });
		$("#dialog_customer_form").dialog("option", "buttons", [
		
		    {
		        text: "Save",
		        height: "50",
		        width: "100",
		        click: function () {
		        	saveCustomer();	
		        }
		    },
		
		    {
		        text: "View Work Orders",
		        height: "50",
		        width: "100",
		        disabled: true,
		        click: function () {
		        	viewWorkOrders();
		        	$(this).dialog("close");
		        }
		    },
		    
		    {
		        text: "New Work Order",
		        height: "50",
		        width: "100",
		        disabled: true,
		        click: function () {
		        	newWorkOrder();
		        	$(this).dialog("close");
		        }
		    },
		    
		    {
		    	text: "Delete",
		    	height: "50",
		    	width: "100",
		    	disabled: true,
		    	click: function() {
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
		
		$("#dialog_customer_form").dialog("open");
		resizeDialog();
	}
	
	/**
	 * @param id The customer id.
	 * This function opens the customer form based on the customer id that has been passed to it.
	 */
	function openCustomer(id) {
		$("#custID").val(id);
		$.ajax({
				type: "POST",
				url: home + "index.php/customer/getCustInfo",
				data: { "id" : id
					
				},
				success: function(data) {
					var info = eval("(" + data + ")");
					$("#custCompany").val(info['cust_company']);
					$("#custFName").val(info['cust_fname']);
					$("#custLName").val(info['cust_lname']);
					$("#custAddress").val(info['cust_address']);
					$("#custCity").val(info['cust_city']);
					$("#custProvince").val(info['cust_prov']);
					$("#custPCode").val(info['cust_pcode']);
					$("#custHPhone").val(info['cust_hphone']);
					$("#custBPhone").val(info['cust_bphone']);
					$("#custCPhone").val(info['cust_cphone']);
					$("#custEmail").val(info['cust_email']);
					$("#custRef").val(info['cust_referral']);
					$("#custNotes").val(info['cust_notes']);
				}, 
				error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
			});
		
		//The buttons are created below
		$( "#dialog_customer_form" ).dialog({ title: "Showing Customer" });
		$("#dialog_customer_form").dialog("option", "buttons", [
		
		    {
		        text: "Save",
		        height: "50",
		        width: "100",
		        click: function () {
		        	saveCustomer();
		        }
		    },
		
		    {
		        text: "View Work Orders",
		        height: "50",
		        width: "100",
		        click: function () {
		        	viewWorkOrders();
		        }
		    },
		    
		    {
		        text: "New Work Order",
		        height: "50",
		        width: "100",
		        click: function () {
		        	newWorkOrder();
		        }
		    },
		    
		    {
		    	
		    	text: "Delete",
		    	height: "50",
		    	width: "100",
		    	click: function() {
		    		if(confirm("Are you sure you want to delete this customer?\n" +
		    					"This will permanently remove them from the database...")) {
		    			deleteCustomer();
		    		}
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
		
		$("#dialog_customer_form").dialog("open");
		resizeDialog();
	}
	
	/**
	 * Gets the values in the form, and passes them to the controller, to be input to the database
	 */
	
	function saveCustomer() {
		var id = $("#custID").val();
		var company = $("#custCompany").val();
		var fname = $("#custFName").val();
		var lname = $("#custLName").val();
		var address = $("#custAddress").val();
		var city = $("#custCity").val();
		var prov = $("#custProvince").val();
		var pcode = $("#custPCode").val();
		var hphone = $("#custHPhone").val();
		if(hphone == "403-") hphone = "";
		var bphone = $("#custBPhone").val();
		if(bphone == "403-") bphone = "";
		var cphone = $("#custCPhone").val();
		if(cphone == "403-") cphone = "";
		var email = $("#custEmail").val();
		var ref = $("#custRef").val();
		var notes = $("#custNotes").val();
		
		//If required variables don't contain any characters, then alert them and exit the function.
		if(fname == 0 && lname == 0 && company == 0) {
			alert("You must have either a first name, last name, or company to save a customer.");
			return;
		}
		
		$.ajax({
			type: "POST",
			url: home + "index.php/customer/savecustomer",
			data: { "id" : id,         "company" : company, "fname" : fname,
					"lname" : lname,   "address" : address, "city" : city,
					"prov" : prov,     "pcode" : pcode,     "hphone" : hphone,
					"bphone" : bphone, "cphone" : cphone,   "email" : email,
					"ref" : ref,       "notes" : notes 	
			},
			
			/**	Gives a value to the hidden input, and then submits the form.
			 *	This will reload the page, and put the form data into the table-results div.
			 *	The page is reloaded so that the autocomplete has the data that they just saved.
			 */
			success: function(data) {
				$("#alert-data").val(data);
				document.getElementById("alert-form").submit();
			}, 
			error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
		});
	}
	
	/**
	 * This function grabs the customer id and passes it to the deletecustomer controller function. 
	 */
	function deleteCustomer() {
		var id = $("#custID").val();
			
		$.ajax({
			type: "POST",
			url: home + "index.php/customer/deletecustomer",
			data: { "id" : id},
			success: function(data) {	
				/*	Gives a value to the hidden input, and then submits the form.
				 *	This will reload the page, and put the form data into the table-results div.
				 *	The page is reloaded so that the autocomplete has the data that they just saved.
				 */
				$("#alert-data").val(data);
				document.getElementById("alert-form").submit();
			}, 
			error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
		});
	
	}
	
	/**
	 * This function grabs the customers id and opens up a new tab with all of the corrosponding work orders
	 */
	function viewWorkOrders() {
		var id = $("#custID").val();
		var url = home + "index.php/workordersearch/showAllForCust/" + id;
		var page = window.open(url, '_blank');
		page.focus();
	}
	
	/**
	 * This function grabs the customers id and opens a new tab with a blank worker order for the corrosponding customer 
	 */
	function newWorkOrder() {
		var id = $("#custID").val();
		var url = home + "index.php/workorderform/newForCust/" + id;
		var page = window.open(url, '_blank');
		page.focus();
	}
	
	
	/**
	 * This function displays or hides the search tips.
	 * If the search tips are hidden, it removes the hidden class to display them.
	 * If they are not hidden, it hides them.
	 */
	function showTips() {
		if($('#search-div').hasClass('hidden')) {
			$('#search-div').removeClass('hidden');
			$('#id_searchTips_button').html("Hide Search Help");
		}
		else {
			$('#search-div').addClass('hidden');
			$('#id_searchTips_button').html("Show Search Help");
		}
	}
	
	/*
	 * This function resets all the values in the form
	 */
	function clearForm() {
		$("#custID").val("");
		$("#custCompany").val("");
		$("#custFName").val("");
		$("#custLName").val("");
		$("#custAddress").val("");
		$("#custCity").val("Lethbridge");
		$("#custProvince").val("AB");
		$("#custPCode").val("");
		$("#custHPhone").val("403-");
		$("#custBPhone").val("403-");
		$("#custCPhone").val("403-");
		$("#custEmail").val("");
		$("#custRef").val("");
		$("#custNotes").val("");
	}

	/*
	 * @param arr Array with search results
	 * This function removes duplicates from the search results
	 */
	function eliminateDuplicates(arr) {
		var i,
	  	len=arr.length,
	  	out=[],
	  	obj={};
	
	 	for (i=0;i<len;i++) {
	 		obj[arr[i]]=0;
	 	}
	 	for (i in obj) {
	 		out.push(i);
	 	}
	 	return out;
	}
	
	/*
	 * This function changes the size of the dialog box based on the size of the window
	 * This prevents the dialog box extending past the borders of the window and breaking (useful for mobile devices).
	 */
	function resizeDialog() {
		var timerid;
		(timerid && clearTimeout(timerid));
	        timerid = setTimeout(function () {
	            //uncomment to test alert("Do Resize");
	            $("#dialog_customer_form").dialog("option","width",$(window).width()*0.9);
	            $("#dialog_customer_form").dialog("option","height",$(window).height()*0.9);
	            if($(".ui-dialog").width() > 850) {
	            	$("#dialog_customer_form").dialog("option","width", 850);
	            } 
	            if($(".ui-dialog").height() > 735) {
	            	$("#dialog_customer_form").dialog("option","height", 735);
	            }
	            $("#dialog_customer_form").dialog("option","position","center");
	        }, 200);
	}
	