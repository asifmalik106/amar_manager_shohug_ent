<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header" align="center">Add New Cash Transaction</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
              
                
                    <div id="cashStatusTrue" style="display: none">
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-ok"></i> Cash Transaction Successful!</strong> 
                        </div>
                        <h4 align="center"><a href="<?php echo BASE_URL; ?>admin/cash/">Click Here</a> for Updated Information</h4>
                    </div>
                    <div id="cashStatusFalse" style="display: none">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-remove"></i>Cash Transaction Failed!</strong> 
                        </div>
                    </div>
                    <div id="cashStatusEmpty" style="display: none">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-info-sign"></i> Fill All Fields...</strong> 
                        </div>
                    </div>
                    <div id="cashStatusLoading" style="display: none">
                        <div class="alert" role="alert">
                        <p align="center"><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <strong>Please Wait..</strong></p> 
                        </div>
                    </div>


                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title" align="center"><strong>Cash Transaction Form</strong></h4>
                    </div>
                    <div class="panel-body">
                      <div class="text-center">
                        <div class="btn-group pull-center" data-toggle="buttons" >
                          <label class="btn btn-default active" id="addCashToggle">
                            <input type="radio" name="options" autocomplete="off" checked>Add Cash
                          </label>
                          <label class="btn btn-default" id="transferCashToggle">
                            <input type="radio" name="options" autocomplete="off"> Transfer Cash
                          </label>
                        </div>
                      </div>
                      <div id="addCashDiv">
                        <h4 class="text-center"> Add Cash to Business </h4>
                        <form class="form">
                           <div class="form-group">
                                <label>Select Cash Account</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-file"></i>
                                    </span>
                                    <select id="selectCashAccount" class="form-control" required> 
                                        <option value="" disabled="1" selected="1">Selece a Cash Account</option>
                                    <?php
                                        foreach($data['data']['cashAccounts'] as $key){
                                            echo '<option value="'.$key['cashID'].'">'.$key['cashName']." (".$key['balance'].')</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                           </div>
                          
                          <div class="form-group">
                                <label>Cash Amount</label>
                                <div class="input-group">
                                    <b class="input-group-addon">
                                        <i class="glyphicon glyphicon-usd"></i>
                                    </b>
                                    <input type="number" id="cashAmount" class="form-control" required>
                                </div>
                           </div>
                           <div class="form-group">
                                <label>Transaction Note</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-list-alt"></i>
                                    </span>
                                    <textarea id="cashNote" class="form-control">

                                    </textarea>
                                </div>
                           </div>
                           
                           <button class="btn btn-lg btn-primary pull-right" type="button" onclick="addCash()"><span class="glyphicon glyphicon-plus"></span> Add Cash</button>
                       
                        </form>
                      </div>
                      <div id="transferCashDiv" style="display:none">
                        <h4 class="text-center"> Transfer Cash </h4>
                        <form class="form">
                          <div class="form-group">
                                <label>Select Source Cash Account</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-file"></i>
                                    </span>
                                    <select id="selectCashAccountS" class="form-control"> 
                                        <option value="" disabled="1" selected="1">Selece a Cash Account</option>
                                    <?php
                                        foreach($data['data']['cashAccounts'] as $key){
                                            echo '<option value="'.$key['cashID'].'" balance="'.$key['balance'].'">'.$key['cashName']." (".$key['balance'].')</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                           </div>
                          <div class="form-group">
                                <label>Available Amount To Transfer Cash</label>
                                <div class="input-group">
                                    <b class="input-group-addon">
                                        <i class="glyphicon glyphicon-flash"></i>
                                    </b>
                                    <input type="number" id="cashAmountAvailable" class="form-control" readonly>
                                </div>
                           </div>
                          <hr>
                          <div class="form-group">
                                <label>Select Destinated Cash Account</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-file"></i>
                                    </span>
                                    <select id="selectCashAccountD" class="form-control"> 
                                        <option value="" disabled="1" selected="1">Selece a Cash Account</option>
                                    </select>
                                </div>
                           </div>
                          <div class="form-group">
                                <label>Transfer Cash Amount</label>
                                <div class="input-group">
                                    <b class="input-group-addon">
                                        <i class="glyphicon glyphicon-usd"></i>
                                    </b>
                                    <input type="number" id="cashAmountTransfer" class="form-control" >
                                </div>
                           </div>
                           <div class="form-group">
                                <label>Transaction Note</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-list-alt"></i>
                                    </span>
                                    <textarea id="cashTransferNote" class="form-control">

                                    </textarea>
                                </div>
                           </div>
                           <button class="btn btn-lg btn-primary pull-right" type="button" onclick="transferCash()"><span class="glyphicon glyphicon-refresh"></span> Transfer Cash</button>

                        </form>
                      </div>
                    </div>
                </div>

            
          </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>