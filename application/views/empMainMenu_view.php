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
		     	<a class="btn" href="<?php echo $home?>index.php/changePassword">Change Password</a><br>
		     	<a class="btn" href="https://www.google.com/calendar" target="_blank">Google Calendar</a><br>
		     	<a class="btn" href="<?php echo $home?>">Logout</a><br>
			</div>
		</div>
	</body>    
</html>
