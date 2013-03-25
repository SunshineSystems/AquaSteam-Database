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
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/bootstrap-responsive.css">
	    <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/jquery-ui-1.10.0.custom.css">
	    <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/header.css">
	    
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
						  <div class="btn-group">
  						  	  <button class="btn dropdown-toggle" data-toggle="dropdown" align="right">
									You're logged in <?php if(isset($user_username)) echo $user_username; ?>
									<span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu"> 
							  	<?php function index()
									{
										
										if(!isset($_SESSION['id'])) {
											header('Location: login');
										}
										else {
											$data['title'] = "Home";
											$this->load->view('header', $data);
											if($_SESSION['usertype'] == 1) {
												?> <li><a href="<?php echo $home?>index.php/manageAccount">Manage Accounts</a></li>
												//$this->load->view('adminMainMenu_view');
											<?php }
											else { ?>
												<li><a href="<?php echo $home?>index.php/changePassword">Change Password</a></li>
												<?php //$this->load->view('empMainMenu_view');
											}
										}
									} ?>
							  	  
							  	  
							  	  <li id="logoutLink"><a href="<?php echo $home?>">Logout</a></li>
							  </ul>
						  </div>
			      </div>
			    </div>
		    </div>
		</div>
	</body>
</html>