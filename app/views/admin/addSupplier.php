<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header" align="center"><?php echo $newSupplier['addNewSupplier']; ?></h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                
                    <div id="supplierStatusTrue" style="display: none">
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-ok"></i> <?php echo $newSupplier['supplierAddedSuccessfully']; ?></strong> 
                        </div>
                        <h4 align="center"><a href="<?php echo BASE_URL; ?>/admin/supplier/"><?php echo $newSupplier['clickHere']; ?></a> <?php echo $newSupplier['updatedInformation']; ?></h4>
                    </div>
                    <div id="supplierStatusFalse" style="display: none">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-remove"></i> <?php echo $newSupplier['failedToAddSupplier']; ?></strong> 
                        </div>
                    </div>
                    <div id="supplierStatusEmpty" style="display: none">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $newSupplier['fillAllFields']; ?></strong> 
                        </div>
                    </div>
                    <div id="supplierStatusDuplicate" style="display: none">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="glyphicon glyphicon-warning-sign"></i> <?php echo $newSupplier['supplierAlreadyExists']; ?></strong> 
                        </div>
                    </div>
                    <div id="supplierStatusLoading" style="display: none">
                        <div class="alert" role="alert">
                        <p align="center"><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <strong><?php echo $systemWords['pleasewait']; ?></strong></p> 
                        </div>
                    </div>
                

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title" align="center"><strong><?php echo $newSupplier['addNewSupplierForm']; ?></strong></h4>
                    </div>
                    <div class="panel-body">
                       <form class="form">
                           <div class="form-group">
                                <label><?php echo $newSupplier['supplierName']; ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" id="newSupplierName" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label><?php echo $newSupplier['contactPerson']; ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" id="newSupplierFather" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label><?php echo $newSupplier['contactNo']; ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-earphone"></i>
                                    </span>
                                    <input type="text" id="newSupplierPhone" class="form-control"> 
                                </div>
                           </div>
                           <div class="form-group">
                                <label><?php echo $newSupplier['supplierAddress']; ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <textarea id="newSupplierAddress" class="form-control">

                                    </textarea>
                                </div>
                           </div>
                           <div class="form-group">
                                <label><?php echo $newSupplier['creditLimit']; ?></label>
                                <div class="input-group">
                                    <b class="input-group-addon">
                                        <i class="glyphicon glyphicon-usd"></i>
                                    </b>
                                    <input type="text" id="newSupplierLimit" class="form-control">
                                </div>
                           </div>
                           <button class="btn btn-lg btn-primary pull-right" type="button" onclick="addSupplier()"><span class="glyphicon glyphicon-plus"></span> <?php echo $newSupplier['addNewSupplier']; ?></button>
                       </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>