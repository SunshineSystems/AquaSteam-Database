<?php
    $home = base_url();
?>
		        
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/workOrderSearch.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/table css/style.css">
        
        <!-- Keep all displayed content inside container div -->
        <div class="container wo-container">
	    	<h1>Search Work Orders</h1>
	    	<select id="searchType" onchange="loadSearch()">
				<option value="name" selected="selected">Name</option>
				<option value="company">Company</option>
				<option value="city">City</option>
				<option value="address">Address</option>
			</select>
			<input id="searchbar" placeholder="Search..." onClick="this.select();"/>
			<button id="id_search_button" class="btn btn-primary" onclick="getSearchResults()">Search</button>
			<div id="id_result_table"><?php if(isset($_POST['alert-data'])) { echo $_POST['alert-data']; }?></div>
		
	    </div>
	    <script src="<?php echo $home?>js/jquery.tablesorter.js"></script>
	    <script src="<?php echo $home?>js/workOrderSearch.js"></script>
    </body>
</html>