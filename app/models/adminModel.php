<?php
include 'system/Model.php';
class adminModel extends Model
{
	public function getStock($pID = null)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		if($pID == null){
		$sql = "SELECT stock.productID, productName, quantity, purchaseUnit, saleUnit, batch, productLimit, categoryName, categoryUnit, stock.barcode FROM product inner join stock on stock.productID=product.productID INNER JOIN productCategory on product.productCategoryID = productCategory.categoryID order by productID desc";
		}else{
		$sql = "SELECT stock.productID, productName, quantity, purchaseUnit, saleUnit, batch, productLimit, categoryName, categoryUnit, stock.barcode FROM stock inner join product on stock.productID=product.productID INNER JOIN productCategory on product.productCategoryID = productCategory.categoryID WHERE stock.productID = '$pID' order by productID desc";
		}
		return $this->db->fetch($sql);
	}
	
	public function getStockWarning()
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT count(*) as warning FROM stock inner join product on stock.productID = product.productID where (product.productLimit - stock.quantity) >0 ";
		return $this->db->fetch($sql);
	}
	
	public function getStockOver()
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT count(*) as overf FROM stock where stock.quantity=0";
		return $this->db->fetch($sql);
	}
	
	public function getStockBatch($pID, $batch)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT stock.productID, productName, quantity, purchaseUnit, saleUnit, batch, productLimit, categoryName, categoryUnit FROM stock inner join product on stock.productID=product.productID INNER JOIN productCategory on product.productCategoryID = productCategory.categoryID WHERE stock.productID = '$pID' AND stock.batch = '$batch' order by productID desc";
		return $this->db->fetch($sql);
	}
	
	public function getStockTotal($pID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(quantity) as total FROM stock WHERE productID = '$pID'";
		return $this->db->fetch($sql);
	}
	
	public function isUniqueBatch($pID, $batch)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM stock WHERE productID = '$pID' AND batch = '$batch'";
		return $this->db->fetch($sql);
	}
	
	public function updateBatchSale($pID,$exBatch, $batch, $saleUnit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE  stock SET batch = '$batch', saleUnit = '$saleUnit' WHERE  productID = '$pID' AND batch = '$exBatch'";
		return $this->db->fetch($sql);
	}
	
	public function updateBatchInvoice($pID,$exBatch, $batch){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE  invoice SET invoiceBatch = '$batch' WHERE  productID = '$pID' AND invoiceBatch = '$exBatch'";
		return $this->db->fetch($sql);
	}
	
	public function isBatchEmpty($pID, $batch)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT SUM(quantity) as quantity FROM stock WHERE productID = '$pID' AND batch = '$batch'";
		return $this->db->fetch($sql);
	}
	
	public function deleteBatch($pID, $batch)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "DELETE FROM stock WHERE productID = '$pID' AND batch = '$batch'";
		return $this->db->execute($sql);
	}
	public function getAllCategory()
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM productCategory order by categoryID desc";
		return $this->db->fetch($sql);
	}

	/*
	public function getAllCategoryCount(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		//$sql = "SELECT productCategory.categoryID, productCategory.categoryName, productCategory.categoryUnit, count(product.productID) as count FROM productCategory inner join product on product.productCategoryID = productCategory.categoryID group by productCategoryID order by categoryID desc";
		$sql = "SELECT productCategory.categoryID, productCategory.categoryName, productCategory.categoryUnit, count(product.productID) as count FROM productCategory inner join product on product.productCategoryID = productCategory.categoryID group by productCategoryID order by categoryID desc";
		//$sql = "SELECT * FROM productCategory order by categoryID desc";
		return $this->db->fetch($sql);
	}
	*/

	public function getCategoryProductCount($catID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT COUNT(*) as count FROM product WHERE productCategoryID = '$catID'";
		return $this->db->fetch($sql);
	}

	public function addCategory($catName, $catUnit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO productCategory (categoryName, categoryUnit) VALUES ( '$catName', '$catUnit')";
		return $this->db->execute($sql);
	}

	public function searchCategory($catData){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		//$sql = "SELECT productCategory.categoryID, productCategory.categoryName, productCategory.categoryUnit, count(product.productID) as count FROM productCategory inner join product on product.productCategoryID = productCategory.categoryID WHERE categoryName like '%{$catData}%' OR categoryUnit like '%{$catData}%' group by productCategoryID order by categoryID desc";

		$sql = "SELECT * FROM productCategory WHERE categoryName like '%{$catData}%' OR categoryUnit like '%{$catData}%' order by categoryID desc";
		return $this->db->fetch($sql);
	}

	public function isUniqueCategory($catName, $catUnit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM productCategory WHERE categoryName = '$catName' AND categoryUnit = '$catUnit'";
		return $this->db->fetch($sql);
	}

	public function editCategory($catID, $catName, $catUnit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE productCategory SET categoryName='$catName', categoryUnit='$catUnit' WHERE categoryID = '$catID'";
		return $this->db->execute($sql);
	}
	
	public function updateCategoryInvoice($cID,$exCatName, $exCatUnit, $catName, $catUnit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE invoice SET invoiceProductCategoryName = '$catName', invoiceProductCategoryUnit = '$catUnit' WHERE  invoiceProductCategoryID = '$cID' AND invoiceProductCategoryName = '$exCatName' AND invoiceProductCategoryUnit = '$exCatUnit'";
		return $this->db->fetch($sql);
	}

	public function deleteCategory($catID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "DELETE FROM productCategory WHERE categoryID = '$catID'";
		return $this->db->execute($sql);
	}


	public function getAllProduct($id = null){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		if($id==null)
		{
			$sql = "SELECT * FROM product inner join productCategory on product.productCategoryID = productCategory.categoryID order by product.productID desc";
		}else{
			$sql = "SELECT * FROM product inner join productCategory on product.productCategoryID = productCategory.categoryID Where product.productID = '$id' order by product.productID desc";
		}
		return $this->db->fetch($sql);
	}

	public function isUniqueProduct($productName, $productCategory){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM product WHERE productName = '$productName' AND productCategoryID = '$productCategory'";
		return $this->db->fetch($sql);
	}

	public function addProduct($productName, $productDescription, $productCategoryID, $productLimit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO product (productName, productDescription, productLimit, productCategoryID) VALUES ( '$productName', '$productDescription', '$productLimit', '$productCategoryID')";
		return $this->db->execute($sql);
	}

	public function editProduct($pID, $pName, $pDes, $cID, $pLimit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE product SET productName='$pName', productDescription='$pDes', productCategoryID='$cID', productLimit='$pLimit' WHERE productID = '$pID'";
		return $this->db->execute($sql);
	}

	public function searchProduct($productData){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM product inner join productCategory on product.productCategoryID = productCategory.categoryID WHERE productName like '%{$productData}%' OR productDescription like '%{$productData}%' order by product.productID desc";
		return $this->db->fetch($sql);
	}


	public function isUniqueCustomer($customerName, $customerPhone){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM supplierCustomer WHERE (scNameCompany = '$customerName' OR scContactNo = '$customerPhone') AND scType='customer'";
		return $this->db->fetch($sql);
	}
	
	public function isUniqueCustomerEdit($editSCID, $editSCName, $editSCPhone){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM supplierCustomer WHERE (scNameCompany = '$editSCName' OR scContactNo = '$editSCPhone') AND scType='customer' AND scID!='$editSCID'";
		return $this->db->fetch($sql);
	}

	public function addCustomer($newCustomerName, $newCustomerFather, $newCustomerPhone, $newCustomerAddress, $newCustomerLimit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$sql = "INSERT INTO supplierCustomer (scNameCompany, scFatherContactPerson, scContactNo, scAddress, scLimit, scType, scDate) VALUES ('$newCustomerName', '$newCustomerFather', '$newCustomerPhone', '$newCustomerAddress', '$newCustomerLimit', 'customer', '$date')";
		return $this->db->execute($sql);
	}
	
	public function editSCProfile($editSCID, $editSCName, $editSCFather, $editSCPhone, $editSCAddress, $editSCLimit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE supplierCustomer SET scNameCompany = '$editSCName', scFatherContactPerson = '$editSCFather', scContactNo = '$editSCPhone', scAddress = '$editSCAddress', scLimit = '$editSCLimit' WHERE scID = '$editSCID'";
		return $this->db->execute($sql);
	}
	
	public function getCustomer()
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM supplierCustomer WHERE scType='customer'";
		return $this->db->fetch($sql);
	}

	public function invoiceCountCustomer($customerID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT count(invoiceID) as invoiceCount FROM invoiceInfo WHERE scID='$customerID'";
		return $this->db->fetch($sql);
	}

	public function getCustomerExpense($customerID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(invoiceAmount - invoiceDiscount) as expense FROM invoiceInfo WHERE scID='$customerID'";
		return $this->db->fetch($sql);
	}
	public function getCustomerDeposit($customerID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(trxAmount) as deposit FROM transaction WHERE scID='$customerID'";
		return $this->db->fetch($sql);
	}









	public function isUniqueSupplier($supplierName, $supplierPhone){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM supplierCustomer WHERE (scNameCompany = '$supplierName' OR scContactNo = '$supplierPhone') AND scType='supplier'";
		return $this->db->fetch($sql);
	}

	public function addSupplier($newSupplierName, $newSupplierFather, $newSupplierPhone, $newSupplierAddress, $newSupplierLimit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$sql = "INSERT INTO supplierCustomer (scNameCompany, scFatherContactPerson, scContactNo, scAddress, scLimit, scType, scDate) VALUES ('$newSupplierName', '$newSupplierFather', '$newSupplierPhone', '$newSupplierAddress', '$newSupplierLimit', 'supplier', '$date')";
		return $this->db->execute($sql);
	}
	
	public function getSupplier()
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM supplierCustomer WHERE scType='supplier'";
		return $this->db->fetch($sql);
	}

	public function invoiceCountSupplier($supplierID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT count(invoiceID) as invoiceCount FROM invoiceInfo WHERE scID='$supplierID'";
		return $this->db->fetch($sql);
	}

	public function getSupplierDeposit($supplierID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(invoiceAmount) as deposit FROM invoiceInfo WHERE scID='$supplierID'";
		return $this->db->fetch($sql);
	}
	public function getSupplierExpense($supplierID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(trxAmount) as expense FROM transaction WHERE scID='$supplierID'";
		return $this->db->fetch($sql);
	}








	public function addCashAccount($cashName){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO account (accountName, accountType) VALUES ( '$cashName', 'cash')";
		return $this->db->execute($sql);
	}
	public function isUniqueCashAccount($cashName){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM account WHERE accountName = '$cashName' AND accountType = 'cash'";
		return $this->db->fetch($sql);
	}

	public function getAllCashAccounts(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM account WHERE accountType = 'cash'";
		return $this->db->fetch($sql);
	}
		public function getAllCashAccountsWithBalance(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT transaction.trxReference as CashID, account.accountName as CashName, sum(transaction.trxAmount) as CashBalance FROM account inner JOIN transaction on account.accountID=transaction.trxReference where transaction.trxType='cash' GROUP BY transaction.trxReference";
		return $this->db->fetch($sql);
	}

	public function addCash($cashAccount, $cashAmount, $cashNote){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sql = "INSERT INTO transaction (userID, trxDate, trxTime, trxType, trxReference, trxAmount, trxInfo) VALUES ( '$uID', '$date', '$time', 'cash', '$cashAccount', '$cashAmount', '$cashNote')";
		return $this->db->execute($sql);
	}
  
  public function addCashWithDate($cashAccount, $date, $cashAmount, $cashNote){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$time = date('H:i:s');
		$sql = "INSERT INTO transaction (userID, trxDate, trxTime, trxType, trxReference, trxAmount, trxInfo) VALUES ( '$uID', '$date', '$time', 'cash', '$cashAccount', '$cashAmount', '$cashNote')";
		return $this->db->execute($sql);
	}

	public function getCashTransaction(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM transaction WHERE trxType = 'cash' order by trxID desc";
		return $this->db->fetch($sql);
	}

	public function getCashAccountName($cashAccountID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT accountName FROM account WHERE accountType = 'cash' AND accountID = '$cashAccountID'";
		return $this->db->fetch($sql);
	}
	public function getUserFullName($cashUserID){
		$this->db->selectDB(DB_NAME);
		$sql = "SELECT name FROM businessCredentials WHERE userID = '$cashUserID'";
		return $this->db->fetch($sql);
	}
	public function getCashAccountBalance($cashAccountID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(trxAmount) as balance FROM transaction WHERE trxType = 'cash' AND trxReference = '$cashAccountID'";
		return $this->db->fetch($sql);
	}












	//purchase
	public function getStockInfo($value)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM stock WHERE productID = '$value'";
		return $this->db->fetch($sql);
	}
	
	public function getStockInfoWithBatch($pID, $batch)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM stock WHERE productID = '$pID' AND batch='$batch'";
		return $this->db->fetch($sql);
	}
	
	public function getProducts()
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM product";
		return $this->db->fetch($sql);
	}

	public function getProductInfo($value)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM product WHERE productID = '$value'";
		return $this->db->fetch($sql);
	}

	public function getProductCategoryInfo($value)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM productCategory WHERE categoryID = '$value'";
		return $this->db->fetch($sql);
	}

	public function getLastBatch($value)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM stock WHERE productID = '$value' order by batch desc";
		return $this->db->fetch($sql);
	}

	public function addInvoiceInfo($scID, $amount, $discount, $status, $type, $note){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sql = "INSERT INTO invoiceInfo (userID, scID, invoiceAmount, invoiceDiscount, invoiceDate, invoiceTime, invoiceStatus, invoiceType, invoiceNote) VALUES ( '$uID', '$scID', '$amount', '$discount', '$date', '$time', '$status', '$type', '$note')";

		return $this->db->execute($sql);
	}
  
  public function addInvoiceInfoWithDate($scID, $date, $amount, $discount, $status, $type, $note){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$time = date('H:i:s');
		$sql = "INSERT INTO invoiceInfo (userID, scID, invoiceAmount, invoiceDiscount, invoiceDate, invoiceTime, invoiceStatus, invoiceType, invoiceNote) VALUES ( '$uID', '$scID', '$amount', '$discount', '$date', '$time', '$status', '$type', '$note')";

		return $this->db->execute($sql);
	}
  

	public function addInvoiceTrx($invoiceID, $amount, $scID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sql = "INSERT INTO transaction (userID, trxDate, trxTime, trxType, trxReference, trxAmount, scID) VALUES ( '$uID', '$date', '$time', 'invoice', '$invoiceID', '$amount', '$scID')";
		return $this->db->execute($sql);
	}
  
  public function addInvoiceTrxWithDate($invoiceID, $date, $amount, $scID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$time = date('H:i:s');
		$sql = "INSERT INTO transaction (userID, trxDate, trxTime, trxType, trxReference, trxAmount, scID) VALUES ( '$uID', '$date', '$time', 'invoice', '$invoiceID', '$amount', '$scID')";
		return $this->db->execute($sql);
	}

	public function getLastInvoiceID($userID, $scID, $invoiceAmount,$invoiceStatus)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT invoiceID FROM invoiceInfo WHERE userID = '$userID' AND scID = '$scID' AND invoiceAmount = '$invoiceAmount' AND invoiceStatus = '$invoiceStatus' order by invoiceID desc";
		return $this->db->fetch($sql);
	}
  
  public function getLastSCID($scNameCompany, $scContactNo,$scLimit, $scType)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT scID FROM supplierCustomer WHERE scNameCompany = '$scNameCompany' AND scContactNo = '$scContactNo' AND scLimit = '$scLimit' AND scType = '$scType' order by scID desc";
		return $this->db->fetch($sql);
	}

	public function addNewBatchToStock($pID, $quantity, $purchaseUnit, $saleUnit, $batch, $barcode){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO stock (productID, quantity, purchaseUnit, saleUnit, batch, barcode) VALUES ('$pID', '$quantity', '$purchaseUnit', '$saleUnit', '$batch', '$barcode')";
		return $this->db->execute($sql);
	}
	public function addProductToInvoice($invID, $pID, $quantity, $batch, $purchaseUnit, $saleUnit, $pName, $cCatID, $pCatName, $pCatUnit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO invoice (invoiceID, productID, invoiceQuantity, invoiceBatch, invoicePurchase, invoiceSale, invoiceProductName, invoiceProductCategoryID, invoiceProductCategoryName, invoiceProductCategoryUnit) VALUES ('$invID', '$pID', '$quantity', '$batch', '$purchaseUnit', '$saleUnit', '$pName', '$cCatID', '$pCatName', '$pCatUnit')";

		return $this->db->execute($sql);
	}
	public function getQuantityExistingBatch($pID, $batch)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT quantity FROM stock WHERE productID='$pID' AND batch='$batch'";
		return $this->db->fetch($sql);
	}
	public function updateQuantityExistingBatch($pID, $batch,$q)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE stock SET quantity = '$q' WHERE productID='$pID' AND batch='$batch'";
		return $this->db->execute($sql);
	}








	//function invoice
	public function getAllInvoiceList($reqData)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT invoiceInfo.invoiceID, invoiceInfo.invoiceDate, invoiceInfo.invoiceTime, invoiceInfo.invoiceAmount, invoiceInfo.invoiceDiscount, invoiceInfo.invoiceStatus, invoiceInfo.userID,  supplierCustomer.scNameCompany, supplierCustomer.scContactNo, supplierCustomer.scAddress FROM invoiceInfo INNER JOIN supplierCustomer on invoiceInfo.scID = supplierCustomer.scID WHERE invoiceInfo.invoiceType = '$reqData'";
		return $this->db->fetch($sql);
	}
	public function getInvoiceList($reqData)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM invoice WHERE invoiceID='$reqData'";
		return $this->db->fetch($sql);
	}
	public function getInvoiceInfo($reqData)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT invoiceInfo.scID, invoiceInfo.invoiceID, invoiceInfo.invoiceDate, invoiceInfo.invoiceType, invoiceInfo.invoiceTime, invoiceInfo.invoiceAmount, invoiceInfo.invoiceDiscount, invoiceInfo.invoiceStatus, invoiceInfo.invoiceNote, invoiceInfo.userID,  supplierCustomer.scNameCompany, supplierCustomer.scContactNo, supplierCustomer.scAddress FROM invoiceInfo INNER JOIN supplierCustomer on invoiceInfo.scID = supplierCustomer.scID WHERE invoiceInfo.invoiceID = '$reqData'";
		return $this->db->fetch($sql);
	}
	public function getInvoicePaidAmount($reqData)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(trxAmount) as paid FROM transaction WHERE trxReference ='$reqData' AND trxType = 'invoice'";
		return $this->db->fetch($sql);
	}
	public function getSCInfo($reqData)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM supplierCustomer WHERE scID='$reqData'";
		return $this->db->fetch($sql);
	}
	
	//dashboard
	public function getTotalCashBalance()
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(trxAmount) as balance FROM transaction WHERE trxType='cash'";
		return $this->db->fetch($sql);
	}
	public function getTotalPaidSC($value)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(trxAmount) as paidTotal FROM transaction WHERE scID = '$value'";
		return $this->db->fetch($sql);
	}
	public function getTotalInvoiceSC($value)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(invoiceAmount - invoiceDiscount) as invoiceTotal FROM invoiceInfo WHERE scID = '$value'";
		return $this->db->fetch($sql);
	}
	public function getTotalStockQuantity($value)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(quantity) as quantity FROM stock WHERE productID = '$value'";
		return $this->db->fetch($sql);
	}
	
	
	
	
	
	
	
	
	
	
	
	public function getExpense(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM transaction WHERE trxType = 'expense' order by trxID desc";
		return $this->db->fetch($sql);
	}
	public function getExpenseAccountName($expenseAccountID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT accountName FROM account WHERE accountType = 'expense' AND accountID = '$expenseAccountID'";
		return $this->db->fetch($sql);
	}
	
	public function getAllExpenseCategory(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM account WHERE accountType = 'expense' order by accountID desc";
		return $this->db->fetch($sql);
	}
	public function isUniqueExpenseCategory($expenseName){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM account WHERE accountName = '$expenseName' AND accountType = 'expense'";
		return $this->db->fetch($sql);
	}
	public function addExpenseCategory($expenseName){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO account (accountName, accountType) VALUES ( '$expenseName', 'expense')";
		return $this->db->execute($sql);
	}
	public function addExpense($expenseCategory, $expenseAmount, $expenseNote){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sql = "INSERT INTO transaction (userID, trxDate, trxTime, trxType, trxReference, trxAmount, trxInfo) VALUES ( '$uID', '$date', '$time', 'expense', '$expenseCategory', '$expenseAmount', '$expenseNote')";
		return $this->db->execute($sql);
	}
	
	
	 
	
	
	public function getDrawings(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM transaction WHERE trxType = 'drawing' order by trxID desc";
		return $this->db->fetch($sql);
	}
	public function addDrawing($drawingAmount, $drawingNote){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sql = "INSERT INTO transaction (userID, trxDate, trxTime, trxType, trxAmount, trxInfo) VALUES ( '$uID', '$date', '$time', 'drawing', '$drawingAmount', '$drawingNote')";
		return $this->db->execute($sql);
	}
	
	
	public function getAllInvoices($type){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		if($type == 'all'){
			$sql = "SELECT * FROM invoiceInfo order by invoiceID desc";
		}else{
			$sql = "SELECT * FROM invoiceInfo WHERE invoiceType = '$type' order by invoiceID desc";
		}
		return $this->db->fetch($sql);
	}
	
	public function getSCInvoiceInfo($scID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM invoiceInfo WHERE scID = '$scID' order by invoiceID desc";
		return $this->db->fetch($sql);
	}
	
	public function getTotalPaidIndividualInvoice($value)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(trxAmount) as paidTotal FROM transaction WHERE trxType = 'invoice' and trxReference = '$value'";
		return $this->db->fetch($sql);
	}
  
  public function getTotalPaidIndividualInvoiceForDailyReport($value, $date)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(trxAmount) as paidTotal FROM transaction WHERE trxType = 'invoice' and trxReference = '$value' AND trxDate = '$date'";
		return $this->db->fetch($sql);
	}
	
	public function getSCTransaction($scID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM transaction WHERE scID = '$scID' order by trxID desc";
		return $this->db->fetch($sql);
	}
	public function addDeposit($scID, $advAmount, $advNote){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sql = "INSERT INTO transaction (userID, trxDate, trxTime, trxType, trxAmount, trxInfo, scID) VALUES ( '$uID', '$date', '$time', 'deposit', '$advAmount', '$advNote', '$scID')";
		return $this->db->execute($sql);
	}
	public function addWithdraw($scID, $wAmount, $wNote){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		$wAmount = $wAmount * (-1);
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sql = "INSERT INTO transaction (userID, trxDate, trxTime, trxType, trxAmount, trxInfo, scID) VALUES ( '$uID', '$date', '$time', 'withdraw', '$wAmount', '$wNote', '$scID')";
    //echo $sql."<br>";
		return $this->db->execute($sql);
	}

	
	//Invoice Return
		public function isStockExists($pID, $batch)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM stock WHERE productID = '$pID' AND batch='$batch'";
		return $this->db->fetch($sql);
	}
		public function isCategoryExists($cID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM category WHERE categoryID = '$cID'";
		return $this->db->fetch($sql);
	}
		public function isProductExists($pID)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM product WHERE productID = '$pID'";
		return $this->db->fetch($sql);
	}
		public function addCategoryForce($catID, $catName, $catUnit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO productCategory (categoryID, categoryName, categoryUnit) VALUES ('$catID', '$catName', '$catUnit')";
		return $this->db->execute($sql);
	}
	
		public function addProductForce($productID, $productName, $productDescription, $productCategoryID, $productLimit){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO product (productID, productName, productDescription, productLimit, productCategoryID) VALUES ('$productID', '$productName', '$productDescription', '$productLimit', '$productCategoryID')";
		return $this->db->execute($sql);
	}
	
	public function updateProductToInvoice($invID, $pID, $batch, $qty){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql ="UPDATE invoice SET invoiceQuantity = '$qty' WHERE invoiceID = '$invID' AND productID = '$pID' AND invoiceBatch = '$batch'";
		return $this->db->execute($sql);
	}
		public function updateQuantityExistingBatchReturn($pID, $batch,$q, $type)
	{
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		if($type=='sale'){
			$sql = "UPDATE stock SET quantity = quantity + '$q' WHERE productID='$pID' AND batch='$batch'";
		}else{
			$sql = "UPDATE stock SET quantity = quantity - '$q' WHERE productID='$pID' AND batch='$batch'";
		}
		
		return $this->db->execute($sql);
	}
	function updateInvoiceTotalReturn($invID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE invoiceInfo SET invoiceAmount = ( SELECT SUM( invoiceQuantity * invoiceSale ) FROM  invoice WHERE invoiceID ='$invID' ) WHERE invoiceID ='$invID'";
		return $this->db->execute($sql);
	}
	
	function updateInvoiceTotalPurchaseReturn($invID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE invoiceInfo SET invoiceAmount = ( SELECT SUM( invoiceQuantity * invoicePurchase ) FROM  invoice WHERE invoiceID ='$invID' ) WHERE invoiceID ='$invID'";
		return $this->db->execute($sql);
	}
	
	function updateInvoiceDiscount($invID, $dAmount){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE invoiceInfo SET invoiceDiscount = '$dAmount' WHERE invoiceID ='$invID'";
		return $this->db->execute($sql);
	}
	
	public function getExtraPaymentByInvoiceReturn($invID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT IF(invoiceAmount < invoiceDiscount, 0 ,  (invoiceAmount - invoiceDiscount)) - (SELECT sum(trxAmount) as paidTotal FROM transaction WHERE trxType = 'invoice' and trxReference = '$invID') as extraPayment FROM invoiceInfo WHERE invoiceID = '$invID'";
		return $this->db->fetch($sql);
	}
	
	
	
	//Settings
		public function changeLanguage($lang){
		$this->db->selectDB(DB_NAME);
		$userID =	$_SESSION['data']['userID'];
		$sql = "UPDATE  businessCredentials SET  language =  '$lang' WHERE  userID = '$userID'";
		return $this->db->fetch($sql);
	}
	
	//SMS
	public function getSMSTemplate(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM sms_template";
		return $this->db->fetch($sql);
	}
	public function getSMSText($smsID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM sms_template WHERE smsID = '$smsID'";
		return $this->db->fetch($sql);
	}
	public function getSMSBalance(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(quantity) as balance FROM smsLog";
		return $this->db->fetch($sql);
	}
		public function getSMSLog(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM smsLog inner JOIN supplierCustomer on smsLog.scID = supplierCustomer.scID ORDER BY smsNo DESC";
		return $this->db->fetch($sql);
	}
	
	public function addSMSLog($scID, $mobile, $smsText, $qty,$smslength){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$uID = $_SESSION['data']['userID'];
		$wAmount = $wAmount * (-1);
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sql = "INSERT INTO smsLog (scID, mobileNo, userID, smsDate, smsTime, text, quantity, byte) VALUES ('$scID', '$mobile', '$uID', '$date', '$time', '$smsText', -1, '$smslength')";
		return $this->db->execute($sql);
	}
	public function updateSMSMainServer($qty){
		$this->db->selectDB(DB_NAME);
		$businessID = $_SESSION['data']['businessID'];
		$sql = "UPDATE businessValidity SET sms = sms-'$qty' WHERE businessID = '$businessID'";
		return $this->db->fetch($sql);
	}
	//Report Section
	//SELECT sum((`invoiceSale`*`invoiceQuantity`)-(`invoicePurchase`*`invoiceQuantity`)) from invoice LEFT JOIN invoiceInfo ON invoice.invoiceID = invoiceInfo.invoiceID WHERE invoiceInfo.invoiceDate >= '2017-05-31' AND invoiceInfo.invoiceDate <= '2017-06-30' 
	//SELECT invoiceInfo.invoiceID , invoiceInfo.invoiceDate, (Select sum((`invoiceSale`*`invoiceQuantity`)-(`invoicePurchase`*`invoiceQuantity`)) from invoice WHERE invoice.invoiceID = invoiceInfo.invoiceID) from invoiceInfo LEFT JOIN invoice ON invoice.invoiceID = invoiceInfo.invoiceID 
	//Daily Profit: SELECT invoiceInfo.invoiceID, (SELECT sum((`invoiceSale`*`invoiceQuantity`)-(`invoicePurchase`*`invoiceQuantity`)) from invoice where invoice.invoiceID = invoiceInfo.invoiceID) from invoiceInfo;
	public function getDailyProfit($date){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT invoiceInfo.invoiceID, invoiceInfo.invoiceTime, sum(invoice.invoiceSale*invoice.invoiceQuantity) - sum(invoice.invoicePurchase*invoice.invoiceQuantity) - sum(invoiceInfo.invoiceDiscount) as profit, sum(invoice.invoiceSale*invoice.invoiceQuantity) - invoiceInfo.invoiceDiscount as totalSale from invoiceInfo inner join invoice on invoiceInfo.invoiceID = invoice.invoiceID where invoiceInfo.invoiceType='sale' AND invoiceInfo.invoiceDate = '$date' group by invoiceInfo.invoiceID";
		//$sql = "SELECT invoiceInfo.invoiceID, invoiceInfo.invoiceTime, (SELECT sum((`invoiceSale`*`invoiceQuantity`)-(`invoicePurchase`*`invoiceQuantity`))- invoiceInfo.invoiceDiscount from invoice where invoice.invoiceID = invoiceInfo.invoiceID) as profit from invoiceInfo where invoiceInfo.invoiceType='sale' AND invoiceInfo.invoiceDate = '$date'";
		//$sql = "SELECT * from productCategory";
		return $this->db->fetch($sql);
	}
  
  public function getPreviousInvoiceCollectionOnThisDate($date){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
    $sql = "SELECT * FROM `transaction` join invoiceInfo on transaction.trxReference = invoiceInfo.invoiceID where trxDate = '$date' AND invoiceDate != '$date' AND transaction.trxType = 'invoice' ORDER BY invoiceInfo.invoiceDate desc";
    return $this->db->fetch($sql);
  }
  
  
	public function getTotalSalePurchase($from, $to){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		//$sql = "SELECT invoiceInfo.invoiceDate, invoiceInfo.invoiceTime, (SELECT sum((`invoiceSale`*`invoiceQuantity`)-(`invoicePurchase`*`invoiceQuantity`))- invoiceInfo.invoiceDiscount from invoice where invoice.invoiceID = invoiceInfo.invoiceID) as profit from invoiceInfo where invoiceInfo.invoiceType='sale' AND (invoiceInfo.invoiceDate between '$from' AND '$to')";
		$sql = "SELECT invoiceInfo.invoiceDate, sum(invoice.invoiceSale*invoice.invoiceQuantity) as sale, sum(invoice.invoicePurchase*invoice.invoiceQuantity) as purchase, sum(invoiceInfo.invoiceDiscount) as discount, sum(invoice.invoiceSale*invoice.invoiceQuantity) - sum(invoice.invoicePurchase*invoice.invoiceQuantity) - sum(invoiceInfo.invoiceDiscount) as FinalProfit FROM invoiceInfo INNER JOIN invoice on invoiceInfo.invoiceID = invoice.invoiceID WHERE invoiceInfo.invoiceType = 'sale' AND invoiceInfo.invoiceDate BETWEEN '$from' AND '$to' GROUP BY invoiceInfo.invoiceDate";
		//$sql = "SELECT * from productCategory";
		return $this->db->fetch($sql);
	}

	public function getTotalDiscount($from, $to){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT invoiceInfo.invoiceDate, sum(invoiceInfo.invoiceDiscount) as discount FROM invoiceInfo WHERE invoiceInfo.invoiceType = 'sale' AND invoiceInfo.invoiceDate BETWEEN '$from' AND '$to' GROUP BY invoiceInfo.invoiceDate";
		return $this->db->fetch($sql);
	}

	public function getExpenseIncomeStatement($from, $to){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT trxDate, sum(trxAmount) as expense FROM transaction WHERE trxType = 'expense' AND trxDate BETWEEN '$from' AND '$to' GROUP BY trxDate";
		return $this->db->fetch($sql);
	}
	
	public function getSCBalance(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT supplierCustomer.scID as scID, supplierCustomer.scNameCompany, sum(transaction.trxAmount) as paid, (SELECT sum(invoiceInfo.invoiceAmount-invoiceInfo.invoiceDiscount) from invoiceInfo Where scID=supplierCustomer.scID) as expense, sum(transaction.trxAmount) -(SELECT sum(invoiceInfo.invoiceAmount-invoiceInfo.invoiceDiscount) as balance from invoiceInfo Where scID=supplierCustomer.scID) as balance FROM transaction inner join supplierCustomer on transaction.scID = supplierCustomer.scID WHERE supplierCustomer.scType='customer' GROUP BY supplierCustomer.scID";
		return $this->db->fetch($sql);
	}
	
	public function getProductBarcode(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT product.productID, product.productName, stock.saleUnit, stock.barcode FROM stock inner join product on stock.productID = product.productID";
		return $this->db->fetch($sql);
	}
	
	public function addEmployee($name, $contactNo, $dailySalary, $fine, $info){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO employee (empName, empPhone, empDailySalary, empFine, empInfo) VALUES ('$name', '$contactNo', '$dailySalary', '$fine', '$info')";
		return $this->db->execute($sql);
	}
	
	public function editEmployee($id, $name, $contactNo, $dailySalary, $fine, $info){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE employee SET empName = '$name', empPhone = '$contactNo', empDailySalary = '$dailySalary', empFine = '$fine', empInfo = '$info' WHERE empID = '$id'";
		return $this->db->execute($sql);
	}
	
	public function isUniqueEmployee($phone){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT count(*) as total from employee where empPhone='$phone'";
		return $this->db->fetch($sql);
	}
	
	public function getEmployee(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * from employee";
		return $this->db->fetch($sql);
	}
	
	public function getEmployeeInfo($eID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * from employee where empID='$eID'";
		return $this->db->fetch($sql);
	}
	
	public function getEmployeeBalance($eID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT sum(empTrxAmount) as balance from employeeTransaction where empID='$eID'";
		return $this->db->fetch($sql);
	}
	
	public function getEmployeeAttandance($eID, $date){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * from employeeAttandance where empID = '$eID' AND attandanceDate='$date' order by attandanceDate asc";
		return $this->db->fetch($sql);
	}
	
	public function getEmployeeAttandanceStatus($eID, $date){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT count(*) as t, attandanceType FROM employeeAttandance WHERE empID = '$eID' AND attandanceDate='$date'";
		return $this->db->fetch($sql);
	}
	
	public function addAttandance($eID, $date, $type){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "INSERT INTO employeeAttandance (empID, attandanceDate, attandanceType) VALUES ('$eID', '$date', '$type')";
		return $this->db->execute($sql);
	}	
	
	public function updateAttandance($eID, $date, $type){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "UPDATE employeeAttandance SET attandanceType='$type' WHERE empID='$eID' AND attandanceDate='$date'";
		return $this->db->execute($sql);
	}
	public function addEmployeeTransaction($eID, $amount, $note){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$user = $_SESSION['data']['userID'];
		date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sql = "INSERT INTO employeeTransaction (empID, empTrxDate, empTrxTime, empTrxAmount, empTrxNote, userID) VALUES ('$eID', '$date', '$time', '$amount', '$note', '$user')";
		return $this->db->execute($sql);
	}
	
	public function getEmployeeTrx($eID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM employeeTransaction WHERE empID = '$eID'";
		return $this->db->fetch($sql);
	}
	
	public function getEmployeeAttandanceList($eID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM employeeAttandance WHERE empID = '$eID'";
		return $this->db->fetch($sql);
	}
	
  public function getProductPurchaseHistoryForManager(){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM invoice join invoiceInfo on invoice.invoiceID = invoiceInfo.invoiceID where invoiceType = 'purchase'";
		return $this->db->fetch($sql);
	}
  
  /* Ledger SQL Start */
  public function getTotalSalesFromDateToDate($from, $to){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT invoiceDate,count(*) as salesNumber, sum(invoiceAmount) as sales, sum(invoiceDiscount) as discount, sum(invoiceAmount) - sum(invoiceDiscount) as TotalSales FROM `invoiceInfo` WHERE invoiceType = 'sale' AND invoiceInfo.invoiceDate BETWEEN '$from' AND '$to' GROUP BY invoiceDate";
		return $this->db->fetch($sql);
  }
  
  public function getCollenctionOnDate($date){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
    $sql = "select sum(trxAmount) as onDateCollection from transaction where transaction.trxType = 'invoice' AND transaction.trxDate = '$date' AND transaction.trxReference IN (SELECT invoiceID from invoiceInfo WHERE invoiceDate = '$date' AND invoiceType = 'sale')";
    return $this->db->fetch($sql);
  }
  public function getCollectionOtherDate($date){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
    $sql = "select sum(trxAmount) as otherDateCollection from transaction where transaction.trxType = 'invoice' AND transaction.trxDate = '$date' AND transaction.trxReference NOT IN (SELECT invoiceID from invoiceInfo WHERE invoiceDate = '$date')";
    return $this->db->fetch($sql);
  }
  
  public function getCostOfGoodsSold($date){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
    $sql = "SELECT sum(invoice.invoiceQuantity*invoice.invoicePurchase) as COGS, sum(invoice.invoiceQuantity*invoice.invoiceSale) as Sales, sum(invoice.invoiceQuantity*invoice.invoiceSale) - sum(invoice.invoiceQuantity*invoice.invoicePurchase) as Profit FROM invoiceInfo inner join invoice on invoiceInfo.invoiceID = invoice.invoiceID WHERE invoiceInfo.invoiceType = 'sale' AND invoiceInfo.invoiceDate = '$date'";
    return $this->db->fetch($sql);
  }
  
  public function getCostOfGoodsSoldByInvoice($invID){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
    $sql = "SELECT sum(invoice.invoiceQuantity*invoice.invoicePurchase) as COGS FROM invoice WHERE invoice.invoiceID = '$invID'";
    return $this->db->fetch($sql);
  }
  
  public function getSaleInvoiceInfoByDate($date){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
    $sql = "SELECT * FROM invoiceInfo WHERE invoiceInfo.invoiceType = '$invID'";
    return $this->db->fetch($sql);
  }
  
  /* Ledger SQL End */
  
  /* Individual Collection */
  
  public function getUserListForCollectionReport($bID){
		$this->db->selectDB(DB_NAME);
    $sql = "SELECT userID, name, rank, username FROM businessCredentials WHERE businessID = '$bID' AND password != '1062014'";
    return $this->db->fetch($sql);
  }
  
  public function getTrxByUserDateToDate($user, $from, $to){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
		$sql = "SELECT * FROM transaction inner join supplierCustomer on transaction.scID = supplierCustomer.scID where userID = '$user' AND trxType = 'invoice' and trxDate BETWEEN '$from' AND '$to' ORDER BY `trxID` ASC";
    return $this->db->fetch($sql);
  }
  
  /* Individual Collection */
  
  
  public function setActivity($page){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
    date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
    $dateTime = $date." ".$time;
    $uName = $_SESSION['data']['name'];
		$sql = "INSERT INTO activity_log ( `name`, `dateTime`, `page`) VALUES ( '$uName', '$dateTime', '$page')";
    return $this->db->fetch($sql);
  }
  
  
}