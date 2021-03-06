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
		    			<label class="control-label" for="workOrderID">Work Order ID:</label>
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
	    					<input type="text" id="custCompany" maxlength="75" readonly value="<?php if(isset($custCompany)) echo $custCompany; ?>">
	    				</div>
		    		</div>
		    		
		    		<div class="control-group">
		    			<label class="control-label" for="custFName">First Name:</label>
	    				<div class="controls">
	    					<input type="text" id="custFName" maxlength="50" readonly value="<?php if(isset($custFName)) echo $custFName; ?>" >
	    				</div>
		    		</div>
		    		
		    		<div class="control-group">
		    			<label class="control-label" for="custLName">Last Name:</label>
	    				<div class="controls">
	    					<input type="text" id="custLName" maxlength="50" readonly value="<?php if(isset($custLName)) echo $custLName; ?>">
	    				</div>
		    		</div>
				    <hr class="address-hr">
					<div class="address-container">
						<h4>Cleaning to be done at</h4>
					    <div class="addr-control-group">
			    			<label class="control-label" for="woAddress">Address:</label>
		    				<div class="controls">
		    					<input type="text" id="woAddress" maxlength="150" value="<?php if(isset($woAddress)) echo $woAddress; ?>">
		    				</div>
			    		</div>
			    		
			    		<div class="addr-control-group">
			    			<label class="control-label" for="woCity">City:</label>
		    				<div class="controls">
		    					<input type="text" id="woCity" maxlength="50" value="<?php if(isset($woCity)) echo $woCity; ?>">
		    				</div>
			    		</div>
			    		
			    		<div class="addr-control-group">
			    			<label class="control-label" for="woProvince">Province:</label>
		    				<div class="controls">
		    					<input type="text" id="woProvince" maxlength="2" value="<?php if(isset($woProv)) echo $woProv; ?>">
		    				</div>
			    		</div>
			    		
			    		<div class="addr-control-group">
			    			<label class="control-label" for="woPCode">Postal Code:</label>
		    				<div class="controls">
		    					<input type="text" id="woPCode" maxlength="7" value="<?php if(isset($woPCode)) echo $woPCode; ?>">
		    				</div>
			    		</div>
			    		
			    		<div class="addr-control-group">
		    			<label class="control-label" for="woPhone">Phone:</label>
		    				<div class="controls">
		    					<input type="text" id="woPhone" maxlength="12" value="<?php if(isset($woPhone)) echo $woPhone; ?>">
		    				</div>
		    			</div>
		    		</div>
		    		<hr class="address-hr">
		    		<div class="control-group">
						<label class="control-label" for="workOrderDate">Date:</label>
						<input type="text" id="datepicker" placeholder="mm/dd/yyyy" value="<?php if(isset($woDate)) echo $woDate; ?>">
					</div>
										
					<div class="control-group">
			    		<label class="control-label" for="workOrderGift">Gift:</label>
		    			<div class="controls">
		    				<input type="text" id="workOrderGift" maxlength="250" value="<?php if(isset($payGift)) echo $payGift; ?>">
		    			</div> 
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
					    		<input id="payDebit" type="checkbox" <?php if(isset($payDebit)) echo $payDebit; ?>> Debit
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
					<li><a id="carpet-tab-link" class="tab-link" href="#carpetTab">Carpet</a></li>
					<li><a id="upholstery-tab-link" class="tab-link"  href="#upholsteryTab">Upholstery</a></li>
					<li><a id="stainguard-tab-link" class="tab-link" href="#stainGuardTab">Stain Guard</a></li>
					<li><a id="other-tab-link" class="tab-link" href="#otherTab">Other</a></li>
					<li><a id="travel-tab-link" class="tab-link" href="#travelTab">Travel</a></li>
					<li><a id="spots-tab-link" class="tab-link" href="#spotsTab">Spots</a></li>
					<li><a id="notes-tab-link" class="tab-link" href="#notesTab">Notes</a></li>
				</ul>
				<div id="carpetTab">
					<?php if(isset($serviceTable)) echo $serviceTable; ?>
				</div>
			
				<div id="upholsteryTab">
					<?php if(isset($upholsteryTable)) echo $upholsteryTable; ?>
				</div>
				
				<div id="stainGuardTab">
					<?php if(isset($stainguardTable)) echo $stainguardTable; ?>
				</div>
				
				<div id="otherTab">
					<?php if(isset($otherTable)) echo $otherTable; ?>
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
						<label>Total Travel Price:</label>
						<div class="input-prepend">
							<span class="add-on">$</span>
						  	<input id="travelTotal" class="input-small span2" type="text" value="0.00" readonly>
						</div>
					</div>
				</div>
				
				<div id="spotsTab">
					<textarea id="woSpots" placeholder="Insert Spots Here..."><?php if(isset($woSpots)) echo $woSpots; ?></textarea>
				</div>
				
				<div id="notesTab">
					<textarea id="woNotes" placeholder="Insert Notes Here..."><?php if(isset($woNotes)) echo $woNotes; ?></textarea>
				</div>
			</div>
			<hr>
			<div id="tax-container">
				<label>Total GST: </label>
				<div id="tax-input" class="input-prepend input-append">
					<span class="add-on">$</span>
				  	<input id="total-wo-tax" class="input-small span2" type="text" value="0.00" readonly>
				  	<span id="current-tax-perc" class="add-on">&nbsp;&nbsp;<?php if(isset($payTax)) echo $payTax; ?>%</span>
				</div>
				<button id="tax-btn" class="btn" type="button" onclick="openTaxRateForm()">Change %</button>
				
				<div id="new-tax-container" class="input-append well hidden">
					<a class="close" href="javascript:void(0)" onclick="closeTaxRateForm()">&times;</a>
					<label>Insert New % Here: </label>
				  	<input id="new-tax-input" class="input-small span2" type="text" placeholder="0-100">
				  	<span class="add-on">%</span>
				  	<button class="btn btn-success" type="button" onclick="saveTaxRate()">Save</button>
				</div>
				
				<div id="tax-alert-container"></div>
				
			</div>	
			<div>
				<label>Total Price: </label>
				<div class="input-prepend">
					<span class="add-on">$</span>
				  	<input id="total-wo-price" class="input-small span2" type="text" value="0.00" readonly>
				</div>
			</div>
			<hr>
			<!-- Need button groups in order for the formatting to work properly for the dropdown -->
			<div id="buttons-container">
				<div class="btn-group">
					<button id="delete-button" class="btn btn-large btn-danger" onclick="deleteWorkOrder()">Delete Work Order</button>
				</div>
				<div class="btn-group">
					<button id="print-button" class="btn btn-large btn-info dropdown-toggle" data-toggle="dropdown">Print Work Order</button>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						<li>
							<a href="javascript:void(0)" onclick="printWorkOrder()">Work Order</a>
						</li>
						<li>
							<a href="javascript:void(0)" onclick="printCustSummary()">Customer Summary</a>
						</li>
					</ul>
				</div>
				<div class="btn-group">
					<button id="start-new-button" class="btn btn-large btn-info" onclick="startAsNew()">Start as New</button>
				</div>
				<div class="btn-group">
					<button id="save-button" class="btn btn-large btn-primary" onclick="saveWorkOrder()">Save Work Order</button>
				</div>
				<div class="btn-group">
					<button id="customer-button" class="btn btn-large btn-success" onclick="gotoCustomer()">View Customer</button>
				</div>
			</div> 
		</div> <!-- End of Container -->
		
		<script>
			var home = "<?php echo $home; ?>";
		</script>
		<script src="<?php echo $home?>js/workorderform.js"></script>
		<script>
			<?php if(isset($newForCust)) echo "startAsNew();";?>
		</script>
    </body>
</html>