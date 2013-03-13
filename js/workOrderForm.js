
	
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
    	alert("This will save the updated/new work order to the database");
    }
    
    function startAsNew() {
    	alert("This will clear all of the job specific information, but retain the consistent info\n" +
    			"such as customer/location information, so that they can create a new workorder for an existing location.");
    }
    
    function printWorkOrder() {
    	alert("This will open a printable PDF in a new tab with the formatted work order");
    }
    
    function deleteWorkOrder() {
    	if(confirm("Are you sure you want to delete this work order?\n" +
		    					"This will permanently remove them from the database...")) {
			alert("The Work Order Has Been Deleted!\n...Once we've implemented the functionality");
		}
    }


 