<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php include 'system/notification.php'; ?>
                <h2 class="page-header">Daily Profit Report</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
          <form class="form-inline" method="GET" action="">
            <div class="form-group">
              <label for="exampleInputName2">Select Date</label>
              <input type="text" class="form-control datepicker" name="date" placeholder="Select Date">
            </div>
            <button type="submit" class="btn btn-default">Generate Report</button>
          </form>
        </div>
      <?php 
        if(isset($data['profit'])){
          ?>
      <div class="row">
        <div class="today-first">
          
        
        <h2>Report: Invoices & Collections of <?php echo date("d-m-Y", strtotime($data['date'])); ?></h2>
             <table class="table table-striped table-bordered" cellspacing="0" id="cashList">
                <thead>
                    <tr>
                        <td>Invoice ID</td>
                        <td>Time</td>
			                  <td>Sales</td>
                        <td>Collection</td>
                        <td>Due</td>
                        <td>Profit</td>
                    </tr>
                </thead>

                <tbody>
                    <?php
          $total = 0; $saleTotal = 0; $collectionTotal = 0; $dueTotal = 0; $todaysCount = 0; $todaysCollectionCount = 0;
                         foreach($data['profit'] as $row){
                           
                           echo "<tr>";
                            echo "<td><a href=\"".BASE_URL."admin/invoice/".$row['invoiceID']."\">".$row['invoiceID']."</td>";
                            echo "<td>".date("h:i:s a", strtotime($row['invoiceTime']))."</td>";
                            echo "<td>".$_SESSION['data']['businessCurrency']." ".number_format((float)$row['totalSale'], 2,'.','')."</td>";
                            echo "<td class='green-text'>".$_SESSION['data']['businessCurrency']." ".number_format((float)$row['todaysCollection'], 2,'.','')."</td>";
                            echo "<td class='red-text'>".$_SESSION['data']['businessCurrency']." ".number_format((float)$row['totalSale'] - (float)$row['todaysCollection'], 2,'.','')."</td>";
                            echo "<td><b>".$_SESSION['data']['businessCurrency']." ".number_format((float)$row['profit'], 2,'.','')."</b></td>";
                            echo "</tr>";
                           $total+= (float)$row['profit'];
			      $saleTotal+= (float)$row['totalSale'];
                           $collectionTotal+=(float)$row['todaysCollection'];
                           $dueTotal += (float)$row['totalSale'] - (float)$row['todaysCollection'];
                           $todaysCount++;
                           if((float)$row['todaysCollection']>0){
                             $todaysCollectionCount++;
                           }
                        }
                          echo "<tr>";
                            echo "<td></td>";
                            echo "<td><b>Total Profit</b></td>";
				                    echo "<td>".$_SESSION['data']['businessCurrency']." ".$saleTotal."</td>";
                            echo "<td class='green-text'>".$_SESSION['data']['businessCurrency']." ".$collectionTotal."</td>";
                            echo "<td class='red-text'>".$_SESSION['data']['businessCurrency']." ".$dueTotal."</td>";
                            echo "<td><b>".$_SESSION['data']['businessCurrency']." ".$total."</b></td>";
                            echo "</tr>";
                    ?>
                </tbody>
            </table>
        </div>

        
      
        <h2>Report: Collections of Other Invoices on <?php echo date("d-m-Y", strtotime($data['date'])); ?></h2>
                   <table class="table table-striped table-bordered" cellspacing="0" id="cashList">
                <thead>
                    <tr>
                        <td>Invoice ID</td>
                        <td>Invoice Date</td>
			                  <td>Invoice Total</td>
                        <td>Todays Collection</td>
                       <!-- <td>Due</td>
                        <td>Profit</td> -->
                    </tr>
                </thead>

                <tbody>
      <?php
      
      //var_print($data['previous']);
      $todaysTotalCollection = 0; $todaysOtherTotalCollection = 0;
      while($row = $data['previous']->fetch_assoc()){
        echo "<tr>";
          echo "<td><a href=\"".BASE_URL."admin/invoice/".$row['invoiceID']."\">".$row['invoiceID']."</td>";
          echo "<td>".date("d-m-Y", strtotime($row['invoiceDate']))."</td>";
          echo "<td>".$_SESSION['data']['businessCurrency']." ".number_format((float)$row['invoiceAmount'], 2,'.','')."</td>";
          echo "<td class='green-text'>".$_SESSION['data']['businessCurrency']." ".number_format((float)$row['trxAmount'], 2,'.','')."</td>";
          /*echo "<td></td>";
          echo "<td></td>";*/
        echo "</tr>";
        //pre_print($row);
        //print_r($prev);
        $todaysTotalCollection+=(float)$row['trxAmount'];
        $todaysOtherTotalCollection++;
      }
          echo "<tr>";
            echo "<td colspan='3'><b>Today's Total Collection of Other Invoices</b></td>"; 
            echo "<td class='green-text'><b>".$_SESSION['data']['businessCurrency']." ".$todaysTotalCollection."</b></td>";
          echo "</tr>";
          
      ?>
                                  </tbody>
            </table>
        
        <?php $grandTodaysTotal = $collectionTotal + $todaysTotalCollection; ?>
        <table class="table table-striped table-bordered" cellspacing="0">
          <thead>
            <tr>
              <th colspan="2"><h3>Summary of <?php echo date("d-m-Y", strtotime($data['date'])); ?></h3></th>  
              </tr>
          </thead>
          <tbody>
            <tr>
              <td><b>Number Of Invoices</b></td>
              <td><?php echo $todaysCount; ?></td>
            </tr>
            <tr>
              <td><b>Total Sale Amount</b></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".$saleTotal;?></td>
            </tr>
            
            <tr>
              <td><b>Number Of Collections</b></td>
              <td><?php echo $todaysOtherTotalCollection+$todaysCollectionCount;?></td>
            </tr>
            
            <tr>
              <td><b>Collection of <?php echo date("d-m-Y", strtotime($data['date'])); ?> Invoices</b></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".$collectionTotal;?></td>
            </tr>
            
            
            <tr>
              <td><b>Collection of Other Invoices</b></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".$todaysTotalCollection;?></td>
            </tr>
            
            <tr>
              <td><b>Total Collection</b></td>
              <td><b><?php echo $_SESSION['data']['businessCurrency']." ".$grandTodaysTotal;?></b></td>
            </tr>
            
            <tr>
              <td><b>Total Due</b></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".$dueTotal;?></td>
            </tr>
            
            <tr>
              <td><b>Total Profit</b></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".$total;?></td>
            </tr>
            
          </tbody>
        </table>
        
    </div>
  <?php
        }
      ?>
    <!-- /#page-wrapper -->
</body>