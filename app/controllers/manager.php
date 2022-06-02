<?php
include 'system/Controller.php';
class manager extends Controller
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
				'title'=> 'Manager Dashboard | আমার Manager'
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
    $dashModel->setActivity( "Manager Dashboard");
		$result = $dashModel->getStock();
		$data['data']['stock'] = $result;
		$this->load->view('manager/dashboard', $data);
    
	}
  
  	public function purchaseHistory(){
		$this->sessionVerify('verify');
		$data = array(
				'title'=> 'Manager Dashboard | আমার Manager'
				);
		$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css'
							);
		$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/manager/managerStockHistory.js'
							);
		$this->load->model('adminModel');
		$dashModel = new adminModel();
      $dashModel->setActivity( "Manager Purchase History");
		$result = $dashModel->getProductPurchaseHistoryForManager();
		$data['data']['stock'] = $result;
		$this->load->view('manager/stockHistory', $data);

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
      $dashModel->setActivity( "Manager Customer List");
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

			$this->load->view('manager/customer', $data);
		}
		else{
			$reqData = func_get_arg(0);
			if($reqData[0]=='new')
			{
				$data = array(
				'title'=> 'Add New Customer | আমার Manager'
				);
				$data['js'] = array('js/page/manager/managerCustomer.js');

				$this->load->view('manager/addCustomer', $data);
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
									echo "<td><a class=\"btn btn-xs btn-primary\" href=\"".BASE_URL."manager/invoice/".$invRow['invoiceID']."\"> <i class=\"glyphicon glyphicon-eye-open\"></i> View </a></td>";
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
							$newArray['trxType'] = "<a href=\"".BASE_URL."manager/invoice/".$row['trxReference']."\">Invoice #";
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
        $dashModel->setActivity( "Manager Customer Profile# ".$reqData[0]);
				$scResult = $scInfo->fetch_assoc();
				$invT = $dashModel->getTotalInvoiceSC($reqData[0])->fetch_assoc()['invoiceTotal'];
				$paidT = $dashModel->getTotalPaidSC($reqData[0])->fetch_assoc()['paidTotal'];
				$data = array(
				'title'=> $scResult['scNameCompany'].' | আমার Manager'
				);
				$data['css'] = array('dataTables/css/dataTables.bootstrap.min.css',
							'dataTables/css/dataTables.responsive.css',
              'css/jquery-ui.css'
							);
				$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
                          'js/jquery-ui.js',
							'dataTables/js/dataTables.bootstrap.min.js',
							'dataTables/js/dataTables.responsive.js',
							'js/page/manager/adminProfile.js'
							);
				$data['data']['sc'] = $scResult;
				$data['data']['type'] = "Customer";

				
				
				
				$data['data']['balance'] = number_format(($paidT - $invT),2, '.', '');
				
				
				$this->load->view('manager/profile', $data);
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
								  'css/toastr.min.css',
                 'css/jquery-ui.css'
							);
			$data['js'] = array('dataTables/js/jquery.dataTables.min.js',
                          'js/jquery-ui.js',
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
        $dashModel->setActivity( "Manager Sale");
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
				$this->load->view('manager/sale', $data);

		}
		else{
			$reqData = func_get_arg(0);

			if($reqData[0]=='add')
			{
				$pq = 0;
				$productList = array();
				$customerID = Validation::verify($_POST['customerID']);
        $invDate = Validation::verify($_POST['date']);
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
					
					$invInf = $dashModel->addInvoiceInfoWithDate($customerID, $invDate, $grandTotal,$discount,$status,'sale',$invoiceNote);
					$invoiceID = $dashModel->getLastInvoiceID($_SESSION['data']['userID'], $customerID, $grandTotal,$status);
					$invoiceID = $invoiceID->fetch_assoc()['invoiceID'];
					if($payFromBalance>0){
						$note = "Invoice: ".$invoiceID.". Withdraw Balance For Payment".
						$paymentInfo = $dashModel->addWithdraw($customerID,$payFromBalance, $note);
					}
					if($paymentTotal>0){
						$test = $dashModel->addInvoiceTrxWithDate($invoiceID, $invDate, $paymentTotal, $customerID);
						/*echo "<pre>Hello".$invoiceID." ".$paymentTotal." ".$customerID;
						var_dump($test->fetch_assoc());
						echo "</pre>";*/
					}
					
					$cashNote = "Invoice: ".$invoiceID.". Cash Receive";
					$dashModel->addCashWithDate($_POST['cashID'], $invDate, $paymentTotal, $cashNote);
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
					$this->load->redirectIn('manager/invoice/'.$invoiceID);
				}
					else{
						$this->load->redirectIn('manager/sale/');
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
			$data['js'] = array('js/page/manager/managerReturn.js'); 
			$this->load->view('manager/return', $data);
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
							echo '<form method="POST" action="'.BASE_URL."manager/invoiceReturn/submit".'">';
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
                                echo "<td><input name='newQty[]' type='number' min='0' step='0.01' max='".$row['invoiceQuantity']."' value='".$row['invoiceQuantity']."' required></td>";

                                echo "</tr>";    
                                $i++;
                            }
                       

                    echo '</tbody>';
               echo '</table>';
							  echo '<div class="form-group"><label for="discount">'.$invoiceReturn['discountAmount'].'</label><input type="number" name="discount" id="discount" placeholder="Enter Discount Amount" value="'.$result['invoiceDiscount'].'" required></div>';
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
						$this->load->redirectIn('manager/invoice/'.$_POST['returnInvoiceID']);
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
					$this->load->redirectIn('manager/invoice/'.$_POST['returnInvoiceID']);
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
        $dashModel->setActivity( "Manager Invoice List");
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
				$this->load->view('manager/invoiceList', $data);
			}
			else if($reqData[0]=='payment'){
				if($_POST['submit']=="true")
				{
					if(!($_POST['payment']=='' && $_POST['fromBalance']=='')){
						$scID = (int)Validation::verify($_POST['scID']);
						$invID = (int)Validation::verify($_POST['invID']);
						$payment = (float)Validation::verify($_POST['payment']);
						$fromBalance = (float)Validation::verify($_POST['fromBalance']);
            $date = Validation::verify($_POST['payDate']);
						$check = true;
						$this->load->model('adminModel');
						$dashModel = new adminModel();
            $dashModel->setActivity( "Manager Payment For Invoice# ".$invID." Amount: ".$payment);
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
							$dashModel->addInvoiceTrxWithDate($invID, $date, $total, $scID);
							$dashModel->addCashWithDate(1, $date, $total, 'Payment For Invoice#'.$invID);
							
              
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
			else if($reqData[0]=="print"&&is_int((int)$reqData[1])){
          					$this->load->model('adminModel');
					$dashModel = new adminModel();
        $dashModel->setActivity( "Manager Print Invoice# ".$reqData[1]);
					$result = $dashModel->getInvoiceInfo($reqData[1]);
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
						$data['data']['invoice'] = $dashModel->getInvoiceList($reqData[1]);
						$data['data']['paid'] = $dashModel->getInvoicePaidAmount($reqData[1]);
            echo "<style>@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');</style>";
            echo '<h2 style="font-family: Roboto, sans-serif; margin:0; font-size: 18px; font-weight: 700" align="center">'.$_SESSION['data']['businessName'].'</h2>';
            echo '<p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="center" align="center">'.$_SESSION['data']['businessAddress'].' Phone: '.$_SESSION['data']['businessPhone'].'</p>';
            $invoiceType = "";
             $price = '';
            if($data['data']['info']['invoiceType'] == 'sale'){
                $invoiceType = "Sales Invoice# ".$reqData[1];
              $price = 'invoiceSale';
            }else{
              $price = 'invoicePurchase';
                $invoiceType = 'Purchase Invoice# '.$reqData[1];
            }
            echo '<p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 700; text-decoration: underline" align="center">'.$invoiceType.'</p>';
            echo '<p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="center"><span style="font-weight: 700">Date: </span>'.date("d/m/Y", strtotime($data['data']['info']['invoiceDate'])).'</p>';
            echo '<p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400"><span style="font-weight: 700">Name: </span>'.$data['data']['info']['scID'].'-'.$data['data']['info']['scNameCompany'].' ('.$data['data']['info']['scContactNo'].')'.'</p>';
            echo '<p style="font-family: Roboto, sans-serif; margin:0px 0px 6px 0px; font-size: 14px; font-weight: 400"><span style="font-weight: 700; font-style: italic;">Prepared By: </span>'.$data['data']['info']['user'].'</p>';
            echo '<table border="1px solid #000" style="border-collapse: collapse; width: 100%; margin-left: auto; margin-right: auto;">';
                    echo '<thead>';
                        echo '<tr>';
                            echo '<th style="font-family: Roboto, sans-serif; margin:0; font-size: 12px; font-weight: 700">Sl.</th>';
                            echo '<th style="font-family: Roboto, sans-serif; margin:0; font-size: 12px; font-weight: 700">Product Name</th>';
                            echo '<th style="font-family: Roboto, sans-serif; margin:0; font-size: 12px; font-weight: 700">Quantity</th>';
                            echo '<th style="font-family: Roboto, sans-serif; margin:0; font-size: 12px; font-weight: 700">Unit</th>';
                            echo '<th style="font-family: Roboto, sans-serif; margin:0; font-size: 12px; font-weight: 700">Total</th>';
                        echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                            $i = 1;
                            while ($row = $data['data']['invoice']->fetch_assoc())
                            {
                                $total = number_format(($row['invoiceQuantity'] * $row[$price]), 2, '.', '');
                                echo "<tr>";
                                echo '<td style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400">'.$i.'</td>';
                                echo '<td style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400">'.$row['invoiceProductName'].'</td>';
                                echo '<td style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400">'.$row['invoiceQuantity']." ".$row['invoiceProductCategoryUnit']."</td>";
                                echo '<td style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400">'.$_SESSION['data']['businessCurrency']." ".$row[$price]."</td>";
                                echo '<td><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">'.$_SESSION['data']['businessCurrency']." ".$total."</p></td>";

                                echo "</tr>";    
                                $i++;
                            }
                        echo '<tr>';
                            echo '<td colspan="4"><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">Total</p></td>';
                            echo '<td><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">'.$_SESSION['data']['businessCurrency']." ".$data['data']['info']['invoiceAmount'].'</p></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td colspan="4"><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">Discount</p></td>';
                            echo '<td><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">'.$_SESSION['data']['businessCurrency']." ".$data['data']['info']['invoiceDiscount'].'</p></td>';
                        echo '</tr>';
                            echo '<td colspan="4"><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">Grand Total</p></td>';
                            $grandTotal = $data['data']['info']['invoiceAmount'] - $data['data']['info']['invoiceDiscount'];
                            echo '<td><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">'.$_SESSION['data']['businessCurrency']." ".number_format($grandTotal, 2,'.','').'</p></td>';
                        echo '</tr>';
                        $payment = $data['data']['paid']->fetch_assoc();
                        echo '<tr class="invoice-lg">';
                            echo '<td colspan="4"><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">Paid</p></td>';
                            echo '<td><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">'.$_SESSION['data']['businessCurrency']." ".number_format($payment['paid'], 2,'.','').'</p></td>';
                        echo '</tr>';
            $due = 0.0;
                                if($grandTotal>$payment['paid']){
                                    $due = $grandTotal - $payment['paid'];
                                }
                        echo '<tr class="invoice-lg">';
                            echo '<td colspan="4"><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">Due</p></td>';
                            echo '<td><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">'.$_SESSION['data']['businessCurrency']." ".number_format($due, 2,'.','').'</p></td>';
                        echo '</tr>';
            				$invT = $dashModel->getTotalInvoiceSC($data['data']['info']['scID'])->fetch_assoc()['invoiceTotal'];
				$paidT = $dashModel->getTotalPaidSC($data['data']['info']['scID'])->fetch_assoc()['paidTotal'];
				$b = $paidT - $invT;
            
            $previousDue = 0;
            $totalDue = 0;
				if($b<0 && $b!=$due)
				{
          $b = $b*(-1);
          $previousDue = $b - $due;
          
        }
            $totalDue = $previousDue + $due;
                        echo '<tr class="invoice-lg">';
                            echo '<td colspan="4"><p style="font-family: Roboto, sans-serif; margin:0; font-size: 12px; font-weight: 400" align="right">Previous Due</p></td>';
                            echo '<td><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">'.$_SESSION['data']['businessCurrency']." ".number_format($previousDue, 2,'.','').'</p></td>';
                        echo '</tr>';
                        echo '<tr class="invoice-lg">';
                            echo '<td colspan="4"><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 400" align="right">Total Due</p></td>';
                            echo '<td><p style="font-family: Roboto, sans-serif; margin:0; font-size: 14px; font-weight: 700" align="right">'.$_SESSION['data']['businessCurrency']." ".number_format($totalDue, 2,'.','').'</p></td>';
                        echo '</tr>';
                    echo '</tbody>';
                echo '</table>';
            date_default_timezone_set($_SESSION['data']['businessTimeZone']);
                echo '<p style="font-family: Roboto, sans-serif; margin:6px 0px 0px 0px; font-size: 14px; font-style: italic; font-weight: 400" align="center">This invoice is printed on '.date('l h:m:s A').','.date('d-M-Y').'</p>';
            
            
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
            $data['data']['invID'] = $reqData[0];
						/*echo "<pre>";
						print_r($data['data']['paid']->fetch_assoc());
						echo "</pre>";*/
						$this->load->view('manager/invoice', $data);
					}
				}
        else{
					echo "Not Invoice";//404
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
			$this->load->view('manager/settings', $data);
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
				$this->load->view('manager/settings', $data);
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
				$this->load->view('manager/settings', $data);
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
			
			$this->load->view('manager/sms', $data);
	}

}