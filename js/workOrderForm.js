
	/**
	 * @file workOrderForm.js
	 * @brief Contains the javascript functions that are used by the workOrderForm_view.php file.
	 */
	
	//Sets the current page as active on the header menu
	$(".active").removeClass("active");
	$("#workOrderLink").addClass("active");
	
 	$(function() {
		$( "#datepicker" ).datepicker();
	});
 
 	$('.dropdown-toggle').dropdown()
 
 	$(function() {
		$( "#tabs" ).tabs();
	});
	
	//Runs all of the data calculations on page load
	runAllCalcs();
	
	//Calculates totals when the values have changed, and the changed input has lost focus.
	/**************************************************************************************/
	$('#travelDist').change(function() {
		runAllCalcs();
	});
	
	$('#travelPrice').change(function() {
		runAllCalcs();
	});
	
	$('#workOrderDiscount').change(function() {
		runAllCalcs();
	});
	
	$('#workOrderDiscountType').change(function() {
		runAllCalcs();
	});
    /**************************************************************************************/
   	
   	//When the user closes the window, we first call the checkUnsavedChanges function to make sure that
   	//there's no unsaved values that they've set.
   	$(window).bind('beforeunload', function() {
   		if(checkUnsavedChanges() == "unsaved") {
   			return 'There are unsaved changes, are you sure you want to close?';
   		}
   		else {
   			return null;
   		}
   	});
   	
   /**
    * Gets the values of all of the fields in the work order form, and passes them to the saveWorkOrder function in the controller.
    * It outputs the recieved success/error message to the #alert-div div. 
    */
    function saveWorkOrder() {
    	var woID = $('#workOrderID').val();
    	var custID = $('#custID').val();
    	var woAddress = $('#woAddress').val();
    	var woCity = $('#woCity').val();
    	var woProv = $('#woProvince').val();
    	var woPCode = $('#woPCode').val();
    	var woPhone = $('#woPhone').val();
    	var woNotes = $('#woNotes').val();
    	var woSpots = $('#woSpots').val();
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
    	if($('#payDebit').is(':checked')) var payDebit = 1;
    	else var payDebit = 0;
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
					"travelPrice" : travelPrice,		   "woSpots" : woSpots,			"payDebit" : payDebit
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

    /**
     * Clears information specific to an individial work order, and saves it as a new one so that a new work order may be 
     * worked on that has the same location/customer information. 
     */
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
    	$('#payDebit').attr('checked', false);
    	$('#payOther').val("");
    	$('#woRX').attr('checked', false);
    	$('#woFan').attr('checked', false);
    	$('#woRake').attr('checked', false);
    	$('#woPad').attr('checked', false);
    	$('#woEncapsulate').attr('checked', false);
    	$('#woForm').attr('checked', false);
    	$('tbody').html("");
    	saveWorkOrder();
    }
    
    /**
     * gets the value of the workorderID field, and passes it to the printWorkOrder function in the controller, to create a printable
     * PDF, and then opens the returned pdf in a new window.
     * 
     * CURRENTLY NOT IN USE 

    function printWorkOrder() {
    	var id = $("#workOrderID").val();
    	var url = home + "index.php/workorderform/printWorkOrder/" + id;
		var page = window.open(url, '_blank');
    }
    */
   
   /**
    * Gets the value of the customerID field, and passes it to the gotoCustomer() function in the controller,
    * and opens the page in a new window. 
    */
    function gotoCustomer() {
    	var id = $("#custID").val();
    	var url = home + "index.php/customer/gotoCustomer/" + id;
		var page = window.open(url, '_blank');
    }
    
    
    /**
     * Gets the value of the workorderID field. It confirms if the user really wants to delete the work order, and if yes
     * it passes the workorderID to the deleteWorkOrder() function in the controller to be deleted. If successful
     * the workorderSearch page is opened, and the success message is displayed there. 
     */
    function deleteWorkOrder() {
    	var id = $("#workOrderID").val();
    	if(id == "") {
    		alert("You can't delete a work order that doesn't exist");
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
    
    
    /**
     * Gets the values of the work order id, as well as all of the editable inputs that the user can save
     * and passes the values to the checkChanges function in the controller. That function compares the values in the form
     * to the values in the database and returns an appropriate message. This function returns that message. 
     */
    function checkUnsavedChanges() {
    	var woID = $('#workOrderID').val();
    	var woAddress = $('#woAddress').val();
    	var woCity = $('#woCity').val();
    	var woProv = $('#woProvince').val();
    	var woPCode = $('#woPCode').val();
    	var woPhone = $('#woPhone').val();
    	var woNotes = $('#woNotes').val();
    	var woSpots = $('#woSpots').val();
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
    	if($('#payDebit').is(':checked')) var payDebit = 1;
    	else var payDebit = 0;
    	var payOther = $('#payOther').val();
    	
    	var result = "";
    	$.ajax({
			type: "POST",
			async: false,
			url: home + "index.php/workOrderForm/checkChanges",
			data: { "woID" : woID,     					   "payGift" : payGift, 		"woDate" : woDate,
					"payDiscountType" : payDiscountType,   "woAddress" : woAddress, 	"woCity" : woCity,
					"woProv" : woProv,     				   "woPCode" : woPCode,     	"woPhone" : woPhone,
					"payDiscount" : payDiscount, 		   "woRX" : woRX,   			"woFan" : woFan,
					"woRake" : woRake,					   "woPad" : woPad, 			"woEncap" : woEncap,
					"woForm" : woForm, 					   "payCash" : payCash, 		"payCheque" : payCheque,
					"payCC" : payCC, 					   "payCharge" : payCharge, 	"payOther" : payOther,
					"woNotes" : woNotes,			       "travelDistance" : travelDistance,
					"travelPrice" : travelPrice,		   "woSpots" : woSpots,			"payDebit" : payDebit
			},
			success: function(data) {
				result = data; //If there's an unsaved change, data == "unsaved";
			},
			error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
		});
		return result;
  	}
    
    /**
     * Calculates the total travel price based on the value in the distance traveled field, and the travel rate field
     * and outputs the result to the travel total field. 
     */
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
    
    function openTaxRateForm() {
    	$('#new-tax-container').removeClass('hidden');
    	$('#tax-alert-container').html("");
    	$('#tax-alert-container').removeClass('success-alert');
    }
    
    function closeTaxRateForm() {
    	$('#new-tax-container').addClass('hidden');
    	$('#tax-alert-container').html("");
    	$('#tax-alert-container').removeClass('success-alert');
    }
    
    /**
     * Gets the value of the work order id and the new gst rate set by the user, from the form and passes
     * them to the controller function saveNewTax(). If the controller function successfully saves, we close
     * the tax rate form and display a success message.
     */
    function saveTaxRate() {
    	var id = $("#workOrderID").val();
    	var newRate = parseInt($("#new-tax-input").val());
    	
    	if(isValidNum(newRate) && newRate <= 100) {
			$.ajax({
				type: "POST",
				url: home + "index.php/workOrderForm/saveNewTax",
				data: { "id" : id, "newRate" : newRate},
				success: function(data) {
					//Creates the success alert to be displayed to the user.
					var successMessage = '<div class="alert alert-success">' +
											'<a class="close" data-dismiss="alert" href="#">&times;</a>' +
											'<p><strong>Success! </strong>The new tax rate has been saved for this work order(i.e. 0-100)</p>' +
										'</div>';
					closeTaxRateForm();
					$('#tax-alert-container').addClass('success-alert');			
					$('#tax-alert-container').html(successMessage);
					
					//Updates the displayed tax rate to the value that was just saved.
					$('#current-tax-perc').html('&nbsp;&nbsp;' +newRate+ '%');
					$("#new-tax-input").val(""); //Clears the new tax input.
					runAllCalcs();
				}, 
				error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
			});
    	}
    	else {
    		var errorMessage = '<div class="alert alert-error">' +
							'<a class="close" data-dismiss="alert" href="#">&times;</a>' +
							'<p><strong>Error! </strong>Please enter a valid percentage(i.e. 0-100)</p>' +
						'</div>';
						
			$('#tax-alert-container').html(errorMessage);
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

    /**
     * Goes through each row in the service/upholstery/stainguard/other tables, and calculates the square feet by multiplying
     * the values in that rows length and with fields, and outputting the results to the square feet column in each row. 
     */
    function calcSqFt(i) {
    	$("#service-table tbody tr").each(function(i) {
    		var length = $('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(3)').text();
    		var width = $('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(4)').text();
    		
    		if(isValidNum(length) && isValidNum(width)) {
    			var total = length * width;
    			var roundedTotal = total.toFixed(2);
    			$('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text(roundedTotal);
    		}
    		else {
    			$('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text("0.00");
    		}
    	});
    	
    	$("#upholstery-table tbody tr").each(function(i) {
    		var length = $('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(3)').text();
    		var width = $('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(4)').text();
    		
    		if(isValidNum(length) && isValidNum(width)) {
    			var total = length * width;
    			var roundedTotal = total.toFixed(2);
    			$('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text(roundedTotal);
    		}
    		else {
    			$('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text("0.00");
    		}
    	});
    	
    	$("#stainguard-table tbody tr").each(function(i) {
    		var length = $('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(3)').text();
    		var width = $('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(4)').text();
    		
    		if(isValidNum(length) && isValidNum(width)) {
    			var total = length * width;
    			var roundedTotal = total.toFixed(2);
    			$('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text(roundedTotal);
    		}
    		else {
    			$('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text("0.00");
    		}
    	});
    	
    	$("#other-table tbody tr").each(function(i) {
    		var length = $('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(3)').text();
    		var width = $('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(4)').text();
    		
    		if(isValidNum(length) && isValidNum(width)) {
    			var total = length * width;
    			var roundedTotal = total.toFixed(2);
    			$('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text(roundedTotal);
    		}
    		else {
    			$('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text("0.00");
    		}
    	});
    }
    
    /**
     * Goes through each row in the service/upholstery/stainguard/other tables, and calculates the extended price by multiplying
     * the values in that rows squarefeet, quantity, and unit price fields and outputting the results 
     * to the extended price column in each row. 
     */
    function calcExtPrice() {
    	$("#service-table tbody tr").each(function(i) {
    		var sqft = $('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text();
    		var quantity = $('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(6)').text();
    		var price = $('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(7)').text();
    		
    		if(isValidNum(quantity) && isValidNum(price) && isValidNum(sqft)) {
    			var total = sqft * quantity * price;
    			var roundedTotal = total.toFixed(2);
    			$('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text(roundedTotal);
    		}
    		else {
    			$('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text("0.00");
    		}
    	});
    	
    	$("#upholstery-table tbody tr").each(function(i) {
    		var sqft = $('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text();
    		var quantity = $('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(6)').text();
    		var price = $('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(7)').text();
    		
    		if(isValidNum(quantity) && isValidNum(price) && isValidNum(sqft)) {
    			var total = sqft * quantity * price;
    			var roundedTotal = total.toFixed(2);
    			$('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text(roundedTotal);
    		}
    		else {
    			$('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text("0.00");
    		}
    	});
    	
    	$("#stainguard-table tbody tr").each(function(i) {
    		var sqft = $('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text();
    		var quantity = $('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(6)').text();
    		var price = $('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(7)').text();
    		
    		if(isValidNum(quantity) && isValidNum(price) && isValidNum(sqft)) {
    			var total = sqft * quantity * price;
    			var roundedTotal = total.toFixed(2);
    			$('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text(roundedTotal);
    		}
    		else {
    			$('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text("0.00");
    		}
    	});
    	
    	$("#other-table tbody tr").each(function(i) {
    		var sqft = $('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text();
    		var quantity = $('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(6)').text();
    		var price = $('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(7)').text();
    		
    		if(isValidNum(quantity) && isValidNum(price) && isValidNum(sqft)) {
    			var total = sqft * quantity * price;
    			var roundedTotal = total.toFixed(2);
    			$('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text(roundedTotal);
    		}
    		else {
    			$('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text("0.00");
    		}
    	});
    }
    
    /**
     * For each data table, the function goes through each body row, and gets the value of the extended price column
     * and adds it to the total. Once it's gone through each row, it displays the total in the total talbe price field. 
     */
	function calcTotalTablePrice() {
		var serviceTotal = 0;
		var upholsteryTotal = 0;
		var stainguardTotal = 0;
		var otherTotal = 0;
		
		$("#service-table tbody tr").each(function(i) {
			var rowPrice = $('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text();
			if(isValidNum(rowPrice)) {
				serviceTotal += parseFloat(rowPrice);
				var roundedTotal = serviceTotal.toFixed(2);
				$("#total-service-price").val(roundedTotal);
			}
		});
		
		$("#upholstery-table tbody tr").each(function(i) {
			var rowPrice = $('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text();
			if(isValidNum(rowPrice)) {
				upholsteryTotal += parseFloat(rowPrice);
				var roundedTotal = upholsteryTotal.toFixed(2);
				$("#total-upholstery-price").val(roundedTotal);
			}
		});
		
		$("#stainguard-table tbody tr").each(function(i) {
			var rowPrice = $('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text();
			if(isValidNum(rowPrice)) {
				stainguardTotal += parseFloat(rowPrice);
				var roundedTotal = stainguardTotal.toFixed(2);
				$("#total-stainguard-price").val(roundedTotal);
			}	
		});
		
		$("#other-table tbody tr").each(function(i) {
			var rowPrice = $('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(8)').text();
			if(isValidNum(rowPrice)) {
				otherTotal += parseFloat(rowPrice);
				var roundedTotal = otherTotal.toFixed(2);
				$("#total-other-price").val(roundedTotal);
			}	
		});
	}
	
    /**
     * For each data table, the function goes through each body row, and gets the value of the square feet column
     * and adds it to the total. Once it's gone through each row, it displays the total in the total talbe sqft field. 
     */
	function calcTotalTableSqFt() {
		var serviceTotal = 0;
		var upholsteryTotal = 0;
		var stainguardTotal = 0;
		var otherTotal = 0;
		
		$("#service-table tbody tr").each(function(i) {
			var rowPrice = $('#service-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text();
			if(isValidNum(rowPrice)) {
				serviceTotal += parseFloat(rowPrice);
				var roundedTotal = serviceTotal.toFixed(2);
				$("#total-service-sqft").val(roundedTotal);
			}	
		});
		
		$("#upholstery-table tbody tr").each(function(i) {
			var rowPrice = $('#upholstery-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text();
			if(isValidNum(rowPrice)) {
				upholsteryTotal += parseFloat(rowPrice);
				var roundedTotal = upholsteryTotal.toFixed(2);
				$("#total-upholstery-sqft").val(roundedTotal);
			}	
		});
		
		$("#stainguard-table tbody tr").each(function(i) {
			var rowPrice = $('#stainguard-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text();
			if(isValidNum(rowPrice)) {
				stainguardTotal += parseFloat(rowPrice);
				var roundedTotal = stainguardTotal.toFixed(2);
				$("#total-stainguard-sqft").val(roundedTotal);
			}	
		});
		
		$("#other-table tbody tr").each(function(i) {
			var rowPrice = $('#other-table tbody tr:nth-child('+(i+1)+')>td:nth-child(5)').text();
			if(isValidNum(rowPrice)) {
				otherTotal += parseFloat(rowPrice);
				var roundedTotal = otherTotal.toFixed(2);
				$("#total-other-sqft").val(roundedTotal);
			}	
		});
	}
	
	/**
	 * Calculates the total price of the work order by adding all the total price fields in the work orders, and subtracting
	 * the discount. It displays the results in the Total Work Order Price field. Also calls the calcTotalTax function, which
	 * returns the total price of taxes that's added on to the total work order price.
	 */
	function calcTotalWOPrice() {
		var carpetTotal = $("#total-service-price").val();
		var upholsteryTotal = $("#total-upholstery-price").val();
		var stainGuardTotal = $("#total-stainguard-price").val();
		var otherTotal = $("#total-other-price").val();
		var travelTotal = $("#travelTotal").val();
		var discount = $("#workOrderDiscount").val();
		var discountType = $("#workOrderDiscountType").val();

		var totalPrice = parseFloat(carpetTotal) 
						   + parseFloat(upholsteryTotal) 
						   + parseFloat(stainGuardTotal) 
						   + parseFloat(otherTotal) 
						   + parseFloat(travelTotal);
		
		if(discountType == "$") { //If the discount is in dollars, just subtract the dollars.
			totalPrice -= parseFloat(discount);
		}
		else { // Else if the discount is in %, calculate the percentage of the total, and subtract it from the total's price.
			discount = parseFloat(discount);
			discount = discount.toFixed(2) / 100;
			var percentOff = totalPrice * discount;
			totalPrice -= percentOff;
		}
		
		//Passes the current total price to the CalcTotalTax function, to get the value of the tax.
		//The value of the tax is then added on to the total price.
		var taxTotal = calcTotalTax(totalPrice.toFixed(2));
		totalPrice += parseFloat(taxTotal);
		
		$("#total-wo-price").val(totalPrice.toFixed(2));
	}
	
	/**
	 * Calculates 
	 */
	function calcTotalTax(subTotal) {
		var percString = $('#current-tax-perc').html();
		
		//removes everything except for the digets from the percentage string.
		var diget = percString.match(/\d/g);
		diget = diget.join("");
		
		var totalTax = subTotal * diget/100;
		
		$("#total-wo-tax").val(totalTax.toFixed(2));
		return totalTax.toFixed(2);
	}
	
    /**
     * Runs all calculation functions at once. 
     */
    function runAllCalcs() {
    	calcTravel();
		calcSqFt();
		calcExtPrice();
		calcTotalTablePrice();
		calcTotalTableSqFt();
		calcTotalWOPrice();
    }
    
    /************************************************************************************************/
    /*		     	 *This section of code will handle all of the table editing stuff*              */
    /*                                                                                              */
    /************************************************************************************************/
	
	//When an editable table cell is clicked, an input box with the value of that td will show up inside of the cell.
	$(function() {
	    $(document).on("click", 'td.editable', function(){
	    	
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
	 		if($('#editbox').val() == "undefined") {
	    		$('#editbox').val("");
	    	}  
	  		
	  		//Puts the cursor at the end of the input value, instead of highlighting it all
			$('#editbox').focus(function() {
				this.selectionStart = this.selectionEnd = this.value.length;
			});
			
			$('#editbox').focus();
		});
	});
	
	//When enter is hit while editing a cell, the value of that cell is updated in the database.
	$(function() {
		$(document).on("keydown", 'td.editable', function(event){
		    if(event.keyCode == 13) {
		    	console.log(this);  
		   		updateTabTable(this);
		    } 
		});
	}); 
	
	//Removes the input box when it is no longer focused.
	$(function() {
		$(document).on('blur', '#editbox', function(){
			updateTabTable($(this).parent()); //Calls the updateTabTable function when the input box is blurred.
			$('.ajax').html($('.ajax input').val());
			$('.ajax').removeClass('ajax');
		});
	});
	
	//Takes the classes of the submitted element, and uses them to save the updated value to the database.
	function updateTabTable(selector) {
		var value = $('.ajax input').val();
	   
	    //Puts all of the classes into an array, to be passed to the controller.
	    var data = $(selector).attr('class').split( " " );
	    //data[0] = editable
	    //data[1] = table name
	    //data[2] = table field
	    //data[3] = primary key
	    //data[4] = data type
	    
	    //If the value in a number cell isn't a number, it defaults it back to 0.00, so that there are no errors saving to the database.
	    if(data[4] == "num" && isNaN(value)) {
	    	value = 0;
	    	$('.ajax input').val("0.00");
	    }
	    
		$.ajax({    
			type: "POST",  
			url: home + "index.php/workOrderForm/updateTabTable",   
			data: {
				'id' : data[3], 'field' : data[2], 'table' : data[1], 'value' : value
			},
			success: function(data){
				$('.ajax').html($('.ajax input').val());  
				$('.ajax').removeClass('ajax');
				runAllCalcs();  
		  	}
    	});
	}
	
	//Appends an empty row to the open table, and saves a new record into the database for that blank row
	function addTableRow(woID, tableType, tableTab) {
		
		$.ajax({    
			type: "POST",  
			url: home + "index.php/workOrderForm/newTableRow",   
			data: {
				'woID' : woID, 'table' : tableType
			},
			success: function(data){ 
				$(tableTab).html(data);
				runAllCalcs();
				
		  	},
		  	error: function(xhr) {
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
			}
    	});
	}
	
	/**
	 * Confirms if the user really wants to delete a row from the table, then passes the information of that table row
	 * to the deleteTableRow() function in the controller to have the table row deleted. 
	 * Outputs the returned data to the table tab that had the table updated, and runs all calculations again. 
	 */
	function deleteTableRow(id, woID, tableType, idName, tableTab) {
		if(confirm("Are you sure you want to permanently delete this row?")) {
			$.ajax({    
				type: "POST",  
				url: home + "index.php/workOrderForm/deleteTableRow",   
				data: {
					'id' : id, 'woID' : woID, 'table' : tableType, 'idName' : idName
				},
				success: function(data){ 
					$(tableTab).html(data);
					runAllCalcs();
			  	},
			  	error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
	    	});
    	}
	}
	/************************************************************************************************/
    /*		                         *End of table editing functions*                               */
    /*                                                                                              */
    /************************************************************************************************/
	

	
    
    

 