<body>
        <?php include 'asset/includes/sidebar.php';?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
<?php include 'system/notification.php'; ?>
                    <h2 class="page-header"><?php echo $adminIndex['dashboard']; ?></h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-money fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h1><?php 
                                      echo $_SESSION['data']['businessCurrency']." ".(float)$data['data']['balance']->fetch_assoc()['balance'];
                                     /* $out = (double)($data['data']['balance']->fetch_assoc()['balance']); 
                                      $bn_digits=array('০','১','২','৩','৪','৫','৬','৭','৮','৯');
                                      $output = str_replace(range(0, 9),$bn_digits, $out); 
                                      echo $output;*/
                                      ?></h1>
                                    <h4><?php echo $adminIndex['cashBalance']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo BASE_URL; ?>admin/cash/">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo $adminIndex['viewDetails']; ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                              <div class="col-lg-4 col-md-8">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-money fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h1><?php 
                                      echo $_SESSION['data']['businessCurrency']." ".(float)$data['data']['unearned'];
                                     /* $out = (double)($data['data']['balance']->fetch_assoc()['balance']); 
                                      $bn_digits=array('০','১','২','৩','৪','৫','৬','৭','৮','৯');
                                      $output = str_replace(range(0, 9),$bn_digits, $out); 
                                      echo $output;*/
                                      ?></h1>
                                    <h4><?php echo $adminIndex['unearnedRevenue']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo BASE_URL; ?>admin/misc/unearned/">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo $adminIndex['viewDetails']; ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-8">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-warning fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h1>
                                        <?php
                                            echo $_SESSION['data']['businessCurrency']." ".$data['data']['receivable'];
                                        ?>
                                    </h1>
                                    <h4><?php echo $adminIndex['accountsReceivable']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo BASE_URL; ?>admin/misc/receivable/">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo $adminIndex['viewDetails']; ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-8">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h1>
                                        <?php
                                            echo $data['data']['danger'];
                                        ?>
                                    </h1>
                                    <h4><?php echo $adminIndex['dangerZone']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo BASE_URL; ?>admin/misc/dangerzone/">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo $adminIndex['viewDetails']; ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>





                <div class="col-lg-4 col-md-8">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-archive fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h1><?php
                                            echo $data['data']['warning'];
                                        ?></h1>
                                    <h4><?php echo $adminIndex['stockWarning']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo BASE_URL; ?>admin/misc/productWarning/">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo $adminIndex['viewDetails']; ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-8">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-exclamation-circle fa-4x"></i>
                                    
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h1><?php
                                            echo $data['data']['out'];
                                        ?></h1>
                                    <h4><?php echo $adminIndex['outOfStock']; ?>!!!</h4>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo BASE_URL; ?>admin/misc/outOfStock/">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo $adminIndex['viewDetails']; ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <!-- /.row -->
            <div class="row">
                
                <div class="col-lg-12">
                    <h2 class="page-header"><?php echo $adminIndex['stock']; ?></h2>
                </div>

                <div class="col-lg-12 custom-table-height">
                    <table class="table table-striped table-bordered" cellspacing="0" id="dStock">
                        <thead>
                            <tr>
                                <td><?php echo $adminIndex['serial']; ?></td>
                                <td><?php echo $adminIndex['productName']; ?></td>
                                <td><?php echo $adminIndex['category']; ?></td>
                                <td><?php echo $adminIndex['batch']; ?></td>
                                <td><?php echo $adminIndex['stockLimit']; ?></td>
                                <td><?php echo $adminIndex['stockQuantity']; ?></td>
                                <td><?php echo $adminIndex['retailPrice']; ?></td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $i = 1;
                                while($row = $data['data']['stock']->fetch_assoc()){
                                    echo "<tr>";
                                    echo "<td>".$row['productID']."</td>";
                                    echo "<td>".$row['productName']."</td>";
                                    echo "<td>".$row['categoryName']." (".$row['categoryUnit'].")</td>";
                                    echo "<td>".$row['batch']."</td>";
                                    echo "<td>".$row['productLimit']."</td>";
                                    echo "<td>".$row['quantity']."</td>";
                                    echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['saleUnit']."</td>";
                                    echo "</tr>";
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
        <!-- /#page-wrapper -->
</body>