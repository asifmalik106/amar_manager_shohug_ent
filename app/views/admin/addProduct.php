<body class="wrapper">
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $newProduct['editProductInfo']; ?></h4>
            </div>
            <div class="modal-body">

            	<div class="catStatusHeight">
					<div id="productEditStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $newProduct['productUpdatedSuccessfully']; ?></strong> 
						</div>
						
					</div>
					<div id="productEditStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $newProduct['failedToUpdateProduct']; ?></strong> 
						</div>
					</div>
					<div id="productEditStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $newProduct['fillAllFields']; ?></strong> 
						</div>
					</div>
					<div id="productEditStatusDuplicate" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-warning-sign"></i> <?php echo $newProduct['productAlreadyExists']; ?></strong> 
						</div>
					</div>
					<div id="productEditStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif"> <?php echo $systemWords['pleasewait']; ?></strong> 
						</div>
					</div>
				</div>

	        	<form>
					<div class="form-group">
						<input type="hidden" class="form-control" id="editProductID">
					</div>
					<div class="form-group">
						<label><?php echo $newProduct['productName']; ?></label>
						<input type="text" class="form-control" id="editProductName">
					</div>
					<div class="form-group">
						<strong><?php echo $newProduct['selectProductCategory']; ?></strong><br>
						<select id="editProductCategory">
							<option value="" disabled="1" selected><?php echo $newProduct['selectAProductCategory']; ?></option>
						<?php 
							while($row = $data['data']['category']->fetch_assoc())
							{
								echo "<option value=\"".$row['categoryID']."\">".$row['categoryName']." (".$row['categoryUnit'].")</option>";
							}
						?>
						</select>
					</div>
					<div class="form-group">
						<label><?php echo $newProduct['description']; ?></label>
						<textarea id="editProductDescription" class="form-control" rows="3"></textarea>
					</div>
					<div class="form-group">
						<label><?php echo $newProduct['productWarningLimit']; ?></label>
						<input type="text" class="form-control" id="editProductLimit">
					</div>
				</form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $newProduct['close'];?></button>
                <button type="button" class="btn btn-primary" onclick="editProduct()"><?php echo $newProduct['saveChanges'];?></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $newProduct['deleteProduct']; ?></h4>
            </div>
            <div class="modal-body">
               <h3 align="center">Delete Product Not Available!!!</h3>
              <!--   <form class="form">
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
	        	</form> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $newProduct['close']; ?></button>
                <button type="button" class="btn btn-danger"><?php echo $newProduct['yesDelete']; ?></button>
            </div>
        </div>
    </div>
</div>

<?php include 'asset/includes/sidebar.php';?>
<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><?php echo $newProduct['addNewProduct']; ?></h3>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-8">
		<form class="form-inline">
			<div class="form-group" style="display: none;" id="loadingProduct">
    			<div class="form-control loadingProductStyle">
    			<p><img src="<?php echo BASE_URL; ?>asset/reload.gif"><?php echo $systemWords['pleasewait']; ?></p>
    			</div>
  			</div>	
			<div class="form-group">
				<button type="button" class="reloadCategory btn btn-primary pull-right reloadCategory" onclick="loadProduct()"><i class="glyphicon glyphicon-refresh"></i> <?php echo $newProduct['refreshTable']; ?></button>
			</div>
		</form>
			<div id="loadProduct">
				
			</div>
		</div>
		<div class="col-lg-4">
			<div class="catStatusHeight">
				<div id="productStatusTrue" style="display: none">
					<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $newProduct['productAddedSuccessfully']; ?></strong> 
					</div>
				</div>
				<div id="productStatusFalse" style="display: none">
					<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $newProduct['failedToAddProduct']; ?></strong> 
					</div>
				</div>
				<div id="productStatusEmpty" style="display: none">
					<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $newProduct['fillAllFields']; ?></strong> 
					</div>
				</div>
				<div id="productStatusDuplicate" style="display: none">
					<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-warning-sign"></i> <?php echo $newProduct['productAlreadyExists']; ?></strong> 
					</div>
				</div>
				<div id="productStatusLoading" style="display: none">
					<div class="alert" role="alert">
                        <p align="center"><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <strong><?php echo $systemWords['pleasewait']; ?></strong></p> 
                        </div>
				</div>
			</div>
				<div class="panel panel-primary">
					<div class="panel-heading"><h4 align="center"><b><?php echo $newProduct['addNewProduct']; ?></b></h4></div>
					<div class="panel-body">
						<form>
							<div class="form-group">
								<label><?php echo $newProduct['productName']; ?></label>
								<input type="text" class="form-control" id="newProductName">
							</div>
							<div class="form-group">
								<strong><?php echo $newProduct['selectProductCategory']; ?></strong>
								<select id="newProductCategory" class="form-control">
									<option value="" disabled="1" selected><?php echo $newProduct['selectAProductCategory']; ?></option>
								<?php 
									while($row = $data['data']['category2']->fetch_assoc())
									{
										echo "<option value=\"".$row['categoryID']."\">".$row['categoryName']." (".$row['categoryUnit'].")</option>";
									}
								?>
								</select>
							</div>
							<div class="form-group">
								<label><?php echo $newProduct['description']; ?></label>
								<textarea id="newProductDescription" class="form-control" rows="3"></textarea>
							</div>
							<div class="form-group">
								<label><?php echo $newProduct['productWarningLimit']; ?></label>
								<input type="text" class="form-control" id="newProductLimit">
							</div>
						</form>
					</div>
					<div class="panel-footer">
						<button type="button" class="btn btn-primary" onclick="addProduct()"><?php echo $newProduct['addProduct']; ?></button>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>