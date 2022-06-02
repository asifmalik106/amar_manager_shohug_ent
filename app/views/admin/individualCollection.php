<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Individual Collection Report</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
          <form class="form-inline" method="GET" action="">
            <div class="form-group">
              <label for="exampleInputName2">Select User</label>
              <select class="form-control" name="userID">
                <?php
                  while($u = $data['userList']->fetch_assoc()){
                   // pre_print($u);
                    echo '<option value="'.$u['userID'].'">'.$u['name'].' ('.$u['username'].')'.' ['.$u['rank'].']'.'</option>';
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputName2">From Date</label>
              <input type="text" class="form-control datepicker" name="from" placeholder="Select Date">
            </div>
            <div class="form-group">
              <label for="exampleInputName2">To Date</label>
              <input type="text" class="form-control datepicker" name="to" placeholder="Select Date">
            </div>
            <button type="submit" class="btn btn-primary">Generate Report</button>
          </form>
        </div>
      <?php 
        if(isset($data['trx'])){
          ?>
      <div class="row">
        <h4>Collector Name: <b><?php echo $data['userName']; ?></b></h4>
        <p>Collection Period: <b><?php echo date("d-m-Y", strtotime($data['from'])); ?></b> - <b><?php echo date("d-m-Y", strtotime($data['to'])); ?></b></p>
             <table class="table table-striped table-bordered" cellspacing="0" id="cashList">
                <thead>
                    <tr>
                        <td>TrxID</td>
                        <td>Date</td>
                        <td>Time</td>
                        <td>Invoice</td>
                        <td>Amount</td>
                        <td>Customer</td>
                      
                    </tr>
                </thead>

                <tbody>
                    <?php
          $totalCollection = 0;
                         while($row = $data['trx']->fetch_assoc()){
                           //pre_print($row);
                           echo "<tr>";
                           echo "<td>".$row['trxID']."</td>";
                           echo "<td>".date("d-m-Y", strtotime($row['trxDate']))."</td>";
                           echo "<td>".$row['trxTime']."</td>";
                           
                            echo "<td><a href='".BASE_URL."admin/invoice/".$row['trxReference']."' target='_blank'>Invoice# ".$row['trxReference']."</a></td>";
                            echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['trxAmount']."</td>";
                            echo "<td><a href='".BASE_URL."admin/customer/".$row['scID']."' target='_blank'>".$row['scNameCompany']."</a></td>";
                            echo "</tr>";
                           $totalCollection+= (float)$row['trxAmount'];
                        }
                          echo "<tr>";
                            echo "<td colspan='4'><h4 align='right'><b>Total Collection</b></h4></td>";
                            echo "<td><h4><b>".$_SESSION['data']['businessCurrency']." ".(float)$totalCollection."</b></h4></td>";
                            echo "</tr>";
                    ?>
                </tbody>
            </table>
      </div>  
              
      
      <?php
        }
      ?>
    </div>
    <!-- /#page-wrapper -->
</body>