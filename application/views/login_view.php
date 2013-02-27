        <?php
		    $home = base_url();
		?>
		        
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/login.css">
        
        <div class="container">
	      <form class="form-signin">
	        <h2 class="form-signin-heading">Please sign in</h2>
	        <input id="loginUsername"type="text" class="input-block-level" placeholder="Username">
	        <input id="loginPassword"type="password" class="input-block-level" placeholder="Password">
	        <label class="checkbox">
	          <input type="checkbox" value="remember-me"> Remember me
	        </label>
	        <button class="btn btn-large btn-primary" onclick="verifyLogin()">Sign in</button>
	      </form>
	    </div>
    </body>
    
    <script>
        function verifyLogin() {
        	var username = $("#loginUsername").val();
        	var password = $("#loginPassword").val();
        	alert("Signing in as: " + username + " | " + password);
        }
    </script>
</html>
