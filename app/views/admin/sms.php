<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">SMS</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-4">                          <h3>SMS Balance</h3>
            <div class="panel panel-primary">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-3">
                          <i class="fa fa-envelope-o fa-4x"></i>
                      </div>
                      <div class="col-xs-9 text-right">
                          <h1><?php echo $data['data']['balance']; ?></h1>
                      </div>
                  </div>
              </div>
          </div>
          </div>
          
          <div class="col-md-8">
            <h3>SMS Template</h3>
            <table class="table table-bordered">
              <thead>
                <th>SMS Template ID</th>
                <th>SMS Template Category</th>
                <th>SMS Template Text</th>
              </thead>
              <tbody>
                <?php
                while($row = $data['data']['template']->fetch_assoc())
                {
                  echo "<tr>";
                  echo "<td>".$row['smsID']."</td>";
                  echo "<td>".$row['smsName']."</td>";
                  echo "<td>".$row['smsTemplate']."</td>";
                  echo "</tr>";
                }
                ?>
                
                
                <tr>
                
                
                </tr>
              </tbody>
            </table>
          </div>
          
        </div>
      
        <div class="row">
          <div class="col-md-12"> 
             <h3>SMS Template</h3>
            <table class="table table-bordered">
              <thead>
                <th>Sl.</th>
                <th>Customer</th>
                <th>Mobile No.</th>
                <th>Date</th>
                <th>Time</th>
                <th>SMS Text</th>
                <th>Size</th>
              </thead>
              <tbody>
                <?php
                $i = $data['data']['log']->num_rows;
                while($row = $data['data']['log']->fetch_assoc())
                {

                  echo "<tr>";
                  echo "<td>".$i."</td>";
                  echo "<td>".$row['scNameCompany']."</td>";
                  echo "<td>".$row['mobileNo']."</td>";
                  echo "<td>".$row['smsDate']."</td>";
                  echo "<td>".$row['smsTime']."</td>";
                  echo "<td>".$row['text']."</td>";
                  echo "<td>".$row['quantity']*(-1)."</td>";
                  echo "</tr>";
                  $i--;
                }
                ?>
              </tbody>
            </table>
          </div>
      </div>
    </div>
    <!-- /#page-wrapper -->
</body>