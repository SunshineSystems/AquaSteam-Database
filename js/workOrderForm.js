
	
	//Sets the current page as active on the header menu
	$(".active").removeClass("active");
	$("#workOrderLink").addClass("active");
	
 	$(function() {
		$( "#datepicker" ).datepicker();
	});
 
 	$(function() {
		$( "#tabs" ).tabs();
	});
	
// bind our event handler to all td elements with class editable
    $('td.editable').click(function() {
        // Only create an editable input if one doesn't exist
        if(!$(this).has('input').length) {
            // Get the text from the cell containing the value
            var value = $(this).html();
            // Create a new input element with the value of the cell text
            var input = $('<input/>', {
                'type':'text',
                'value':value,
                // Give it an onchange handler so when the data is changed
                // It will do the ajax call
                change: function() {
                    var new_value = $(this).val();
                    // This finds the sibling td element with class identifier so we have
                    // an id to pass to the ajax call
                    var cell = $(this).parent();
                    // Get the position of the td cell...
                    var cell_index = $(this).parent().parent().children().index(cell);
                    // .. to find its corresponding header
                    var identifier = $('thead th:eq('+cell_index+')').html();
                    //ajax post with id and new value
                    $(this).replaceWith(new_value);
                }
            });
            // Empty out the cell contents...
            $(this).empty();
            // ... and replace it with the input field that has the value populated
            $(this).append(input);
        }
    });
    
    function saveWorkOrder() {
    	var woID = $('#workOrderID').val();
    	var custID = $('#custID').val();
    	var woAddress = $('#woAddress').val();
    	var woCity = $('#woCity').val();
    	var woProv = $('#woProvince').val();
    	var woPCode = $('#woPCode').val();
    	var woPhone = $('#woPhone').val();
    	var payGift = $('#workOrderGift').val();
    	var woDate = $('#datepicker').val();
    	var payDiscount = $('#workOrderDiscount').val();
    	var payDiscountType = $('#workOrderDiscountType').val();
    	
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
					"custID" : custID
			},
			success: function(data) {
				$("#alert-div").html(data);
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
					alert("Work Order Deleted:\nNeed to do something after deleted, cuz this isn't good enough.")
				}, 
				error: function(xhr) {
					alert("An error occured: " + xhr.status + " " + xhr.statusText);
				}
			});
		}
    }


 