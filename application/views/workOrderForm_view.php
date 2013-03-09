<?php
    $home = base_url();
?>
		<head>       
        <link rel="stylesheet" type="text/css" href="<?php echo $home?>css/workOrderForm.css">
        
        <!-- Keep all displayed content inside container div -->
        <div class="container wo-container">
	      <h1>Work Order</h1>
	    
	    <script src="<?php echo $home?>js/workOrderForm.js">
	    	
	    </script>
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
    	<label class="control-label" for="workOrderDiscount">Discount</label>
   			<div class="controls">
 				<input type="text" id="workOderDiscount">
  			
<select class="input-small">
		<option>%</option>
		<option>$</option>
	</select>
    </div>
    </div>
 	
    		
<div class="control-group">
	<label class="control-label" for="workOrderDate">Date </label>
	<input type="text" id="datepicker" placeholder="mm/dd/yyyy"/>
	</div>
	
	
	<div id="tabs">
<ul>
<li><a href="#carpetTab">Carpet</a></li>
<li><a href="#upholsteryTab">Upholstery</a></li>
<li><a href="#stainGuardTab">Stain Guard</a></li>
<li><a href="#spotsTab">Spots</a></li>
<li><a href="#travelTab">Travel</a></li>
<li><a href="#notesTab">Notes</a></li>

</ul>
<div id="carpetTab">
<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
</div>
<div id="upholsteryTab">
<p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
</div>
<div id="stainGuardTab">
<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
</div>
<div id="spotsTab">
<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
</div>
<div id="travelTab">
<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
</div>
<div id="notesTab">
<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
</div>
</div>


 

    </form>
    
    </body>
</html>

    