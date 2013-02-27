<?php 
    $this->load->helper('url'); 
    $home = base_url();
	$home = str_replace(" ", "-", $home);
?>
<html>
    <head>
        <title>Change Password</title>
    </head>
    <body>
        <script src="js/jquery-1.9.1.js"></script>
        
        <h1>Change Password</h1>
        <div id="form">
            Old Password: <input id="loginPassword" type="password" /><br>
            New Password: <input id="newPassword" type="password" /><br>
            Re-type New Password: <input id="reNewPassword" type="password" /><br>
            <button id="changePasswordButton" onclick="verifyChangePassword()">Change</button>
            
        </div>
    </body>
    
    <script>
 ?????????????????????????????????????????????????????????????    
        function verifyLogin() {
           var username = $("#loginUsername").val();
           var password = $("#loginPassword").val();
           alert(username +' : '+ password);
        }
        
    </script>
</html>