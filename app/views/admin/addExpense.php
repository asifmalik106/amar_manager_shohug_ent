<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header" align="center">Add New Expense</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
              
                
                    <div id="cashStatusTrue" style="display: none">
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-ok"></i> Expense Added Successfully!</strong> 
                        </div>
                        <h4 align="center"><a href="<?php echo BASE_URL; ?>admin/expense/">Click Here</a> for Updated Information</h4>
                    </div>
                    <div id="cashStatusFalse" style="display: none">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-remove"></i>Failed to Add Expense!</strong> 
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
                        <h4 class="panel-title" align="center"><strong>Add Expense Form</strong></h4>
                    </div>
                    <div class="panel-body">
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
                                <label>Select Expense Category</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-file"></i>
                                    </span>
                                    <select id="selectExpenseCategory" class="form-control" required> 
                                        <option value="" disabled="1" selected="1">Selece a Expense Category</option>
                                    <?php
                                        foreach($data['data']['expense'] as $key){
                                            echo '<option value="'.$key['accountID'].'">'.$key['accountName'].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                           </div>
                          
                          <div class="form-group">
                                <label>Expense Amount</label>
                                <div class="input-group">
                                    <b class="input-group-addon">
                                        <i class="glyphicon glyphicon-usd"></i>
                                    </b>
                                    <input type="number" id="expenseAmount" class="form-control" readonly="0" required>
                                </div>
                           </div>
                           <div class="form-group">
                                <label>Expense Note</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-list-alt"></i>
                                    </span>
                                    <textarea id="expenseNote" class="form-control">

                                    </textarea>
                                </div>
                           </div>
                           
                           <button class="btn btn-lg btn-primary pull-right" type="button" onclick="addExpense()"><span class="glyphicon glyphicon-plus"></span> Add Expense</button>
                       
                        </form>
                      </div>
                    </div>
                </div>

            
          </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>