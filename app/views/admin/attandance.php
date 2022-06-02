<body>
  <?php include 'asset/includes/sidebar.php';?>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h2 class="page-header">Daily Attandance Report</h2>
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
        if(isset($data['attandance'])){
          ?>
    <div class="row">
      <form method="POST" action="<?php echo BASE_URL; ?>admin/attandance/info/">
        <h4>Date: <?php echo date_format(date_create($data['date']),"d-m-Y"); ?></h4>
        <input type="hidden" name="date" value="<?php echo $data['date']; ?>">
      <table class="table table-striped table-bordered" cellspacing="0" id="cashList">
        <thead>
          <tr>
            <td>Status</td>
            <td>Name</td>
            <td>Phone</td>
            <td>Info</td>
            <td>Today</td>
          </tr>
        </thead>

        <tbody>
          <?php
                         foreach($data['attandance'] as $row){
                    ?>
            <tr>
              <td>
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-success">
                          <input type="radio" name="p<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>,1">
                          <span class="glyphicon glyphicon-ok"></span>
                        </label>
                  <label class="btn btn-danger">
                          <input type="radio" name="a<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>,0">
                          <span class="glyphicon glyphicon-ok"></span>
                        </label>
                </div>
              </td>
              <?php
                           $out = '';
                           if($row['status'] == 1){
                             $out = '<i class="fa fa-check fa-2x green-text"></i>';
                           }else if($row['status'] == 0){
                             $out = '<i class="fa fa-times fa-2x red-text"></i>';
                           }else{
                             $out = '<i class="fa fa-exclamation-triangle fa-2x yellow-text"></i>';
                           }
                            echo "<td><a href='".BASE_URL."admin/employee/".$row['id']."'>".$row['name']."</a></td>";
                            echo "<td>".$row['phone']."</td>";
                            echo "<td>".$row['info']."</td>";
                            echo "<td>".$out."</td>";
                            echo "</tr>";
                        }

                    ?>
        </tbody>
      </table>
      <button type="submit" class="btn btn-primary">Submit Attandance</button>
      </form>
    </div>

    <?php
        }
      ?>
      
  </div>
  <!-- /#page-wrapper -->
</body>