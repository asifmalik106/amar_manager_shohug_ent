<?php
include 'system/Controller.php';
class admin extends Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function sessionVerify($data){
		if($data=='verify'){
			if (!(array_key_exists('data', $_SESSION) && $_SESSION['data']['rank'] == 'manager')){
				$this->load->redirectIn();
			}
		}
	}

	public function index(){
		$this->sessionVerify('verify');
		$data = array(
				'title'=> 'Dashboard | আমার Manager'
				);
		$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
		$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminDashboard.js'
							);
		$this->load->model('adminModel');
		$dashModel = new adminModel();
		$result = $dashModel->getStock();
		$data['data']['stock'] = $result;
		$data['data']['balance'] = $dashModel->getTotalCashBalance();
		$customers = $dashModel->getCustomer();
		$acReceivable = 0;
		$dangerZone = 0;
		while($cRow = $customers->fetch_assoc()){
			$invT = $dashModel->getTotalInvoiceSC($cRow['scID'])->fetch_assoc()['invoiceTotal'];
			$paidT = $dashModel->getTotalPaidSC($cRow['scID'])->fetch_assoc()['paidTotal'];
			if(($invT - $paidT)>0)
			{
				$acReceivable += ($invT - $paidT);
			}
			
			if($cRow['scLimit']<(($invT - $paidT))){
				$dangerZone++;
			}
		}
		
		$unearnedQuery = $dashModel->getSCBalance();
		$unearnedTotal = 0;
		while($urow = $unearnedQuery->fetch_assoc()){
			if($urow['balance']>0){
				$unearnedTotal+= $urow['balance'];
			}
		}
		$data['data']['receivable'] = $acReceivable;
		$data['data']['danger'] = $dangerZone;
		$data['data']['unearned'] = $unearnedTotal;
		$products = $dashModel->getProducts();
		$warning = $dashModel->getStockWarning()->fetch_assoc()['warning'];
		$stock = $dashModel->getStockOver()->fetch_assoc()['over'];
		$data['data']['warning'] = $warning;
		$data['data']['out'] = $stock;
		$this->load->view('admin/dashboard', $data);

	}
	
	public function misc(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null){
			echo "An Error Occured!";
		}
		else{
			$reqData = func_get_arg(0);
			if($reqData[0]=='receivable')
			{
				$data = array(
					'title'=> 'Cash Receivable from Customers | আমার Manager'
					);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminCustomer.js'
							);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getCustomer();
				$finalOutput = array();

				while ($row = $result->fetch_assoc()){
					$invoice = $dashModel->invoiceCountCustomer($row['scID']);
					$invoice = $invoice->fetch_assoc();

					$deposit = $dashModel->getCustomerDeposit($row['scID']);
					$deposit = $deposit->fetch_assoc();

					$expense = $dashModel->getCustomerExpense($row['scID']);
					$expense = $expense->fetch_assoc();
					$balance = $deposit['deposit'] - $expense['expense'];
					if($balance<0){
						$newArray = array(
							'id'           => $row['scID'],
							'name' 	       => $row['scNameCompany'],
							'contact'      => $row['scContactNo'],
							'limit'        => $row['scLimit'],
							'invoiceCount' => $invoice['invoiceCount'],
							'balance'      => $balance
						);

					$finalOutput[] = $newArray;
					}
					
				}
				$data['data'] = $finalOutput;

				$this->load->view('admin/customer', $data);
			}
			else if($reqData[0]=='unearned')
			{
				$data = array(
					'title'=> 'Unearned Revenues from Customers | আমার Manager'
					);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminCustomer.js'
							);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getCustomer();
				$finalOutput = array();

				while ($row = $result->fetch_assoc()){
					$invoice = $dashModel->invoiceCountCustomer($row['scID']);
					$invoice = $invoice->fetch_assoc();

					$deposit = $dashModel->getCustomerDeposit($row['scID']);
					$deposit = $deposit->fetch_assoc();

					$expense = $dashModel->getCustomerExpense($row['scID']);
					$expense = $expense->fetch_assoc();
					$balance = $deposit['deposit'] - $expense['expense'];
					if($balance>0){
						$newArray = array(
							'id'           => $row['scID'],
							'name' 	       => $row['scNameCompany'],
							'contact'      => $row['scContactNo'],
							'limit'        => $row['scLimit'],
							'invoiceCount' => $invoice['invoiceCount'],
							'balance'      => $balance
						);

					$finalOutput[] = $newArray;
					}
					
				}
				$data['data'] = $finalOutput;

				$this->load->view('admin/customer', $data);
			}
			else if($reqData[0]=='dangerzone')
			{
				$data = array(
					'title'=> 'Danger Zone Customers | আমার Manager'
					);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminCustomer.js'
							);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getCustomer();
				$finalOutput = array();

				while ($row = $result->fetch_assoc()){
					$invoice = $dashModel->invoiceCountCustomer($row['scID']);
					$invoice = $invoice->fetch_assoc();

					$deposit = $dashModel->getCustomerDeposit($row['scID']);
					$deposit = $deposit->fetch_assoc();

					$expense = $dashModel->getCustomerExpense($row['scID']);
					$expense = $expense->fetch_assoc();
					$balance = $deposit['deposit'] - $expense['expense'];
					if(($balance*(-1))>$row['scLimit']){
						$newArray = array(
							'id'           => $row['scID'],
							'name' 	       => $row['scNameCompany'],
							'contact'      => $row['scContactNo'],
							'limit'        => $row['scLimit'],
							'invoiceCount' => $invoice['invoiceCount'],
							'balance'      => $balance
						);

					$finalOutput[] = $newArray;
					}
					
				}
				$data['data'] = $finalOutput;

				$this->load->view('admin/customer', $data);
			}
			
			
			else if($reqData[0]=="productWarning"){
				$data = array(
					'title'=> 'Product Warning | আমার Manager'
				);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
									'dataTables/css/dataTables.responsive.css'
									);
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
									'dataTables/js/dataTables.bootstrap.min.js',
									'dataTables/js/dataTables.responsive.js',
									'js/page/adminDashboard.js'
									);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getStock();
				$data['data']['stock'] = $result;
				$data['data']['type'] = 'warning';
				$this->load->view('admin/productWarning', $data);
			}
			else if($reqData[0]=="outOfStock"){
				$data = array(
					'title'=> 'Out of Stock Product | আমার Manager'
				);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
									'dataTables/css/dataTables.responsive.css'
									);
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
									'dataTables/js/dataTables.bootstrap.min.js',
									'dataTables/js/dataTables.responsive.js',
									'js/page/adminDashboard.js'
									);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getStock();
				$data['data']['stock'] = $result;
				$data['data']['type'] = 'outOfStock';
				$this->load->view('admin/productWarning', $data);
			}
		}
		
	}

	public function category(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null){
			$data = array(
					'title'=> 'Product Category | আমার Manager'
					);
						$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
						'dataTables/css/dataTables.responsive.css'
						);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
						'js/page/adminCategory.js'
						);
	
			$this->load->view('admin/category', $data);
		}else{ 


			$reqData = func_get_arg(0);



			if($reqData[0]=='addCategory')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['newCatName']!='' && $_POST['newCatUnit']!='')
					{
						$catName = Validation::verify($_POST['newCatName']);
						$catUnit = Validation::verify($_POST['newCatUnit']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->isUniqueCategory($catName, $catUnit);
						if(($result->num_rows)==0)
						{
							$result = $dashModel->addCategory($catName, $catUnit);
							if($result)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}


			if($reqData[0]=='getAllCategory')
			{
				global $category;
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getAllCategory();
				$i = 1;
				echo	"<table id=\"categoryTable\" class=\"table table-striped table-bordered\">";
				echo	"<thead>";
				echo	"<tr>";
				echo	"<th>".$category['id']."</th>";
				echo	"<th>".$category['categoryName']."</th>";
				echo	"<th>".$category['categoryUnit']."</th>";
				echo	"<th>".$category['noOfProduct']."</th>";
				echo	"<th>".$category['action']."</th>";
				echo	"</tr>";
				echo	"</thead>";
				echo	"<tbody>";
				while($row = $result->fetch_assoc())
				{
						echo "<tr>";
						echo "<td>".$row['categoryID']."</td>";
						echo "<td>".$row['categoryName']."</td>";
						echo "<td>".$row['categoryUnit']."</td>";
						$resultCount = $dashModel->getCategoryProductCount($row['categoryID']);
						$rowResultCount = $resultCount->fetch_assoc();
						echo "<td>".$rowResultCount['count']."</td>";
						echo "<td>
						<a href=\"#\" onclick=\"fillModifyCategoryData(".$row['categoryID'].",'".$row['categoryName']."','".$row['categoryUnit']."')\" title=\"Edit Category\" data-toggle=\"modal\" data-target=\"#editModal\">
						<i class=\"fa fa-edit fa-lg edit\"></i></a>
						<a href=\"#\" onclick=\"fillDeleteCategoryData(".$row['categoryID'].",'".$row['categoryName']."',".$rowResultCount['count'].",'".$row['categoryUnit']."')\" data-toggle=\"modal\" data-target=\"#deleteModal\">
						<i class=\"fa fa-times fa-lg delete\" title=\"Delete category\"></i></a>
						</td>";
						echo "</tr>";
						$i++;
				}
				echo "</tbody>";
				echo "</table>";
				echo "<script>";
				echo "$('#categoryTable').dataTable({'order': [[0, 'desc']]});";
				echo "</script>";
				
			}

			if($reqData[0]=='deleteCategory')
			{
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				if($_POST['submit']=="true")
				{
					if($_POST['deleteCatID']!='')
					{
						$catID 	 = Validation::verify($_POST['deleteCatID']);
						$dashModel = new adminModel();
						$result = $dashModel->deleteCategory($catID);
						if($result)
						{
							echo "true";
						}
						else
						{
							echo "false";
						}
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}

			if($reqData[0]=='editCategory')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['editCatName']!='' && $_POST['editCatUnit']!='')
					{
						$catID 	 = Validation::verify($_POST['editCatID']);  
						$catName = Validation::verify($_POST['editCatName']);
						$catUnit = Validation::verify($_POST['editCatUnit']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->isUniqueCategory($catName, $catUnit);
						if(($result->num_rows)==0)
						{
							$inResult = $dashModel->getProductCategoryInfo($catID)->fetch_assoc();
							
							$result1 = $dashModel->updateCategoryInvoice($catID,$inResult['categoryName'], $inResult['categoryUnit'], $catName, $catUnit);
							$result = $dashModel->editCategory($catID, $catName, $catUnit);
							if($result && $result1)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}
			/*
			echo "<pre>";
			print_r($reqData);
			echo "</pre>";
			*/
		}
	}

	public function product(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null)
		{
			$data = array(
				'title'=> 'Products | আমার Manager'
				);
			$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminProductList.js'
							);
			$this->load->model('adminModel');
			$dashModel = new adminModel();
			$result = $dashModel->getAllProduct();
			$data['data']['product'] = $result;
			$this->load->view('admin/product', $data);
		}
		else
		{ 
			$reqData = func_get_arg(0);

			if($reqData[0]=='all')
			{
				global $newProduct;
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getAllProduct();
				$i = 1;
				echo '<table id="productTable" class="table table-striped table-bordered">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>'.$newProduct['id'].'</th>';
				echo '<th>'.$newProduct['productName'].'</th>';
				echo '<th>'.$newProduct['description'].'</th>';
				echo '<th>'.$newProduct['category'].'</th>';
				echo '<th>'.$newProduct['action'].'</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
                         
        
                while($row = $result->fetch_assoc())
                {
                   	echo "<tr>";
                    echo "<td>".$row['productID']."</td>";
										echo "<td>".$row['productName']."</td>";
                    echo "<td>".$row['productDescription']."</td>";
                    echo "<td>".$row['categoryName']."</td>";
                    echo "<td>
                    <a href=\"#\" onclick=\"fillModifyProductData(".$row['productID'].",'".$row['productName']."','".$row['productDescription']."','".$row['categoryID']."','".$row['productLimit']."')\" title=\"Edit Category\" data-toggle=\"modal\" data-target=\"#editModal\">
                    <i class=\"fa fa-edit fa-lg edit\"></i></a>
                    <a href=\"#\" onclick=\"fillDeleteCategoryData(".$row['categoryID'].",'".$row['categoryName']."','".$row['categoryUnit']."')\" data-toggle=\"modal\" data-target=\"#deleteModal\">
                    <i class=\"fa fa-times fa-lg delete\" title=\"Delete category\"></i></a>
                    </td>";
                    echo "</tr>";
                    $i++;
                }
				echo '</tbody>';
				echo '</table>';
				echo "<script>";
				echo "$('#productTable').dataTable({'order': [[0, 'desc']]});";
				echo "</script>";
			}
			else if($reqData[0]=='edit'){
				if($_POST['submit']=="true")
				{
					if($_POST['editProductID']!='' && $_POST['editProductName']!='' &&  $_POST['editCatID']!='')
					{
						$pID = Validation::verify($_POST['editProductID']);
						$pName = Validation::verify($_POST['editProductName']);
						$pDes = Validation::verify($_POST['editProductDescription']);
						$cID = Validation::verify($_POST['editCatID']);
						$pLimit = Validation::verify($_POST['editProductLimit']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						//$result = $dashModel->isUniqueProduct($pName, $cID);
						if(0==0)
						{
							$result = $dashModel->editProduct($pID, $pName, $pDes, $cID, $pLimit);
							if($result)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0]=='info'){
				if($_POST['submit']=="true" && $_POST['pID']!=''){
				$pID = Validation::verify($_POST['pID']);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$scInfo = $dashModel->getAllProduct($pID);
				$scInfo = $scInfo->fetch_assoc();
				echo '<div class="col-md-4">';
				echo '<input id="productID" style="display: none" value="'.$scInfo['productID'].'">';
				echo '<table><tr>';
				echo '<td class="productTable"><h3>Product: </h3></td>';
				echo '<td class="productTable"><h3> <strong id="productName">'.$scInfo['productName'].'</strong> </h3></td>';
				echo '</tr><tr>';
				echo '<td class="productTable"><h4>Category: </h4></td>';
				echo '<td class="productTable"><h4> <strong id="productCategoryName">'.$scInfo['categoryName'].'</strong> </h4></td>';
				echo '</tr><tr>';
				echo '<td class="productTable"><h4>Unit: </h4></td>';
				echo '<td class="productTable"><h4> <strong id="productCategoryUnit">'.$scInfo['categoryUnit'].'</strong> </h4></td>';
				echo '</tr><tr>';
				echo '<td class="productTable"><h4>Warning Limit: </h4></td>';
				echo '<td class="productTable"><h4> <strong id="productCategoryUnit">'.$scInfo['productLimit'].'</strong> </h4></td>';
				echo '</tr></table>';
				$editData = "fillModifyProductData(".$scInfo['productID'].", '".$scInfo['productName']."', '".$scInfo['productDescription']."', '".$scInfo['categoryID']."', '".$scInfo['productLimit']."')";
				echo '<button class="btn btn-primary" onclick="'.$editData.'" title="Edit Product Information" data-toggle="modal" data-target="#editModal"><i class="glyphicon glyphicon-edit"></i> Edit Profile Information</button>';
				echo '</div>';
				echo '<div class="col-md-4">';
				echo '<h4>Description: </h4>';
				echo '<h4> <strong id="productDescription">'.$scInfo['productDescription'].'</h4>';
				echo '</div>';
				}
				else
				{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0]=='add')
			{
				$select2Lang = 'select2/js/lang/'.$_SESSION['data']['language'].'.js';
				$data = array(
						'title'=> 'Add Product | আমার Manager'
						);

				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
					'dataTables/css/dataTables.responsive.css',
					'select2/css/select2.min.css');
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
					'dataTables/js/dataTables.bootstrap.min.js',
					'dataTables/js/dataTables.responsive.js',
					'select2/js/select2.min.js',
					'js/page/adminProduct.js'
					);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getAllCategory();
				$result2 = $dashModel->getAllCategory();
				$data['data']['category'] = $result; 
				$data['data']['category2'] = $result2; 
				$this->load->view('admin/addProduct', $data);
			}
			else if($reqData[0]=='new')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['name']!='' && $_POST['cat']!='')
					{
						$productName = Validation::verify($_POST['name']);
						$productDescription = Validation::verify($_POST['description']);
						$productCategoryID = Validation::verify($_POST['cat']);
						$productLimit = Validation::verify($_POST['limit']);

						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->isUniqueProduct($productName, $productCategoryID);
						if(($result->num_rows)==0)
						{
							$result = $dashModel->addProduct($productName, $productDescription, $productCategoryID, $productLimit);
							if($result)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0]=='batch')
			{
				if($reqData[1]=='edit')
				{
					if($_POST['submit']=="true")
					{
						if($_POST['batch']!='' && $_POST['exBatch']!='' && $_POST['saleUnit']!='')
						{
							$pID = Validation::verify($_POST['pID']);
							$batch = Validation::verify($_POST['batch']);
							$exBatch = Validation::verify($_POST['exBatch']);
							$saleUnit = Validation::verify($_POST['saleUnit']);
							$this->load->model('adminModel');
							$dashModel = new adminModel();
							$result = $dashModel->isUniqueBatch($pID, $batch);
							if((($result->num_rows)==0)||($batch==$exBatch))
							{
								$result = $dashModel->updateBatchSale($pID,$exBatch, $batch, $saleUnit);
								$result1 = $dashModel->updateBatchInvoice($pID,$exBatch, $batch);
								if($result && $result1)
								{
									echo "true";
								}
								else
								{
									echo "false";
								}
							}
							else
							{
								echo "duplicate";
							}
						}
						else
						{
							echo "empty";
						}

					}
					else
					{
						$this->load->redirectIn();
					}
				}
				else if($reqData[1]=='get')
				{
					$pID = Validation::verify($_POST['pID']);
					$this->load->model('adminModel');
					$dashModel = new adminModel();
					$batch = $dashModel->getStock($pID);
					while($row = $batch->fetch_assoc()){
										echo "<tr>";
										echo "<td>".$row['batch']."</td>";
										echo "<td>".$row['quantity']."</td>";
										echo "<td>".$row['purchaseUnit']."</td>";
										echo "<td>".$row['saleUnit']."</td>";
																echo "<td>
						<a href=\"#\" onclick=\"fillModifyBatchData('".$row['batch']."','".$row['saleUnit']."')\" title=\"Edit Category\" data-toggle=\"modal\" data-target=\"#editBatchModal\">
						<i class=\"fa fa-edit fa-lg edit\"></i></a>
						<a href=\"#\" onclick=\"fillDeleteCategoryData(".$row['categoryID'].",'".$row['categoryName']."',".$rowResultCount['count'].",'".$row['categoryUnit']."')\" data-toggle=\"modal\" data-target=\"#deleteModal\">
						<i class=\"fa fa-times fa-lg delete\" title=\"Delete category\"></i></a>
						</td>";
										echo "</tr>";
									}
				}
				else if($reqData[1]=='delete'){
					if($_POST['submit']=="true")
					{
						if($_POST['batch']!='' &&  $_POST['pID']!='')
						{
							$pID = Validation::verify($_POST['pID']);
							$batch = Validation::verify($_POST['batch']);
							$this->load->model('adminModel');
							$dashModel = new adminModel();
							$result = $dashModel->isBatchEmpty($pID, $batch)->fetch_assoc();
							if($result['quantity']==0)
							{
								$result = $dashModel->deleteBatch($pID, $batch);
								if($result)
								{
									echo "true";
								}
								else
								{
									echo "false";
								}
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "empty";
						}

					}
					else
					{
						$this->load->redirectIn();
					}
				}
			}
			else if($reqData[0]=='barcode'){
				$data = array(
					'title'=> 'Barcode | আমার Manager'
				);
				$data['js'] = array('js/JsBarcode.code128.min.js','js/page/barcode.js');
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$pID = $dashModel->getProducts();
				$productArray = array();
				while($row = $pID->fetch_assoc()){
					
					$batchStock = $dashModel->getStock($row['productID']);
					$price = '';
					$batch = '';
					$printBarcode = '';
					while($rowIn = $batchStock->fetch_assoc()){
						$price.= $_SESSION['data']['businessCurrency']." ".$rowIn['saleUnit'].',';
						$batch.= $rowIn['batch'].',';
						$printBarcode.= $rowIn['barcode'].',';
					}
					$localArray = array(
						'productID' => $row['productID'],
						'productName' => $row['productName'],
						'saleUnit' => $price,
						'batch' => $batch,
						'barcode' => $printBarcode
					);
					array_push($productArray,$localArray);
				}
				
				$data['data']['product'] = $productArray;
				 
                    
                   // echo "<option barcode='".$row['barcode']."'  batch='".$row['batch']."'  saleUnit='".$row['saleUnit']."' value='".$row['productID']."' name='".$row['productName']."'>".$row['productID']." - ".$row['productName']."</option>"
               
				$this->load->view('admin/barcode', $data);
			}
			else{
				$data = array(
						'title'=> 'Product | আমার Manager'
						);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminProduct.js'
							);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$scInfo = $dashModel->getAllProduct($reqData[0]);
				$scInfo = $scInfo->fetch_assoc();
				$data['data']['product'] = $scInfo;
				$scInfo = $dashModel->getStockTotal($reqData[0]);
				$scInfo = $scInfo->fetch_assoc();
				$data['data']['productTotal'] = $scInfo['total'];
				$result = $dashModel->getAllCategory();
				$result2 = $dashModel->getAllCategory();
				$data['data']['category'] = $result; 
				$data['data']['category2'] = $result2; 
				$batch = $dashModel->getStock($reqData[0]);
				$data['data']['batch'] = $batch;
				$this->load->view('admin/productProfile', $data);
			}
		}
	}

	public function customer(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null)
		{
			$data = array(
				'title'=> 'Customers | আমার Manager'
				);
			$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
						'dataTables/css/dataTables.responsive.css'
						);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
						'dataTables/js/dataTables.bootstrap.min.js',
						'dataTables/js/dataTables.responsive.js',
						'js/page/adminCustomer.js'
						);
			$this->load->model('adminModel');
			$dashModel = new adminModel();
			$result = $dashModel->getCustomer();
			$finalOutput = array();
			
			while ($row = $result->fetch_assoc()){
				$invoice = $dashModel->invoiceCountCustomer($row['scID']);
				$invoice = $invoice->fetch_assoc();

				$deposit = $dashModel->getCustomerDeposit($row['scID']);
				$deposit = $deposit->fetch_assoc();

				$expense = $dashModel->getCustomerExpense($row['scID']);
				$expense = $expense->fetch_assoc();
				$balance = $deposit['deposit'] - $expense['expense'];
				
				$newArray = array(
						'id'           => $row['scID'],
						'name' 	       => $row['scNameCompany'],
						'contact'      => $row['scContactNo'],
						'limit'        => $row['scLimit'],
						'invoiceCount' => $invoice['invoiceCount'],
						'balance'      => $balance
					);

				$finalOutput[] = $newArray;
			}
			$data['data'] = $finalOutput;

			$this->load->view('admin/customer', $data);
		}
		else{
			$reqData = func_get_arg(0);
			if($reqData[0]=='new')
			{
				$data = array(
				'title'=> 'Add New Customer | আমার Manager'
				);
				$data['js'] = array('js/page/adminCustomer.js');

				$this->load->view('admin/addCustomer', $data);
			}
			else if($reqData[0]=='add')
			{
				if($_POST['submit']=="true"){
					if($_POST['newCName']!='' && $_POST['newCPhone']!='')
					{
						$newCustomerName = Validation::verify($_POST['newCName']);
						$newCustomerFather = Validation::verify($_POST['newCFather']);
						$newCustomerPhone = Validation::verify($_POST['newCPhone']);
						$newCustomerAddress = Validation::verify($_POST['newCAddress']);
						$newCustomerLimit = Validation::verify($_POST['newCLimit']);

						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->isUniqueCustomer($newCustomerName, $newCustomerPhone);
						if(($result->num_rows)==0)
						{
							$result = $dashModel->addCustomer($newCustomerName, $newCustomerFather, $newCustomerPhone, $newCustomerAddress, $newCustomerLimit);
							if($result)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
				}else{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0]=='editProfile')
			{
				if($_POST['submit']=="true"){
					if($_POST['editSCName']!='' && $_POST['editSCPhone']!='' && $_POST['editSCID']!='')
					{
						$editSCID = Validation::verify($_POST['editSCID']);
						$editSCName = Validation::verify($_POST['editSCName']);
						$editSCFather = Validation::verify($_POST['editSCFather']);
						$editSCPhone = Validation::verify($_POST['editSCPhone']);
						$editSCAddress = Validation::verify($_POST['editSCAddress']);
						$editSCLimit = Validation::verify($_POST['editSCLimit']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->isUniqueCustomerEdit($editSCID, $editSCName, $editSCPhone);
						if(($result->num_rows)==0)
						{
							$result = $dashModel->editSCProfile($editSCID, $editSCName, $editSCFather, $editSCPhone, $editSCAddress, $editSCLimit);
							if($result)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
				}else{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0]=='getProfile')
			{
				if($_POST['submit'] == "true")
				{
					$this->load->model('adminModel');
					$dashModel = new adminModel();
					$scInfo = $dashModel->getSCInfo($reqData[1]);
					$scResult = $scInfo->fetch_assoc();
					
					echo '<div class="col-md-4">';
					echo '<input id="scID" type="hidden" value="'.$scResult['scID'].'">';
					echo '<h4> Name: </h4>';
					echo '<h4> <strong id="SCName">'.$scResult['scNameCompany'].'</strong></h4>';
					echo '<h4> Contact No: </h4>';
					echo '<h4> <strong id="SCPhone">'.$scResult['scContactNo'].'</strong> </h4>';
					echo '<h4> Credit Limit: </h4>';
					echo '<h4> <strong id="SCLimit">'.$scResult['scLimit'].'</strong> </h4>';
					echo '</div>';
					echo '<div class="col-md-4">';
					echo '<h5> Father/Contact Person: </h5>';
					echo '<h5> <strong id="SCFather">'.$scResult['scFatherContactPerson'].'</strong></h5>';
					echo '<h5> Address: </h5>';
					echo '<h5> <strong id="SCAddress">'.$scResult['scAddress'].'</strong></h5>';
					echo '<h5> Registration Date: </h5>';
					echo '<h5> <strong>'.$scResult['scDate'].'</strong> </h5>';
					echo '</div>';
				}
				else{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0]=='getInvoices')
			{
				if($_POST['submit'] == "true")
				{
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getSCInvoiceInfo($reqData[1]);
				$finalOutput = array();
				while ($row = $result->fetch_assoc()){
					$UserFullName = $dashModel->getUserFullName($row['userID']);
					$UserFullName = $UserFullName->fetch_assoc();
					$paymentInfo = $dashModel->getTotalPaidIndividualInvoice($row['invoiceID']);
					$paymentInfo = $paymentInfo->fetch_assoc();
					$newArray = array(
							'invoiceID'      	=> $row['invoiceID'],
							'invoiceDate'    	=> $row['invoiceDate'],
							'invoiceTime'   	=> $row['invoiceTime'],
							'invoiceAmount'		=> number_format(($row['invoiceAmount']-$row['invoiceDiscount']),2, '.', ''),
							'invoicePaid'			=> number_format($paymentInfo['paidTotal'],2, '.', ''),
							'invoiceStatus'   => $row['invoiceStatus'],
							'invoiceAgentName'=> $UserFullName['name']
						);
					$finalOutput[] = $newArray;
				}
				$data['data']['invoiceInfo'] = $finalOutput;
				echo "<table class=\"table\" id=\"invoiceList\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Invoice ID</th>";
        echo "<th> Invoice Date </th>";
        echo "<th> Invoice Time </th>";
        echo "<th> Invoice Total </th>";
        echo "<th> Paid Total  </th>";
        echo "<th> Stuff Name </th>";
        echo "<th> Status </th>";
        echo "<th> View </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
                foreach($data['data']['invoiceInfo'] as $invRow)
                {
									$invoiceDate = date("d/m/Y", strtotime($invRow['invoiceDate']));
									$invoiceTime = date("h:i:s A", strtotime($invRow['invoiceTime']));
									$payNow = "payNow(".$invRow['invoiceID'].",'".$invoiceDate."','".$invoiceTime."','".$invRow['invoiceAmount']."','".$invRow['invoicePaid']."')";
                  $invStatus = 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#payNow"> <i class="glyphicon glyphicon-warning-sign"> </i> Pay Now </button>';
                  $invStatus = '<button onclick="'.$payNow.'" '.$invStatus;
									if($invRow['invoicePaid'] == 0 && $invRow['invoiceAmount'] > 0)
                  {
                    echo "<tr class=\"ebmDanger\">";
                  }
                  else if($invRow['invoicePaid'] > 0 && $invRow['invoicePaid'] < $invRow['invoiceAmount'] && $invRow['invoiceAmount'] > 0 )
                  {
                    echo "<tr class=\"ebmWarning\">";
                  }
                  else
                  {
                    echo "<tr class=\"ebmSuccess\">";
                    $invStatus = '<span class="label label-success"> <i class="glyphicon glyphicon-ok"> </i> Paid </span>';
                  }
									
                  echo "<td class=\"invoiceID\">".$invRow['invoiceID']."</td>";
                  echo "<td class=\"invoiceDate\">".date("d/m/Y", strtotime($invRow['invoiceDate']))."</td>";
                  echo "<td class=\"invoiceTime\">".date("h:i:s A", strtotime($invRow['invoiceTime']))."</td>";
                  echo "<td class=\"invoiceAmount\">".$invRow['invoiceAmount']."</td>";
                  echo "<td class=\"invoicePaid\">".$invRow['invoicePaid']."</td>";
                  echo "<td>".$invRow['invoiceAgentName']."</td>";
                  if($invRow['invoicePaid'] == 0 && $invRow['invoiceAmount'] > 0)
                  {
                    
                  }
									//echo '<td><button onclick="asif(4)" '.$invStatus;
                  //echo '<td><button onclick="payNow("'.$invRow['invoiceID'].'") '.$invStatus."</td>";
                  
                  echo "<td>".$invStatus."</td>";
									echo "<td><a class=\"btn btn-xs btn-primary\" href=\"".BASE_URL."admin/invoice/".$invRow['invoiceID']."\"> <i class=\"glyphicon glyphicon-eye-open\"></i> View </a></td>";
                  echo "</tr>";
                }
              
            echo "</tbody>";
            echo "</table>";
				echo "<script></script>";
				}
				else{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0] == 'getBalance')
			{
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$scLimit = $dashModel->getSCInfo($_POST['scID'])->fetch_assoc()['scLimit'];
				$scLimit*=(-1);
				$invT = $dashModel->getTotalInvoiceSC($_POST['scID'])->fetch_assoc()['invoiceTotal'];
				$paidT = $dashModel->getTotalPaidSC($_POST['scID'])->fetch_assoc()['paidTotal'];
				$b = $paidT - $invT;
				if($b>=0)
				{
					$scLimit = '<h4 class="edit"> <i class="glyphicon glyphicon-ok"></i> Healthy Profile </h4>';
				}
				else if($b<0 && $b>($scLimit/2))
				{
					$scLimit = '<h4 class="text-warning"> <i class="glyphicon glyphicon-info-sign"></i> Due Balance </h4>';
				}
				else if($b<=($scLimit/2) && $b>(3*($scLimit/4)))
				{
					$scLimit = '<h4 class="text-warning"> <i class="glyphicon glyphicon-warning-sign"></i> 50% Limit Exceeded!!! </h4>';
				}
				else if($b<=(3*($scLimit/4)) && $b>$scLimit)
				{
					$scLimit = '<h4 class="delete"> <i class="glyphicon glyphicon-warning-sign"></i> 75% Limit Exceeded!!! </h4>';
				}
				else
				{
					$scLimit = '<h4 class="delete"><strong> <i class="glyphicon glyphicon-remove"></i> 100% Limit Exceeded!!! </strong></h4>';
				}
				/*
				if($b<$scLimit)
				{
					$scLimit = '<h4 class="delete"> <i class="glyphicon glyphicon-remove"></i> 100% Limit Exceeded!!! </h4>';
				}
				else if($b<0)
				{
					$scLimit = '<h4 class="text-warning"> <i class="glyphicon glyphicon-info-sign"></i> Due Balance </h4>';
				}
				else if($b<($scLimit/2))
				{
					$scLimit = '<h4 class="text-warning"> <i class="glyphicon glyphicon-warning-sign"></i> 50% Limit Exceeded!!! </h4>';
				}
				else if($b<(3*($scLimit/4)))
				{
					$scLimit = '<h4 class="delete"> <i class="glyphicon glyphicon-warning-sign"></i> 75% Limit Exceeded!!! </h4>';
				}
				else
				{
					$scLimit = '<h4 class="edit"> <i class="glyphicon glyphicon-ok"></i> Healthy Profile </h4>';
				}
				*/
				
				if($b>0)
				{
					echo "<strong id=\"profileBalance\"><h1 class=\"edit\" id=\"mainBalance\">".number_format(($paidT - $invT),2, '.', '')."</h1></strong><button onclick=\"setBalance()\" class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#depositNow\"> Make a Deposit </button> <button onclick=\"setBalance()\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#withdrawNow\"> Withdraw Balance </button> <br>".$scLimit;
				}
				else
				{
					echo "<strong id=\"profileBalance\"><h1 class=\"delete\" id=\"mainBalance\">".number_format(($paidT - $invT),2, '.', '')."</h1></strong><button onclick=\"setBalance()\" class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#depositNow\"> Make a Deposit </button><br>".$scLimit;
				}
			}
			else if($reqData[0] == 'getTransactions')
			{
				if($_POST['submit'] == "true")
				{
					$this->load->model('adminModel');
					$dashModel = new adminModel();
					$result = $dashModel->getSCTransaction($reqData[1]);
					$finalTrx = array();
					while($row = $result->fetch_assoc())
					{
						$UserFullName = $dashModel->getUserFullName($row['userID']);
						$UserFullName = $UserFullName->fetch_assoc();
						$newArray = array(
								'trxID'      	=> $row['trxID'],
								'trxDate'    	=> $row['trxDate'],
								'trxTime'   	=> $row['trxTime'],
								'trxAmount'		=> number_format($row['trxAmount'],2, '.', ''),
								'trxUser'   	=> $UserFullName['name'],
								'trxInfo'			=> $row['trxInfo']
							);
						$newArray['trxRef'] = "";
						if($row['trxType'] == 'invoice')
						{
							$newArray['trxType'] = "<a href=\"".BASE_URL."admin/invoice/".$row['trxReference']."\">Invoice #";
							$newArray['trxRef']  = $row['trxReference']."</a>";
						}
						else if($row['trxType'] == 'deposit' && $row['trxAmount']>=0){
							$newArray['trxType'] = "Cash Deposit";
						}
						else{
							$newArray['trxType'] = "Cash Withdraw";
						}
						$finalTrx[] = $newArray;
					}
					$data['data']['transaction'] = $finalTrx;
					echo "<table class=\"table table-bordered table-hover\" id=\"transactionList\">";
           echo "<thead>";
             echo "<tr>";
               echo "<th> Transaction ID</th>";
               echo "<th> Transaction Date </th>";
               echo "<th> Transaction Time </th>";
               echo "<th> Transaction Type </th>";
               echo "<th> Amount  </th>";
               echo "<th> Stuff Name </th>";
               echo "<th> Information </th>";
             echo "</tr>";
           echo "</thead>";
           echo "<tbody>";
                foreach($data['data']['transaction'] as $trxRow)
                {
                  echo "<tr>";                 
                  echo "<td>".$trxRow['trxID']."</td>";
                  echo "<td>".date("d/m/Y", strtotime($trxRow['trxDate']))."</td>";
                  echo "<td>".date("h:i:s A", strtotime($trxRow['trxTime']))."</td>";
                  echo "<td>".$trxRow['trxType'].$trxRow['trxRef']."</td>";
                  echo "<td>".$trxRow['trxAmount']."</td>";
                  echo "<td>".$trxRow['trxUser']."</td>";
                  echo "<td>".$trxRow['trxInfo']."</td>";
                  echo "</tr>";
                }
              
           echo "</tbody>";
         echo "</table>";
				}
				else
				{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0] == 'addAdvance')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['scID']!='' && $_POST['advAmount']!='')
					{
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$invT = $dashModel->getTotalInvoiceSC($_POST['scID'])->fetch_assoc()['invoiceTotal'];
						$paidT = $dashModel->getTotalPaidSC($_POST['scID'])->fetch_assoc()['paidTotal'];
						$b = $paidT - $invT;
						if($b<0){
							$b*=(-1);
							if($_POST['advAmount']>$b){
								$r1 = $dashModel->addCash(1, $b,  "Receive Cash Customer ID: ".$_POST['scID']);
							}else{
								$r1 = $dashModel->addCash(1, $_POST['advAmount'],  "Receive Cash Customer ID: ".$_POST['scID']);
							}
						}
						$paymentInfo = $dashModel->addDeposit($_POST['scID'], $_POST['advAmount'], $_POST['note']);
						if($paymentInfo)
						{
								echo "true";
						}
						else
						{
							echo "false";
						}
					}else{
						echo "empty";
					}
				}else
				{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0] == 'withdrawBalance')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['scID']!='' && $_POST['wAmount']!='')
					{
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$invT = $dashModel->getTotalInvoiceSC($_POST['scID'])->fetch_assoc()['invoiceTotal'];
						$paidT = $dashModel->getTotalPaidSC($_POST['scID'])->fetch_assoc()['paidTotal'];
						$b = $paidT - $invT;
						if($_POST['wAmount'] <= $b ){
							$paymentInfo = $dashModel->addWithdraw($_POST['scID'], $_POST['wAmount'], $_POST['note']);
							if($paymentInfo)
							{
									echo "true";
							}
							else
							{
								echo "false";
							}
						}
					}else{
						echo "empty";
					}
				}else
				{
					$this->load->redirectIn();
				}
			}
			
			else
			{
				
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$scInfo = $dashModel->getSCInfo($reqData[0]);
				$scResult = $scInfo->fetch_assoc();
				$invT = $dashModel->getTotalInvoiceSC($reqData[0])->fetch_assoc()['invoiceTotal'];
				$paidT = $dashModel->getTotalPaidSC($reqData[0])->fetch_assoc()['paidTotal'];
				$data = array(
				'title'=> $scResult['scNameCompany'].' | আমার Manager'
				);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminProfile.js'
							);
				$data['data']['sc'] = $scResult;
				$data['data']['type'] = "Customer";

				
				
				
				$data['data']['balance'] = number_format(($paidT - $invT),2, '.', '');
				
				
				$this->load->view('admin/profile', $data);
			}
		}
	}

	public function supplier(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null)
		{
			$data = array(
				'title'=> 'Suppliers | আমার Manager'
				);
			$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
						'dataTables/css/dataTables.responsive.css'
						);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
						'dataTables/js/dataTables.bootstrap.min.js',
						'dataTables/js/dataTables.responsive.js',
						'js/page/adminSupplier.js'
						);
			$this->load->model('adminModel');
			$dashModel = new adminModel();
			$result = $dashModel->getSupplier();
			$finalOutput = array();
			
			while ($row = $result->fetch_assoc()){
				$invoice = $dashModel->invoiceCountSupplier($row['scID']);
				$invoice = $invoice->fetch_assoc();

				$deposit = $dashModel->getSupplierDeposit($row['scID']);
				$deposit = $deposit->fetch_assoc();

				$expense = $dashModel->getSupplierExpense($row['scID']);
				$expense = $expense->fetch_assoc();
				$balance = $deposit['deposit'] - $expense['expense'];
				
				$newArray = array(
						'id'           => $row['scID'],
						'name' 	       => $row['scNameCompany'],
						'contact'      => $row['scContactNo'],
						'limit'        => $row['scLimit'],
						'invoiceCount' => $invoice['invoiceCount'],
						'balance'      => $balance
					);

				$finalOutput[] = $newArray;
			}
			$data['data'] = $finalOutput;

			$this->load->view('admin/supplier', $data);
		}else{
			$reqData = func_get_arg(0);

			if($reqData[0]=='new')
			{
				$data = array(
				'title'=> 'Add New Supplier | আমার Manager'
				);
				$data['js'] = array('js/page/adminSupplier.js');

				$this->load->view('admin/addSupplier', $data);
			}

			else if($reqData[0]=='add'){
				if($_POST['submit']=="true"){
					if($_POST['newSName']!='' && $_POST['newSPhone']!='')
					{
						$newSupplierName = Validation::verify($_POST['newSName']);
						$newSupplierFather = Validation::verify($_POST['newSFather']);
						$newSupplierPhone = Validation::verify($_POST['newSPhone']);
						$newSupplierAddress = Validation::verify($_POST['newSAddress']);
						$newSupplierLimit = Validation::verify($_POST['newSLimit']);

						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->isUniqueSupplier($newSupplierName, $newSupplierPhone);
						if(($result->num_rows)==0)
						{
							$result = $dashModel->addSupplier($newSupplierName, $newSupplierFather, $newSupplierPhone, $newSupplierAddress, $newSupplierLimit);
							if($result)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
				}else{
					$this->load->redirectIn();
				}
			}
			
			
			
			
			
			
			
			
			
			
			
						else if($reqData[0]=='editProfile')
			{
				if($_POST['submit']=="true"){
					if($_POST['editSCName']!='' && $_POST['editSCPhone']!='' && $_POST['editSCID']!='')
					{
						$editSCID = Validation::verify($_POST['editSCID']);
						$editSCName = Validation::verify($_POST['editSCName']);
						$editSCFather = Validation::verify($_POST['editSCFather']);
						$editSCPhone = Validation::verify($_POST['editSCPhone']);
						$editSCAddress = Validation::verify($_POST['editSCAddress']);
						$editSCLimit = Validation::verify($_POST['editSCLimit']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->isUniqueCustomerEdit($editSCID, $editSCName, $editSCPhone);
						if(($result->num_rows)==0)
						{
							$result = $dashModel->editSCProfile($editSCID, $editSCName, $editSCFather, $editSCPhone, $editSCAddress, $editSCLimit);
							if($result)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
				}else{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0]=='getProfile')
			{
				if($_POST['submit'] == "true")
				{
					$this->load->model('adminModel');
					$dashModel = new adminModel();
					$scInfo = $dashModel->getSCInfo($reqData[1]);
					$scResult = $scInfo->fetch_assoc();
					
					echo '<div class="col-md-4">';
					echo '<input id="scID" type="hidden" value="'.$scResult['scID'].'">';
					echo '<h4> Name: </h4>';
					echo '<h4> <strong id="SCName">'.$scResult['scNameCompany'].'</strong></h4>';
					echo '<h4> Contact No: </h4>';
					echo '<h4> <strong id="SCPhone">'.$scResult['scContactNo'].'</strong> </h4>';
					echo '<h4> Credit Limit: </h4>';
					echo '<h4> <strong id="SCLimit">'.$scResult['scLimit'].'</strong> </h4>';
					echo '</div>';
					echo '<div class="col-md-4">';
					echo '<h5> Father/Contact Person: </h5>';
					echo '<h5> <strong id="SCFather">'.$scResult['scFatherContactPerson'].'</strong></h5>';
					echo '<h5> Address: </h5>';
					echo '<h5> <strong id="SCAddress">'.$scResult['scAddress'].'</strong></h5>';
					echo '<h5> Registration Date: </h5>';
					echo '<h5> <strong>'.$scResult['scDate'].'</strong> </h5>';
					echo '</div>';
				}
				else{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0]=='getInvoices')
			{
				if($_POST['submit'] == "true")
				{
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getSCInvoiceInfo($reqData[1]);
				$finalOutput = array();
				while ($row = $result->fetch_assoc()){
					$UserFullName = $dashModel->getUserFullName($row['userID']);
					$UserFullName = $UserFullName->fetch_assoc();
					$paymentInfo = $dashModel->getTotalPaidIndividualInvoice($row['invoiceID']);
					$paymentInfo = $paymentInfo->fetch_assoc();
					$newArray = array(
							'invoiceID'      	=> $row['invoiceID'],
							'invoiceDate'    	=> $row['invoiceDate'],
							'invoiceTime'   	=> $row['invoiceTime'],
							'invoiceAmount'		=> number_format(($row['invoiceAmount']-$row['invoiceDiscount']),2, '.', ''),
							'invoicePaid'			=> number_format($paymentInfo['paidTotal'],2, '.', ''),
							'invoiceStatus'   => $row['invoiceStatus'],
							'invoiceAgentName'=> $UserFullName['name']
						);
					$finalOutput[] = $newArray;
				}
				$data['data']['invoiceInfo'] = $finalOutput;
				echo "<table class=\"table\" id=\"invoiceList\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Invoice ID</th>";
        echo "<th> Invoice Date </th>";
        echo "<th> Invoice Time </th>";
        echo "<th> Invoice Total </th>";
        echo "<th> Paid Total  </th>";
        echo "<th> Stuff Name </th>";
        echo "<th> Status </th>";
        echo "<th> View </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
                foreach($data['data']['invoiceInfo'] as $invRow)
                {
									$invoiceDate = date("d/m/Y", strtotime($invRow['invoiceDate']));
									$invoiceTime = date("h:i:s A", strtotime($invRow['invoiceTime']));
									$payNow = "payNow(".$invRow['invoiceID'].",'".$invoiceDate."','".$invoiceTime."','".$invRow['invoiceAmount']."','".$invRow['invoicePaid']."')";
                  $invStatus = 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#payNow"> <i class="glyphicon glyphicon-warning-sign"> </i> Pay Now </button>';
                  $invStatus = '<button onclick="'.$payNow.'" '.$invStatus;
									if($invRow['invoicePaid'] == 0 && $invRow['invoiceAmount'] > 0)
                  {
                    echo "<tr class=\"ebmDanger\">";
                  }
                  else if($invRow['invoicePaid'] > 0 && $invRow['invoicePaid'] < $invRow['invoiceAmount'] && $invRow['invoiceAmount'] > 0 )
                  {
                    echo "<tr class=\"ebmWarning\">";
                  }
                  else
                  {
                    echo "<tr class=\"ebmSuccess\">";
                    $invStatus = '<span class="label label-success"> <i class="glyphicon glyphicon-ok"> </i> Paid </span>';
                  }
									
                  echo "<td class=\"invoiceID\">".$invRow['invoiceID']."</td>";
                  echo "<td class=\"invoiceDate\">".date("d/m/Y", strtotime($invRow['invoiceDate']))."</td>";
                  echo "<td class=\"invoiceTime\">".date("h:i:s A", strtotime($invRow['invoiceTime']))."</td>";
                  echo "<td class=\"invoiceAmount\">".$invRow['invoiceAmount']."</td>";
                  echo "<td class=\"invoicePaid\">".$invRow['invoicePaid']."</td>";
                  echo "<td>".$invRow['invoiceAgentName']."</td>";
                  if($invRow['invoicePaid'] == 0 && $invRow['invoiceAmount'] > 0)
                  {
                    
                  }
									//echo '<td><button onclick="asif(4)" '.$invStatus;
                  //echo '<td><button onclick="payNow("'.$invRow['invoiceID'].'") '.$invStatus."</td>";
                  
                  echo "<td>".$invStatus."</td>";
									echo "<td><a class=\"btn btn-xs btn-primary\" href=\"".BASE_URL."admin/invoice/".$invRow['invoiceID']."\"> <i class=\"glyphicon glyphicon-eye-open\"></i> View </a></td>";
                  echo "</tr>";
                }
              
            echo "</tbody>";
            echo "</table>";
				echo "<script></script>";
				}
				else{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0] == 'getBalance')
			{
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$scLimit = $dashModel->getSCInfo($_POST['scID'])->fetch_assoc()['scLimit'];
				$scLimit*=(-1);
				$invT = $dashModel->getTotalInvoiceSC($_POST['scID'])->fetch_assoc()['invoiceTotal'];
				$paidT = $dashModel->getTotalPaidSC($_POST['scID'])->fetch_assoc()['paidTotal'];
				$b = $paidT - $invT;
				if($b>=0)
				{
					$scLimit = '<h4 class="edit"> <i class="glyphicon glyphicon-ok"></i> Healthy Profile </h4>';
				}
				else if($b<0 && $b>($scLimit/2))
				{
					$scLimit = '<h4 class="text-warning"> <i class="glyphicon glyphicon-info-sign"></i> Due Balance </h4>';
				}
				else if($b<=($scLimit/2) && $b>(3*($scLimit/4)))
				{
					$scLimit = '<h4 class="text-warning"> <i class="glyphicon glyphicon-warning-sign"></i> 50% Limit Exceeded!!! </h4>';
				}
				else if($b<=(3*($scLimit/4)) && $b>$scLimit)
				{
					$scLimit = '<h4 class="delete"> <i class="glyphicon glyphicon-warning-sign"></i> 75% Limit Exceeded!!! </h4>';
				}
				else
				{
					$scLimit = '<h4 class="delete"><strong> <i class="glyphicon glyphicon-remove"></i> 100% Limit Exceeded!!! </strong></h4>';
				}
				/*
				if($b<$scLimit)
				{
					$scLimit = '<h4 class="delete"> <i class="glyphicon glyphicon-remove"></i> 100% Limit Exceeded!!! </h4>';
				}
				else if($b<0)
				{
					$scLimit = '<h4 class="text-warning"> <i class="glyphicon glyphicon-info-sign"></i> Due Balance </h4>';
				}
				else if($b<($scLimit/2))
				{
					$scLimit = '<h4 class="text-warning"> <i class="glyphicon glyphicon-warning-sign"></i> 50% Limit Exceeded!!! </h4>';
				}
				else if($b<(3*($scLimit/4)))
				{
					$scLimit = '<h4 class="delete"> <i class="glyphicon glyphicon-warning-sign"></i> 75% Limit Exceeded!!! </h4>';
				}
				else
				{
					$scLimit = '<h4 class="edit"> <i class="glyphicon glyphicon-ok"></i> Healthy Profile </h4>';
				}
				*/
				
				if($b>0)
				{
					echo "<strong id=\"profileBalance\"><h1 class=\"edit\" id=\"mainBalance\">".number_format(($paidT - $invT),2, '.', '')."</h1></strong><button onclick=\"setBalance()\" class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#depositNow\"> Make a Deposit </button> <button onclick=\"setBalance()\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#withdrawNow\"> Withdraw Balance </button> <br>".$scLimit;
				}
				else
				{
					echo "<strong id=\"profileBalance\"><h1 class=\"delete\" id=\"mainBalance\">".number_format(($paidT - $invT),2, '.', '')."</h1></strong><button onclick=\"setBalance()\" class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#depositNow\"> Make a Deposit </button> <br>".$scLimit;
				}
			}
			else if($reqData[0] == 'getTransactions')
			{
				if($_POST['submit'] == "true")
				{
					$this->load->model('adminModel');
					$dashModel = new adminModel();
					$result = $dashModel->getSCTransaction($reqData[1]);
					$finalTrx = array();
					while($row = $result->fetch_assoc())
					{
						$UserFullName = $dashModel->getUserFullName($row['userID']);
						$UserFullName = $UserFullName->fetch_assoc();
						$newArray = array(
								'trxID'      	=> $row['trxID'],
								'trxDate'    	=> $row['trxDate'],
								'trxTime'   	=> $row['trxTime'],
								'trxAmount'		=> number_format($row['trxAmount'],2, '.', ''),
								'trxUser'   	=> $UserFullName['name'],
								'trxInfo'			=> $row['trxInfo']
							);
						$newArray['trxRef'] = "";
						if($row['trxType'] == 'invoice')
						{
							$newArray['trxType'] = "<a href=\"".BASE_URL."admin/invoice/".$row['trxReference']."\">Invoice #";
							$newArray['trxRef']  = $row['trxReference']."</a>";
						}
						else if($row['trxType'] == 'deposit' && $row['trxAmount']>=0){
							$newArray['trxType'] = "Cash Deposit";
						}
						else{
							$newArray['trxType'] = "Cash Withdraw";
						}
						$finalTrx[] = $newArray;
					}
					$data['data']['transaction'] = $finalTrx;
					echo "<table class=\"table table-bordered table-hover\" id=\"transactionList\">";
           echo "<thead>";
             echo "<tr>";
               echo "<th> Transaction ID</th>";
               echo "<th> Transaction Date </th>";
               echo "<th> Transaction Time </th>";
               echo "<th> Transaction Type </th>";
               echo "<th> Amount  </th>";
               echo "<th> Stuff Name </th>";
               echo "<th> Information </th>";
             echo "</tr>";
           echo "</thead>";
           echo "<tbody>";
                foreach($data['data']['transaction'] as $trxRow)
                {
                  echo "<tr>";                 
                  echo "<td>".$trxRow['trxID']."</td>";
                  echo "<td>".date("d/m/Y", strtotime($trxRow['trxDate']))."</td>";
                  echo "<td>".date("h:i:s A", strtotime($trxRow['trxTime']))."</td>";
                  echo "<td>".$trxRow['trxType'].$trxRow['trxRef']."</td>";
                  echo "<td>".$trxRow['trxAmount']."</td>";
                  echo "<td>".$trxRow['trxUser']."</td>";
                  echo "<td>".$trxRow['trxInfo']."</td>";
                  echo "</tr>";
                }
              
           echo "</tbody>";
         echo "</table>";
				}
				else
				{
					$this->load->redirectIn();
				}
			}
			else if($reqData[0] == 'addAdvance')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['scID']!='' && $_POST['cashID']!='' && $_POST['payment']!='')
					{
						$scID = Validation::verify($_POST['scID']);
						$cashID = Validation::verify($_POST['cashID']);
						$payment = Validation::verify($_POST['payment']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						//Game Starts Here..
						$cashBalance = $dashModel->getCashAccountBalance($cashID)->fetch_assoc();
						$cashBalance = $cashBalance['balance'];
						if($cashBalance>=$payment){
							$r1 = $dashModel->addCash($cashID, ($payment*(-1)),  "Payment For Invoice ID ".$invID);
							$paymentInfo = $dashModel->addDeposit($scID, $payment, $_POST['note']);
							if($paymentInfo && $r1)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						}else{
							echo "empty";
						}
				}else
				{
					$this->load->redirectIn();
				}
			}
				
			else if($reqData[0] == 'withdrawBalance')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['scID']!='' && $_POST['wAmount']!='')
					{
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$scID = Validation::verify($_POST['scID']);
						$wAmount = (float)Validation::verify($_POST['wAmount']);
						$note = Validation::verify($_POST['note']);
						$invT = $dashModel->getTotalInvoiceSC($_POST['scID'])->fetch_assoc()['invoiceTotal'];
						$paidT = $dashModel->getTotalPaidSC($_POST['scID'])->fetch_assoc()['paidTotal'];
						$b = $paidT - $invT;
						if($_POST['wAmount'] <= $b ){
							$paymentInfo = $dashModel->addWithdraw($scID, $wAmount, $note);
							$r1 = $dashModel->addCash(1, $wAmount,  "Add Cash From Supplier Withdraw");
							if($paymentInfo)
							{
									echo "true";
							}
							else
							{
								echo "false";
							}
						}
					}else{
						echo "empty";
					}
				}else
				{
					$this->load->redirectIn();
				}
			}
			
			else
			{
				
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$scInfo = $dashModel->getSCInfo($reqData[0]);
				$scResult = $scInfo->fetch_assoc();
				$invT = $dashModel->getTotalInvoiceSC($reqData[0])->fetch_assoc()['invoiceTotal'];
				$paidT = $dashModel->getTotalPaidSC($reqData[0])->fetch_assoc()['paidTotal'];
				$data = array(
				'title'=> $scResult['scNameCompany'].' | আমার Manager'
				);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminProfile.js'
							);
				$data['data']['sc'] = $scResult;
				$data['data']['type'] = "Supplier";

				
				
				
				$data['data']['balance'] = number_format(($paidT - $invT),2, '.', '');
				
				$cash = $dashModel->getAllCashAccounts();
				$finalCash = array();
				while($key = $cash->fetch_assoc()) {
					$cashID = $key['accountID'];
					$balance = $dashModel->getCashAccountBalance($cashID)->fetch_assoc();
					$balance = $balance['balance'];
					$cashArray = array(
							'cashID' => $cashID,
							'cashName' => $key['accountName'],
							'balance' => $balance
						);
					array_push($finalCash, $cashArray);
				}
				$data['data']['cash'] = $finalCash;
				$this->load->view('admin/profile', $data);
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		}
	}

	public function purchase(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null)
		{
			$select2Lang = 'select2/js/lang/'.$_SESSION['data']['language'].'.js';
			$data = array(
					'title'=> 'Purchase Entry | আমার Manager'
					);
			$data['css'] = array('select2/css/select2.min.css',
								 'dataTables/css/dataTables.bootstrap.min.css',
							 	 'dataTables/css/dataTables.responsive.css'
							);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
								'dataTables/js/dataTables.bootstrap.min.js',
								'dataTables/js/dataTables.responsive.js',
								'select2/js/select2.min.js',
								$select2Lang,
								'js/float-panel.js',
								'js/page/adminPurchase.js'
						);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getSupplier();
			
			
				
	
				$finalSupplier = array();
				while($key = $result->fetch_assoc()) {
					
					$scID = $key['scID'];
					$scName = $key['scNameCompany'];
					$invT = $dashModel->getTotalInvoiceSC($scID)->fetch_assoc()['invoiceTotal'];
					$paidT = $dashModel->getTotalPaidSC($scID)->fetch_assoc()['paidTotal'];
					$balance = $paidT - $invT;
					if($balance == NULL){
						$balance = 0.00;
					}
					$supplierArray = array(
							'scID' => $scID,
							'scNameCompany' => $scName,
							'scContactNo' => $key['scContactNo'],
							'balance' => $balance
						);
					array_push($finalSupplier, $supplierArray);
				}
				
			
			
			
			
				$data['data']['supplier'] = $finalSupplier;


				$stock = array();
				$product = array();
				$purchase = array();
				$productResult = $dashModel->getProducts();
				while($row = $productResult->fetch_assoc()){
					$result = $dashModel->getStockInfo($row['productID']);
					if($result->fetch_assoc()){
						array_push($stock, $row['productID']);
					}else{
						array_push($product, $row['productID']);
					}
				}

				foreach ($product as $key) {
					$productID = $key;
					
					$productInfo = $dashModel->getProductInfo($key);
					$productInfo = $productInfo->fetch_assoc();
					
					$productName = $productInfo['productName'];
					$productLimit = $productInfo['productLimit'];
					
					$productCategoryID = $productInfo['productCategoryID'];
					
					$productCategoryInfo = $dashModel->getProductCategoryInfo($productCategoryID);
					$productCategoryInfo = $productCategoryInfo->fetch_assoc();
					
					$productCategoryName = $productCategoryInfo['categoryName'];
					$productCategoryUnit = $productCategoryInfo['categoryUnit'];

					$productArray = array(
							'pID'          => $productID,
							'pName'  	   => $productName,
							'pCategory'    => $productCategoryName.' ('.$productCategoryUnit.')',
							'pLimit'       => $productLimit,
							'pQuantity'    => 0,
							'purchaseUnit' => 0.0,
							'saleUnit'     => 0.0,
							'pBatch'	   => ''
						);
					array_push($purchase, $productArray);
				}

					foreach ($stock as $key) {
					$productID = $key;
					$productInfo = $dashModel->getProductInfo($key);
					$productInfo = $productInfo->fetch_assoc();

					$productName = $productInfo['productName'];
					$productLimit = $productInfo['productLimit'];
					
					$productCategoryID = $productInfo['productCategoryID'];
					
					$productCategoryInfo = $dashModel->getProductCategoryInfo($productCategoryID);
					$productCategoryInfo = $productCategoryInfo->fetch_assoc();
					
					$productCategoryName = $productCategoryInfo['categoryName'];
					$productCategoryUnit = $productCategoryInfo['categoryUnit'];
					$stockInfo = $dashModel->getStockInfo($key);
					while($row = $stockInfo->fetch_assoc()){
						$productArray = array(
								'pID'          => $productID,
								'pName'  	   => $productName,
								'pCategory'    => $productCategoryName.' ('.$productCategoryUnit.')',
								'pLimit'       => $productLimit,
								'pQuantity'    => $row['quantity'],
								'purchaseUnit' => $row['purchaseUnit'],
								'saleUnit'     => $row['saleUnit'],
								'pBatch'	   => $row['batch'],
								'barcode' => $row['barcode']
							);
						array_push($purchase, $productArray);
					}
				}
				$data['data']['purchase'] = $purchase;

				$cash = $dashModel->getAllCashAccounts();
				$finalCash = array();
				while($key = $cash->fetch_assoc()) {
					$cashID = $key['accountID'];
					$balance = $dashModel->getCashAccountBalance($cashID)->fetch_assoc();
					$balance = $balance['balance'];
					$cashArray = array(
							'cashID' => $cashID,
							'cashName' => $key['accountName'],
							'balance' => $balance
						);
					array_push($finalCash, $cashArray);
				}
				$data['data']['cash'] = $finalCash;
				$this->load->view('admin/purchase', $data);

		}else{
			$reqData = func_get_arg(0);			
			//Final Purchase Invoice	
			if($reqData[0]=='final'){
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$cashArray = array();
				$pq = count($_POST['pID']);
				
				//Main Variables Here
				$invoiceTotal1 = 0.0;
				$finalCheck = true;
				$payFromSupplierBalance = 0;
				$paymentTotal = 0;
				
				//Building Product Array
				$productListArray = array();
				for($i = 0; $i<$pq; $i++){
					$quantity = (float)Validation::verify($_POST['quantity'][$i]);
					$purchaseRate = (float)Validation::verify($_POST['purchaseRate'][$i]);
					$retailRate = (float)Validation::verify($_POST['retailRate'][$i]);
					if($quantity<0 || $purchaseRate<0 || $retailRate<0){
						$finalCheck = false;
						break;
					}
					$proID = Validation::verify($_POST['pID'][$i]);
					$productInfo = $dashModel->getProductInfo($proID);
					$productInfo = $productInfo->fetch_assoc();
					$categoryInfo = $dashModel->getProductCategoryInfo($productInfo['productCategoryID']);
					$categoryInfo = $categoryInfo->fetch_assoc();
					$productInfoArray = array(
						'productID' => $proID,
						'productName' => $productInfo['productName'],
						'categoryID' => $productInfo['productCategoryID'],
						'categoryName' => $categoryInfo['categoryName'],
						'categoryUnit' => $categoryInfo['categoryUnit'],
						'batch' => Validation::verify($_POST['batch'][$i]),
						'quantity' => $quantity,
						'purchaseRate' => $purchaseRate,
						'retailRate' => $retailRate
					);
					$invoiceTotal1+=$productInfoArray['quantity']*$productInfoArray['purchaseRate'];
					array_push($productListArray, $productInfoArray);
				}
				
				$scID = (int)Validation::verify($_POST['supplierID']);
				$invT = $dashModel->getTotalInvoiceSC($scID)->fetch_assoc()['invoiceTotal'];
				$paidT = $dashModel->getTotalPaidSC($scID)->fetch_assoc()['paidTotal'];
				$b = $paidT - $invT;
		
				if($b>0){
					if($b<=$invoiceTotal1){
						$payFromSupplierBalance = $b;
					}else{
						$payFromSupplierBalance = $invoiceTotal1;
					}
				}
				if(count($_POST['cashID'])==count($_POST['cashAmount'])){
					$cashCount = count($_POST['cashID']);
					for($i = 0; $i<$cashCount; $i++){
						$cashIDPurchase = Validation::verify($_POST['cashID'][$i]);
						$cashAmountPurchase = Validation::verify($_POST['cashAmount'][$i]);
						$balance = $dashModel->getCashAccountBalance($cashIDPurchase)->fetch_assoc();
						$balance = $balance['balance'];
						if($cashAmountPurchase>$balance){
						$finalCheck = false;
						break;
						}else{
							$paymentTotal+= (float)$cashAmountPurchase;
							$cashTemp = array(
								'cashID' => (int)$cashIDPurchase,
								'balance' => (float)$balance,
								'pay' => (float)$cashAmountPurchase
							);
							array_push($cashArray, $cashTemp);
						}
					}
				}
				
				echo "<pre>";
					var_dump($finalCheck);
					echo "</pre>";
				if($finalCheck){
					echo "Asif Malik";
					echo "<pre>";
					print_r($cashArray);
					echo "</pre>";
					$status = '';
					$gt = $invoiceTotal1;
					$pt = $paymentTotal;
					if($pt<=0 && $gt>$pt){
						$status = 'unpaid';
					}
					elseif($pt!=0 && $gt>$pt){
						$status = 'partial';
					}
					else{
						$status = 'paid';
					}
					$invoiceNote = Validation::verify($_POST['invoiceNote']);
					$dashModel->addInvoiceInfo($scID,$invoiceTotal1,0.0,$status,'purchase',$invoiceNote);
					$invoiceID = $dashModel->getLastInvoiceID($_SESSION['data']['userID'], $scID, $invoiceTotal1, $status);
					$invoiceID = $invoiceID->fetch_assoc()['invoiceID'];
					
					$cashNote = "Payment For Invoice ID ".$invoiceID;
					echo "<pre>";
					print_r($cashArray);
					echo "</pre>";
					foreach($cashArray as $c) {
						if($c['pay']>0){
							$dashModel->addCash($c['cashID'], ($c['pay']*(-1)), $cashNote);
							echo "Cash ID:".$c['cashID']." Payment:".$c['pay'];
						}
					}
					
					if($payFromSupplierBalance>0){
						$dashModel->addWithdraw($scID, $payFromSupplierBalance, "Withdraw For Payment Invoice ID:".$invoiceID);
					}
					
					if($paymentTotal>0){
						$dashModel->addInvoiceTrx($invoiceID, $paymentTotal, $scID);
					}
					
					foreach($productListArray as $p) { 
						if($p['batch']=='New'){
							$newBatch = $dashModel->getLastBatch($p['productID']);
							$newBatch = 1+(int)($newBatch->fetch_assoc()['batch']);
							$p['batch'] = $newBatch;
							$barcode = "P".$p['productID']."B".$newBatch;
							$dashModel->addNewBatchToStock($p['productID'], $p['quantity'], $p['purchaseRate'], $p['retailRate'], $newBatch, $barcode);
						}else{
							$quantityStock = $dashModel->getQuantityExistingBatch($p['productID'], $p['batch']);
							$quantityStock = $quantityStock->fetch_assoc();
							$quantityStock = (float)($quantityStock['quantity']) + (float)$p['quantity'];
							echo "New Quantity: ".$quantityStock;
							$dashModel->updateQuantityExistingBatch($p['productID'], $p['batch'], $quantityStock);
						}
						$dashModel->addProductToInvoice($invoiceID, $p['productID'], $p['quantity'], $p['batch'], $p['purchaseRate'], $p['retailRate'], $p['productName'], $p['categoryID'], $p['categoryName'], $p['categoryUnit']);
						//addProductToInvoice($invID, $pID, $quantity, $batch, $purchaseUnit, $saleUnit, $pName, $cCatID, $pCatName, $pCatUnit)
					}
					$this->load->redirectIn('admin/invoice/'.$invoiceID);
				}else{
					echo "An error occured!!!";
				}
			}
			
			if($reqData[0]=='data1'){
				echo "<pre>";
				print_r($_POST);
				echo "</pre>";
			}
			
		}
	}

	public function sale(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null)
		{
			$select2Lang = 'select2/js/lang/'.$_SESSION['data']['language'].'.js';
			$data = array(
					'title'=> 'Sale Entry | আমার Manager'
					);
			$data['css'] = array('select2/css/select2.min.css',
								 'dataTables/css/dataTables.bootstrap.min.css',
							 	 'dataTables/css/dataTables.responsive.css',
									'css/toastr.min.css'
							);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
								'dataTables/js/dataTables.bootstrap.min.js',
								'dataTables/js/dataTables.responsive.js',
								'select2/js/select2.min.js',
								$select2Lang,
								'js/float-panel.js',
								'js/page/adminSale.js',
								'js/toastr.min.js'
						);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getCustomer();

	
				$finalCustomer = array();
				while($key = $result->fetch_assoc()) {
					
					$scID = $key['scID'];
					$scName = $key['scNameCompany'];
					$invT = $dashModel->getTotalInvoiceSC($scID)->fetch_assoc()['invoiceTotal'];
					$paidT = $dashModel->getTotalPaidSC($scID)->fetch_assoc()['paidTotal'];
					$balance = $paidT - $invT;
					if($balance == NULL){
						$balance = 0.00;
					}
					$customerArray = array(
							'scID' => $scID,
							'scNameCompany' => $scName,
							'scContactNo' => $key['scContactNo'],
							'balance' => $balance
						);
					array_push($finalCustomer, $customerArray);
				}
				
					$data['data']['customer'] = $finalCustomer;
				/*$stock = array();
				$product = array();
				$purchase = array();
				$productResult = $dashModel->getProducts();
				while($row = $productResult->fetch_assoc()){
					$result = $dashModel->getStockInfo($row['productID']);
					if($result->fetch_assoc()){
						array_push($stock, $row['productID']);
					}else{
						array_push($product, $row['productID']);
					}
				}

				foreach ($product as $key) {
					$productID = $key;
					
					$productInfo = $dashModel->getProductInfo($key);
					$productInfo = $productInfo->fetch_assoc();
					
					$productName = $productInfo['productName'];
					$productLimit = $productInfo['productLimit'];
					
					$productCategoryID = $productInfo['productCategoryID'];
					
					$productCategoryInfo = $dashModel->getProductCategoryInfo($productCategoryID);
					$productCategoryInfo = $productCategoryInfo->fetch_assoc();
					
					$productCategoryName = $productCategoryInfo['categoryName'];
					$productCategoryUnit = $productCategoryInfo['categoryUnit'];

					$productArray = array(
							'pID'          => $productID,
							'pName'  	   => $productName,
							'pCategory'    => $productCategoryName.' ('.$productCategoryUnit.')',
							'pLimit'       => $productLimit,
							'pQuantity'    => 0,
							'purchaseUnit' => 0.0,
							'saleUnit'     => 0.0,
							'pBatch'	   => ''
						);
					array_push($purchase, $productArray);
				}

					foreach ($stock as $key) {
					$productID = $key;
					$productInfo = $dashModel->getProductInfo($key);
					$productInfo = $productInfo->fetch_assoc();

					$productName = $productInfo['productName'];
					$productLimit = $productInfo['productLimit'];
					
					$productCategoryID = $productInfo['productCategoryID'];
					
					$productCategoryInfo = $dashModel->getProductCategoryInfo($productCategoryID);
					$productCategoryInfo = $productCategoryInfo->fetch_assoc();
					
					$productCategoryName = $productCategoryInfo['categoryName'];
					$productCategoryUnit = $productCategoryInfo['categoryUnit'];
					$stockInfo = $dashModel->getStockInfo($key);
					while($row = $stockInfo->fetch_assoc()){
						$productArray = array(
								'pID'          => $productID,
								'pName'  	   => $productName,
								'pCategory'    => $productCategoryName.' ('.$productCategoryUnit.')',
								'pLimit'       => $productLimit,
								'pQuantity'    => $row['quantity'],
								'purchaseUnit' => $row['purchaseUnit'],
								'saleUnit'     => $row['saleUnit'],
								'pBatch'	   => $row['batch']
							);
						array_push($purchase, $productArray);
					}
				}
				$data['data']['purchase'] = $purchase;

				$cash = $dashModel->getAllCashAccounts();
				$finalCash = array();
				while($key = $cash->fetch_assoc()) {
					$cashID = $key['accountID'];
					$balance = $dashModel->getCashAccountBalance($cashID)->fetch_assoc();
					$balance = $balance['balance'];
					$cashArray = array(
							'cashID' => $cashID,
							'cashName' => $key['accountName'],
							'balance' => $balance
						);
					array_push($finalCash, $cashArray);
				}
				$data['data']['cash'] = $finalCash;*/
				$purchase = $dashModel->getStock();
				$data['data']['product'] = $purchase;
				$cash = $dashModel->getAllCashAccounts();
				$data['data']['cash'] = $cash;
				$this->load->view('admin/sale', $data);

		}else{
			$reqData = func_get_arg(0);

			if($reqData[0]=='add')
			{
				$pq = 0;
				$productList = array();
				$customerID = Validation::verify($_POST['customerID']);
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$invT = $dashModel->getTotalInvoiceSC($customerID)->fetch_assoc()['invoiceTotal'];
				$paidT = $dashModel->getTotalPaidSC($customerID)->fetch_assoc()['paidTotal'];
				$balance = $paidT - $invT;
				$payFromBalance = Validation::verify($_POST['payFromBalanceInput']);
				$grandTotal = 0.0;
				$firstCheck = '';
				$thirdCheck = '';
				if(($payFromBalance<=$balance && $balance>0)||($payFromBalance==0 && $balance<=0)){
					$firstCheck = true;
				}else{
					$firstCheck = false;
				}
				$secondCheck = '';
				if($firstCheck)
				{
					$pq = count($_POST['pID']);
					for ($i=0; $i < $pq; $i++) 
					{ 
						//ProductID
					$productID = Validation::verify($_POST['pID'][$i]);
							//Invoice Quantity
					$productInvoiceQuantity = Validation::verify($_POST['quantity'][$i]);
							//Product Batch
					$productBatch = Validation::verify($_POST['batch'][$i]);
					$productStockResult = $dashModel->getStockInfoWithBatch($productID, $productBatch);
					$productStockResult = $productStockResult->fetch_assoc();
					$productStockQuantity = $productStockResult['quantity'];
					$productPurchaseUnit = $productStockResult['purchaseUnit'];
						//Product Quantity Checker
					if($productInvoiceQuantity>$productStockQuantity){
						$secondCheck = false;
						break;
					}else{
						$secondCheck = true;
					}
						
					$result = $dashModel->getProductInfo($productID);
					$result = $result->fetch_assoc();
						//Name
					$productName = $result['productName'];
						//CategoryID
					$productCategoryID = $result['productCategoryID'];
					$result = $dashModel->getProductCategoryInfo($productCategoryID);
					$result = $result->fetch_assoc();
						//CategoryName
					$productCategoryName = $result['categoryName'];
						//CategoryUnit
					$productCategoryUnit = $result['categoryUnit'];
						//Sale Unit Price
					$productSaleUnit = Validation::verify($_POST['saleRate'][$i]);
						$grandTotal += ($productInvoiceQuantity*$productSaleUnit);
						$productArray = array(
							'productID' => $productID,
							'productName' => $productName,
							'productQuantity' => $productInvoiceQuantity,
							'productStock' => $productStockQuantity,
							'productBatch' => $productBatch,
							'purchaseUnit' => $productPurchaseUnit,
							'saleUnit' => $productSaleUnit,
							'categoryID' => $productCategoryID,
							'categoryName' => $productCategoryName,
							'categoryUnit' => $productCategoryUnit
						);
						array_push($productList, $productArray);
					}
				}
				// Start From Here, We can get all product List
				$diff = Validation::verify($_POST['grandTotal']) - $grandTotal;
				if($diff>=-0.01 && $diff<=0.01)
				{
					$thirdCheck = true;
				}
				$discount = floatval(Validation::verify($_POST['discount']));
				var_dump($discount);
				$grandTotal = Validation::verify($_POST['grandTotal']);
				$invoiceNote = Validation::verify($_POST['invoiceNote']);
				$grandTotalFinal = $grandTotal - $discount;
				$paymentTotal = Validation::verify($_POST['paymentTotal'])+$payFromBalance;
				if($grandTotalFinal<$paymentTotal){
					$paymentTotal = $grandTotalFinal;
				}
				
				$status = '';
				
				
				if($paymentTotal==0 && $grandTotalFinal>$paymentTotal){
					$status = 'unpaid';
				}
				elseif($pt!=0 && $gt>$pt){
					$status = 'partial';
				}
				else{
					$status = 'paid';
				}
				
				var_dump($firstCheck);
				var_dump($secondCheck);
				var_dump($thirdCheck);

				//Last Step
				if($firstCheck && $secondCheck && $thirdCheck){
					
					$invInf = $dashModel->addInvoiceInfo($customerID,$grandTotal,$discount,$status,'sale',$invoiceNote);
					$invoiceID = $dashModel->getLastInvoiceID($_SESSION['data']['userID'], $customerID, $grandTotal,$status);
					$invoiceID = $invoiceID->fetch_assoc()['invoiceID'];
					if($payFromBalance>0){
						$note = "Invoice: ".$invoiceID.". Withdraw Balance For Payment".
						$paymentInfo = $dashModel->addWithdraw($customerID,$payFromBalance, $note);
					}
					if($paymentTotal>0){
						$test = $dashModel->addInvoiceTrx($invoiceID, $paymentTotal, $customerID);
						/*echo "<pre>Hello".$invoiceID." ".$paymentTotal." ".$customerID;
						var_dump($test->fetch_assoc());
						echo "</pre>";*/
					}
					
					$cashNote = "Invoice: ".$invoiceID.". Cash Receive";
					$dashModel->addCash($_POST['cashID'], $paymentTotal, $cashNote);
					for ($i=0; $i < $pq; $i++) { 
						$quantityStock = (float)($productList[$i]['productStock']) - (float)($productList[$i]['productQuantity']);
						$up = $dashModel->updateQuantityExistingBatch($productList[$i]['productID'], $productList[$i]['productBatch'],$quantityStock);
						$dashModel->addProductToInvoice($invoiceID, $productList[$i]['productID'],(float)$productList[$i]['productQuantity'], $productList[$i]['productBatch'], $productList[$i]['purchaseUnit'], $productList[$i]['saleUnit'], $productList[$i]['productName'],$productList[$i]['categoryID'], $productList[$i]['categoryName'], $productList[$i]['categoryUnit']);
						//var_dump($up);
						//echo '\nBatch: '.$productList[$i]['productBatch'];
					}
					//echo $quantityStock;
					if($_POST['sms']=='on'){
						SMS::verifySMS(1,$invoiceID);
					}
					//die();
					$this->load->redirectIn('admin/invoice/'.$invoiceID);
				}
				else{
					$this->load->redirectIn('admin/sale/');
				}
				}
			}
				

		
			if($reqData[0]=='data'){
				echo "<pre>";
				print_r($_POST);
				echo "</pre>";
			}
		}

	public function invoiceReturn(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null){
			$data = array(
				'title'=> 'Invoice Return | আমার Manager'
			);
			$data['js'] = array('js/page/adminReturn.js'); 
			$this->load->view('admin/return', $data);
		}else{
			$reqData = func_get_arg(0);
			if($reqData[0]=='get'){
				if($_POST['submit']==true && $_POST['invoiceID']!=''){
					
					if(is_int((int)$_POST['invoiceID'])){
						$invoiceID = Validation::verify($_POST['invoiceID']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->getInvoiceInfo($invoiceID);
						$result = $result->fetch_assoc();
						if($result == null){
							echo "wrong";//404
						}else{
							$data = array(
								'title'=> ' Invoice# '.$reqData[0].' | আমার Manager'
							);
							$data['data']['info'] = $result;
							
							$fullUserName = $dashModel->getUserFullName($result['userID']);
							$fullUserName = $fullUserName->fetch_assoc();
							$data['data']['info']['user'] = $fullUserName['name'];
							$data['data']['invoice'] = $dashModel->getInvoiceList($invoiceID);
							//$result['invoiceType'] = ucfirst($result['invoiceType']);
							$price = 'invoice'.ucfirst($result['invoiceType']);
							//$this->load->view('admin/return', $data);
							//html code here
							global $invoiceReturn;
							echo '<form method="POST" action="'.BASE_URL."admin/invoiceReturn/submit".'">';
							echo '<h3 align="center"><u>'.$invoiceReturn[$result['invoiceType']].'</u></h3>';
							echo '<h4 align="center"><b>'.$invoiceReturn['invoice'].'# '.$result['invoiceID'].'<input type="hidden" name="returnInvoiceID" value="'.$invoiceID.'"></b></h3>';
							echo '<h4 align="center">'.date("h:i:s A", strtotime($data['data']['info']['invoiceTime'])).'    '.date("d/m/Y", strtotime($data['data']['info']['invoiceDate'])).'</h4>';
							echo '<hr>';
           		echo '<strong>'.$invoiceReturn['name'].': </strong><input type="hidden" name="scID" value="'.$result['scID'].'">'.$data['data']['info']['scNameCompany'].'<br>';
           		echo '<strong>'.$invoiceReturn['address'].': </strong>'.$data['data']['info']['scAddress'].'<br>';
           		echo '<strong>'.$invoiceReturn['phone'].': </strong>'.$data['data']['info']['scContactNo'].'<br>';
							echo '<strong>'.$invoiceReturn['preparedBy'].': </strong>'.$data['data']['info']['user'].'<br>';
							
							echo '<div class="row">';
                
                echo '<table class="table table-striped">';
                    echo '<thead>';
                       echo '<tr>';
                           echo ' <th>'.$invoiceReturn['serial'].'</th>';
                            echo '<th>'.$invoiceReturn['productName'].'</th>';
                            echo '<th>'.$invoiceReturn['previousQuantity'].'</th>';
                            echo '<th>'.$invoiceReturn['unitPrice'].'</th>';
                            echo '<th>'.$invoiceReturn['newQuantity'].'</th>';
                        echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                        
                            $i = 1;
                            while ($row = $data['data']['invoice']->fetch_assoc())
                            {
                                $total = number_format(($row['invoiceQuantity'] * $row[$price]), 2, '.', '');
                                echo "<tr>";
                                echo "<td>".$i."</td>";
                                echo "<td><input type='hidden' name='newPID[]' value='".$row['productID']."'>".$row['invoiceProductName']."</td>";
                                echo "<td>".$row['invoiceQuantity']." ".$row['invoiceProductCategoryUnit']."</td>";
                                echo "<td><input type='hidden' name='newBatch[]' value='".$row['invoiceBatch']."'>".$row[$price]."</td>";
                                echo "<td><input name='newQty[]' type='number' min='0' step='0.01' max='".$row['invoiceQuantity']."' value='".$row['invoiceQuantity']."'</td>";

                                echo "</tr>";    
                                $i++;
                            }
                       

                    echo '</tbody>';
               echo '</table>';
							  echo '<div class="form-group"><label for="discount">'.$invoiceReturn['discountAmount'].'</label><input type="number" name="discount" id="discount" placeholder="Enter Discount Amount" value="'.$result['invoiceDiscount'].'"></div>';
            echo '</div>';
							echo '<input class="btn btn-primary" type="submit" value="'.$invoiceReturn['submit'].'"></form>';
							//html code end
						}
					}else{
						echo "invalid";//404
					}
				
					
					
				}
			}
			if($reqData[0]=='submit'){
				echo "<pre>";
				print_r($_POST);
				echo "</pre>";
				
				//$process is the array to store database info of selected invoice
				$process = array();
				$process['oldPID'] = array();
				$process['oldQty'] = array();
				$process['oldBatch'] = array();
				
				
				//Load Database Model
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				
				//Fetch existing database informaion of selected invoice
				$oldInvoiceData = $dashModel->getInvoiceList($_POST['returnInvoiceID']);
				$oldInvoiceData1 = $dashModel->getInvoiceList($_POST['returnInvoiceID']);
				
				$oldInvoiceInfo = $dashModel->getInvoiceInfo($_POST['returnInvoiceID'])->fetch_assoc();
				//insert old invoice data to array
				while($row = $oldInvoiceData1->fetch_assoc()){
					array_push($process['oldPID'], $row['productID']);
					array_push($process['oldQty'], $row['invoiceQuantity']);
					array_push($process['oldBatch'], $row['invoiceBatch']);
				}
				
				echo "<pre>";
				print_r($process);
				echo "</pre>";
				
				//Check Difference of existing & new data
				$productSize = array_diff($_POST['newPID'],$process['oldPID']);
				$quantitySize = array_diff($_POST['newQty'],$process['oldQty']);
				$batchSize = array_diff($_POST['newBatch'],$process['oldBatch']);
			
				echo "<pre>";
				print('Product Array: '.sizeof($productSize));
				echo "<br>";
				print('Quantity Array: '.sizeof($quantitySize));
				
				echo "</pre>";
				$validSubmit = true;
				
				
				//Check the validity of data
				for($i = 0; $i<sizeof($process['oldPID']); $i++){
					if($_POST['newPID'][$i]==$process['oldPID'][$i]){
						if(($_POST['newQty'][$i]>$process['oldQty'][$i])||($_POST['newBatch'][$i]!=$process['oldBatch'][$i])){
							$validSubmit = false;
							break;
						}
					}else{
						$validSubmit = false;
						break;
					}
				}
				
				
				//Sale Return Option
				if($oldInvoiceInfo['invoiceType']=='sale'){
					
					if($validSubmit){
					echo "Everything is OK!!! Now Return process is Started... <br>";
					for($i = 0; $i<sizeof($process['oldPID']); $i++){
						$oldInvDataList = $oldInvoiceData->fetch_assoc();
						echo $i." Loop Started <br>";
						$isStockReady = $dashModel->isStockExists($process['oldPID'][$i],$process['oldBatch'][$i])->num_rows;
						if($isStockReady==1){
							echo $i." Stock Ready <br>";
							if($process['oldQty'][$i] !=  $_POST['newQty'][$i]){
								echo $i." Need Update <br>";
								$q = (float)$process['oldQty'][$i] - (float)$_POST['newQty'][$i];
								var_dump($q);
								
								
								//Purchase Update Required
								$executeStockUpdate = $dashModel->updateQuantityExistingBatchReturn($process['oldPID'][$i],$_POST['newBatch'][$i],$q,$oldInvoiceInfo['invoiceType']);								
								
								$executeInvoiceUpdate = $dashModel->updateProductToInvoice($_POST['returnInvoiceID'], $process['oldPID'][$i], $_POST['newBatch'][$i],$_POST['newQty'][$i]);
								if($executeStockUpdate){
									var_dump($executeStockUpdate);
									echo "Stock Updated Successfully<br>";
								}else{
									echo "Stock Updated Failed!!!<br>";
								}
								if($executeInvoiceUpdate){
									var_dump($executeInvoiceUpdate);
									echo "Invoice Updated Successfully<br>";
								}else{
									echo "Invoice Updated Failed!!!<br>";
								}

							}
							
						}
						else{
							$newStockQty = (float)$process['oldQty'][$i]-(float)$_POST['newQty'][$i];
							echo "Special ".$newStockQty;
							if($newStockQty>0){
								
								$isCategoryExists = $dashModel->isCategoryExists($oldInvDataList['invoiceProductCategoryID'])->num_rows;
								if($isCategoryExists==0){
									$addCat = $dashModel->addCategoryForce($oldInvDataList['invoiceProductCategoryID'],$oldInvDataList['invoiceProductCategoryName'], $oldInvDataList['invoiceProductCategoryUnit']);
								}

								$isProductExists = $dashModel->isProductExists($oldInvDataList['productID'])->num_rows;
								if($isProductExists==0){
									$dashModel->addProductForce($oldInvDataList['productID'], $oldInvDataList['productName'], '', $oldInvDataList['invoiceProductCategoryID'], '');
								}

								$asifMalik = $dashModel->addNewBatchToStock($oldInvDataList['productID'], $newStockQty, $oldInvDataList['invoicePurchase'],  $oldInvDataList['invoiceSale'],  $oldInvDataList['invoiceBatch']);
						
							}
							
							
						}
					}
					$dAmount = Validation::verify($_POST['discount']);
					$executeTotalUpdate = $dashModel->updateInvoiceTotalReturn($_POST['returnInvoiceID']);
						$executeTotalUpdate = $dashModel->updateInvoiceDiscount($_POST['returnInvoiceID'], $dAmount);
						$executeAdvanceUpdate = $dashModel->getExtraPaymentByInvoiceReturn($_POST['returnInvoiceID'])->fetch_assoc();
					if($executeAdvanceUpdate['extraPayment']<0){
						$dashModel->addInvoiceTrx($_POST['returnInvoiceID'], $executeAdvanceUpdate['extraPayment'], $_POST['scID']);
						$executeAdvanceUpdate['extraPayment'] *=(-1);
						$note = "Advance on Return Invoice#".$_POST['returnInvoiceID'];
						$dashModel->addDeposit( $_POST['scID'], $executeAdvanceUpdate['extraPayment'], $note);
						$executeAdvanceUpdate['extraPayment'] *=(-1);
						$note = "Return For Invoice#".$_POST['returnInvoiceID'];
						$dashModel->addCash(1,$executeAdvanceUpdate['extraPayment'], $note);
					}	
					echo "<pre>";
					print_r($executeAdvanceUpdate);
					echo "</pre>";
						$this->load->redirectIn('admin/invoice/'.$_POST['returnInvoiceID']);
					}
					else{
						echo "False";
					}
					
				}
				//Purchase Return Option
				else{
					$this->load->model('adminModel');
					$dashModel = new adminModel();
					if($validSubmit){
						$returnArray = array();
						for($i = 0; $i<sizeof($process['oldPID']); $i++){
							$pID = $process['oldPID'][$i];
							$batch = Validation::verify($_POST['newBatch'][$i]);
							$stock = $dashModel->getStockBatch($pID, $batch)->fetch_assoc()['quantity'];

							$returnTemp = array(
								'productID' => $pID,
								'stockQty' => (float)$stock, 
								'oldQty' => (float)$process['oldQty'][$i],
								'newQty' => (float)Validation::verify($_POST['newQty'][$i]),
								'batch' => $batch
							);
							array_push($returnArray, $returnTemp);
						
						
						$returnQty = (float)$process['oldQty'][$i] - (float)Validation::verify($_POST['newQty'][$i]);
						if($stock >= $returnQty){
							echo "From Execution $$$$$$$$$$$$$$$$$$-----------------".$process['oldPID'][$i]." ".$batch." ".$returnQty;
							$executeStockUpdate = $dashModel->updateQuantityExistingBatchReturn($process['oldPID'][$i],$batch,$returnQty,'purchase');
							$executeInvoiceUpdate = $dashModel->updateProductToInvoice($_POST['returnInvoiceID'], $process['oldPID'][$i], $_POST['newBatch'][$i],$_POST['newQty'][$i]);
							var_dump($executeStockUpdate);
							var_dump($executeInvoiceUpdate);
							
						}
					}
						
					
					echo "<br><h1>Asif Malik</h1></br>";
					$executeTotalUpdate = $dashModel->updateInvoiceTotalPurchaseReturn($_POST['returnInvoiceID']);
						$executeAdvanceUpdate = $dashModel->getExtraPaymentByInvoiceReturn($_POST['returnInvoiceID'])->fetch_assoc();
					if($executeAdvanceUpdate['extraPayment']<0){
						$dashModel->addInvoiceTrx($_POST['returnInvoiceID'], $executeAdvanceUpdate['extraPayment'], $_POST['scID']);
						$executeAdvanceUpdate['extraPayment'] *=(-1);
						$note = "Advance on Return Invoice#".$_POST['returnInvoiceID'];
						$dashModel->addDeposit( $_POST['scID'], $executeAdvanceUpdate['extraPayment'], $note);
						$note = "Return For Invoice#".$_POST['returnInvoiceID'];
						$dashModel->addCash(1,$executeAdvanceUpdate['extraPayment'], $note);
					}	
					$this->load->redirectIn('admin/invoice/'.$_POST['returnInvoiceID']);
					echo "<pre>";
					print_r($returnArray);
					echo "</pre>";
					/*echo "Hello, Purchase";
					for($i = 0; $i<sizeof($process['oldPID']); $i++){
						$oldInvDataList = $oldInvoiceData->fetch_assoc();
						echo "<pre>";
					print_r($oldInvDataList);
					echo "</pre>";
						$stockCurrentQty = $dashModel->isBatchEmpty($oldInvDataList['productID'], $oldInvDataList['invoiceBatch'])->fetch_assoc();
						if($stockCurrentQty['quantity']>0){
							$q = (float)$process['oldQty'][$i] - (float)$_POST['newQty'][$i];
							$executeStockUpdate = $dashModel->updateQuantityExistingBatchReturn($process['oldPID'][$i],$_POST['newBatch'][$i],$q,$oldInvoiceInfo['invoiceType']);
							$executeInvoiceUpdate = $dashModel->updateProductToInvoice($_POST['returnInvoiceID'], $process['oldPID'][$i], $_POST['newBatch'][$i],$_POST['newQty'][$i]);
						}else{
							echo "Product Currently Not in Stock";
						}
					}
					
					$executeTotalUpdate = $dashModel->updateInvoiceTotalReturn($_POST['returnInvoiceID']);
					$executeAdvanceUpdate = $dashModel->getExtraPaymentByInvoiceReturn($_POST['returnInvoiceID'])->fetch_assoc();
					if($executeAdvanceUpdate['extraPayment']<0){
						$dashModel->addInvoiceTrx($_POST['returnInvoiceID'], $executeAdvanceUpdate['extraPayment'], $_POST['scID']);
						$executeAdvanceUpdate['extraPayment'] *=(-1);
						$note = "Advance on Return Invoice#".$_POST['returnInvoiceID'];
						$dashModel->addDeposit( $_POST['scID'], $executeAdvanceUpdate['extraPayment'], $note);
					*/
					
				}
				
				
				
				}
				
				
				
			}
			
		}
				
	}

	public function cash()
	{
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null)
		{
			$data = array(
				'title'=> 'Cash Transactions | আমার Manager'
				);
			$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminCash.js'
							);
			$this->load->model('adminModel');
			$dashModel = new adminModel();
			$result = $dashModel->getCashTransaction();
			$data['data']['cash'] = $result;
			$finalOutput = array();
			
			while ($row = $result->fetch_assoc()){
				$cashAccountName = $dashModel->getCashAccountName($row['trxReference']);
				$cashAccountName = $cashAccountName->fetch_assoc();

				$UserFullName = $dashModel->getUserFullName($row['userID']);
				$UserFullName = $UserFullName->fetch_assoc();

				$newArray = array(
						'trxID'     	  	=> $row['trxID'],
						'trxDate'	     	=> $row['trxDate'],
						'trxTime'     		=> $row['trxTime'],
						'trxAmount'   		=> $row['trxAmount'],
						'cashAccountName' 	=> $cashAccountName['accountName'],
						'user'				=> $UserFullName['name'],
						'trxNote'   	    => $row['trxInfo']
					);

				$finalOutput[] = $newArray;
			}
			$data['data'] = $finalOutput;
			$this->load->view('admin/cash', $data);
		}else{
			$reqData = func_get_arg(0);

			if($reqData[0]=='accounts')
			{
				$data = array(
				'title'=> 'Cash Accounts | আমার Manager'
				);
				$data['js'] = array('js/page/adminCash.js');

				$this->load->view('admin/cashCategory', $data);
			}

			if($reqData[0]=='new')
			{
				$data = array(
				'title'=> 'Add New Cash Transaction | আমার Manager'
				);
				$data['js'] = array('js/page/adminCash.js');
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$cash = $dashModel->getAllCashAccounts();
				$finalCash = array();
				while($key = $cash->fetch_assoc()) {
					$cashID = $key['accountID'];
					$balance = $dashModel->getCashAccountBalance($cashID)->fetch_assoc();
					$balance = $balance['balance'];
					if($balance == NULL){
						$balance = 0.00;
					}
					$cashArray = array(
							'cashID' => $cashID,
							'cashName' => $key['accountName'],
							'balance' => $balance
						);
					array_push($finalCash, $cashArray);
				}
				$data['data']['cashAccounts'] = $finalCash;
				$this->load->view('admin/addCash', $data);
			}

			if($reqData[0]=='addCashAccount')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['newCashName']!='')
					{
						$cashName = Validation::verify($_POST['newCashName']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->isUniqueCashAccount($cashName);
						if(($result->num_rows)==0)
						{
							$result = $dashModel->addCashAccount($cashName);
							$result = $dashModel->addCash($cashAccount, $cashAmount, $cashNote);
							if($result)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}

			if($reqData[0]=='addCash')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['cAccount']!='' && $_POST['cAmount']!='')
					{
						$cashAccount = Validation::verify($_POST['cAccount']);
						$cashAmount  = Validation::verify($_POST['cAmount']);
						$cashNote    = Validation::verify($_POST['cNote']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->addCash($cashAccount, $cashAmount, $cashNote);
						if($result)
						{
							echo "true";
						}
						else
						{
							echo "false";
						}
					
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}

			if($reqData[0]=='get')
			{
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getAllCashAccounts();
				$i = 1;
                while($row = $result->fetch_assoc()){
										$balance = (float)$dashModel->getCashAccountBalance($row['accountID'])->fetch_assoc()['balance'];
                    echo "<tr>";
                    echo "<td>".$row['accountID']."</td>";
                    echo "<td>".$row['accountName']."</td>";
                    echo "<td>".$_SESSION['data']['businessCurrency']." ".$balance."</td>";
                    echo "</tr>";
                    $i++;
                }
			}


			if($reqData[0]=='transferCash')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['sAccount']!='' && $_POST['dAccount']!='' && $_POST['dAmount']!='')
					{
						$sourceAccount = Validation::verify($_POST['sAccount']);
						$desAccount = Validation::verify($_POST['dAccount']);
						$desAmount  = Validation::verify($_POST['dAmount']);
						$cashNote   = Validation::verify($_POST['cNote']);
						$cashNote   = "Cash Transfer: ".$cashNote; 
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$sourceBalance = $dashModel->getCashAccountBalance($sourceAccount)->fetch_assoc();
						if($sourceAccount != $desAccount && $sourceBalance['balance'] >= $desAmount)
						{
							$resultSource = $dashModel->addCash($sourceAccount, ($desAmount*(-1)), $cashNote);
							$resultDestination = $dashModel->addCash($desAccount, $desAmount, $cashNote);
							if($resultSource && $resultDestination)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "false";
						}
					
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}

		}
	}


	public function expense()
	{
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null)
		{
			$data = array(
				'title'=> 'Expenses | আমার Manager'
				);
			$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminCash.js'
							);
			$this->load->model('adminModel');
			$dashModel = new adminModel();
			$result = $dashModel->getExpense();
			$data['data']['cash'] = $result;
			$finalOutput = array();
			
			while ($row = $result->fetch_assoc()){
				$cashAccountName = $dashModel->getExpenseAccountName($row['trxReference']);
				$cashAccountName = $cashAccountName->fetch_assoc();

				$UserFullName = $dashModel->getUserFullName($row['userID']);
				$UserFullName = $UserFullName->fetch_assoc();

				$newArray = array(
						'trxID'     	  	=> $row['trxID'],
						'trxDate'	     	=> $row['trxDate'],
						'trxTime'     		=> $row['trxTime'],
						'trxAmount'   		=> $row['trxAmount'],
						'expenseAccountName' 	=> $cashAccountName['accountName'],
						'user'				=> $UserFullName['name'],
						'trxNote'   	    => $row['trxInfo']
					);

				$finalOutput[] = $newArray;
			}
			$data['data'] = $finalOutput;
			$this->load->view('admin/expense', $data);
		}else{
			$reqData = func_get_arg(0);

			if($reqData[0]=='category')
			{
				$data = array(
				'title'=> 'Expense Categories | আমার Manager'
				);
				$data['js'] = array('js/page/adminExpense.js');

				$this->load->view('admin/expenseCategory', $data);
			}

			if($reqData[0]=='new')
			{
				$data = array(
				'title'=> 'Add New Expense | আমার Manager'
				);
				$data['js'] = array('js/page/adminExpense.js');
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$cash = $dashModel->getAllCashAccounts();
				$finalCash = array();
				while($key = $cash->fetch_assoc()) {
					$cashID = $key['accountID'];
					$balance = $dashModel->getCashAccountBalance($cashID)->fetch_assoc();
					$balance = $balance['balance'];
					if($balance == NULL){
						$balance = 0.00;
					}
					$cashArray = array(
							'cashID' => $cashID,
							'cashName' => $key['accountName'],
							'balance' => $balance
						);
					array_push($finalCash, $cashArray);
				}
				$data['data']['cashAccounts'] = $finalCash;
				$expenseCat = $dashModel->getAllExpenseCategory();
				$finalExpense = array();
				while($key = $expenseCat->fetch_assoc()) {
					$cashID = $key['accountID'];
					$expenseArray = array(
							'accountID' => $cashID,
							'accountName' => $key['accountName']
						);
					array_push($finalExpense, $expenseArray);
				}
				$data['data']['expense'] = $finalExpense;
				$this->load->view('admin/addExpense', $data);
			}

			if($reqData[0]=='addExpenseCategory')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['newExpenseName']!='')
					{
						$expenseName = Validation::verify($_POST['newExpenseName']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result = $dashModel->isUniqueExpenseCategory($expenseName);
						if(($result->num_rows)==0)
						{
							$result = $dashModel->addExpenseCategory($expenseName);
							if($result)
							{
								echo "true";
							}
							else
							{
								echo "false";
							}
						}
						else
						{
							echo "duplicate";
						}
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}

			if($reqData[0]=='addExpense')
			{
				if($_POST['submit']=="true")
				{
					if($_POST['cAccount']!='' && $_POST['eAmount']!='' && $_POST['eCategory']!='')
					{
						$cashAccount = Validation::verify($_POST['cAccount']);
						$expenseAmount  = Validation::verify($_POST['eAmount']);
						$expenseCategory  = Validation::verify($_POST['eCategory']);
						$expenseNote    = Validation::verify($_POST['eNote']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$result1 = $dashModel->addCash($cashAccount, (($expenseAmount)*(-1)), $expenseNote);
						$result2 = $dashModel->addExpense($expenseCategory, $expenseAmount, $expenseNote);
						if($result1 && $result2)
						{
							echo "true";
						}
						else
						{
							echo "false";
						}
					
					}
					else
					{
						echo "empty";
					}
					
				}
				else
				{
					$this->load->redirectIn();
				}
			}

			if($reqData[0]=='get')
			{
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getAllExpenseCategory();
				$i = 1;
				while($row = $result->fetch_assoc()){
						echo "<tr>";
						echo "<td>".$row['accountID']."</td>";
						echo "<td>".$row['accountName']."</td>";
						/*
						$resultCount = $dashModel->getCategoryProductCount($row['categoryID']);
						$rowResultCount = $resultCount->fetch_assoc();
						echo "<td>".$rowResultCount['count']."</td>";
						echo "<td>
						<a href=\"#\" onclick=\"fillModifyCategoryData(".$row['categoryID'].",'".$row['categoryName']."','".$row['categoryUnit']."')\" title=\"Edit Category\" data-toggle=\"modal\" data-target=\"#editModal\">
						<i class=\"fa fa-edit fa-lg edit\"></i></a>
						<a href=\"#\" onclick=\"fillDeleteCategoryData(".$row['categoryID'].",'".$row['categoryName']."',".$rowResultCount['count'].",'".$row['categoryUnit']."')\" data-toggle=\"modal\" data-target=\"#deleteModal\">
						<i class=\"fa fa-times fa-lg delete\" title=\"Delete category\"></i></a>
						</td>";
						*/
						echo "</tr>";
						$i++;
				}
			}

		}
	}
	
	public function invoice(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null){
		
		}
		else{
			$reqData = func_get_arg(0);

			if($reqData[0]=='sale' || $reqData[0]=='purchase' )
			{

				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = $dashModel->getAllInvoiceList($reqData[0]);
				$finalInvoiceList = array();
				$localInvoiceList = array();
				while($row = $result->fetch_assoc())
				{
					$localInvoiceList = array_merge($localInvoiceList, $row);
					$fullUserName = $dashModel->getUserFullName($row['userID']);
					$fullUserName = $fullUserName->fetch_assoc();
					$localInvoiceList = array_merge($localInvoiceList, $fullUserName);
					$finalInvoiceList[] = $localInvoiceList;	
					$localInvoiceList = array();
				}
					$reqData[0] = ucfirst($reqData[0]);
					$data = array(
					'title'=> $reqData[0].' Invoices | আমার Manager'
				);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/adminInvoice.js'
							);
				$data['data']['invoice'] = $finalInvoiceList;
				$data['data']['type'] = $reqData[0];
				$this->load->view('admin/invoiceList', $data);
			}
			else if($reqData[0]=='payment'){
				if($_POST['submit']=="true")
				{
					if(!($_POST['payment']=='' && $_POST['fromBalance']=='')){
						$scID = (int)Validation::verify($_POST['scID']);
						$invID = (int)Validation::verify($_POST['invID']);
						$payment = (float)Validation::verify($_POST['payment']);
						$fromBalance = (float)Validation::verify($_POST['fromBalance']);

						$check = true;
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$invoiceTotal = $dashModel->getInvoiceInfo($invID)->fetch_assoc();
						$invoiceTotal = (float)$invoiceTotal['invoiceAmount']-(float)$invoiceTotal['invoiceDiscount'];
						//echo "Invoice Total: ".$invoiceTotal;
						$invoicePaidTotal = (float)$dashModel->getInvoicePaidAmount($invID)->fetch_assoc()['paid'];
						//echo "Invoice Paid: ".$invoicePaidTotal;

						$due = $invoiceTotal - $invoicePaidTotal;

						//echo "Due: ".$due;

						if($fromBalance>0){
							$invT = $dashModel->getTotalInvoiceSC($_POST['scID'])->fetch_assoc()['invoiceTotal'];
							$paidT = $dashModel->getTotalPaidSC($_POST['scID'])->fetch_assoc()['paidTotal'];
							$currentBalance = $paidT - $invT;

							//echo "Balance: ".$currentBalance;
							if($fromBalance>$currentBalance){
								$check = false;
							}
						}else{
							$fromBalance = 0;
						}
						$total = $payment + $fromBalance;
						 //echo $payment;
						if($due<$total){
							$check = false;
						}

						if(check){
							if($fromBalance>0){
								$dashModel->addWithdraw($scID, $fromBalance, 'Withdraw Balance');
							}
							$dashModel->addInvoiceTrx($invID, $total, $scID);
							$dashModel->addCash(1, $total, 'Payment For Invoice#'.$invID);
							
							echo "true";
						}else{
							echo "false";
						}
					}else{
						echo "empty";
					}
				}
				/*echo "<pre>";
				var_dump($_POST);
				echo "</pre>";*/
				/*echo "<pre>";
				print_r($scID);
				echo "</pre>";
				echo "<pre>";
				print_r($invID);
				echo "</pre>";
				echo "<pre>";
				print_r($payment);
				echo "</pre>";
				echo "<pre>";
				print_r($fromBalance);
				echo "</pre>";*/
			}
			
			else if($reqData[0]=='purchasePayment'){
				if($_POST['submit']=="true")
				{
					if($_POST['scID']!='' && $_POST['invID']!='' && ($_POST['fromBalance'] || ($_POST['cashID']!='' && $_POST['payment']!=''))){
						$scID = (int)Validation::verify($_POST['scID']);
						$invID = (int)Validation::verify($_POST['invID']);
						$cashID = (float)Validation::verify($_POST['cashID']);
						$payment = (float)Validation::verify($_POST['payment']);
						$fromBalance = (float)Validation::verify($_POST['fromBalance']);
						echo $fromBalance;
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$invoiceTotal = $dashModel->getInvoiceInfo($invID)->fetch_assoc();
						$invoiceTotal = (float)$invoiceTotal['invoiceAmount']-(float)$invoiceTotal['invoiceDiscount'];
						//echo "Invoice Total: ".$invoiceTotal;
						$invoicePaidTotal = (float)$dashModel->getInvoicePaidAmount($invID)->fetch_assoc()['paid'];
						//echo "Invoice Paid: ".$invoicePaidTotal;
						$due = $invoiceTotal - $invoicePaidTotal;
						
						if($due>0){
							$cashBalance = $dashModel->getCashAccountBalance($cashID)->fetch_assoc();
							$cashBalance = $cashBalance['balance'];
							$gt = $payment+$fromBalance;
							if($cashBalance>=$payment && $gt<=$due){
								$r1 = $dashModel->addCash($cashID, ($payment*(-1)),  "Payment For Invoice ID ".$invID);
								if($fromBalance>0){
									$dashModel->addWithdraw($scID, $fromBalance, 'Withdraw Balance');
								}
								$r2 = $dashModel->addInvoiceTrx($invID, $gt, $scID);
								if($r1 && $r2){
									echo "true";
								}
							}else{
								echo "failed";
							}
						}else{
							echo "failed";
						}
					}else{
						echo "empty";
					}
				}else
				{
					$this->load->redirectIn();
				}
			}
			
			else{
				if(is_int((int)$reqData[0])){
					$this->load->model('adminModel');
					$dashModel = new adminModel();
					$result = $dashModel->getInvoiceInfo($reqData[0]);
					$result = $result->fetch_assoc();
					if($result == null){
						echo "null";//404
					}else{
						$data = array(
							'title'=> ' Invoice# '.$reqData[0].' | আমার Manager'
						);
						$data['data']['info'] = $result;
						$fullUserName = $dashModel->getUserFullName($result['userID']);
						$fullUserName = $fullUserName->fetch_assoc();
						$data['data']['info']['user'] = $fullUserName['name'];
						$data['data']['invoice'] = $dashModel->getInvoiceList($reqData[0]);
						$data['data']['paid'] = $dashModel->getInvoicePaidAmount($reqData[0]);
						/*echo "<pre>";
						print_r($data['data']['paid']->fetch_assoc());
						echo "</pre>";*/
						$this->load->view('admin/invoice', $data);
					}
				}else{
					echo "Not Invoice";//404
				}
				
			}
		}
	}
	
	public function drawing(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null){
			$data = array(
				'title'=> 'Drawings | আমার Manager'
				);
			$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
								'dataTables/css/dataTables.responsive.css'
								);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
								'dataTables/js/dataTables.bootstrap.min.js',
								'dataTables/js/dataTables.responsive.js',
								'js/page/adminDrawing.js'
								);
			$this->load->model('adminModel');
			$dashModel = new adminModel();
			$result = $dashModel->getDrawings();
			$finalDrawingList = array();
				
				while($row = $result->fetch_assoc())
				{
					$fullUserName = $dashModel->getUserFullName($row['userID']);
					$fullUserName = $fullUserName->fetch_assoc()['name'];
					$localDrawingList = array(
						'trxID' => $row['trxID'],
						'trxDate' => $row['trxDate'],
						'trxTime' => $row['trxTime'],
						'trxAmount' => $row['trxAmount'],
						'trxNote' => $row['trxNote'],
						'user' => $fullUserName
					);
					array_push($finalDrawingList, $localDrawingList);
				}
				$data['data'] = $finalDrawingList;
				

			$this->load->view('admin/drawings', $data);
		}
		else{
			$reqData = func_get_arg(0);

			if($reqData[0]=='new')
			{
				$data = array(
					'title'=> 'Add New Drawing | আমার Manager'
				);
				$data['js'] = array('js/page/adminDrawing.js');
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$cash = $dashModel->getAllCashAccounts();
				$finalCash = array();
				while($key = $cash->fetch_assoc()) {
					$cashID = $key['accountID'];
					$balance = $dashModel->getCashAccountBalance($cashID)->fetch_assoc();
					$balance = $balance['balance'];
					$cashArray = array(
							'cashID' => $cashID,
							'cashName' => $key['accountName'],
							'balance' => $balance
						);
					array_push($finalCash, $cashArray);
				}
				$data['data']['cashAccounts'] = $finalCash;
				$this->load->view('admin/addDrawing', $data);
			}else if($reqData[0]=='addDrawing'){
				if($_POST['submit']=="true")
				{
					if($_POST['cAccount']!='' || $_POST['dAmount']!=''){
						$cashID = (int)Validation::verify($_POST['cAccount']);
						$drawingAmount = (float)Validation::verify($_POST['dAmount']);
						$note = (float)Validation::verify($_POST['dNote']);
						$this->load->model('adminModel');
						$dashModel = new adminModel();
						$balance = $dashModel->getCashAccountBalance($cashID)->fetch_assoc()['balance'];
						if($balance>=$drawingAmount){
							$c = $dashModel->addCash($cashID, ($drawingAmount*(-1)),  "Cash Drawing");
							$d = $dashModel->addDrawing($drawingAmount, $note);
							if($c && $d){
								echo "true";
							}else{
								echo "false";
							}
						}else{
							echo "false";
						}
					}else{
						echo "empty";
					}
				}else
				{
					$this->load->redirectIn();
				}
			}
		}
	}
	
	public function settings(){
		$this->sessionVerify('verify');
		if(func_get_arg(0)==null){
			$data = array(
				'title'=> 'Settings | আমার Manager'
			);
			$this->load->view('admin/settings', $data);
		}else{
			$reqData = func_get_arg(0);
			if($reqData[0]=='language')
			{
				$data = array(
					'title'=> 'Settings | আমার Manager'
				);
				$data['langMsg'] = null;
				$this->load->model('adminModel');
				$dashModel = new adminModel();
				$result = false;
				$lang = Validation::verify($_POST['language']);
				if($lang=='en' || $lang=='bn'){
					$result = $dashModel->changeLanguage($lang);
				}
				if($_POST['language']!=null && $result){
					$data['langMsg'] = "success";
					$_SESSION['data']['language'] = $lang;
				}else if($_POST['language']!=null){
					$data['langMsg'] = "failed";
				}
				$this->load->view('admin/settings', $data);
			}
			else if($reqData[0]=='password'){
				$data = array(
					'title'=> 'Settings | আমার Manager'
				);
				$old = Validation::verify($_POST['old']);
				$new = Validation::verify($_POST['new']);
				$new2 = Validation::verify($_POST['new2']);
				$this->load->model('mainModel');
				$dbModel = new mainModel();
				$result = $dbModel->loginVerify($_SESSION['data']['email'], $old);
				if(($result->num_rows)==1){
					if($new==$new2){
						$result = $dbModel->updatePassword($_SESSION['data']['userID'], $new);
						if($result){
							$data['passMsg'] = "success";
						}else{
							$data['passMsg'] = "failed";
						}
					}
					else{
						$data['passMsg'] = "failed";
					}
				}else if($old!=null||$new!=null||$new2!=null){
					$data['passMsg'] = "failed";
				}
				$this->load->view('admin/settings', $data);
			}
		}
		
	}
	
	public function sms(){
		$this->sessionVerify('verify');
			$this->load->model('adminModel');
			$dashModel = new adminModel();
			$data = array(
				'title'=> 'SMS | আমার Manager'
			);
			$data['data']['balance'] = $dashModel->getSMSBalance()->fetch_assoc()['balance'];
			$data['data']['template'] = $dashModel->getSMSTemplate();
			$data['data']['log'] = $dashModel->getSMSLog();
			
			$this->load->view('admin/sms', $data);
	}
	
	public function report(){
		$this->sessionVerify('verify');
		$this->load->model('adminModel');
		$dashModel = new adminModel();
		if(func_get_arg(0)==null){
		
		}else{
			$reqData = func_get_arg(0);

			if($reqData[0]=='profit')
			{
				$data = array(
				'title'=> 'Daily Profit Report'
				);
				$data['css'] = array('css/jquery-ui.css');
				$data['js'] = array('js/jquery-ui.js','js/page/adminProfit.js');
				if(isset($_GET['date'])){
					$date = date_create($_GET['date']);
					$date = date_format($date,"Y-m-d");
					$data['profit'] = $dashModel->getDailyProfit($date);
				}
				
				//print_r($data['profit']->fetch_assoc());

				$this->load->view('admin/profit', $data);
			}
			if($reqData[0]=='income')
			{
				$data = array(
				'title'=> 'Income Statement'
				);
				$data['css'] = array('css/jquery-ui.css');
				$data['js'] = array('js/jquery-ui.js','js/page/adminProfit.js');
				if(isset($_GET['from'])){
					$from = date_create($_GET['from']);
					$from = date_format($from,"Y-m-d");
					$to = date_create($_GET['to']);
					$to = date_format($to,"Y-m-d");
					$data['profit'] = $dashModel->getProfit($from,$to);
					$data['expense'] = $dashModel->getExpenseIncomeStatement($from, $to);
				}
				
				

				$this->load->view('admin/income', $data);
			}
			
		}
	}
	
	public function attandance(){
		$this->sessionVerify('verify');
		$this->load->model('adminModel');
		$dashModel = new adminModel();
		if(func_get_arg(0)==null){
			$data = array(
					'title'=> 'Attandance Report'
				);
				$data['css'] = array('css/jquery-ui.css');
				$data['js'] = array('js/jquery-ui.js','js/page/adminEmployee.js');
				if(isset($_GET['date'])){
					$date = date_create($_GET['date']);
					$date = date_format($date,"Y-m-d");
					$employeeData = $dashModel->getEmployee();
					$finalAttandance = array();
					while($row = $employeeData->fetch_assoc())
					{
						$id = $row['empID'];
						$name = $row['empName'];
						$phone = $row['empPhone'];
						$info = $row['empInfo'];
						$status = $dashModel->getEmployeeAttandance($row['empID'], $date)->fetch_assoc()['attandanceType'];
					 	if($status == NULL){
							$status = -1;
					 	}
						$localAttandance = array(
							'id' => $id,
							'name' => $name,
							'phone'=> $phone,
							'info' =>$info,
							'status'=> $status
						);
						array_push($finalAttandance, $localAttandance);
					}
					$data['attandance'] = $finalAttandance;
					$data['date'] = $date;
				}
				$this->load->view('admin/attandance', $data);
		}
		else
		{
			$reqData = func_get_arg(0);

			if($reqData[0]=='data')
			{
				echo "<pre>";
					print_r($_POST);
					echo "</pre>";
				if(isset($_POST['date'])){
					$date = date_create($_POST['date']);
					$date = date_format($date,"Y-m-d");
				$employeeData = $dashModel->getEmployee();
					while($row = $employeeData->fetch_assoc())
					{echo "<pre>";
					echo $row['empName']."<br>";
					echo $row['empPhone']."<br>";
					$status = $dashModel->getEmployeeAttandance($row['empID'], $date)->fetch_assoc()['attandanceType'];
					 if($status == NULL){
						 $status = -1;
					 }
					echo $status."<br>";
					echo "</pre>";
					}
					
				}
			}
			else if($reqData[0]=='info'){
				echo "<pre>";
					var_dump($_POST);
					echo "</pre>";
				$date = $_POST['date'];
				$i = 0;
				echo "<br>";
				echo $date."<br>";
				foreach($_POST as $d){
					if($i>0){
						$r = explode(",", $d);
						$employee = $dashModel->getEmployeeInfo($r[0])->fetch_assoc();
						$result = $dashModel->getEmployeeAttandanceStatus($r[0], $date);
						$result = $result->fetch_assoc();
						if($result['t']==0){
							$dashModel->addAttandance($r[0], $date, $r[1]);
							if($r[1]==1){
								$dashModel->addEmployeeTransaction($r[0], $employee['empDailySalary'], "Salary Added: ".date_format(date_create($date),"d-m-Y"));
							}else if($r[1]==0){
								$dashModel->addEmployeeTransaction($r[0], (-1)*$employee['empFine'], "Absent Fine: ".date_format(date_create($date),"d-m-Y"));
							}
						}else{
							$dashModel->updateAttandance($r[0], $date, $r[1]);
						}
					}
					$i++;
				}
				$date = date_create($date);
				$date = date_format($date,"d-m-Y");
				$this->load->redirectIn('admin/attandance?date='.$date);
			}
		}
	}
	
		public function employee(){
			$this->sessionVerify('verify');
			$this->load->model('adminModel');
			$dashModel = new adminModel();
			if(func_get_arg(0)==null){
				
			}else{
				$reqData = func_get_arg(0);

				if($reqData[0]=='new')
				{
					$data = array(
						'title'=> 'Add New Employee | আমার Manager'
					);
					$data['js'] = array('js/page/adminEmployee.js');

					$this->load->view('admin/addEmployee', $data);
				}else if($reqData[0]=='add'){
					if($_POST['submit']=="true"){
						if($_POST['name']!='' && $_POST['phone']!='' && $_POST['salary']!='' && $_POST['fine']!='')
						{
							$newEmployeeName = Validation::verify($_POST['name']);
							$newEmployeePhone = Validation::verify($_POST['phone']);
							$newEmployeeSalary = (float)Validation::verify($_POST['salary']);
							$newEmployeeFine = (float)Validation::verify($_POST['fine']);
							$newEmployeeInfo = Validation::verify($_POST['info']);

							$this->load->model('adminModel');
							$dashModel = new adminModel();
							$result = $dashModel->isUniqueEmployee($newEmployeePhone)->fetch_assoc();
							if($result['total']==0)
							{
								$result = $dashModel->addEmployee($newEmployeeName, $newEmployeePhone, $newEmployeeSalary, $newEmployeeFine, $newEmployeeInfo);
								if($result)
								{
									echo "true";
								}
								else
								{
									echo "false";
								}
							}
							else
							{
								echo "duplicate";
							}
						}
						else
						{
							echo "empty";
						}
					}else{
						$this->load->redirectIn();
					}
				}else if($reqData[0]=='edit'){
					$id = Validation::verify($_POST['id']);
					$name = Validation::verify($_POST['name']);
					$phone = Validation::verify($_POST['phone']);
					$salary = Validation::verify($_POST['salary']);
					$fine = Validation::verify($_POST['fine']);
					$info = Validation::verify($_POST['info']);
					if($dashModel->editEmployee($id, $name, $phone, $salary, $fine, $info)){
						$this->load->redirectIn('admin/employee/'.$id);
					}
					echo "Failed ".$id." ".$name." ".$phone." ".$salary." ".$fine." ".$info;
				}else if($reqData[0]=='addMoney'){
					$id = Validation::verify($_POST['id']);
					$amount = Validation::verify($_POST['amount']);
					$note = Validation::verify($_POST['note']);
					if($dashModel->addEmployeeTransaction($id, $amount, $note)){
						$this->load->redirectIn('admin/employee/'.$id);
					}
				}else if($reqData[0]=='withdraw'){
					$id = Validation::verify($_POST['id']);
					$cashID = Validation::verify($_POST['cashID']);
					$amount = Validation::verify($_POST['amount']);
					$note = Validation::verify($_POST['note']);
					$dashModel->addEmployeeTransaction($id, ($amount*(-1)), $note);
					$result1 = $dashModel->addCash($cashID, (($amount)*(-1)), $note);
					$result2 = $dashModel->addExpense(2, $amount, $note);
					if($result1 && $result2){
						$this->load->redirectIn('admin/employee/'.$id);
					}
				}else{
					$data = array(
						'title'=> 'Employee Profile'
					);
				$data['css'] = array('css/jquery-ui.css');
				$data['js'] = array('js/jquery-ui.js','js/page/adminEmployee.js');
				$employee = $dashModel->getEmployeeInfo($reqData[0])->fetch_assoc();
				$data['employee'] = $employee;
				$cash = $dashModel->getAllCashAccounts();
				$data['data']['cash'] = $cash;
				$result = $dashModel->getEmployeeTrx($reqData[0]);	
					$finalTrx = array();
					while($row = $result->fetch_assoc())
					{
						$UserFullName = $dashModel->getUserFullName($row['userID']);
						$UserFullName = $UserFullName->fetch_assoc();
						$newArray = array(
								'trxDate'    	=> $row['empTrxDate'],
								'trxTime'   	=> $row['empTrxTime'],
								'trxAmount'		=> number_format($row['empTrxAmount'],2, '.', ''),
								'trxUser'   	=> $UserFullName['name'],
								'trxNote'			=> $row['empTrxNote']
							);
						$finalTrx[] = $newArray;
					}
					$data['trx'] = $finalTrx;
					$attandance = $dashModel->getEmployeeAttandanceList($reqData[0]);
					$data['attandance'] = $attandance;
					$balance = $dashModel->getEmployeeBalance($reqData[0])->fetch_assoc();
					$data['balance'] = $balance['balance']; 
					$this->load->view('admin/employee', $data);
				}
			}
		}
}