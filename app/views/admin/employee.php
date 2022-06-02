<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
      <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Employee Profile<?php //echo $profileLang[$data['data']['type']]; ?></h2>
							<input id="scID" type="hidden" value="<?php echo $data['employee']['empID']; ?>">
            </div>
      </div>
      <div class="row">
				<div class="col-md-4">
					<form method="POST" action="<?php echo BASE_URL; ?>admin/employee/edit/">
						<div class="form-group">
							<label>Name</label>
							<input type="hidden" name="id" value="<?php echo $data['employee']['empID']; ?>">
							<input class="form-control lock" name="name" value="<?php echo $data['employee']['empName']; ?>" disabled>
						</div>
						<div class="form-group">
							<label>Contact</label>
							<input class="form-control lock" name="phone" value="<?php echo $data['employee']['empPhone']; ?>" disabled>
						</div>
						<div class="form-group">
							<label>Daily Salary</label>
							<input class="form-control lock" name="salary" value="<?php echo $data['employee']['empDailySalary']; ?>" disabled>
						</div>
						<div class="form-group">
							<label>Fine</label>
							<input class="form-control lock" name="fine" value="<?php echo $data['employee']['empFine']; ?>" disabled>
						</div>
						<div class="form-group">
							<label>Info</label>
							<input class="form-control lock" name="info" value="<?php echo $data['employee']['empInfo']; ?>" disabled>
						</div>
						<button class="btn btn-success unlock" type="button">Unlock</button>
						<button class="btn btn-primary edit-data" type="submit" style="display:none">Edit Data</button>
					</form>
				</div>
				<div class="col-md-4">
					<h3 align="center">Balance: <b><?php echo $_SESSION['data']['businessCurrency']." ".$data['balance']; ?></b></h3>
					<hr>
					<h4>Add Money</h4>
					<form method="POST" action="<?php echo BASE_URL; ?>admin/employee/addMoney/">
						<div class="form-group">
							<label>Amount</label>
							<input type="hidden" name="id" value="<?php echo $data['employee']['empID']; ?>">
							<input class="form-control" name="amount">
						</div>
						<div class="form-group">
							<label>Note</label>
							<textarea class="form-control" name="note">
							</textarea>
						</div>
						<button type="submit" class="btn btn-primary">Add Money</button>
					</form>
				</div>
				<div class="col-md-4">
					<h3>Withdraw</h3><hr>
					<form method="POST" action="<?php echo BASE_URL; ?>admin/employee/withdraw/">
							<input type="hidden" name="id" value="<?php echo $data['employee']['empID']; ?>">
						<div class="form-group">
							<label>Select Cash Account</label>
						<select name="cashID" class="form-control">
							<?php
							while($cashList = $data['data']['cash']->fetch_assoc()){
								echo "<option value='".$cashList['accountID']."'>".$cashList['accountName']."</option>";
							}
							?>
						</select>
						</div>
						<div class="form-group">
							<label>Amount</label>
							<input class="form-control" name="amount">
						</div>
						<div class="form-group">
							<label>Note</label>
							<textarea class="form-control" name="note">
							</textarea>
						</div>
						<button type="submit" class="btn btn-primary">Withdraw</button>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<table class="table table-striped table-bordered" id="cashList">
						<thead>
							<tr>
								<td>Date</td>
								<td>Time</td>
							</tr>
						</thead>
						<tbody>
								<?php
                         while($row = $data['attandance']->fetch_assoc()){
													 $out = '';
														 if($row['attandanceType'] == 1){
															 $out = '<i class="fa fa-check fa-lg green-text"></i>';
														 }else if($row['attandanceType'] == 0){
															 $out = '<i class="fa fa-times fa-lg red-text"></i>';
														 }else{
															 $out = '<i class="fa fa-exclamation-triangle fa-lg yellow-text"></i>';
														 }
                            echo "<tr>";
                            echo "<td>".date("d/m/Y", strtotime($row['attandanceDate']))."</td>";
                            echo "<td>".$out."</td>";
                            echo "</tr>";
                        }
                    ?>
						</tbody>
					</table>
				</div>
				<div class="col-md-9">
					<table class="table table-striped table-bordered" id="cashList">
						<thead>
							<tr>
								<td>Date</td>
								<td>Time</td>
								<td>Amount</td>
								<td>Note</td>
								<td>User</td>
							</tr>
						</thead>
						<tbody>
							<?php
                         foreach($data['trx'] as $row){
                            echo "<tr>";
                            echo "<td>".date("d/m/Y", strtotime($row['trxDate']))."</td>";
                            echo "<td>".$row['trxTime']."</td>";
                            echo "<td>".$_SESSION['data']['businessCurrency']." ".$row['trxAmount']."</td>";
                            echo "<td>".$row['trxNote']."</td>";
                            echo "<td>".$row['trxUser']."</td>";
                            echo "</tr>";
                        }
                    ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<!-- Edit Profile Modal End -->
</body>