<?php 
    $this->load->helper('url'); 
    $home = base_url();
	$home = str_replace(" ", "-", $home);
?>
<html>
    <head>
        <title>Admin Main Menu</title>
    </head>
    <body>
        <script src="js/jquery-1.9.1.js"></script>
        
        <h1>AquaStem Employee Main Menu</h1>
        <div id="adminForm" >
            <button id="customersButton" onclick="loadCustomers()">Customers</button><br>
            <button id="viewWorkOrdersButton" onclick="loadWorkOrders()">View Work Orders</button><br>
            <button id="PrintBlankWorkOrderButton" onclick="printBlankWorkOrders()">Print Blank Work Order</button><br>
    		<button id="changePasswordButton" onclick="loadPasswordChange()">Change Password</button><br>
            <button id="googleCalendarButton" onclick="loadGoogleCalendars()">Google Calendar</button><br>
            <button id="logoutButton" onclick="logout()">Logout and Exit</button>
        </div>
    </body>
</html>