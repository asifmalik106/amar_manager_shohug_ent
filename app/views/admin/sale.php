<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php include 'system/notification.php'; ?>
                <h2 class="page-header"><?php echo $adminSale['saleEntry']; ?></h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <form method="POST" action="<?php echo BASE_URL; ?>admin/sale/add/">
                <div class="col-md-9">
                    <div class="form-group">
                        <strong><?php echo $adminSale['selectCustomer']; ?></strong>
                        <select id="selectCustomer" name="customerID" class="form-control" required>
                            <option value="" disabled="1" selected><?php echo $adminSale['selectACustomer']; ?></option>
                        <?php 
                            foreach($data['data']['customer'] as $row)
                            {
                                echo "<option value=\"".$row['scID']."\" balance=\"".$row['balance']."\">".$row['scID']." - ".$row['scNameCompany']." - ".$row['scContactNo']."</option>";
                            }
                        ?>
                        </select>
                    </div>
<p>Date: <input type="text" name="date" id="datepicker" required="1" value="<?php echo date('Y-m-d'); ?>" readonly> Today is: <?php date_default_timezone_set($_SESSION['data']['businessTimeZone']); echo "<b>".date('Y-m-d')."</b> Now: <b>".date('h:m:s A')."</b>"; ?></p>
                    <table class="table table-bordered table-condensed" id="productForSale">
                        <thead>
                            <tr>
                                <th><?php echo $adminSale['productID']; ?></th>
                                <th><?php echo $adminSale['productName']; ?></th>
                                <th><?php echo $adminSale['batch']; ?></th>
                                <th><?php echo $adminSale['category']; ?></th>
                                <th><?php echo $adminSale['retailRate']; ?></th>
                                <th><?php echo $adminSale['stockQuantity']; ?></th>
                                <th><?php echo $adminSale['limit']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while ($product = $data['data']['product']->fetch_assoc()) {
                                    echo "<tr class='mouseHover'><input class='cartStatus' type='hidden' value='0'>";
                                    echo "<td class='pID'>".$product['productID']."</td>";
                                    echo "<td class='pName'>".$product['productName']."</td>";
                                    echo "<td class='pBatch'>".$product['batch']."</td>";
                                    echo "<td class='pCategory'>".$product['categoryName']." (".$product['categoryUnit'].")"."</td>";
                                    echo "<td class='pSale'>".$product['saleUnit']."</td>";
                                    echo "<td class='pQuantity'>".$product['quantity']."</td>";
                                    echo "<td class='pLimit'><p style='display:none'>".$product['barcode']."</p>".$product['productLimit']."</td>";
                                    echo "";
                                    echo "</tr>";
                                }
                                /*foreach($data['data']['purchase'] as $product)
                                {
                                    
                                }*/
                            ?>
                        </tbody>
                    </table>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo $adminSale['serial']; ?></th>
                                <th><?php echo $adminSale['productName']; ?></th>
                                <th><?php echo $adminSale['batch']; ?></th>
                                <th><?php echo $adminSale['quantity']; ?></th>
                                <th><?php echo $adminSale['retailRate']; ?></th>
                                <th><?php echo $adminSale['total']; ?></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody class="purchase">
                           
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-primary float-panel">
                        <div class="panel-heading">
                            <strong><p align="center"><?php echo $adminSale['saleInfo']; ?></p></strong>
                        </div>
                        <div class="panel-body">
                        <h4><?php echo $adminSale['total']; ?>: <strong class="pull-right" id="grandTotal">0.0</strong></h4>
                        <input type="hidden" name="grandTotal" value="0.0">
                        <h4><?php echo $adminSale['discount']; ?></h4>
                        <input type="" name="discount" class="form-control input-lg" style="text-align:right;" placeholder="0.0" oninput="getGrandTotal()">
                        <hr>
                        <h4><?php echo $adminSale['grandTotal']; ?>: <strong class="pull-right" id="grandFinalTotal">0.0</strong></h4>
                        <hr><hr>
                        <h4><?php echo $adminSale['balance']; ?>: <strong class="pull-right" id="customerBalance">0.0</strong></h4>
                         <h4><?php echo $adminSale['payFromBalance']; ?>: <br> <strong class="pull-right" id="payFromBalance">0.0</strong></h4>
                          <input style="display:none" id="payFromBalanceInput" name="payFromBalanceInput">
                        <hr>
                         <h4><?php echo $adminSale['cashPayment']; ?></h4>
                          <select name="cashID" class="form-control">
                            <?php
                            while($cashList = $data['data']['cash']->fetch_assoc()){
                              echo "<option value='".$cashList['accountID']."'>".$cashList['accountName']."</option>";
                            }
                            
                            ?>
                          </select>
                        <input class="form-control input-lg" name="paymentTotal" placeholder="0.0" style="text-align:right;" oninput="getDueAdvance()">
                        <h4><?php echo $adminSale['due']; ?> : <strong class="pull-right red-text" id="dueTotal">0.0</strong></h4>
                        <h4><?php echo $adminSale['return']; ?> : <strong class="pull-right green-text" id="advanceTotal">0.0</strong></h4>
                        <hr>
                        <h5><b><?php echo $adminSale['saleNote']; ?>:</b></h5>
                        <textarea class="form-control" name="invoiceNote"></textarea>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="sms"> <?php echo $adminSale['sendSMS']; ?>  
                            </label>
                          </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-success"><?php echo $adminSale['submit']; ?></button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>