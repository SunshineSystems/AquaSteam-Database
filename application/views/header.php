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
					      <li id="logoutLink"><a href="<?php echo $home?>">Logout</a></li>
				      </ul>
			      </div>
			    </div>
		    </div>
		</div>