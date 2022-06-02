<body class="wrapper">
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit Product Category</h4>
            </div>
            <div class="modal-body">

            	<div class="catStatusHeight">
					<div id="catEditStatusTrue" style="display: none">
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-ok"></i> Category Updated Successfully!</strong> 
						</div>
					</div>
					<div id="catEditStatusFalse" style="display: none">
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-remove"></i> Failed to Update Category!</strong> 
						</div>
					</div>
					<div id="catEditStatusEmpty" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-info-sign"></i> Fill All Fields...</strong> 
						</div>
					</div>
					<div id="catEditStatusDuplicate" style="display: none">
						<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				<strong><i class="glyphicon glyphicon-warning-sign"></i> Category Already Exists!!!</strong> 
						</div>
					</div>
					<div id="catEditStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  Please Wait..</strong> 
						</div>
					</div>
				</div>

	        	<form class="form">
	        		<div class="form-group">
	        			<input type="hidden" id="modifyCategoryID" type="text" name="" class="form-control" readonly>
	        		</div>
	        		<div class="form-group">
	        			<label>Edit Category Name</label>
	        			<input id="modifyCategoryName" type="text" name="" class="form-control">
	        		</div>
	        		<div class="form-group">
	        			<label>Edit Category Unit</label>
	        			<input id="modifyCategoryUnit" type="text" name="" class="form-control">
	        		</div>
	        	</form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editCategory()">Save changes</button>
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
                <h4 class="modal-title" id="myModalLabel">Delete Product Category</h4>
            </div>
            <div class="modal-body">
            	<div class="cannot-delete-category" style="display: none">
            		<h3 align="center">You can not Delete this category</h3>
            	</div>

            	<div id="catDeleteStatusTrue" style="display: none">
					<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-ok"></i> Category Deleted Successfully!</strong> 
					</div>
				</div>

				<div id="catDeleteStatusFalse" style="display: none">
					<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-remove"></i> Failed to Delete Category!</strong> 
					</div>
				</div>

				<div id="catDeleteStatusLoading" style="display: none">
						<div class="alert" role="alert">
		  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  Please Wait..</strong> 
						</div>
					</div>

            	<div class="delete-category" style="display: none">

	                <h3 align="center">Are you sure to DELETE Product Category?</h3>
	                <form class="form">
		        		<div class="form-group">
		        			<input id="deleteCategoryID" type="hidden" name="" class="form-control" readonly>
		        		</div>
		        		<div class="form-group">
		        			<label>Category Name</label>
		        			<input id="deleteCategoryName" type="text" name="" class="form-control" readonly>
		        		</div>
		        		<div class="form-group">
		        			<label>Category Unit</label>
		        			<input id="deleteCategoryUnit" type="text" name="" class="form-control" readonly>
		        		</div>
		        	</form>
		        	<button type="button" class="btn btn-default" data-dismiss="modal">No, Back...</button>
                <button type="button" class="btn btn-danger" onclick="deleteCategory()">Yes, Delete!</button>
		        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include 'asset/includes/sidebar.php';?>
<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Cash Accounts</h3>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-8">
		<form class="form-inline">
			<div class="form-group">
				<input class="form-control" placeholder="Search Cash Accounts..." id="searchCategory" oninput="searchCat()">
			</div>
			<div class="form-group" style="display: none;" id="loadingCashAccounts">
    			<div class="form-control loadingCategoryStyle">
    			<p><img src="<?php echo BASE_URL; ?>asset/reload.gif"> Loading</p>
    			</div>
  			</div>	
			<div class="form-group">
				<button type="button" class="reloadCategory btn btn-primary pull-right reloadCategory" onclick="loadCashAccounts()"><i class="glyphicon glyphicon-refresh"></i></button>
			</div>
		</form>
			
			<table id="categoryTable" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th width="20%">Cash Account ID</th>
						<th>Cash Account Name</th>
						<th>Cash Account Balance</th>
						<!--<th>Action</th>-->
					</tr>
				</thead>
				<tbody id="loadCashAccounts">
                         
                </tbody>
			</table>
		</div>
		<div class="col-lg-4">
			<div class="catStatusHeight">
				<div id="cashAccountStatusTrue" style="display: none">
					<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-ok"></i> Cash Account Added Successfully!</strong> 
					</div>
				</div>
				<div id="cashAccountStatusFalse" style="display: none">
					<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-remove"></i> Failed to Add Cash Account!</strong> 
					</div>
				</div>
				<div id="cashAccountStatusEmpty" style="display: none">
					<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-info-sign"></i> Cash Account Name Required...</strong> 
					</div>
				</div>
				<div id="cashAccountStatusDuplicate" style="display: none">
					<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<strong><i class="glyphicon glyphicon-warning-sign"></i> Cash Account Already Exists!!!</strong> 
					</div>
				</div>
				<div id="cashAccountStatusLoading" style="display: none">
					<div class="alert" role="alert">
	  				<strong><img src="<?php echo BASE_URL; ?>asset/reload.gif">  Please Wait..</strong> 
					</div>
				</div>
			</div>
				<div class="panel panel-primary">
					<div class="panel-heading"><h4 align="center"><b>Add New Cash Account</b></h4></div>
					<div class="panel-body">
						<form>
							<div class="form-group">
								<label>Cash Account Name</label>
								<input type="text" class="form-control" id="newCashAccountName">
							</div>
						</form>
					</div>
					<div class="panel-footer">
						<button type="button" class="btn btn-primary" onclick="addCashAccount()">Add Cash Account</button>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>