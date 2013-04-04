<?php 
    $this->load->helper('url'); 
    $home = base_url();
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title?></title>
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
        
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/bootstrap.css">
	    <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/jquery-ui-1.10.0.custom.css">
	    <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/header.css">
	    <link rel="apple-touch-icon" href="<?php echo $home?>images/aquasteam icon.png" />  
	    
	    <script src="<?php echo $home?>js/jquery-1.9.1.js"></script>
	    <script src="<?php echo $home?>js/bootstrap.js"></script>
	    <script src="<?php echo $home?>js/jquery-ui-1.10.0.custom.min.js"></script>
    </head>
    <body style="padding-top: 0px;">
    	<div class="navbar">
		  <div class="navbar-inner">
		  	  <div class="container">
		  	  	 <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
			      <a class="brand" href="<?php echo $home?>index.php/MainMenu">Aqua Steam Database</a>
			      <div class="nav-collapse collapse">
				      <ul class="nav">
					      <li id="homeLink"class="active"><a class="menu-links" href="<?php echo $home?>index.php/MainMenu">Home</a></li>
					      <li id="customerLink"><a class="menu-links" href="<?php echo $home?>index.php/customer">Customers</a></li>
					      <li id="workOrderLink"><a href="<?php echo $home?>index.php/workOrderSearch">Work Orders</a></li>
					      <li><a href="https://www.google.com/calendar" target="_blank">Google Calendar</a></li>
				      </ul>
				      <ul class="nav pull-right">
						  <li id="account-dropdown" class="dropdown">
						  	  <?php if(!isset($_SESSION['username'])) {echo '<a href="'.$home.'index.php/login">Log In</a>';} 
						  	  		else { echo '<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
						  	  						<i class="icon-user"></i> <b>'.$_SESSION['username'].'</b> <span class="caret"></span>
						  	  						<ul class="dropdown-menu">';
														if($_SESSION['usertype'] == 1) {
															echo '<li id="accountLink"><a href="'.$home.'index.php/manageAccount">Manage Accounts</a></li>';
														}
														else {
															echo '<li id="accountLink"><a href="'.$home.'index.php/changePassword">Change Password</a></li>';
														} 
													  	echo '<li id="logoutLink"><a href="'.$home.'index.php/login">Logout</a></li>
													  </ul>';
									
									}?>

						  </div>
				  	  </ul>
			      </div>
			    </div>
		    </div>
		</div>
	</body>
</html>