<body>
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
                        <li><a href="<?php echo BASE_URL; ?>admin/settings"><i class="fa fa-gear fa-fw"></i> <?php echo $sidebar['settings']; ?></a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo BASE_URL; ?>main/logout/"><i class="fa fa-sign-out fa-fw"></i> <?php echo $sidebar['logout']; ?></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
  </nav>
  <div class="container">
            <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?php echo $data['title']; ?></h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
          <form class="form-inline" method="GET" action="">
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
  </div>
  <?php if(isset($data['finalStatement'])){ ?>
  <div class="container-fluid">
    <?php
      //pre_print($data['finalStatement'][0]);
    //echo date('Y-m-d',time());
    //echo mktime('2020-07-10')."<br>";
    //echo mktime('2020-07-11')."<br>";
    //echo mktime('2020-07-12')."<br>";
    //echo mktime('2020-07-13')."<br>";
    //echo mktime('2020-07-14')."<br>";
    //echo mktime('2020-07-15')."<br>";
    //echo mktime('2020-07-16')."<br>";
    //echo mktime('2020-07-17')."<br>";
    //echo mktime('2020-07-18')."<br>";
    //echo mktime('2020-07-19')."<br>";
    //pre_print($_SESSION);
    ?>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped table-bordered" cellspacing="0">
          <thead>
            <tr>
              <th>Date</th>
              <th>No. of Sales</th>
              <th>Total Sales (A)</th>
              <th>Collection on Date (B)</th>
              <th>Collection (Others) (C)</th>
              <th>Total Collection (B+C)</th>
              <th>Due on Date (A-B)</th>
              <th>Cost of Goods Sold (D)</th>
              <th>Profit (A-D)</th>
            </tr>
          </thead>
          
          <tbody>
            <?php 
            array_multisort(array_column($data['finalStatement'], 'invoiceDate'), SORT_ASC, $data['finalStatement']);
            $totalSalesNumer = 0; $totalSalesAmount = 0; $totalCollectionOnDate = 0; $totalCollectionOtherDate = 0; $totalCollection = 0; $totalCOGS = 0; $totalProfit = 0;
            foreach($data['finalStatement'] as $row){
              $stmtDate = date("d-m-Y", strtotime($row['invoiceDate']));
              echo "<tr>";
                echo "<td><a href='".BASE_URL."admin/report/profit?date=".$stmtDate."' target='_blank'>".$stmtDate."</td>";
                echo "<td>".$row['salesNumber']."</td>"; $totalSalesNumer+=$row['salesNumber'];
                echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['TotalSales']."</td>"; $totalSalesAmount+=$row['TotalSales'];
                echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['onDate']."</td>"; $totalCollectionOnDate+=$row['onDate'];
                echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['otherDate']."</td>"; $totalCollectionOtherDate+=$row['otherDate'];
                echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['totalCollection']."</td>"; $totalCollection+=$row['totalCollection'];
                echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['dueOnDate']."</td>";
                echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['cogs']."</td>"; $totalCOGS+=$row['cogs'];
                echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['profit']."</td>"; $totalProfit+=$row['profit'];
              
              echo "</tr>";
            }
            ?>
            <tr>
              <td></td>
              <td><?php echo $totalSalesNumer; ?></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".number_format((float)$totalSalesAmount, 2, '.', ''); ?></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".number_format((float)$totalCollectionOnDate, 2, '.', ''); ?></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".number_format((float)$totalCollectionOtherDate, 2, '.', ''); ?></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".number_format((float)$totalCollection, 2, '.', ''); ?></td>
              <td> - </td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".number_format((float)$totalCOGS, 2, '.', ''); ?></td>
              <td><?php echo $_SESSION['data']['businessCurrency']." ".number_format((float)$totalProfit, 2, '.', ''); ?></td>
              
              
            </tr>
          </tbody>
        </table>
      
      </div>
    </div>
  </div>
  
  
  
  
  
  
  
<?php  
  $dataPoints1 = array(
	array("label"=> "2010", "y"=> 36.12),
	array("label"=> "2011", "y"=> 34.87),
	array("label"=> "2012", "y"=> 40.30),
	array("label"=> "2013", "y"=> 35.30),
	array("label"=> "2014", "y"=> 39.50),
	array("label"=> "2015", "y"=> 50.82),
	array("label"=> "2016", "y"=> 74.70)
);
$dataPoints2 = array(
	array("label"=> "2010", "y"=> 64.61),
	array("label"=> "2011", "y"=> 70.55),
	array("label"=> "2012", "y"=> 72.50),
	array("label"=> "2013", "y"=> 81.30),
	array("label"=> "2014", "y"=> 63.60),
	array("label"=> "2015", "y"=> 69.38),
	array("label"=> "2016", "y"=> 98.70)
);

  ?>
  
  <script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Daily Sales vs Daily Collection"
	},
	axisY:{
		includeZero: true
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Sales",
		indexLabel: "{y}",
		//yValueFormatString: "৳#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($data['salesGraph'], JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Collection",
		indexLabel: "{y}",
		//yValueFormatString: "৳#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($data['collectionGraph'], JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
 
}
</script>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
  
  
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <?php } ?>
</body>