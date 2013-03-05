<?php  
    $home = base_url();
?>     
     <h1>Admin Main Menu</h1>
     <ul>
     	<li id="customerLink"><a href="<?php echo $home?>/index.php/customer">Customers</a></li><br>
     	<li id="workOrderLink"><a href="<?php echo $home?>/index.php/workOrder">Work Orders</a></li><br>
     	<li id="printWorkOrderLink"><a href="<?php echo $home?>/index.php/printWorkOrder">Print Blank Work Order</a></li><br>
     	<li id="manageAccountsLink"><a href="<?php echo $home?>/index.php/manageAccounts">Manage Accounts</a></li><br>
     	<li id="googleCalendarLink"><a href="https://www.google.com/calendar">Google Calendar</a></li><br>
     	<li id="logoutLink"><a href="<?php echo $home?>/index.php/logout">Logout</a></li><br>

  </body>    
</html>