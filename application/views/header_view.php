<?php 
    $this->load->helper('url'); 
    $home = base_url();
	$home = str_replace(" ", "-", $home);
?>
<html>
    <head>
        <title>Header</title>
    </head>
    <body>
        <script src="js/jquery-1.9.1.js"></script>
        
        
        <div id="headerForm" >
            <button id="customersButton" onclick="loadCustomers()">Customers</button>
            <button id="viewWorkOrdersButton" onclick="loadWorkOrders()">View Work Orders</button>
            <button id="PrintBlankWorkOrderButton" onclick="printBlankWorkOrders()">Print Blank Work Order</button>
    		<button id="changePasswordLinkButton" onclick="loadPasswordChange()">Change Password</button>
            <button id="googleCalendarButton" onclick="loadGoogleCalendars()">Google Calendar</button>
            <button id="logoutButton" onclick="logout()">Logout and Exit</button>
        </div>
    </body>
</html>