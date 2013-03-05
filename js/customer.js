
	var tagArray = new Array();
	//Gets the data that we got from the database, and puts the first/last name of each customer
	//Into a string which is used for the autocomplete.
	for(var i=0;  i < custNum; i++) {
		tagArray[i] = obj[i]['cust_fname'] + " " + obj[i]['cust_lname'];
	}
	
	
	$(function() {
		$("#searchbar").autocomplete({
			source: tagArray
		});
	});
	
	//Sets the customers page as active on the header menu
	$(".active").removeClass("active");
	$("#customerLink").addClass("active");
	
	function loadSearch() {
		var searchType = $("#searchType").val();
		$("#searchbar").autocomplete( "destroy" );

		switch(searchType) {
			case "name":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_fname'] + " " + obj[i]['cust_lname'];
				}
				break;
			case "company":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_company'];
				}
				break;
			case "city":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_city'];
				}
				break;
			case "address":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_address'];
				}
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
				
				break;
		}
		//replaces NULL values with an empty string, otherwise the autocomplete breaks.
		for(var i=0; i<tagArray.length; i++) {
			if(tagArray[i] == null) {
				tagArray[i] = "";
				
			}
		}
		$(function() {
			$("#searchbar").autocomplete({
				source: tagArray
			});
		});
	}
	
	function getSearchResults() {
		$(function() {
			var searchType = $("#searchType").val();
			var searchQuery = $("#searchbar").val();
			if(searchQuery == "") {
				alert("Please input something to search by");
				return;
			}
			
			$.ajax({
				type: "POST",
				url: "customer/showresults",
				data: { "searchQ" : searchQuery,
					    "searchType" : searchType
					
				},
				success: function(data) {
					$("#id_result_table").html(data);
					$("#result-table").tablesorter();
				}, 
				error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
			});
			
			
		});
	}
	
	function newCustomer() {
		$("#dialog_customer_form").dialog({
		    title: "Create New Customer",
		    height: 725,
		    width: 850,
		    modal: true,
		});
		
		//Need to implement buttons like this, in order to format properly
		$("#dialog_customer_form").dialog("option", "buttons", [
		
		    {
		        text: "Save",
		        height: "50",
		        width: "100",
		        click: function () {
		        	saveCustomer();
		        	$(this).dialog("close");	
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
		    	click: function() {
		    		deleteCustomer();
		    		$(this).dialog("close");
		    	}
		    },
		    
		]);
		
		$("#dialog_customer_form").dialog("open");
	}
	
	function openCustomer(id) {
		alert("you've selected customer: " + id);
	}
	
	function saveCustomer() {
		alert("i'll save the customer!");
	}
	
	function deleteCustomer() {
		alert("i'll delete the customer!");
	}
	
	function viewWorkOrders() {
		alert("I'll show all workorders for this customer!");
	}
	
	function newWorkOrder() {
		alert("I'll start a new workorder for this customer!");
	}
	
	
