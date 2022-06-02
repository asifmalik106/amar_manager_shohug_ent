<body >
        <?php include 'asset/includes/sidebar.php';?>
        <div id="page-wrapper">
            <div class="row">
                <?php include 'system/notification.php'; ?>
                <?php
                    $price = '';
                    if($data['data']['info']['invoiceType'] == 'sale'){
                        $price = 'invoiceSale';
                        $statement = 'Sales Invoice';
                        $sctype = 'customer';
                    }else{
                        $price = 'invoicePurchase';
                        $statement = 'Purchase Invoice';
                        $sctype = 'supplier';
                    }
                ?>
                <h2 align="center"><?php echo $_SESSION['data']['businessName']; ?></h2>
                <p align="center"><?php echo $_SESSION['data']['businessAddress']; ?></p>

                <p align="center">Phone: <?php echo $_SESSION['data']['businessPhone']; ?></p>
                <p align="center"><strong>Invoice No# </strong> <?php echo $data['data']['info']['invoiceID'];?></p>
                    <p align="center"><?php echo $data['data']['info']['invoiceTime'].'    '.date("d/m/Y", strtotime($data['data']['info']['invoiceDate']));?></p>
            </div>
            <div class="row">
                <table class="invoice-md">
                    <tr>
                        <td> <strong>Name: </strong> </td>
                      <td> <a href="<?php echo BASE_URL."admin/".$sctype."/".$data['data']['info']['scID']; ?>"> <?php echo $data['data']['info']['scNameCompany'];?></a> </td>
                    </tr>
                    <tr>
                        <td> <strong>Address: </strong> </td>
                        <td> <?php echo $data['data']['info']['scAddress'];?>  </td>
                    </tr>
                    <tr>
                        <td> <strong>Phone: </strong> </td>
                        <td>  <?php echo $data['data']['info']['scContactNo'];?>  </td>
                    </tr>
                    <tr>
                        <td> <strong><i>Prepared By:</i></strong> </td>
                        <td> <i><?php echo $data['data']['info']['user'];?></i> </td>
                    </tr>
                </table>
            </div>
            <h4 align="center"><u><?php echo $statement; ?></u></h4>
            <hr>
            <div class="row">
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            while ($row = $data['data']['invoice']->fetch_assoc())
                            {
                                $total = number_format(($row['invoiceQuantity'] * $row[$price]), 2, '.', '');
                                echo "<tr>";
                                echo "<td>".$i."</td>";
                                echo "<td>".$row['invoiceProductName']."</td>";
                                echo "<td>".$row['invoiceQuantity']." ".$row['invoiceProductCategoryUnit']."</td>";
                                echo "<td>".$_SESSION['data']['businessCurrency']." ".$row[$price]."</td>";
                                echo "<td>".$_SESSION['data']['businessCurrency']." ".$total."</td>";

                                echo "</tr>";    
                                $i++;
                            }
                        ?>
                        <tr class="invoice-lg">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td><?php echo $_SESSION['data']['businessCurrency']." ".$data['data']['info']['invoiceAmount']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
              <div class="col-md-4">
                <h4>Invoice Note:</h4>
                <p><?php echo $data['data']['info']['invoiceNote']; ?></p>
              </div>
              <div class="col-md-offset-4 col-md-4">
                <table class="table invoice-md" >
                    <tr>
                        <td> <strong>Total: </strong> </td>
                        <td class="invoice-amount">  <?php echo $_SESSION['data']['businessCurrency']." ".$data['data']['info']['invoiceAmount']; ?> </td>
                    </tr>
                    <tr>
                        <td> <strong>Discount: </strong> </td>
                        <td class="invoice-amount"> <?php echo $_SESSION['data']['businessCurrency']." ".$data['data']['info']['invoiceDiscount']; ?> </td>
                    </tr>
                    <tr>
                        <td> <strong>Grand Total: </strong> </td>
                        <td class="invoice-amount">  
                            <?php 
                                $grandTotal = $data['data']['info']['invoiceAmount'] - $data['data']['info']['invoiceDiscount'];
                                echo $_SESSION['data']['businessCurrency']." ".number_format($grandTotal, 2,'.',''); 
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td> <strong>Payment: </strong> </td>
                        <td class="invoice-amount">  
                            <?php 
                                $payment = $data['data']['paid']->fetch_assoc();
                                echo $_SESSION['data']['businessCurrency']." ".number_format($payment['paid'], 2,'.','');
                                $due = 0.0; $adv = 0.0;
                                if($grandTotal>$payment['paid']){
                                    $due = $grandTotal - $payment['paid'];
                                }else{
                                    $adv = $payment['paid'] - $grandTotal;
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> <strong>Due: </strong> </td>
                        <td class="invoice-amount">  <?php echo $_SESSION['data']['businessCurrency']." ".number_format($due, 2,'.',''); ?></td>
                    </tr>
                    <tr>
                        <td> <strong>Advance: </strong> </td>
                        <td class="invoice-amount">   <?php echo $_SESSION['data']['businessCurrency']." ".number_format($adv, 2,'.',''); ?></td>
                    </tr>

                </table>
              </div>
              
              
              
              
              
              
              
              
              
                
            </div>
        </div>
        <!-- /#page-wrapper -->
</body>