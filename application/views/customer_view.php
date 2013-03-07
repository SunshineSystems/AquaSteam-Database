		<?php
		    $home = base_url();
		?>
		        
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/customer.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/table css/style.css">
		
		<div class="container cust-container">
			<h1>Customers</h1>
			<select id="searchType" onchange="loadSearch()">
				<option value="name" selected="selected">Name</option>
				<option value="company">Company</option>
				<option value="city">City</option>
				<option value="address">Address</option>
				<option value="phone">Phone #</option>
			</select>
			<input id="searchbar" placeholder="Search..." onClick="this.select();"/>
			<button id="id_search_button" class="btn btn-primary" onclick="getSearchResults()">Search</button>
			<div><button id="id_newCust_button" class="btn btn-large btn-primary" onclick="newCustomer()">Create New Customer</button></div>
			<div id="id_result_table"></div>
		</div>
		
		<div id="dialog_customer_form"> <!--Creates the form that will be in the dialog box -->
			<div id="cust_form_container">
				<div id="message_container"></div>
				<div class="field-row">
					<label>Cust ID:</label>
					<input id="custID" type="text" placeholder="######" readonly/>
				</div>
				<div class="field-row">		
					<label>Company:</label>
					<input id="custCompany" type="text"/>
				</div>
				<div class="field-row">
					<label>First Name:</label>
					<input id="custFName" type="text"/>
				</div>
				<div class="field-row">		
					<label>Last Name:</label>
					<input id="custLName" type="text"/>
				</div>
				<div class="field-row">
					<label>Personal Address:</label>
					<input id="custAddress" type="text"/>
				</div>
				<div class="field-row">		
					<label>City:</label>
					<input id="custCity" type="text"/>
				</div>
				<div class="field-row">
					<label>Province:</label>
					<input id="custProvince" type="text" value="AB"/>
				</div>
				<div class="field-row">		
					<label>Postal Code:</label>
					<input id="custPCode" type="text"/>
				</div>
				<div class="field-row">
					<label>Home Phone:</label>
					<input id="custHPhone" type="text" value="403-"/>
				</div>
				<div class="field-row">		
					<label>Business Phone:</label>
					<input id="custBPhone" type="text" value="403-"/>
				</div>
				<div class="field-row">
					<label>Cell Phone:</label>
					<input id="custCPhone" type="text" value="403-"/>
				</div>
				<div class="field-row">		
					<label>Email:</label>
					<input id="custEmail" type="text"/>
				</div>
				<div class="field-long-row">		
					<label>Referral:</label>
					<input id="custRef" type="text"/>
				</div>
				<div class="field-long-row">		
					<label>Notes:</label>
					<textarea id="custNotes" rows="3" cols="200"></textarea>
				</div>
			</div>
		</div> <!--Dialog End-->
		
		
		<script>
			var json = <?php echo $tags;?>;
			var custNum = <?php echo $custNum; ?>;
			
			var obj = eval (json);
		</script>
		<script src="<?php echo $home?>js/jquery.tablesorter.js"></script>
		<script src="<?php echo $home?>js/customer.js"></script>
	</body>
</html>