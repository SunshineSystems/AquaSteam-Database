<?php
    $home = base_url();
?>
		<head>       
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/workOrderForm.css">
        
        <!-- Keep all displayed content inside container div -->
        <div class="container wo-container">
	      <h1>Work Order</h1>
	    
	    <script src="<?php echo $home?>js/workOrderForm.js"></script>
	    </head> 
	    <body>
	    	
	    	
	    	
	<form class="form-horizontal">

    		<div class="control-group">
    			<label class="control-label" for="workOrderID">Work Order ID</label>
    				<div class="controls">
    					<input  class="input-small" type="text" id="workOrderID" placeholder="######" readonly>
   		 			</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custID">Customer ID</label>
    				<div class="controls">
    					<input  class="input-small" type="text" id="custID" placeholder="######" readonly>
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custCompany">Company</label>
    				<div class="controls">
    					<input type="text" id="custCompany">
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custFName">First Name</label>
    				<div class="controls">
    					<input type="text" id="custFName">
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custLName">Last Name</label>
    				<div class="controls">
    					<input type="text" id="custLName">
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custAddress">Address</label>
    				<div class="controls">
    					<input type="text" id="custAddress">
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custCity">City</label>
    				<div class="controls">
    					<input type="text" id="custCity">
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custProvince">Province</label>
    				<div class="controls">
    					<input type="text" id="custProvince">
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custPCode">Postal Code</label>
    				<div class="controls">
    					<input type="text" id="custPCode">
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custHPhone">Home Phone</label>
    				<div class="controls">
    					<input type="text" id="custHPhone">
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custBPhone">Business Phone</label>
    				<div class="controls">
    					<input type="text" id="custBPhone">
    				</div>
    		</div>
    		<div class="control-group">
    			<label class="control-label" for="custCPhone">Cell Phone</label>
    				<div class="controls">
    					<input type="text" id="custCPhone">
    				</div>
    		</div>
    		
    	
    
    <div class="controls">
    <label class="checkbox inline">
    <input type="checkbox"> Cash
    </label>
    <label class="checkbox inline">
    <input type="checkbox"> Cheque
    </label>
    <label class="checkbox inline">
    <input type="checkbox"> Credit Card
    </label>
    <label class="checkbox inline">
    <input type="checkbox"> Charge
    </label>
    <label class="checkbox inline">
    <input type="checkbox"> Other
    <input type="text" id="payOther">
    </label>
    </div>
    
    
    <div class="controls">
    <label class="checkbox inline">
    <input type="checkbox"> RX
    </label>
    <label class="checkbox inline">
    <input type="checkbox"> Fan
    </label>
    <label class="checkbox inline">
    <input type="checkbox"> Rake
    </label>
    <label class="checkbox inline">
    <input type="checkbox"> Pad
    </label>
    <label class="checkbox inline">
    <input type="checkbox"> Encapsulate
    </label>
    
    <label class="checkbox inline">
    <input type="checkbox"> Info Form
    </label>
    
    </div>
    

		<div class="control-group">
    			<label class="control-label" for="workOrderGift">Gift</label>
    				<div class="controls">
    					<input type="text" id="workOrderGift">
    				</div> 
    	</div>   		
    		
	
	
	
	
	<div class="control-group">
    	<label class="control-label" for="workOrderSqFeet">Sq Feet</label>
   			<div class="controls">
 				<input type="text" id="workOderSqFeet">
  			</div>
 	</div>
 	<div class="control-group">
    	<label class="control-label" for="sgPrice">Stain Guard Price</label>
   			<div class="controls">
 				<input type="text" id="sgPrice">
  			</div>
 	</div>
 	<div class="control-group">
    	<label class="control-label" for="workOrderDiscount">Discount</label>
   			<div class="controls">
 				<input type="text" id="workOderDiscount">
  			
<select class="input-small">
		<option>%</option>
		<option>$</option>
	</select>
    </div>
    </div>
 	
    		

    </form>
    
    </body>
</html>

    