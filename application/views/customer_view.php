		<?php
		    $home = base_url();
		?>
		        
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/customer.css">
		
		<div class="container cust-container">
			<h1>Customers</h1>
			<select id="searchType" onchange="loadSearch()">
				<option value="name">Name</option>
				<option value="company">Company</option>
				<option value="city">City</option>
				<option value="address">Address</option>
				<option value="phone">Phone #</option>
			</select>
			<input id="searchbar" placeholder="Search..." />
			<button id="id_search_button" class="btn btn-primary" onclick="getSearchResults()">Search</button>
			<div id="id_result_table"></div>
		</div>
		
		<script>
			var testTable = "<table class='table'><tr><th>First Name</th><th>Last Name</th><th>Company</th></tr><tr><td>John</td><td>Johnson</td><td>Johnson Industries</td></tr><tr><td>Mary</td><td>Poppins</td><td>MP Ltd.</td></tr></table>";
			var testNameTags = ["John", "Mary", "Greg", "Phil", "Bob", "Jenn",]
			
			function loadSearch() {
				$(function() {
					$("#searchbar").autocomplete({
						source: testNameTags
					});
				});
			}
			
			function getSearchResults() {
				$("#id_result_table").html(testTable);
			}
			
		</script>
		
	</body>
</html>