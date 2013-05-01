		<?php
		    $home = base_url();
		?>
		        
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/customer.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/table css/style.css">
		
		<div class="container cust-container">
			
			<div id="search-div" class="hidden">
				<div class="search-container">
					<h4>Search Help</h4></br>
						<p><b>Name:</b> Searches for customers by their first and/or last name e.g John Doe.</p></br>
						<p><b>Company:</b> Searches for customers by their company name.</p></br>
						<p><b>City:</b> Searches for customers by their city.</p></br>
						<p><b>Address:</b> Searches customers by their address.</p></br>
						<p><b>Phone Number:</b> Searches for customers by their home, business, and cell phone numbers. When searching, input must contain dashes. i.e. XXX-XXX-XXXX.</p></br>
				</div>
			</div>
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
			<div>
				<button id="id_newCust_button" class="btn btn-large btn-primary" onclick="newCustomer()">Create New Customer</button>
				<button id="id_searchTips_button" class="btn btn-large btn-info" onclick="showTips()">Show Search Help</button>
			</div>
			<div id="id_result_table"><?php if(isset($_POST['alert-data'])) { echo $_POST['alert-data']; }?></div>
			
		</div>
		
		<!--Hidden form that contains will contain the alert code after a customer is saved/deleted-->
		<form id="alert-form" method="POST">
			<input id="alert-data" name="alert-data" type="hidden"/>
		</form>
		
		<div id="dialog_customer_form"> <!--Creates the form that will be in the dialog box -->
			<div id="cust_form_container">
				<div class="field-row">
					<label>Cust ID:</label>
					<input id="custID" type="text" placeholder="######" readonly/>
				</div>
				<div class="field-row">		
					<label>Company:</label>
					<input id="custCompany" type="text" maxlength="75"/>
				</div>
				<div class="field-row">
					<label>First Name:</label>
					<input id="custFName" type="text" maxlength="50"/>
				</div>
				<div class="field-row">		
					<label>Last Name:</label>
					<input id="custLName" type="text" maxlength="50"/>
				</div>
				<div class="field-row">
					<label>Address:</label>
					<input id="custAddress" type="text" maxlength="150"/>
				</div>
				<div class="field-row">		
					<label>City:</label>
					<input id="custCity" type="text" value="Lethbridge" maxlength="20"/>
				</div>
				<div class="field-row">
					<label>Province:</label>
					<input id="custProvince" type="text" value="AB" maxlength="2"/>
				</div>
				<div class="field-row">		
					<label>Postal Code:</label>
					<input id="custPCode" type="text" maxlength="7"/>
				</div>
				<div class="field-row">
					<label>Home Phone:</label>
					<input id="custHPhone" type="text" value="403-" maxlength="12"/>
				</div>
				<div class="field-row">		
					<label>Business Phone:</label>
					<input id="custBPhone" type="text" value="403-" maxlength="12"/>
				</div>
				<div class="field-row">
					<label>Cell Phone:</label>
					<input id="custCPhone" type="text" value="403-" maxlength="12"/>
				</div>
				<div class="field-row">		
					<label>Email:</label>
					<input id="custEmail" type="text" maxlength="100"/>
				</div>
				<div class="field-long-row">		
					<label>Referral:</label>
					<input id="custRef" type="text" maxlength="75"/>
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
			var home = "<?php echo $home; ?>";
		</script>
		<script src="<?php echo $home?>js/jquery.tablesorter.js"></script>
		<script src="<?php echo $home?>js/customer.js"></script>
		<script>
			<?php if(isset($id)) echo "openCustomer($id);";?>
		</script>
	</body>
</html>