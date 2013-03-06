
	var tagArray = new Array();
	var searchField = "cust_fname";
	//Gets the data that we got from the database, and puts the first/last name of each customer
	//Into a string which is used for the autocomplete.
	for(var i=0;  i < custNum; i++) {
		tagArray[i] = obj[i]['cust_fname'] + " " + obj[i]['cust_lname'];
	}
	
	//creates the dialog that contains our customer information form.
	$("#dialog_customer_form").dialog({
		    title: "Create New Customer",
		    height: 735,
		    width: 850,
		    modal: true,
		    autoOpen: false,
		    close: function() {
		    	$(this).dialog("close");
		    	clearForm();
		    }
		});
	
	
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
				searchField = "cust_fname";
				break;
			case "company":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_company'];
				}
				searchField = "cust_company";
				break;
			case "city":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_city'];
				}
				searchField = "cust_city";
				break;
			case "address":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['cust_address'];
				}
				searchField = "cust_address";
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
			var searchQuery = $("#searchbar").val();
			if(searchQuery == "") {
				alert("Please input something to search by");
				return;
			}
			
			$.ajax({
				type: "POST",
				url: "customer/showresults",
				data: { "searchQ" : searchQuery,
					    "searchType" : searchField
					
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
		//Need to implement buttons like this, in order to format properly
		$( "#dialog_customer_form" ).dialog({ title: "Create New Customer" });
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
		    	disabled: true,
		    	click: function() {
		    		$(this).dialog("close");
		    	}
		    },
		    
		]);
		
		$("#dialog_customer_form").dialog("open");
	}
	
	function openCustomer(id) {
		
		$("#custID").val(id);
		$.ajax({
				type: "POST",
				url: "customer/getCustInfo",
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
		
		$( "#dialog_customer_form" ).dialog({ title: "Showing Customer" });
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
		        click: function () {
		        	viewWorkOrders();
		        	$(this).dialog("close");
		        }
		    },
		    
		    {
		        text: "New Work Order",
		        height: "50",
		        width: "100",
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
		    		deleteCustomer(id);
		    		$(this).dialog("close");
		    	}
		    },
		    
		]);
		
		$("#dialog_customer_form").dialog("open");
	}
	
	function saveCustomer() {
		alert("i'll save the customer!");
	}
	
	function deleteCustomer(id) {
		alert("i'll delete the customer: " + id);
	}
	
	function viewWorkOrders() {
		alert("I'll show all workorders for this customer!");
	}
	
	function newWorkOrder() {
		alert("I'll start a new workorder for this customer!");
	}
	
	//Resets the form in the dialog
	function clearForm() {
		$("#custID").val("");
		$("#custCompany").val("");
		$("#custFName").val("");
		$("#custLName").val("");
		$("#custAddress").val("");
		$("#custCity").val("");
		$("#custProvince").val("AB");
		$("#custPCode").val("");
		$("#custHPhone").val("403-");
		$("#custBPhone").val("403-");
		$("#custCPhone").val("403-");
		$("#custEmail").val("");
		$("#custRef").val("");
		$("#custNotes").val("");
	}
