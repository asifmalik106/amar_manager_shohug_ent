<body class="wrapper">
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $category['editProductCategory']; ?></h4>
            </div>
            <div class="modal-body">

            	<div class="catStatusHeight">
					<div id="catEditStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $category['categoryUpdatedSuccessfully']; ?></strong> 
						</div>
					</div>
					<div id="catEditStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $category['FailedToUpdateCategory']; ?></strong> 
						</div>
					</div>
					<div id="catEditStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $category['fillAllFields']; ?></strong> 
						</div>
					</div>
					<div id="catEditStatusDuplicate" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-warning-sign"></i> <?php echo $category['categoryAlreadyExists']; ?></strong> 
						</div>
					</div>
					<div id="catEditStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <?php echo $systemWords['pleasewait']; ?></strong> 
						</div>
					</div>
				</div>

	        	<form class="form">
	        		<div class="form-group">
	        			<input type="hidden" id="modifyCategoryID" type="text" name="" class="form-control" readonly>
	        		</div>
	        		<div class="form-group">
	        			<label><?php echo $category['categoryName']; ?></label>
	        			<input id="modifyCategoryName" type="text" name="" class="form-control">
	        		</div>
	        		<div class="form-group">
	        			<label><?php echo $category['categoryUnit']; ?></label>
	        			<input id="modifyCategoryUnit" type="text" name="" class="form-control">
	        		</div>
	        	</form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $category['close']; ?></button>
                <button type="button" class="btn btn-primary" onclick="editCategory()"><?php echo $category['saveChanges']; ?></button>
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
                <h4 class="modal-title" id="myModalLabel"><?php echo $category['deleteProductCategory']; ?></h4>
            </div>
            <div class="modal-body">
            	<div class="cannot-delete-category" style="display: none">
            		<h3 align="center"><?php echo $category['youCanNotDeleteThisCategory']; ?></h3>
            	</div>

            	<div id="catDeleteStatusTrue" style="display: none">
					<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $category['categoryDeletedSuccessfylly']; ?></strong> 
					</div>
				</div>

				<div id="catDeleteStatusFalse" style="display: none">
					<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $category['failedToDeleteCategory']; ?></strong> 
					</div>
				</div>

				<div id="catDeleteStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <?php echo $systemWords['pleasewait']; ?></strong> 
						</div>
					</div>

            	<div class="delete-category" style="display: none">

	                <h3 align="center"><?php echo $category['areYouSure']; ?></h3>
	                <form class="form">
		        		<div class="form-group">
		        			<input id="deleteCategoryID" type="hidden" name="" class="form-control" readonly>
		        		</div>
		        		<div class="form-group">
		        			<label><?php echo $category['categoryName']; ?></label>
		        			<input id="deleteCategoryName" type="text" name="" class="form-control" readonly>
		        		</div>
		        		<div class="form-group">
		        			<label><?php echo $category['categoryUnit']; ?></label>
		        			<input id="deleteCategoryUnit" type="text" name="" class="form-control" readonly>
		        		</div>
		        	</form>
		        	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $category['close']; ?></button>
                <button type="button" class="btn btn-danger" onclick="deleteCategory()"><?php echo $category['yesDelete']; ?></button>
		        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $category['close']; ?></button>
            </div>
        </div>
    </div>
</div>

<?php include 'asset/includes/sidebar.php';?>
<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><?php echo $category['productCategories']; ?></h3>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-8">
		<form class="form-inline">
			<div class="form-group" style="display: none;" id="loadingCategory">
    			<div class="form-control loadingCategoryStyle">
    			<p><img src="<?php echo BASE_URL; ?>asset/reload.gif"> <?php echo $systemWords['pleasewait']; ?></p>
    			</div>
  			</div>	
			<div class="form-group">
				<button type="button" class="reloadCategory btn btn-primary pull-right reloadCategory" onclick="loadCategory()"><i class="glyphicon glyphicon-refresh"></i> <?php echo $category['refreshTable']; ?></button>
			</div>
		</form>
													<div id="loadCategory">

			                   </div>
		</div>
		<div class="col-lg-4">
			<div class="catStatusHeight">
				<div id="catStatusTrue" style="display: none">
					<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-ok"></i> <?php echo $category['categoryAddedSuccessfully']; ?></strong> 
					</div>
				</div>
				<div id="catStatusFalse" style="display: none">
					<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-remove"></i> <?php echo $category['failedToAddCategory']; ?></strong> 
					</div>
				</div>
				<div id="catStatusEmpty" style="display: none">
					<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $category['fillAllFields']; ?></strong> 
					</div>
				</div>
				<div id="catStatusDuplicate" style="display: none">
					<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-warning-sign"></i> <?php echo $category['categoryAlreadyExists']; ?></strong> 
					</div>
				</div>
				<div id="catStatusLoading" style="display: none">
					<div class="alert" role="alert">
	  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  <?php echo $systemWords['pleasewait']; ?></strong> 
					</div>
				</div>
			</div>
				<div class="panel panel-primary">
					<div class="panel-heading"><h4 align="center"><b><?php echo $category['addNewCategory']; ?></b></h4></div>
					<div class="panel-body">
						<form>
							<div class="form-group">
								<label><?php echo $category['categoryName']; ?></label>
								<input type="text" class="form-control" id="newCategoryName">
							</div>
							<div class="form-group">
								<label><?php echo $category['categoryUnit']; ?></label>
								<input type="text" class="form-control" id="newCategoryUnit">
							</div>

						</form>
					</div>
					<div class="panel-footer">
						<button type="button" class="btn btn-primary" onclick="addCategory()"><?php echo $category['addCategory']; ?></button>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>