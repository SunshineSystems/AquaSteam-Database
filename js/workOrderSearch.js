	
	var tagArray = new Array();
	var searchField = "cust_fname";
	var sorter = [[2,0]]; //Sets which column will be sorted by default
	
	//Gets the data that we got from the database, and puts the first/last name of each customer
	//Into a string which is used for the autocomplete. Also replaces null values with empty strings
	// so "null" isn't displayed in the autocomplete
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
	
	//Creates the initial autoComplete by using the tagArray created above
	$(function() {
		$("#searchbar").autocomplete({
			source: tagArray
		});
	});
	
	
	// If the user hits "Enter" in the searchbar, it runs the onclick event of the search button.
	$("#searchbar").keydown(function(event) {
		if(event.keyCode == 13) {
			$("#id_search_button").click();
			$( "#searchbar" ).autocomplete( "close" ); //Hides the autocomplete on enter so it's not in the way
		}
	});
	
	//Sets the current page as active on the header menu
	$(".active").removeClass("active");
	$("#workOrderLink").addClass("active");
	
	function loadSearch() {
		var searchType = $("#searchType").val();
		switch(searchType) {
			case "name":
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
				sorter = [[1,0]]; 
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
					tagArray[i] = obj[i]['wo_city'];
				}
				searchField = "wo_city";
				sorter = [[3,0]];
				break;
			case "address":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = obj[i]['wo_address'];
				}
				searchField = "wo_address";
				sorter = [[4,0]];
				break;
			case "date":
				for(var i=0;  i < custNum; i++) {
					tagArray[i] = ""; //obj[i]['wo_date'] if we do want autocomplete for dates.
				}
				searchField = "wo_date";
				sorter = [[0,0]];
				break;
		}
		
		//replaces NULL values with an empty string, otherwise the autocomplete breaks.
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
	function getSearchResults() {
		$(function() {
			var searchQuery = $("#searchbar").val();
			if(searchQuery == "") {
				alert("Please input something to search by");
				return;
			}
			
			$.ajax({
				type: "POST",
				url: home + "index.php/workOrderSearch/showresults", //Need to specify full path, incase we're on the page from a different url
				data: { "searchQ" : searchQuery,
					    "searchType" : searchField
					
				},
				success: function(data) {
					$("#id_result_table").html(data);
					$("#result-table").tablesorter({
						sortList: sorter,
						headers: { 0 : { sorter: "shortDate" } } // Makes the first column sort dates properly
					});
				}, 
				error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
			});
		});
	}
	
	
	//When you click on a row, it will bring you to the workorder page and send the wo_id over
	function openWorkOrder(id) {
		var url = home + "index.php/workorderform/openWorkOrder/" + id;
		var page = window.open(url, '_blank');
		page.focus();
		//alert("You've opened work order: " + id);
	}
	
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