<?php
    $home = base_url();
?>
		        
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/manageAccount.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/table css/style.css">
        
        <!-- Keep all displayed content inside container div -->
        <div class="container account-container">
	    	<h1>Manage Accounts</h1>
			<div><button id="id_account_button" class="btn btn-large btn-primary" onclick="newAccount()">Create New Account</button></div>
			<div id="alert-div"></div>
			<div id="accounts-table"></div>
	    </div>
	    
	    <div id="dialog_account_form">
	    	<div id="account_form_container">
				<div class="field-row">
					<label>User ID:</label>
					<input id="userID" type="text" placeholder="######" readonly/>
				</div>
				<div class="field-row">
					<label>User Type:</label>
					<select id="userType">
						<option value="Employee" selected="selected">Employee</option>
						<option value="Admin">Admin</option>
					</select>
				</div>
				<div class="field-row">
					<label>Username:</label>
					<input id="userUName" type="text" maxlength="20"/>
				</div>
				<div class="field-row">
					<label>New Password:</label>
					<input id="userPass" type="password"/>
				</div>
				<div class="field-row">
					<label>First Name:</label>
					<input id="userFName" type="text" maxlength="20"/>
				</div>
				<div class="field-row">		
					<label>Last Name:</label>
					<input id="userLName" type="text" maxlength="20"/>
				</div>
				<div class="field-row">
					<label>Address:</label>
					<input id="userAddress" type="text" maxlength="30"/>
				</div>
				<div class="field-row">		
					<label>City:</label>
					<input id="userCity" type="text" value="Lethbridge" maxlength="20"/>
				</div>
				<div class="field-row">
					<label>Province:</label>
					<input id="userProvince" type="text" value="AB" maxlength="2"/>
				</div>
				<div class="field-row">		
					<label>Postal Code:</label>
					<input id="userPCode" type="text" maxlength="7"/>
				</div>
				<div class="field-row">
					<label>Home Phone:</label>
					<input id="userHPhone" type="text" value="403-" maxlength="12"/>
				</div>
				<div class="field-row">
					<label>Cell Phone:</label>
					<input id="userCPhone" type="text" value="403-" maxlength="12"/>
				</div>
				<div class="field-long-row">		
					<label>Notes:</label>
					<textarea id="userNotes" rows="3" cols="200"></textarea>
				</div>
			</div>
	    </div>
	    <script src="<?php echo $home?>js/jquery.tablesorter.js"></script>
	    <script src="<?php echo $home?>js/manageAccount.js"></script>
    </body>
</html>