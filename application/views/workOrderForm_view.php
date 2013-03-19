<?php
    $home = base_url();
?>
    	<link rel="stylesheet" type="text/css" href="<?php echo $home?>css/workOrderForm.css">   
    	<!-- Keep all displayed content inside container div -->
	    
	    <!--Hidden form that will contain the alert code after a page refresh, if a new work order is saved-->
		<form id="alert-form" method="POST">
			<input id="alert-data" name="alert-data" type="hidden"/>
		</form>
	    
	    <div class="container wo-container">
	    	<h1>Work Order</h1>
	    	<div id="alert-div"><?php if(isset($_POST['alert-data'])) { echo $_POST['alert-data']; }?></div>
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
	    					<input type="text" id="custCompany" maxlength="40" readonly value="<?php if(isset($custCompany)) echo $custCompany; ?>">
	    				</div>
		    		</div>
		    		
		    		<div class="control-group">
		    			<label class="control-label" for="custFName">First Name:</label>
	    				<div class="controls">
	    					<input type="text" id="custFName" maxlength="20" readonly value="<?php if(isset($custFName)) echo $custFName; ?>" >
	    				</div>
		    		</div>
		    		
		    		<div class="control-group">
		    			<label class="control-label" for="custLName">Last Name:</label>
	    				<div class="controls">
	    					<input type="text" id="custLName" maxlength="20" readonly value="<?php if(isset($custLName)) echo $custLName; ?>">
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
			 				<input type="text" id="workOrderDiscount" maxlength="13" value="<?php if(isset($payDiscount)) echo $payDiscount; ?>">
			  				<select id="workOrderDiscountType" class="input-small">
								<option id="percent-option">%</option>
								<option id="dollar-option"<?php if(isset($payDiscountType) && $payDiscountType == '$') echo ' selected'; ?>>$</option>
							</select>
			   			</div>
				    </div>
				</div> <!-- End of inputs-div -->
		
				<div id="checkboxes-div">
					<div class="checkbox-container">
						<h4>Payment</h4>
						<div class="checkbox">
					    	<label>
					    		<input id="payCash" type="checkbox" <?php if(isset($payCash)) echo $payCash; ?>> Cash
					    	</label>
					    	<label>
					    		<input id="payCheque" type="checkbox" <?php if(isset($payCheque)) echo $payCheque; ?>> Cheque
					    	</label>
					    	<label>
					    		<input id="payCC" type="checkbox" <?php if(isset($payCC)) echo $payCC; ?>> Credit Card
					    	</label>
					    	<label>
					    		<input id="payCharge" type="checkbox" <?php if(isset($payCharge)) echo $payCharge; ?>> Charge
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
					    		<input id="woRX" type="checkbox" <?php if(isset($woRX)) echo $woRX; ?>/> RX
					   		 </label>
					    	<label>
					    		<input id="woFan" type="checkbox" <?php if(isset($woFan)) echo $woFan; ?>> Fan
					    	</label>
					    	<label>
					    		<input id="woRake" type="checkbox" <?php if(isset($woRake)) echo $woRake; ?>> Rake
					    	</label>
					    	<label>
					    		<input id="woPad" type="checkbox" <?php if(isset($woPad)) echo $woPad; ?>> Pad
					    	</label>
					    	<label>
					    		<input id="woEncapsulate" type="checkbox" <?php if(isset($woEncapsulate)) echo $woEncapsulate; ?>> Encapsulate
					    	</label>
					    	<label>
					    		<input id="woForm" type="checkbox" <?php if(isset($woForm)) echo $woForm; ?>> Info Form
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
					<p>Hello</p>
				</div>
				
				<div id="stainGuardTab">
					<p>Hello</p>
				</div>
			
				<div id="travelTab">
					<div class="travelField-div">
						<label>Distance(km):</label>
						<input id="travelDist" class="input-small" type="text" value="<?php if(isset($travDistance)) echo $travDistance; ?>">
					</div>
					<div class="travelField-div travelField-pdiv">
						<p>X</p>
					</div>
					<div class="travelField-div">
						<label>Charge($/km):</label>
						<input id="travelPrice" class="input-small" type="text" value="<?php if(isset($travPrice)) echo $travPrice; ?>">
					</div>
					<div class="travelField-div travelField-pdiv">
						<p>=</p>
					</div>
					<div class="travelField-div">
						<label>Total Price:</label>
						<div class="input-prepend">
							<span class="add-on">$</span>
						  	<input id="travelTotal" class="input-small span2" type="text" value="0.00">
						</div>
					</div>
				</div>
			
				<div id="notesTab">
					<textarea id="woNotes" placeholder="Insert Notes Here..."><?php if(isset($woNotes)) echo $woNotes; ?></textarea>
				</div>
			</div>
		
			<div id="buttons-container">
				<button id="save-button" class="btn btn-large btn-primary" onclick="saveWorkOrder()">Save Work Order</button>
				<button id="start-new-button" class="btn btn-large btn-info" onclick="startAsNew()">Start as New</button>
				<button id="print-button" class="btn btn-large btn-info" onclick="printWorkOrder()">Print Work Order</button>
				<button id="delete-button" class="btn btn-large btn-danger" onclick="deleteWorkOrder()">Delete Work Order</button>
			</div> 
		</div> <!-- End of Container -->
		
		<script>
			var home = "<?php echo $home; ?>";
		</script>
		<script src="<?php echo $home?>js/workorderform.js"></script>

    </body>
</html>