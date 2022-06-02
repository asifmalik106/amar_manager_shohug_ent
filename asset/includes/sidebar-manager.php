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
                        <li><a href="<?php echo BASE_URL; ?>manager/settings"><i class="fa fa-gear fa-fw"></i> <?php echo $sidebar['settings']; ?></a>
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
                            <a href="<?php echo BASE_URL; ?>manager/"><i class="fa fa-dashboard fa-lg"></i>  <?php echo $sidebar['stock']; ?></a>
                        </li>
                      
                      <li>
                            <a href="<?php echo BASE_URL; ?>manager/purchaseHistory"><i class="fa fa-history fa-lg"></i>  Stock History</a>
                        </li>
                        
                        <li>
                            <a href="<?php echo BASE_URL; ?>manager/sale/"><i class="fa fa-cart-plus fa-lg"></i>  <?php echo $sidebar['sales']; ?></a>
                        </li>
 
                        <li>
                            <a href="<?php echo BASE_URL; ?>manager/invoiceReturn/"><i class="fa fa-refresh fa-lg"></i>  <?php echo $sidebar['return']; ?></a>
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-user-plus fa-lg"></i>  <?php echo $sidebar['customers']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>manager/customer/"><?php echo $sidebar['customersList']; ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>manager/customer/new/"><?php echo $sidebar['addNewCustomer']; ?></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        


                        <li>
                            <a href="#"><i class="fa fa-file-text-o fa-lg"></i>  <?php echo $sidebar['invoices']; ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>manager/invoice/sale">  <?php echo $sidebar['saleInvoices']; ?></a>
                                </li>
                            </ul>
                        </li>
              
                        <li>
                            <a href="<?php echo BASE_URL; ?>manager/settings"><i class="fa fa-wrench fa-lg"></i>  <?php echo $sidebar['settings']; ?></a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->

                    </nav>