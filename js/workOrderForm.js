
	
	//Sets the current page as active on the header menu
	$(".active").removeClass("active");
	$("#workOrderLink").addClass("active");
	
 	$(function() {
		$( "#datepicker" ).datepicker();
	});
 
 	
 
 	$(function() {
		$( "#tabs" ).tabs();
	});
	
	//Runs all of the data calculations on page load
	runAllCalcs();
	
	//Calculates total in Travel Tab when the values have changed, and the changed input has lost focus.
	$('#travelDist').change(function() {
		calcTravel();
	});
	
	$('#travelPrice').change(function() {
		calcTravel();
	});
    
    function saveWorkOrder() {
    	var woID = $('#workOrderID').val();
    	var custID = $('#custID').val();
    	var woAddress = $('#woAddress').val();
    	var woCity = $('#woCity').val();
    	var woProv = $('#woProvince').val();
    	var woPCode = $('#woPCode').val();
    	var woPhone = $('#woPhone').val();
    	var woNotes = $('#woNotes').val();
    	var payGift = $('#workOrderGift').val();
    	var woDate = $('#datepicker').val();
    	var payDiscount = $('#workOrderDiscount').val();
    	if (payDiscount == "") payDiscount = 0;
    	var payDiscountType = $('#workOrderDiscountType').val();
    	var travelDistance = $('#travelDist').val();
    	if(!isValidNum(travelDistance)) travelDistance = 0;
    	var travelPrice = $('#travelPrice').val();
    	if(!isValidNum(travelPrice)) travelPrice = 0;
    	//Checks to see which checkboxes are checked, and assigns it's variable as either 1 or 0 based on that, to be
    	//entered into the database.
    	if($('#woRX').is(':checked')) var woRX = 1;
    	else var woRX = 0;
    	if($('#woFan').is(':checked')) var woFan = 1;
    	else var woFan = 0;
    	if($('#woRake').is(':checked')) var woRake = 1;
    	else var woRake = 0;
    	if($('#woPad').is(':checked')) var woPad = 1;
    	else var woPad = 0;
    	if($('#woEncapsulate').is(':checked')) var woEncap = 1;
    	else var woEncap = 0;
    	if($('#woForm').is(':checked')) var woForm = 1;
    	else var woForm = 0;
    	
    	if($('#payCash').is(':checked')) var payCash = 1;
    	else var payCash = 0;
    	if($('#payCheque').is(':checked')) var payCheque = 1;
    	else var payCheque = 0;
    	if($('#payCC').is(':checked')) var payCC = 1;
    	else var payCC = 0;
    	if($('#payCharge').is(':checked')) var payCharge = 1;
    	else var payCharge = 0;
    	var payOther = $('#payOther').val();
    	
    	
    	$.ajax({
			type: "POST",
			url: home + "index.php/workOrderForm/saveWorkOrder",
			data: { "woID" : woID,     					   "payGift" : payGift, 		"woDate" : woDate,
					"payDiscountType" : payDiscountType,   "woAddress" : woAddress, 	"woCity" : woCity,
					"woProv" : woProv,     				   "woPCode" : woPCode,     	"woPhone" : woPhone,
					"payDiscount" : payDiscount, 		   "woRX" : woRX,   			"woFan" : woFan,
					"woRake" : woRake,					   "woPad" : woPad, 			"woEncap" : woEncap,
					"woForm" : woForm, 					   "payCash" : payCash, 		"payCheque" : payCheque,
					"payCC" : payCC, 					   "payCharge" : payCharge, 	"payOther" : payOther,
					"custID" : custID, 					   "woNotes" : woNotes,			"travelDistance" : travelDistance,
					"travelPrice" : travelPrice
			},
			success: function(data) {
				$("#alert-div").html(data);
				
				//If It saves a new customer, then load that work order's page', and display the success feedback.
				//Checks for hidden input, that is only output when a new workorder is saved.
				if($("#new-woID-val").length) {
					var url = home + "index.php/workorderform/openWorkOrder/" + $("#new-woID-val").val();
					$("#alert-data").val(data);
					$("#alert-form").attr({'action': url}); //Sets the action of the form, to the new work order's url.
					document.getElementById("alert-form").submit();
				}
				else {
					window.scrollTo(0,0);
				}
			}, 
			error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
		});
    }
    
    //Clears information specific to an individual work order, so that they may save a new one with the consistent
    //information.
    function startAsNew() {
    	$('#workOrderID').val("");
    	$('#workOrderGift').val("");
    	$('#datepicker').val("");
    	$('#workOrderDiscount').val("");
    	$('#dollar-option').attr('selected', false);
    	$('#percent-option').attr('selected', true);
    	$('#payCash').attr('checked', false);
    	$('#payCheque').attr('checked', false);
    	$('#payCC').attr('checked', false);
    	$('#payCharge').attr('checked', false);
    	$('#payOther').val("");
    	$('#woRX').attr('checked', false);
    	$('#woFan').attr('checked', false);
    	$('#woRake').attr('checked', false);
    	$('#woPad').attr('checked', false);
    	$('#woEncapsulate').attr('checked', false);
    	$('#woForm').attr('checked', false);
    }
    
    function printWorkOrder() {
    	alert("This will open a printable PDF in a new tab with the formatted work order");
    }
    
    function deleteWorkOrder() {
    	var id = $("#workOrderID").val();
    	if(id == "") {
    		alert("You can't delete what don't exist son");
    		return;
    	}
    	
    	if(confirm("Are you sure you want to delete this work order?\n" +
		    					"This will permanently remove them from the database...")) 
		{
			$.ajax({
				type: "POST",
				url: home + "index.php/workOrderForm/deleteWorkOrder",
				data: { "id" : id},
				success: function(data) {
					var url = home + "index.php/workordersearch"
					$("#alert-data").val(data);
					$("#alert-form").attr({'action': url}); //Sets the action of the form, to the work order search's url.
					document.getElementById("alert-form").submit();
				}, 
				error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
			});
		}
    }
    
    function calcTravel() {
    	var distance = $('#travelDist').val();
    	var rate = $('#travelPrice').val();

		//Makes sure distance and rate are valid numbers, and don't have any non number characters in their field
    	if(!isNaN(distance) && !isNaN(rate) && !isNaN(parseFloat(distance)) && !isNaN(parseFloat(rate))) {
    		var total = parseFloat(distance) * parseFloat(rate);
    		var roundedTotal = total.toFixed(2);
    		$('#travelTotal').val(roundedTotal);
    	}
    	else {
    		$('#travelTotal').val("0.00");
    	}
    }
    
    //Returns true if the passed variable contains nothing but number characters.
    function isValidNum(value) {
    	
		//Makes sure distance and rate are valid numbers, and don't have any non number characters in their field
    	if(!isNaN(value) && !isNaN(parseFloat(value))) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    
    //Goes through each row, and calculates the square feet by multiplying the values in that rows length/width cells.
    function calcSqFt(i) {
    	$("#service-table tr").each(function(i) {
    		var length = $('tr:nth-child('+(i+1)+')>td:nth-child(3)').text();
    		var width = $('tr:nth-child('+(i+1)+')>td:nth-child(4)').text();
    		
    		if(isValidNum(length) && isValidNum(width)) {
    			var total = length * width;
    			var roundedTotal = total.toFixed(2);
    			$('tr:nth-child('+(i+1)+')>td:nth-child(5)').text(roundedTotal);
    		}
    		else {
    			$('tr:nth-child('+(i+1)+')>td:nth-child(5)').text("0.00");
    		}
    	});
    	
    	$("#upholstery-table tr").each(function(i) {
    		var length = $('tr:nth-child('+(i+1)+')>td:nth-child(3)').text();
    		var width = $('tr:nth-child('+(i+1)+')>td:nth-child(4)').text();
    		
    		if(isValidNum(length) && isValidNum(width)) {
    			var total = length * width;
    			var roundedTotal = total.toFixed(2);
    			$('tr:nth-child('+(i+1)+')>td:nth-child(5)').text(roundedTotal);
    		}
    		else {
    			$('tr:nth-child('+(i+1)+')>td:nth-child(5)').text("0.00");
    		}
    	});
    	
    	$("#stainguard-table tr").each(function(i) {
    		var length = $('tr:nth-child('+(i+1)+')>td:nth-child(3)').text();
    		var width = $('tr:nth-child('+(i+1)+')>td:nth-child(4)').text();
    		
    		if(isValidNum(length) && isValidNum(width)) {
    			var total = length * width;
    			var roundedTotal = total.toFixed(2);
    			$('tr:nth-child('+(i+1)+')>td:nth-child(5)').text(roundedTotal);
    		}
    		else {
    			$('tr:nth-child('+(i+1)+')>td:nth-child(5)').text("0.00");
    		}
    	});
    }
    
    //Goes through each row in the data tables, and calculates the extended price by multiplying quantity by unit price.
    function calcExtPrice() {
    	$("#service-table tr").each(function(i) {
    		var quantity = $('tr:nth-child('+(i+1)+')>td:nth-child(6)').text();
    		var price = $('tr:nth-child('+(i+1)+')>td:nth-child(7)').text();
    		
    		if(isValidNum(quantity) && isValidNum(price)) {
    			var total = quantity * price;
    			var roundedTotal = total.toFixed(2);
    			$('tr:nth-child('+(i+1)+')>td:nth-child(8)').text(roundedTotal);
    		}
    		else {
    			$('tr:nth-child('+(i+1)+')>td:nth-child(8)').text("0.00");
    		}
    	});
    	
    	$("#upholstery-table tr").each(function(i) {
    		var quantity = $('tr:nth-child('+(i+1)+')>td:nth-child(6)').text();
    		var price = $('tr:nth-child('+(i+1)+')>td:nth-child(7)').text();
    		
    		if(isValidNum(quantity) && isValidNum(price)) {
    			var total = quantity * price;
    			var roundedTotal = total.toFixed(2);
    			$('tr:nth-child('+(i+1)+')>td:nth-child(8)').text(roundedTotal);
    		}
    		else {
    			$('tr:nth-child('+(i+1)+')>td:nth-child(8)').text("0.00");
    		}
    	});
    	
    	$("#stainguard-table tr").each(function(i) {
    		var quantity = $('tr:nth-child('+(i+1)+')>td:nth-child(3)').text();
    		var price = $('tr:nth-child('+(i+1)+')>td:nth-child(7)').text();
    		
    		if(isValidNum(quantity) && isValidNum(price)) {
    			var total = quantity * price;
    			var roundedTotal = total.toFixed(2);
    			$('tr:nth-child('+(i+1)+')>td:nth-child(8)').text(roundedTotal);
    		}
    		else {
    			$('tr:nth-child('+(i+1)+')>td:nth-child(8)').text("0.00");
    		}
    	});
    }
    
    /* WORK IN PROGRESS
	function calcTotalTabPrice() {
		var serviceTotal = 0;
		var upholsteryTotal = 0;
		var stainguardTotal = 0;
		
		$("#service-table tr").each(function(i) {
			alert("here");
			var rowPrice = $('tr:nth-child('+(i+1)+')>td:nth-child(8)').text();
			if(isValidNum(rowPrice)) {
				serviceTotal += rowPrice;
				var roundedTotal = serviceTotal.toFixed(2);
				$("#total-service-price").val(roundedTotal);
				alert("hello");
			}
			else {
				$("#total-service-price").val("0.00");
				alert("nope");
			}	
		});
	}
	*/
    
    function runAllCalcs() {
    	calcTravel();
		calcSqFt();
		calcExtPrice();
		calcTotalTabPrice();
    }
    
    /************************************************************************************************/
    /*		     	 *This section of code will handle all of the table editing stuff*              */
    /*                                                                                              */
    /************************************************************************************************/
	$(function() {
	    $('td.editable').click(function(){
	    	
	    	//Prevents input from clearing if clicked twice
	    	var cellText = $(this).text();
	    	if(cellText == 0) {
	    		cellText = $('#editbox').val();
	    	}
	    	
	    	var htmlData = '<input id="editbox" type="text" value="' +  cellText + '">';
	 		$('.ajax').html($('.ajax input').val());  
	 		$('.ajax').removeClass('ajax');  
	  
	 		$(this).addClass('ajax');  
	 		$(this).html(htmlData);  
	  		
	  		//Puts the cursor at the end of the input value, instead of highlighting it all
			$('#editbox').focus(function() {
				this.selectionStart = this.selectionEnd = this.value.length;
			});
			
			$('#editbox').focus();
		});
	});
	
	//When enter is hit while editing a cell, the value of that cell is updated in the database.
	$(function() {
		$('td.editable').keydown(function(event){  
		    var value = $('.ajax input').val();
		    //Puts all of the classes into an array, to be passed to the controller.
		    var data = $(this).attr('class').split( " " );
		    //data[0] = editable
		    //data[1] = table name
		    //data[2] = table field
		    //data[3] = primary key
		    
		    if(event.keyCode == 13)  
		   	{  
				$.ajax({    
					type: "POST",  
					url: home + "index.php/workOrderForm/updateTabTable",   
					data: {
						'id' : data[3], 'field' : data[2], 'table' : data[1], 'value' : value
					},
					success: function(data){ 
						alert(data); 
						$('.ajax').html($('.ajax input').val());  
						$('.ajax').removeClass('ajax');  
				  	},
				  	error: function(xhr) {
						alert("An error occured: " + xhr.status + " " + xhr.statusText);
					}
		    	});  
		    } 
		});
	}); 
	
	//Removes the input box when it is no longer focused.
	$(function() {
		$(document).on('blur', '#editbox', function(){
			$('.ajax').html($('.ajax input').val());
			$('.ajax').removeClass('ajax');
		});
	});
	
	//Appends an empty row to the open table, and saves a new record into the database for that blank row
	function addTableRow(woID, tableType) {
		
		$.ajax({    
				type: "POST",  
				url: home + "index.php/workOrderForm/newTableRow",   
				data: {
					'woID' : woID, 'table' : tableType
				},
				success: function(data){ 
					$('#carpetTab').html(data);
			  	},
			  	error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
	    	});
	}
	/************************************************************************************************/
    /*		                         *End of table editing functions*                               */
    /*                                                                                              */
    /************************************************************************************************/
	

	
    
    

 