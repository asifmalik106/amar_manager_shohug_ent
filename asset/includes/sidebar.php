        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top custom-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle toggle-button-rwd" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo BASE_URL; ?>">আমার Manager</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle user" data-toggle="dropdown" href="#">
                        <span class=""><i class="fa fa-user fa-fw"></i><?php echo $_SESSION['data']['name']; ?> <i class="fa fa-caret-down"></i></span>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo BASE_URL; ?>admin/settings"><i class="fa fa-gear fa-fw"></i> <?php echo $sidebar['settings']; ?></a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo BASE_URL; ?>main/logout/"><i class="fa fa-sign-out fa-fw"></i> <?php echo $sidebar['logout']; ?></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       
                        <li class="sidebar-search">
                            <small><?php echo $sidebar['license']; ?></small>
                           <h4><?php echo $_SESSION['data']['businessName']; ?></h4>
                           <p><?php echo $_SESSION['data']['businessAddress']; ?></p>
                            <!-- /input-group -->
                        </li>

                        <li>
                            <a href="<?php echo BASE_URL; ?>admin/"><i class="fa fa-dashboard fa-lg"></i>  <?php echo $sidebar['dashboard']; ?></a>
                        </li>
                        
                        <li>
                            <a href="<?php echo BASE_URL; ?>admin/sale/"><i class="fa fa-cart-plus fa-lg"></i>  <?php echo $sidebar['sales']; ?></a>
                        </li>
                        

                        <li>
                            <a href="<?php echo BASE_URL; ?>admin/purchase/"><i class="fa fa-cart-arrow-down fa-lg"></i>  <?php echo $sidebar['purchases']; ?></a>
                        </li>
 
                        <li>
                            <a href="<?php echo BASE_URL; ?>admin/invoiceReturn/"><i class="fa fa-refresh fa-lg"></i>  <?php echo $sidebar['return']; ?></a>
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-archive fa-lg"></i>  <?php echo $sidebar['products']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/product/"><?php echo $sidebar['allProducts']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/product/add"><?php echo $sidebar['addNewProduct']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/category/"><?php echo $sidebar['productCategories']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/product/barcode">BARCODE</a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-truck fa-lg"></i>  <?php echo $sidebar['suppliers']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/supplier/"><?php echo $sidebar['suppliersList']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/supplier/new/"><?php echo $sidebar['addNewSupplier']; ?></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-user-plus fa-lg"></i>  <?php echo $sidebar['customers']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/customer/"><?php echo $sidebar['customersList']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/customer/new/"><?php echo $sidebar['addNewCustomer']; ?></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>


                        <li>
                            <a href="#"><i class="fa fa-money fa-lg"></i>  <?php echo $sidebar['cashAccounts']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/cash/"><?php echo $sidebar['cashTransactions']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/cash/new/"><?php echo $sidebar['addNewCashTransaction']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/cash/accounts/"><?php echo $sidebar['cashAccountsList']; ?></a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-minus-square fa-lg"></i>  <?php echo $sidebar['expenses']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/expense"><?php echo $sidebar['allExpenses']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/expense/new"><?php echo $sidebar['addNewExpense']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/expense/category/"><?php echo $sidebar['expenseCategories']; ?></a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-minus-square fa-lg"></i>  <?php echo $sidebar['drawings']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/drawing">  <?php echo $sidebar['allDrawings']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/drawing/new">  <?php echo $sidebar['addNewDrawing']; ?></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-file-text-o fa-lg"></i>  <?php echo $sidebar['invoices']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/invoice/sale">  <?php echo $sidebar['saleInvoices']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/invoice/purchase">  <?php echo $sidebar['purchaseInvoices']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/invoice/discount">  Discounted Invoice</a>
                                </li>
                              
                            </ul>
                        </li>
                            
                        <li>
                            <a href="#"><i class="fa fa-address-book fa-lg"></i> Attandance <?php //echo $sidebar['invoices']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/attandance"> Attandance List <?php //echo $sidebar['saleInvoices']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/employee/new"> Add New Employee <?php //echo $sidebar['purchaseInvoices']; ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-file-pdf-o fa-lg"></i>  <?php echo $sidebar['reports']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/report/profit">  <?php echo $sidebar['dailyProfitReport']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/report/income">  <?php echo $sidebar['incomeStatement']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>admin/report/ledger"> Ledger Statement</a>
                                </li>
                              
                              <li>
                                    <a href="<?php echo BASE_URL; ?>admin/report/collection"> Collection Report</a>
                                </li>
                            
                            </ul>
                        </li>
              

                        <li>
                            <a href="<?php echo BASE_URL; ?>admin/sms"><i class="fa fa-envelope-o fa-lg"></i>  <?php echo $sidebar['sms']; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>admin/settings"><i class="fa fa-wrench fa-lg"></i>  <?php echo $sidebar['settings']; ?></a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->

                    </nav>