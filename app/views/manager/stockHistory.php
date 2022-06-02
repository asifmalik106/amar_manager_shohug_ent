<body>
        <?php include 'asset/includes/sidebar-manager.php';?>
        <div id="page-wrapper">

            <div class="row">
                
                <div class="col-lg-12">
                <?php include 'system/notification.php'; ?>
                    <h2 class="page-header"><?php echo $adminIndex['stock']; ?></h2>
                </div>
                           
                <div class="col-lg-12 custom-table-height">
                    <table class="table table-striped table-bordered" cellspacing="0" id="dStock">
                        <thead>
                            <tr>
                                <td>Invoice ID</td>
                                <td>Date (Time)</td>
                                <td>Product ID</td>
                                <td>Product Name</td>
                                <td>Batch</td>
                                <td>Ouantity</td>
                                <td>Retail Price</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $i = 1;
                                while($row = $data['data']['stock']->fetch_assoc()){
                                  
                                    echo "<tr>";
                                    echo "<td>".$row['invoiceID']."</td>";
                                    echo "<td>".date("d/m/Y", strtotime($row['invoiceDate']))." (".date("h:m A", strtotime($row['invoiceTime'])).")</td>";
                                    
                                    echo "<td>".$row['productID']."</td>";
                                      echo "<td>".$row['invoiceProductName']."</td>";
                                    echo "<td>".$row['invoiceBatch']."</td>";
                                  echo "<td>".$row['invoiceQuantity']." ".$row['invoiceProductCategoryUnit']."</td>";  
                                  echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['invoiceSale']."</td>";
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