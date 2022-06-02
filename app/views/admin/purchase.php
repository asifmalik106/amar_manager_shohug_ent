<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php include 'system/notification.php'; ?>
                <h2 class="page-header"><?php echo $adminPurchase['purchaseEntry']; ?></h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <form method="POST" action="<?php echo BASE_URL; ?>admin/purchase/final/">
                <div class="col-md-9">
                    <div class="form-group">
                        <strong><?php echo $adminPurchase['selectSupplier']; ?></strong>
                        <select id="selectSupplier" name="supplierID" class="form-control" required>
                            <option value="" disabled="1" selected><?php echo $adminPurchase['selectASupplier']; ?></option>
                        <?php 
                            foreach($data['data']['supplier'] as $row)
                            {
                              echo "<option value=\"".$row['scID']."\" balance=\"".$row['balance']."\">".$row['scID']." - ".$row['scNameCompany']." - ".$row['scContactNo']."</option>";
                            }
                        ?>
                        </select>
                    </div>

                    <table class="table table-bordered table-condensed" id="productForPurchase">
                        <thead>
                            <tr>
                                <th><?php echo $adminPurchase['productID']; ?></th>
                                <th><?php echo $adminPurchase['productName']; ?></th>
                                <th><?php echo $adminPurchase['batch']; ?></th>
                                <th><?php echo $adminPurchase['category']; ?></th>
                                <th><?php echo $adminPurchase['purchaseRate']; ?></th>
                                <th><?php echo $adminPurchase['retailRate']; ?></th>
                                <th><?php echo $adminPurchase['stockQuantity']; ?></th>
                                <th><?php echo $adminPurchase['limit']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($data['data']['purchase'] as $product){
                                  echo "<tr class='mouseHover'><input class='cartStatus' type='hidden' value='0'>";
                                  echo "<td class='pID'>".$product['pID']."</td>";
                                  echo "<td class='pName'>".$product['pName']."</td>";
                                  echo "<td class='pBatch'>".$product['pBatch']."</td>";
                                  echo "<td class='pCategory'>".$product['pCategory']."</td>";
                                  echo "<td class='pPurchase'>".$product['purchaseUnit']."</td>";
                                  echo "<td class='pSale'>".$product['saleUnit']."</td>";
                                  echo "<td class='pQuantity'>".$product['pQuantity']."</td>";
                                  echo "<td class='pLimit'><p style='display:none'>".$product['barcode']."</p>".$product['pLimit']."</td>";
                                  echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo $adminPurchase['serial']; ?></th>
                                <th><?php echo $adminPurchase['productName']; ?></th>
                                <th width="12%"><?php echo $adminPurchase['batch']; ?></th>
                                <th><?php echo $adminPurchase['quantity']; ?></th>
                                <th><?php echo $adminPurchase['purchaseRate']; ?></th>
                                <th><?php echo $adminPurchase['retailRate']; ?></th>
                                <th><?php echo $adminPurchase['total']; ?></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody class="purchase">
                           
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                  <div class="selectSupplierVisible" style="display:none">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <strong><p align="center"><?php echo $adminPurchase['paymentInfo']; ?></p></strong>
                        </div>
                        <div class="panel-body">
                        <?php
                            foreach ($data['data']['cash'] as $row) {
                                echo '<div class="form-group">';
                                echo '<label>'.$row['cashName'].' <span class="cashLeft"> '.$row['balance'].'</span></label>';
                                echo '<input type="hidden" name="cashBalance" value="'.$row['balance'].'">';
                                echo '<input type="hidden" name="cashID[]" value="'.$row['cashID'].'">';
                                echo '<input class="form-control cashAmount" name="cashAmount[]">';
                                echo '</div>';
                            }
                        ?>
                        </div>
                    </div>
                  
                      <div class="panel panel-primary">
                        <div class="panel-heading">
                            <strong><p align="center"><?php echo $adminPurchase['payFromBalance']; ?></p></strong>
                        </div>
                        <div class="panel-body">
                          <div class="form-group">
                            <label><?php echo $adminPurchase['balance']; ?>: <span id="supplierBalance"></span></label>
                            <input class="form-control" id="payFromSupplierBalance" name="payFromSupplierBalance">
                          </div>
                        </div>
                      </div>
                  
              </div>
                  
                    <div class="panel panel-primary float-panel">
                        <div class="panel-heading">
                            <strong><p align="center"><?php echo $adminPurchase['purchaseInfo']; ?></p></strong>
                        </div>
                        <div class="panel-body">
                        <h4><?php echo $adminPurchase['total']; ?>: <strong class="pull-right" id="grandTotal">0.0</strong></h4>
                        <input type="hidden" name="grandTotal" value="0.0">
                        <h4><?php echo $adminPurchase['cashPayment']; ?>: <strong class="pull-right" id="paymentTotal">0.0</strong></h4>
                        <input type="hidden" name="paymentTotal" value="0.0">
                        <hr>
                        <h4><?php echo $adminPurchase['due']; ?>: <strong class="pull-right delete" id="dueTotal">0.0</strong></h4>
                        <h4><?php echo $adminPurchase['return']; ?>: <strong class="pull-right edit" id="advanceTotal">0.0</strong></h4>
                        <hr>
                        <h5><?php echo $adminPurchase['purchaseNote']; ?>:</h5>
                        <textarea class="form-control" name="invoiceNote"></textarea>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-success"><?php echo $adminPurchase['submit']; ?></button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>