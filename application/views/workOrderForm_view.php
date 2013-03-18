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
	    					<input  class="input-small" type="text" id="workOrderID" placeholder="######" readonly value="<?php if(isset($woID)) echo $woID; ?>">
	   		 			</div>
	    		</div>
	    		<div class="control-group">
	    			<label class="control-label" for="custID">Customer ID:</label>
    				<div class="controls">
    					<input  class="input-small" type="text" id="custID" placeholder="######" readonly value="<?php if(isset($custID)) echo $custID; ?>">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custCompany">Company:</label>
    				<div class="controls">
    					<input type="text" id="custCompany" maxlength="40" value="<?php if(isset($custCompany)) echo $custCompany; ?>">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custFName">First Name:</label>
    				<div class="controls">
    					<input type="text" id="custFName" maxlength="20" value="<?php if(isset($custFName)) echo $custFName; ?>" >
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="custLName">Last Name:</label>
    				<div class="controls">
    					<input type="text" id="custLName" maxlength="20" value="<?php if(isset($custLName)) echo $custLName; ?>">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="woAddress">Address:</label>
    				<div class="controls">
    					<input type="text" id="woAddress" maxlength="30" value="<?php if(isset($woAddress)) echo $woAddress; ?>">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="woCity">City:</label>
    				<div class="controls">
    					<input type="text" id="woCity" maxlength="20" value="<?php if(isset($woCity)) echo $woCity; ?>">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="woProvince">Province:</label>
    				<div class="controls">
    					<input type="text" id="woProvince" maxlength="2" value="<?php if(isset($woProv)) echo $woProv; ?>">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="woPCode">Postal Code:</label>
    				<div class="controls">
    					<input type="text" id="woPCode" maxlength="7" value="<?php if(isset($woPCode)) echo $woPCode; ?>">
    				</div>
	    		</div>
	    		
	    		<div class="control-group">
	    			<label class="control-label" for="woPhone">Phone:</label>
    				<div class="controls">
    					<input type="text" id="woPhone" maxlength="12" value="<?php if(isset($woPhone)) echo $woPhone; ?>">
    				</div>
	    		</div>
	
				<div class="control-group">
		    		<label class="control-label" for="workOrderGift">Gift:</label>
	    			<div class="controls">
	    				<input type="text" id="workOrderGift" maxlength="30" value="<?php if(isset($payGift)) echo $payGift; ?>">
	    			</div> 
		    	</div> 
	    	 	
		    <div class="control-group">
				<label class="control-label" for="workOrderDate">Date:</label>
				<input type="text" id="datepicker" placeholder="mm/dd/yyyy" value="<?php if(isset($woDate)) echo $woDate; ?>">
			</div>  		
		
		 	<div class="control-group">
		    	<label class="control-label" for="workOrderDiscount">Discount:</label>
	   			<div class="controls">
	 				<input type="text" id="workOderDiscount" maxlength="13" value="<?php if(isset($payDiscount)) echo $payDiscount; ?>">
	  				<select class="input-small"<?php if(isset($payDiscountType) && $payDiscountType == '$') echo 'selected'; ?>>
						<option>%</option>
						<option<?php if(isset($payDiscountType) && $payDiscountType == '$') echo ' selected'; ?>>$</option>
					</select>
	   			</div>
		    </div>
		</div> <!-- End of inputs-div -->
		
		<div id="checkboxes-div">
			<div class="checkbox-container">
				<h4>Payment</h4>
				<div class="checkbox">
			    	<label>
			    		<input type="checkbox" <?php if(isset($payCash)) echo $payCash; ?>> Cash
			    	</label>
			    	<label>
			    		<input type="checkbox" <?php if(isset($payCheque)) echo $payCheque; ?>> Cheque
			    	</label>
			    	<label>
			    		<input type="checkbox" <?php if(isset($payCC)) echo $payCC; ?>> Credit Card
			    	</label>
			    	<label>
			    		<input type="checkbox" <?php if(isset($payCharge)) echo $payCharge; ?>> Charge
			    	</label>
			    	<label>
			    		<input type="checkbox"> Other:
			    		<input type="text" class="input-small" id="payOther" value="<?php if(isset($payOther)) echo $payOther; ?>">
			    	</label>
		    	</div>
		    </div>
	    
		    <div class="checkbox-container">
		    	<h4>Equipment</h4>
			    <div class="controls">
			    	<label>
			    		<input type="checkbox" <?php if(isset($woRX)) echo $woRX; ?>/> RX
			   		 </label>
			    	<label>
			    		<input type="checkbox" <?php if(isset($woFan)) echo $woFan; ?>> Fan
			    	</label>
			    	<label>
			    		<input type="checkbox" <?php if(isset($woRake)) echo $woRake; ?>> Rake
			    	</label>
			    	<label>
			    		<input type="checkbox" <?php if(isset($woPad)) echo $woPad; ?>> Pad
			    	</label>
			    	<label>
			    		<input type="checkbox" <?php if(isset($woEncapsulate)) echo $woEncapsulate; ?>> Encapsulate
			    	</label>
			    	<label>
			    		<input type="checkbox" <?php if(isset($woForm)) echo $woForm; ?>> Info Form
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
		
		<div id="buttons-container">
			<button id="save-button" class="btn btn-large btn-primary" onclick="saveWorkOrder()">Save Work Order</button>
			<button id="start-new-button" class="btn btn-large btn-info" onclick="startAsNew()">Start as New</button>
			<button id="print-button" class="btn btn-large btn-info" onclick="printWorkOrder()">Print Work Order</button>
			<button id="delete-button" class="btn btn-large btn-danger" onclick="deleteWorkOrder()">Delete Work Order</button>
		</div> 
	</div> <!-- End of Container -->

		<script src="<?php echo $home?>js/workorderform.js"></script>

    </body>
</html>