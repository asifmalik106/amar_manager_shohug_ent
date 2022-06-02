<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
      <div class="row">
            <div class="col-lg-12">
                <?php include 'system/notification.php'; ?>
                <h2 class="page-header"><?php echo $profileLang[$data['data']['type']]; ?></h2>
							<input id="scID" type="hidden" value="<?php echo $data['data']['sc']['scID']; ?>">
            </div>
      </div>
      <div class="row">
				<div id="loadProfile">

					</div>
        <div class="col-md-4">
          <h2> <?php echo $profileLang['balance']; ?> </h2>
					<div id="balance">
					</div>
        </div>
      	
			</div>
			<button class="btn btn-primary" data-toggle="modal" data-target="#editProfile" onclick="fillEditProfile()"><i class="glyphicon glyphicon-edit"></i> <?php echo $profileLang['editProfileInformation']; ?></button>
     <hr>
      <div class="row">
        
        <form class="form-inline">
          <div class="form-group">
            <h3><?php echo $profileLang['invoices']; ?></h3>
          </div>
			    <div class="form-group" style="display: none;" id="loadingCategory">
    			<div class="form-control loadingCategoryStyle">
    			  <p><img src="<?php echo BASE_URL; ?>asset/reload.gif"> <?php echo $systemWords['pleasewait']; ?></p>
    			</div>
  			</div>	
			<div class="form-group">
				<button type="button" class="reloadCategory btn btn-primary pull-right reloadCategory" onclick="loadAllInvoice()"><i class="glyphicon glyphicon-refresh"></i> <?php echo $profileLang['refreshInvoiceList']; ?></button>
			</div>
		</form>
        
        <div class="col-md-12">
          <div id="loadInvoices">
            
          </div>
        </div>

      </div>
      <hr>
      <div class="row">
    <form class="form-inline">
          <div class="form-group">
            <h3><?php echo $profileLang['transactions']; ?></h3>
          </div>
			    <div class="form-group" style="display: none;" id="loadingTransactions">
    			<div class="form-control loadingCategoryStyle">
    			  <p><img src="<?php echo BASE_URL; ?>asset/reload.gif"> <?php echo $systemWords['pleasewait']; ?></p>
    			</div>
  			</div>	
			<div class="form-group">
				<button type="button" class="reloadCategory btn btn-primary pull-right reloadCategory" onclick="loadAllTransactions()"><i class="glyphicon glyphicon-refresh"></i> <?php echo $profileLang['refreshTransactionList']; ?></button>
			</div>
		</form>
        <div class="col-md-12" id="loadTransactions">
-
        </div>
      </div>
    </div>
	
	
	<!-- Pay Now Modal -->
	<?php 
	if($data['data']['type']=="Customer"){?>
  <div class="modal fade" id="payNow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $profileLang['paymentForUnpaidInvoice']; ?></h4>
        </div>
        <div class="modal-body">
				<div class="catStatusHeight">
					<div id="catStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $profileLang['paymentAddedSuccessfully']; ?></strong> 
						</div>
					</div>
					<div id="catStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $profileLang['paymentFailed']; ?></strong> 
						</div>
					</div>
					<div id="catStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $profileLang['fillAllFields']; ?></strong> 
						</div>
					</div>
					<div id="catStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <?php echo $systemWords['pleasewait']; ?></strong> 
						</div>
					</div>
				</div>
          <table class="table">
            <tr>
              <td>
                <label><?php echo $profileLang['invoiceID']; ?></label>
                <h4 id="payInvoiceID"></h4></td>
              <td>
                <label><?php echo $profileLang['invoiceDate']; ?></label>
                <h4 id="payInvoiceDate"></h4>
              </td>
              <td>
                <label><?php echo $profileLang['invoiceTime']; ?></label>
                <h4 id="payInvoiceTime"></h4>
              </td>
            </tr>
            <tr>
              <td>
                <label><?php echo $profileLang['invoiceTotal']; ?> </label>
                <h4 id="payInvoiceTotal"></h4>
              </td>
              <td>
                <label><?php echo $profileLang['invoicePaid']; ?></label>
                <h4 id="payInvoicePaid"></h4>
              </td>
              <td>
                <label><?php echo $profileLang['invoiceDue']; ?></label>
                <h2 id="payInvoiceDue" class="delete">2233</h2>
              </td>
            </tr>
          </table>
						<div id="payFromBalanceSection" style="display: none"> 
							<div class="checkbox">
								<label>
									<input type="checkbox" id="useBalance"> <?php echo $profileLang['useBalance']; ?>
								</label>
							</div>
							<div id="payFromBalance" style="display: none">
								<p><?php echo $profileLang['availableBalance']; ?> <strong id="availableBalance"> </strong></p>
								<div class="form-group">
									<label><?php echo $profileLang['payDueAmount']; ?></label>
									<input class="form-control" id="payFromBalanceAmount" type="number" min="0">
								</div>
							</div>
						</div>
					
            <div class="form-group">
              <label><?php echo $profileLang['payDueAmount']; ?></label>
              <input class="form-control" id="payInvoicePayment" type="number" min="0">
            </div>

        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $profileLang['close']; ?></button>
          <button type="button" class="btn btn-success" id="addCashToInvoice" onclick="addCashToInvoice()"><?php echo $profileLang['payDue']; ?></button>
        </div>
      </div>
    </div>
	</div>
	<?php }
	else{?>
		
		
		<div class="modal fade" id="payNow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $profileLang['paymentForUnpaidInvoice']; ?></h4>
        </div>
        <div class="modal-body">
				<div class="catStatusHeight">
					<div id="catStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $profileLang['paymentAddedSuccessfully']; ?></strong> 
						</div>
					</div>
					<div id="catStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $profileLang['paymentFailed']; ?></strong> 
						</div>
					</div>
					<div id="catStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $profileLang['fillAllFields']; ?></strong> 
						</div>
					</div>
					<div id="catStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <?php echo $systemWords['pleasewait']; ?></strong> 
						</div>
					</div>
				</div>
          <table class="table">
            <tr>
              <td>
                <label><?php echo $profileLang['invoiceID']; ?></label>
                <h4 id="payInvoiceID"></h4></td>
              <td>
                <label><?php echo $profileLang['invoiceDate']; ?></label>
                <h4 id="payInvoiceDate"></h4>
              </td>
              <td>
                <label><?php echo $profileLang['invoiceTime']; ?></label>
                <h4 id="payInvoiceTime"></h4>
              </td>
            </tr>
            <tr>
              <td>
                <label><?php echo $profileLang['invoiceTotal']; ?></label>
                <h4 id="payInvoiceTotal"></h4>
              </td>
              <td>
                <label><?php echo $profileLang['invoicePaid']; ?></label>
                <h4 id="payInvoicePaid"></h4>
              </td>
              <td>
                <label><?php echo $profileLang['invoiceDue']; ?></label>
                <h2 id="payInvoiceDue" class="delete">2233</h2>
              </td>
            </tr>
          </table>
						
					
					<div id="payFromBalanceSection" style="display: none"> 
							<div class="checkbox">
								<label>
									<input type="checkbox" id="useBalance"> <?php echo $profileLang['useBalance']; ?>
								</label>
							</div>
							<div id="payFromBalance" style="display: none">
								<p><?php echo $profileLang['availableBalance']; ?> <strong id="availableBalance"> </strong></p>
								<div class="form-group">
									<label><?php echo $profileLang['payFromBalance']; ?></label>
									<input class="form-control" id="payFromBalanceAmount" type="number" min="0">
								</div>
							</div>
						</div>
					
					<div class="form-group">
						<label><?php echo $profileLang['selectCashAccount']; ?></label>
						<select name="cashID" id="cashSelect" class="form-control">
							<option value="" disabled selected><?php echo $profileLang['selectACashAccount']; ?></option>
						<?php
								foreach ($data['data']['cash'] as $row) {
										echo '<option value="'.$row['cashID'].','.$row['cashName'].','.$row['balance'].'">'.$row['cashName'].'</option>';
								}
						?>
							</select>
					</div>
					
            <div class="form-group">
							<input class="form-control" id="availableCashBalance" type="hidden" min="0" readonly>
							<label id="availableBalanceLabel"> </label><br>
              <label><?php echo $profileLang['payDueAmount']; ?></label>
              <input class="form-control" id="payInvoicePayment" type="number" min="0">
            </div>

        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $profileLang['close']; ?></button>
          <button type="button" class="btn btn-success" onclick="payCashToInvoice()"><?php echo $profileLang['payDue']; ?></button>
        </div>
      </div>
    </div>
	</div>
		
		
		
		<?php }?>
	<!-- Pay Now Modal End -->
	
	<!-- Deposit Modal -->
	<div class="modal fade" id="depositNow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $profileLang['advancePayment']; ?></h4>
        </div>
        <div class="modal-body">
				<div class="catStatusHeight">
					<div id="advStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $profileLang['advancePaymentAddedSuccessfully']; ?></strong> 
						</div>
					</div>
					<div id="advStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $profileLang['advancePaymentFailed']; ?></strong> 
						</div>
					</div>
					<div id="advStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $profileLang['fillAllFields']; ?></strong> 
						</div>
					</div>
					<div id="advStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <?php echo $systemWords['pleasewait']; ?></strong> 
						</div>
					</div>
				</div>
          <table class="table">
						<tr>
							<td>
								<label><?php echo $profileLang['currentBalance']; ?></label>
								<h4 id="currentBalance"> 12345</h4>
							</td>
							<?php
						if($data['data']['type']=="Customer"){?>
							<td>
								<label><?php echo $profileLang['newBalance']; ?></label>
								<h1 id="newBalance"> <i id="newBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i></h1>
							</td>
						<?php } ?>	
						</tr>
					</table>
            <hr>
						<?php
						if($data['data']['type']=="Customer"){?>
            <div class="form-group">
              <label><?php echo $profileLang['advancePaymentAmount']; ?></label>
              <input class="form-control" id="payAdvancePayment1" type="number" min="0">
            </div>
						<div class="form-group">
              <label><?php echo $profileLang['repeatAdvancePaymentAmount']; ?></label>
              <input class="form-control" id="payAdvancePayment2" type="number" min="0">
            </div>
						<?php }
					else{ ?>
						<div class="form-group">
						<label><?php echo $profileLang['selectCashAccount']; ?></label>
						<select name="cashID" id="cashSelectDeposit" class="form-control">
							<option value="" disabled selected><?php echo $profileLang['selectACashAccount']; ?></option>
						<?php
								foreach ($data['data']['cash'] as $row) {
										echo '<option value="'.$row['cashID'].','.$row['cashName'].','.$row['balance'].'">'.$row['cashName'].'</option>';
								}
						?>
							</select>
					</div>
					
            <div class="form-group">
							<input class="form-control" id="availableCashBalanceDeposit" type="hidden" min="0" readonly>
							<label id="availableBalanceLabelDeposit"> </label><br>
              <label><?php echo $profileLang['depositAmount']; ?> </label>
              <input class="form-control" id="payDepositPayment1" oninput="depositPaymentSupplier()" type="number" min="0"><br>
							 <label><?php echo $profileLang['repeatDepositAmount']; ?></label>
              <input class="form-control" id="payDepositPayment2" oninput="depositPaymentSupplier()" type="number" min="0">
            </div>
					<?php }?>
					
						<div class="form-group">
							<label><?php echo $profileLang['transactionNote']; ?></label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-list-alt"></i>
									</span>
									<textarea id="cashAvdanceNote" class="form-control">

									</textarea>
								</div>
					 </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $profileLang['close']; ?></button>
					<?php
						if($data['data']['type']=="Customer"){?>
          <button type="button" class="btn btn-success" onclick="addCashAdvance()"><?php echo $profileLang['payAdvance']; ?></button>
					<?php }
					else{ ?>
						<button type="button" class="btn btn-success" onclick="addCashAdvancePayment()"><?php echo $profileLang['payAdvance']; ?></button>
					<?php } ?>
        </div>
      </div>
    </div>
	</div>
	<!-- Deposit Modal End -->
	<!-- Withdraw Modal -->
	<div class="modal fade" id="withdrawNow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><?php echo $profileLang['balanceWithdraw']; ?></h4>
        </div>
        <div class="modal-body">
				<div class="catStatusHeight">
					<div id="wStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $profileLang['balanceWithdrawSuccessful']; ?></strong> 
						</div>
					</div>
					<div id="wStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $profileLang['balanceWithdrawFailed']; ?></strong> 
						</div>
					</div>
					<div id="wStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $profileLang['fillAllFields']; ?> </strong> 
						</div>
					</div>
					<div id="wStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <?php echo $systemWords['pleasewait']; ?></strong> 
						</div>
					</div>
				</div>
          <table class="table">
						<tr>
							<td>
								<label><?php echo $profileLang['currentBalance']; ?> </label>
								<h4 id="currentBalanceW"> 12345</h4>
							</td>
							<td>
								<label><?php echo $profileLang['newBalance']; ?> </label>
								<h1 id="newWithdrawBalance"> <i id="newWithdrawBalanceStatus" class="delete glyphicon glyphicon-warning-sign"></i></h1>
							</td>
							
						</tr>
					</table>
            <hr>
            <div class="form-group">
              <label><?php echo $profileLang['withdrawAmount']; ?> </label>
              <input class="form-control" id="withdrawBalance1" type="number" min="0">
            </div>
						<div class="form-group">
              <label><?php echo $profileLang['repeatWithdrawAmount']; ?>  </label>
              <input class="form-control" id="withdrawBalance2" type="number" min="0">
            </div>
						<div class="form-group">
							<label><?php echo $profileLang['transactionNote']; ?> </label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-list-alt"></i>
									</span>
									<textarea id="cashWithdrawNote" class="form-control">

									</textarea>
								</div>
					 </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $profileLang['close']; ?></button>
					<?php
						if($data['data']['type']=="Customer"){?>
          <button type="button" class="btn btn-danger" onclick="withdrawBalanceSubmit()"><?php echo $profileLang['withdrawBalance']; ?></button>
					<?php }
					else{ ?>
						<button type="button" class="btn btn-danger" onclick="withdrawBalanceSubmitSupplier()"><?php echo $profileLang['withdrawBalance']; ?></button>
					<?php } ?>
					
        </div>
      </div>
    </div>
	</div>
	<!-- Withdraw Modal End -->
	<!-- Edit Profile Modal -->
  <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"> <?php $intext = "edit".$data['data']['type']."Profile";echo $profileLang[$intext]; ?> </h4>
        </div>
        <div class="modal-body">
				<div class="catStatusHeight">
					<div id="editStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $profileLang['profileEditSuccessful']; ?></strong> 
						</div>
					</div>
					<div id="editStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $profileLang['profileEditFailed']; ?></strong> 
						</div>
					</div>
					<div id="editStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $profileLang['fillAllFields']; ?></strong> 
						</div>
					</div>
					<div id="editStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <?php echo $systemWords['pleasewait']; ?></strong> 
						</div>
					</div>
				</div>
          <form class="form">
                           <div class="form-group">
                                <label><?php echo $profileLang['name']; ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" id="editSCName" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label><?php echo $profileLang['contactPersonName']; ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" id="editSCFather" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label><?php echo $profileLang['contactNumber']; ?> </label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-earphone"></i>
                                    </span>
                                    <input type="text" id="editSCPhone" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label><?php echo $profileLang['address']; ?> </label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <textarea id="editSCAddress" class="form-control">

                                    </textarea>
                                </div>
                           </div>
                           <div class="form-group">
                                <label><?php echo $profileLang['creditLimit']; ?> </label>
                                <div class="input-group">
                                    <b class="input-group-addon">
                                        <i class="glyphicon glyphicon-usd"></i>
                                    </b>
                                    <input type="text" id="editSCLimit" class="form-control">
                                </div>
                           </div>
                       </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $profileLang['close']; ?></button>
          <button type="button" class="btn btn-success" onclick="editCustomer()"><?php echo $profileLang['editProfile']; ?></button>
        </div>
      </div>
    </div>
	</div>
	<!-- Edit Profile Modal End -->
</body>