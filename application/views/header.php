<?php 
    $this->load->helper('url'); 
    $home = base_url();
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/bootstrap-responsive.css">
	    <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/jquery-ui-1.10.0.custom.css">
	    
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
			      <a class="brand" href="#"><img src="<?php echo $home;?>images/New Aqua Logo Web.png" alt="Aqua Steam" height="32.75" width="125"></a>
			      <div class="nav-collapse collapse">
				      <ul class="nav">
					      <li id="homeLink"class="active"><a href="<?php echo $home?>index.php/adminMainMenu">Home</a></li>
					      <li id="customerLink"><a href="<?php echo $home?>index.php/customer">Customers</a></li>
					      <li><a href="<?php echo $home?>index.php/workOrder">Work Orders</a></li>
					      <li><a href="<?php echo $home?>index.php/logout">Logout</a></li>
				      </ul>
			      </div>
			    </div>
		    </div>
		</div>