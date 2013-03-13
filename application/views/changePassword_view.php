<?php
    $home = base_url();
?>

<link rel="stylesheet" type="text/css" href="<?php echo $home?>css/changePassword.css">
<body>
<div class="container">
	<div class="form-changepw">
		<h2 class="form-changepw-heading">Change Password</h2>
		        <div id="error-div"></div>
        <div id="form">
            Old Password: <input id="oldPassword"type="password" class="input-block-level" placeholder="Old Password">
		    New Password: <input id="newPassword"type="password" class="input-block-level" placeholder="New Password">
		    Re-type New Password: <input id="retypeNewPassword"type="password" class="input-block-level" placeholder="Re-type New Password">
            <button id="changePasswordButton" class="btn btn-large btn-primary" onclick="verifyChangePassword()">Change Password</button>
	    </div>
	</div>
</div>

    <script>
		var home = "<?php echo $home; ?>";
	</script>
    <script src="<?php echo $home?>js/changePassword.js"></script>
  </body>
</html>