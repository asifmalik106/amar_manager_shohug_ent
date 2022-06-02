 <body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php include 'system/notification.php'; ?>
              <h2 class="page-header">
                <?php 
                  if($data['data']['type']=='Sale'){
                    echo "Sale Invoices";
                  }else{
                    echo "Purchase Invoices";
                  }
                 ?>
              </h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

             <table class="table table-striped table-bordered" cellspacing="0" id="invoiceList">
                <thead>
                    <tr>
                        <td>Invoice ID</td>
                        <td>
                          <?php 
                            if($data['data']['type']=='Sale'){
                              echo "Customer's Name";
                            }else{
                              echo "Supplier's Name";
                            }
                          ?>
                        </td>
                        <td>Date</td>
                        <td>Time</td>
                        <td>Amount</td>
                        <td>Status</td>
                        <td>Stuff Name</td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                         
                         foreach($data['data']['invoice'] as $row){
                           $amt = (float)($row['invoiceAmount']-$row['invoiceDiscount']);
                            echo "<tr>\n";
                            echo "<td><a href=\"".BASE_URL."admin/invoice/".$row['invoiceID']."\">".$row['invoiceID']."</a></td>\n";
                            echo "<td>".$row['scNameCompany']."<p style='display: none'>".$row['scContactNo']."'</p></td>\n";
                            echo "<td>".date("d/m/Y", strtotime($row['invoiceDate']))."</td>\n";
                            echo "<td>".$row['invoiceTime']."</td>\n";
                            echo "<td>৳".$amt."</td>\n";
                            echo "<td>".$row['invoiceStatus']."</td>\n";
                            echo "<td>".$row['name']."</td>\n";
                            echo "</tr>\n";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>