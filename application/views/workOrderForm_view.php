<?php
    $home = base_url();
?>
        	<link rel="stylesheet" type="text/css" href="<?php echo $home?>css/workOrderForm.css">   
        	<!-- Keep all displayed content inside container div -->
	    <div class="container wo-container">
	    	<h1>Work Order</h1>
			<div id="top-container">
			<div id="inputs-div">
	    		<div class="control-group">
	    			<label class="control-label" for="workOrderID">Work Order ID</label>
	    				<div class="controls">
	    					<input  class="input-small" type="text" id="workOrderID" placeholder="######" readonly>
	   		 			</div>
	    		</div>
	    		<div class="control-group">
	    			<label class="control-label" for="custID">Customer ID:</label>
    				<div class="controls">
    					<input  class="input-small" type="text" id="custID" placeholder="######" readonly>
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custCompany">Company:</label>
    				<div class="controls">
    					<input type="text" id="custCompany" maxlength="40">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custFName">First Name:</label>
    				<div class="controls">
    					<input type="text" id="custFName" maxlength="20">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custLName">Last Name:</label>
    				<div class="controls">
    					<input type="text" id="custLName" maxlength="20">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custAddress">Address:</label>
    				<div class="controls">
    					<input type="text" id="custAddress" maxlength="30">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custCity">City:</label>
    				<div class="controls">
    					<input type="text" id="custCity" maxlength="20">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custProvince">Province:</label>
    				<div class="controls">
    					<input type="text" id="custProvince" maxlength="2">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custPCode">Postal Code:</label>
    				<div class="controls">
    					<input type="text" id="custPCode" maxlength="7">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custHPhone">Home Phone:</label>
    				<div class="controls">
    					<input type="text" id="custHPhone" maxlength="12">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custBPhone">Business Phone:</label>
    				<div class="controls">
    					<input type="text" id="custBPhone" maxlength="12">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custCPhone">Cell Phone:</label>
    				<div class="controls">
    					<input type="text" id="custCPhone" maxlength="12">
    				</div>
	    		</div>
	
				<div class="control-group">
		    		<label class="control-label" for="workOrderGift">Gift:</label>
	    			<div class="controls">
	    				<input type="text" id="workOrderGift" maxlength="30">
	    			</div> 
		    	</div> 
	    	 	
		    <div class="control-group">
				<label class="control-label" for="workOrderDate">Date:</label>
				<input type="text" id="datepicker" placeholder="mm/dd/yyyy"/>
			</div>  		
		
		 	<div class="control-group">
		    	<label class="control-label" for="workOrderDiscount">Discount:</label>
	   			<div class="controls">
	 				<input type="text" id="workOderDiscount" maxlength="13">
	  				<select class="input-small">
						<option>%</option>
						<option>$</option>
					</select>
	   			</div>
		    </div>
		</div> <!-- End of inputs-div -->
		
		<div id="checkboxes-div">
			<div class="checkbox-container">
				<h4>Payment</h4>
				<div class="checkbox">
			    	<label>
			    		<input type="checkbox"> Cash
			    	</label>
			    	<label>
			    		<input type="checkbox"> Cheque
			    	</label>
			    	<label>
			    		<input type="checkbox"> Credit Card
			    	</label>
			    	<label>
			    		<input type="checkbox"> Charge
			    	</label>
			    	<label>
			    		<input type="checkbox"> Other
			    		<input type="text" class="input-small" id="payOther">
			    	</label>
		    	</div>
		    </div>
	    
		    <div class="checkbox-container">
		    	<h4>Equipment</h4>
			    <div class="controls">
			    	<label>
			    		<input type="checkbox"> RX
			   		 </label>
			    	<label>
			    		<input type="checkbox"> Fan
			    	</label>
			    	<label>
			    		<input type="checkbox"> Rake
			    	</label>
			    	<label>
			    		<input type="checkbox"> Pad
			    	</label>
			    	<label>
			    		<input type="checkbox"> Encapsulate
			    	</label>
			    	<label>
			    		<input type="checkbox"> Info Form
			    	</label>
			    </div>
			</div>
		</div> <!-- End of Checkboxes-div -->
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
				<table border="1">
	        		<thead>
	            		<tr>
	            			<th>Identifier *not sure</th>
	                		<th>Description</th>
	                		<th>Color/Type</th>                     
	                		<th>Length</th>
	                		<th>Width</th>
	                		<th>Sq Feet</th>
	                		<th>Quantity</th>
	                		<th>Unit Price</th>
	                		<th>Extended Price</th>
	                		<th>Total Price</th>
	            		</tr>
	        		</thead>
	        	<tbody>
	            <tr>         
	                <!-- The "identifier" class makes it so we have an id
	                    to pass to our ajax script so we know what to change -->       
	                <td class="identifier">00123</td>
	                <td class="editable">This is the description</td>
	                <td class="editable">Color/Type</td>
	                <td class="editable">Length</td>
	                <td class="editable">Width</td>
	                <td>sq feet not editable</td>
	                <td class="editable">quantity</td>
	                <td class="editable">Unit Price</td>
	                <td class="editable">Extended Price</td>
	                <td>Total Price not editable</td>
	                
	            </tr>                   
	        	</tbody>
	    		</table>
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
	</div> <!-- End of Container -->

		<script src="<?php echo $home?>js/workorderform.js"></script>

    </body>
</html>