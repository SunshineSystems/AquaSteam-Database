var testTable = "<table id='resultTable'class='tablesorter table-striped table-hover'><thead><tr><th>First Name</th><th>Last Name</th><th>Company</th></tr></thead><tbody><tr><td>John</td><td>Johnson</td><td>Johnson Industries</td></tr><tr><td>Mary</td><td>Poppins</td><td>MP Ltd.</td></tr><tr><td>Jim</td><td>Bobson</td><td>Generic Inc.</td></tr><tr><td>Terry</td><td>Poppins</td><td>somecomany</td></tr></tbody></table>";
var testNameTags = ["John", "Mary", "Greg", "Phil", "Bob", "Jenn",]
$("#searchbar").autocomplete({
	source: testNameTags
});

//Sets the customers page as active on the header menu
$(".active").removeClass("active");
$("#customerLink").addClass("active");

function loadSearch() {
	$(function() {
		$("#searchbar").autocomplete({
			source: testNameTags
		});
	});
}

function getSearchResults() {
	$(function() {
		$("#id_result_table").html(testTable);
		$("#resultTable").tablesorter();
	});
}

function newCustomer() {
	$("#dialog_customer_form").dialog({
	    title: "Create New Customer",
	    height: 725,
	    width: 850,
	    modal: true,
	    buttons: {
	        save: function () {
	            $(this).dialog("close");
	        },
	        cancel: function () {
	            $(this).dialog("close");
	        }
	    }
	});
	$("#dialog_customer_form").dialog("open");
}
