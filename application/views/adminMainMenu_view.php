<?php  
    $home = base_url();
?>     
		<link rel="stylesheet" type="text/css" href="<?php echo $home?>css/mainMenu.css">   
		<div class="container">
				<div class="mainMenu-container">   
				    <h2>Main Menu</h2>
				
				 	<a class="btn" href="<?php echo $home?>index.php/customer">Customers</a><br>
				 	<a class="btn" href="<?php echo $home?>index.php/workOrderSearch">Work Orders</a><br>
				 	<a class="btn" href="<?php echo $home?>documents/Work Order.pdf">Print Blank Work Order</a><br>
				 	<a class="btn" href="<?php echo $home?>index.php/manageAccount">Manage Accounts</a><br>
				 	<a class="btn" href="https://www.google.com/calendar" target="_blank">Google Calendar</a><br>
				 	<a class="btn" href="<?php echo $home?>index.php/login">Logout</a><br>
				</div>
		</div>
		<script>
			function alertthing() {
				alert("This will open a blank work order template in pdf format for them to print out");
			}
		</script>
		
		<div id="footer">
    	<div class="container-footer">
    		<div id="aqualogo">
    			<img src="<?php echo $home; ?>images/New Aqua Logo Web.png" alt="Aqua Steam Logo">
    		</div>
    		<div id="sunshinelogo">
    			<img src="<?php echo $home; ?>images/logo2.png" alt="Sunshine Systems Logo">
    		</div>
    	</div>
 	</body>    
</html>