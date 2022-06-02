<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
      <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?php echo $data['data']['type']; ?> Profile</h2>
            </div>
      </div>
      <div class="row">
				<div id="loadProfile">
						<div class="col-md-4">
							<input id="productID" style="display: none" value="<?php echo $data['data']['product']['productID']; ?>">
							<table>
							<tr>
								<td class="productTable"><h3>Product: </h3></td>
								<td class="productTable"><h3> <strong id="productName"><?php echo $data['data']['product']['productName']; ?></strong> </h3></td>
							</tr>
							<tr>
								<td class="productTable"><h4>Category: </h4></td>
								<td class="productTable"><h4> <strong id="productCategoryName"><?php echo $data['data']['product']['categoryName']; ?></strong> </h4></td>
							</tr>
								
							<tr>
								<td class="productTable"><h4>Unit: </h4></td>
								<td class="productTable"><h4> <strong id="productCategoryUnit"><?php echo $data['data']['product']['categoryUnit']; ?></strong> </h4></td>
							</tr>	
								<tr>
								<td class="productTable"><h4>Warning Limit: </h4></td>
								<td class="productTable"><h4> <strong id="productCategoryUnit"><?php echo $data['data']['product']['productLimit']; ?></strong> </h4></td>
							</tr>	
								
								</table>
								<?php
			$editData = "fillModifyProductData(".$data['data']['product']['productID'].", '".$data['data']['product']['productName']."', '".$data['data']['product']['productDescription']."', '".$data['data']['product']['categoryID']."', '".$data['data']['product']['productLimit']."')";
			?>
			<button class="btn btn-primary" onclick="<?php echo $editData; ?>" title="Edit Product Information" data-toggle="modal" data-target="#editModal"><i class="glyphicon glyphicon-edit"></i> Edit Profile Information</button>
						</div>
				<div class="col-md-4">
         <h4>Description: </h4>
								<h4> <strong id="productDescription"><?php echo $data['data']['product']['productDescription']; ?> </h4>
        </div>
					</div>
        <div class="col-md-4">
          <h3> Stock Quantity </h3>
					<h2><?php echo $data['data']['productTotal']; ?></h2>
        </div>
      	
			</div>
		
     <hr>
      <div class="row">
        <h3> Product Batches </h3>
        <div class="col-md-12">

            <table class="table table-responsive table-bordered table-hover" id="batchTable">
							<thead>
								<tr>
									<th>Batch Name</th>
									<th>Quantity</th>
									<th>Purchase Unit</th>
									<th>Sale Unit</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody id="loadBatch">
								<?php
									while($row = $data['data']['batch']->fetch_assoc()){
										echo "<tr>";
										echo "<td>".$row['batch']."</td>";
										echo "<td>".$row['quantity']."</td>";
										echo "<td>".$row['purchaseUnit']."</td>";
										echo "<td>".$row['saleUnit']."</td>";
																echo "<td>
						<a href=\"#\" onclick=\"fillModifyBatchData('".$row['batch']."','".$row['saleUnit']."')\" title=\"Edit Batch Data\" data-toggle=\"modal\" data-target=\"#editBatchModal\">
						<i class=\"fa fa-edit fa-lg edit\"></i></a>
						<a href=\"#\"onclick=\"fillDeleteBatch('".$row['batch']."','".$row['quantity']."','".$row['purchaseUnit']."')\" title=\"Delete Batch\"  data-toggle=\"modal\" data-target=\"#deleteBatch\">
						<i class=\"fa fa-times fa-lg delete\" title=\"Delete category\"></i></a>
						</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
        </div>

      </div>
    </div>
			
<!-- Product Edit Modal -->			
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit Product Information</h4>
            </div>
            <div class="modal-body">

            	<div class="catStatusHeight">
					<div id="productEditStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> Product Updated Successfully!</strong> 
						</div>
						
					</div>
					<div id="productEditStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> Failed to Update Product!</strong> 
						</div>
					</div>
					<div id="productEditStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> Fill All Fields...</strong> 
						</div>
					</div>
					<div id="productEditStatusDuplicate" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-warning-sign"></i> Product Already Exists!!!</strong> 
						</div>
					</div>
					<div id="productEditStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  Please Wait..</strong> 
						</div>
					</div>
				</div>

	        	<form>
					<div class="form-group">
						<input type="hidden" class="form-control" id="editProductID">
					</div>
					<div class="form-group">
						<label>Edit Product Name</label>
						<input type="text" class="form-control" id="editProductName">
					</div>
					<div class="form-group">
						<strong>Edit Product Category</strong><br>
						<select id="editProductCategory">
							<option value="" disabled="1" selected>Select a Category</option>
						<?php 
							while($row = $data['data']['category']->fetch_assoc())
							{
								echo "<option value=\"".$row['categoryID']."\">".$row['categoryName']." (".$row['categoryUnit'].")</option>";
							}
						?>
						</select>
					</div>
					<div class="form-group">
						<label>Edit Product Description</label>
						<textarea id="editProductDescription" class="form-control" rows="3"></textarea>
					</div>
					<div class="form-group">
						<label>Edit Warning Limit</label>
						<input type="text" class="form-control" id="editProductLimit">
					</div>
				</form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editProduct()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Product Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Delete Product Category</h4>
            </div>
            <div class="modal-body">
                <h3 align="center">Are you sure to DELETE Product Category?</h3>
                <form class="form">
	        		<div class="form-group">
	        			<label>Category ID</label>
	        			<input id="deleteCategoryID" type="text" name="" class="form-control" readonly>
	        		</div>
	        		<div class="form-group">
	        			<label>Edit Category Name</label>
	        			<input id="deleteCategoryName" type="text" name="" class="form-control">
	        		</div>
	        		<div class="form-group">
	        			<label>Edit Category Unit</label>
	        			<input id="deleteCategoryUnit" type="text" name="" class="form-control">
	        		</div>
	        	</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No, Back...</button>
                <button type="button" class="btn btn-danger">Yes, Delete!</button>
            </div>
        </div>
    </div>
</div>
			
<!-- Delete Batch Modal -->
<div class="modal fade" id="deleteBatch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Delete Product Category</h4>
            </div>
            <div class="modal-body">
							<div class="deleteTrue">
								<div class="catStatusHeight">
									<div id="batchDeleteStatusTrue" style="display: none">
										<div class="alert alert-success alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<strong><i class="glyphicon glyphicon-ok"></i> Batch Deleted Successfully!</strong> 
										</div>
									</div>
									<div id="batchDeleteStatusFalse" style="display: none">
										<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<strong><i class="glyphicon glyphicon-remove"></i> Failed to Delete Batch!</strong> 
										</div>
									</div>
									<div id="batchDeleteStatusEmpty" style="display: none">
										<div class="alert alert-warning alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<strong><i class="glyphicon glyphicon-info-sign"></i> Fill All Fields...</strong> 
										</div>
									</div>
									<div id="batchDeleteStatusLoading" style="display: none">
										<div class="alert" role="alert">
											<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  Please Wait..</strong> 
										</div>
									</div>
								</div>
								<h3 align="center">Are you sure to DELETE Product Batch?</h3>
								<form class="form">
								<div class="form-group">
									<label>Batch Name</label>
									<input id="deleteBatchName" type="text" name="" class="form-control" readonly>
								</div>
								<div class="form-group">
									<label>Batch Purchase Rate</label>
									<input id="deleteBatchPurchase" type="text" name="" class="form-control" readonly>
								</div>
								</form>
								<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No, Back...</button>
                <button type="button" class="btn btn-danger" onclick="deleteBatchData()">Yes, Delete!</button>
            </div>
							</div>
							<div class="deleteFalse">
								<h3 align="center">You Cannot Delete this Batch!!!</h3>
								<p align="center">This Batch contains Products!</p>
							</div>
            </div>
            
        </div>
    </div>
</div>

<!-- Edit Batch & Sale Unit Modal -->
<div class="modal fade" id="editBatchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit Batch & Sale Unit Price</h4>
            </div>
            <div class="modal-body">
							<div class="catStatusHeight">
					<div id="batchEditStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> Information Updated Successfully!</strong> 
						</div>
					</div>
					<div id="batchEditStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> Failed to Update Information!</strong> 
						</div>
					</div>
					<div id="batchEditStatusDuplicate" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-warning-sign"></i> Product Already Exists!!!</strong> 
						</div>
					</div>
					<div id="batchEditStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> Fill All Fields...</strong> 
						</div>
					</div>
					<div id="batchEditStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  Please Wait..</strong> 
						</div>
					</div>
				</div>
                <form class="form">
	        		<div class="form-group">
	        			<label>Batch Name</label>
	        			<input id="exBatchName" style="display: none" type="text" name="" class="form-control">
	        			<input id="batchName" type="text" name="" class="form-control">
	        		</div>
	        		<div class="form-group">
	        			<label>Sale Unit Price</label>
	        			<input id="saleUnit" type="text" name="" class="form-control">
	        		</div>
	        	</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No, Back...</button>
                <button type="button" class="btn btn-primary" onclick="editBatchSale()">Update Now!</button>
            </div>
        </div>
    </div>
</div>
			
			
</body>