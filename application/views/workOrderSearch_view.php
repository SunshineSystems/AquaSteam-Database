<?php
    $home = base_url();
?>
		        
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/workOrderSearch.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/table css/style.css">
        
        <!--Hidden form that will contain the alert code after a page load if a work order is deleted on the form page-->
		<form id="alert-form" method="POST">
			<input id="alert-data" name="alert-data" type="hidden"/>
		</form>
        
        <!-- Keep all displayed content inside container div -->
        <div class="container wo-container">
	    	<h1><?php if(isset($header)) echo $header; else echo 'Search Work Orders';?></h1>
	    	<select id="searchType" onchange="loadSearch()">
				<option value="name" selected="selected">Customer Name</option>
				<option value="company">Company</option>
				<option value="city">City</option>
				<option value="address">Address</option>
				<option value="date">Date</option>
			</select>
			<input id="searchbar" placeholder="Search..." onClick="this.select();"/>
			<button id="id_search_button" class="btn btn-primary" onclick="getSearchResults()">Search</button>
			<div id="id_result_table"><?php if(isset($tableData)) echo $tableData; if(isset($_POST['alert-data'])) echo $_POST['alert-data'];?></div>
		
	    </div>
	    <script>
			var json = <?php echo $tags;?>;
			var custNum = <?php echo $custNum; ?>;
			
			var obj = eval (json);
			var home = "<?php echo $home; ?>";
		</script>
		
	    <script src="<?php echo $home?>js/jquery.tablesorter.js"></script>
	    <script src="<?php echo $home?>js/workOrderSearch.js"></script>
    </body>
</html>