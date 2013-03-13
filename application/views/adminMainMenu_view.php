<?php  
    $home = base_url();
?>     
		<link rel="stylesheet" type="text/css" href="<?php echo $home?>css/mainMenu.css">   
		<div class="container">
				<div class="mainMenu-container">   
				    <h2>Admin Main Menu</h2>
				
				 	<a class="btn" href="<?php echo $home?>index.php/customer">Customers</a><br>
				 	<a class="btn" href="<?php echo $home?>index.php/workOrdersearch">Work Orders</a><br>
				 	<!--<a class="btn" href="<?php echo $home?>index.php/printWorkOrder">Print Blank Work Order</a><br> -->
				 	<button class="btn" onclick="alertthing()" style="margin-top: 20px;">Print Blank Work Order</button>
				 	<a class="btn" href="<?php echo $home?>index.php/manageAccount">Manage Accounts</a><br>
				 	<a class="btn" href="https://www.google.com/calendar" target="_blank">Google Calendar</a><br>
				 	<a class="btn" href="<?php echo $home?>">Logout</a><br>
				</div>
		</div>
		<script>
			function alertthing() {
				alert("This will open a blank work order template in pdf format for them to print out");
			}
		</script>
 	</body>    
</html>