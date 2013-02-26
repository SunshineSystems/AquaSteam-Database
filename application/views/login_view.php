<?php 
    $this->load->helper('url'); 
    $home = base_url();
	$home = str_replace(" ", "-", $home);
?>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <script src="js/jquery-1.9.1.js"></script>
        
        <h1>AquaStem Login</h1>
        <div id="loginForm">
            Username: <input id="loginUsername" type="text" /><br>
            Password: <input id="loginPassword" type="password" /><br>
            <button id="loginButton" onclick="verifyLogin()">Login</button>
            <?php echo $home; ?>
        </div>
    </body>
    
    <script>
        
        function verifyLogin() {
           var username = $("#loginUsername").val();
           var password = $("#loginPassword").val();
           alert(username +' : '+ password);
        }
        
    </script>
</html>
