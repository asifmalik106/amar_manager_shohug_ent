<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header" align="center">Add New Employee</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                
                    <div id="employeeStatusTrue" style="display: none">
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-ok"></i> Employee Added Successfully!</strong> 
                        </div>
                        <h4 align="center"><a href="<?php echo BASE_URL; ?>admin/employee/">Click Here</a> for Updated Information</h4>
                    </div>
                    <div id="employeeStatusFalse" style="display: none">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-remove"></i> Failed to Add Employee!</strong> 
                        </div>
                    </div>
                    <div id="employeeStatusEmpty" style="display: none">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-info-sign"></i> Fill All Fields...</strong> 
                        </div>
                    </div>
                    <div id="employeeStatusDuplicate" style="display: none">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-warning-sign"></i> Employee Already Exists!!!</strong> 
                        </div>
                    </div>
                    <div id="employeeStatusLoading" style="display: none">
                        <div class="alert" role="alert">
                        <p align="center"><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <strong>Please Wait..</strong></p> 
                        </div>
                    </div>
                

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title" align="center"><strong>Add New Employee Form</strong></h4>
                    </div>
                    <div class="panel-body">
                       <form class="form">
                           <div class="form-group">
                                <label>Employee Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" id="newEmployeeName" class="form-control"> 
                                </div>
                           </div>
                           
                           <div class="form-group">
                                <label>Contact Number</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-earphone"></i>
                                    </span>
                                    <input type="text" id="newEmployeePhone" class="form-control"> 
                                </div>
                           </div>
                          <div class="form-group">
                                <label>Daily Salary</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="font-size:18px; font-weight: 900">৳
                                        
                                    </span>
                                    <input type="text" id="newEmployeeSalary" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label>Fine on Absentee</label>
                                <div class="input-group">
                                    <b class="input-group-addon">
                                        <i class="glyphicon glyphicon-warning-sign"></i>
                                    </b>
                                    <input type="text" id="newEmployeeFine" class="form-control">
                                </div>
                           </div>
                          <div class="form-group">
                                <label>Employee Information</label>
                                <div class="input-group">
                                    <b class="input-group-addon">
                                        <i class="glyphicon glyphicon-flash"></i>
                                    </b>
                                    <input type="text" id="newEmployeeInfo" class="form-control">
                                </div>
                           </div>
                           <button class="btn btn-lg btn-primary pull-right" type="button" onclick="addEmployee()"><span class="glyphicon glyphicon-plus"></span> Add New Employee</button>
                       </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>