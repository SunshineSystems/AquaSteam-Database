<?php
    $home = base_url();
?>
		        
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/login.css">
        
        <div class="container">
        	<div class="form-signin">
		        <h2 class="form-signin-heading">Please sign in</h2>
		        <div id="error-div"></div>
		        <input id="loginUsername"type="text" class="input-block-level" placeholder="Username">
		        <input id="loginPassword"type="password" class="input-block-level" placeholder="Password">
		        <label class="checkbox">
		          <input type="checkbox" value="remember-me"> Remember me
		        </label>
		        <button id="signin-button" class="btn btn-large btn-primary" onclick="verifyLogin()">Sign in</button>
	        </div>
	    </div>
	<script>
		var home = "<?php echo $home; ?>";
	</script>
    <script src="<?php echo $home?>js/login.js"></script>
    
    <div class="footer-container">
    	<div id="footer" align="center">
    		<img src="../images/New Aqua Logo Web.png" alt="Aqua Steam Logo" width="10%" height="10%">
    	</div>
    </div>
    
    
    </body>
</html>
