<body>
    <?php include 'asset/includes/sidebar-manager.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php include 'system/notification.php'; ?>
                <h2 class="page-header" align="center">Add New Customer</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                
                    <div id="customerStatusTrue" style="display: none">
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-ok"></i> Customer Added Successfully!</strong> 
                        </div>
                        <h4 align="center"><a href="<?php echo BASE_URL; ?>manager/customer/">Click Here</a> for Updated Information</h4>
                    </div>
                    <div id="customerStatusFalse" style="display: none">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-remove"></i> Failed to Add Customer!</strong> 
                        </div>
                    </div>
                    <div id="customerStatusEmpty" style="display: none">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-info-sign"></i> Fill All Fields...</strong> 
                        </div>
                    </div>
                    <div id="customerStatusDuplicate" style="display: none">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-warning-sign"></i> Customer Already Exists!!!</strong> 
                        </div>
                    </div>
                    <div id="customerStatusLoading" style="display: none">
                        <div class="alert" role="alert">
                        <p align="center"><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <strong>Please Wait..</strong></p> 
                        </div>
                    </div>
                

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title" align="center"><strong>Add New Customer Form</strong></h4>
                    </div>
                    <div class="panel-body">
                       <form class="form">
                           <div class="form-group">
                                <label>Customer Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" id="newCustomerName" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label>Father's Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" id="newCustomerFather" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label>Contact Number</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-earphone"></i>
                                    </span>
                                    <input type="text" id="newCustomerPhone" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label>Customer Address</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <textarea id="newCustomerAddress" class="form-control">

                                    </textarea>
                                </div>
                           </div>
                           <div class="form-group">
                                <label>Credit Limit</label>
                                <div class="input-group">
                                    <b class="input-group-addon">
                                        <i class="glyphicon glyphicon-usd"></i>
                                    </b>
                                    <input type="text" id="newCustomerLimit" class="form-control">
                                </div>
                           </div>
                         
                         
                           <button class="btn btn-lg btn-primary pull-right" type="button" onclick="addCustomer()"><span class="glyphicon glyphicon-plus"></span> Add New Customer</button>
                       </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>