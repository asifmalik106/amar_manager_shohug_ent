<?php
class SMS{
  
  public static function verifySMS($smsID, $data){
    $loadSMS = new Load();
    $loadSMS->model('adminModel');
		$smsModel = new adminModel();
    $smsBalance = $smsModel->getSMSBalance()->fetch_assoc()['balance'];
    if($smsBalance > 0){
      if($smsID == 1){
        $shopName = $_SESSION['data']['businessNameSMS'];
        $invoiceInfo = $smsModel->getInvoiceInfo($data)->fetch_assoc();
        $scID = $invoiceInfo['scID'];
        $date = date("d/m/Y", strtotime($invoiceInfo['invoiceDate']));
        $time  = date("g:iA", strtotime($invoiceInfo['invoiceTime']));
        $total  = sprintf("%.2f",  ($invoiceInfo['invoiceAmount'] - $invoiceInfo['invoiceDiscount']));
        $paid = sprintf("%.2f",  $smsModel->getInvoicePaidAmount($data)->fetch_assoc()['paid']);
        $due = sprintf("%.2f",  $total - $paid);
        $smsText = $smsModel->getSMSText($smsID)->fetch_assoc()['smsTemplate'];
        $smsText = str_replace("#SHOPNAME#", $shopName, $smsText);
        $smsText = str_replace("#INV_NO#", $data , $smsText);
        $smsText = str_replace("#TIME#", $time , $smsText);
        $smsText = str_replace("#DATE#", $date , $smsText);
        $smsText = str_replace("#TOTAL#", $total , $smsText);
        $smsText = str_replace("#PAID#", $paid , $smsText);
        $smsText = str_replace("#DUE#", $due , $smsText);
        echo $smsText;
        
        $receipent = $smsModel->getSCInfo($scID)->fetch_assoc()['scContactNo'];
        
        $result = (int)self::sendSMS($receipent, $smsText);
        $qty = 0;
        if($result==1900){
          $qty = (int)(strlen($smsText)/160)+1;
          $result = "success";
        }else if($result==1903){
          $result = "contact";
        }else if($result==1905){
          $result = "invalid";
        }
        
        $log = $smsModel->addSMSLog($scID,$receipent, $smsText, $qty, strlen($smsText));
        $smsModel->updateSMSMainServer($qty);
        echo $result;
      }else if($smsID == 2){
        
      }else if($smsID == 3){
        $shopName = $_SESSION['data']['businessNameSMS'];
        $invoiceInfo = $smsModel->getInvoiceInfo($data)->fetch_assoc();
        $scID = $invoiceInfo['scID'];
        $date = date("d/m/Y", strtotime($invoiceInfo['invoiceDate']));
        $time  = date("g:iA", strtotime($invoiceInfo['invoiceTime']));
        $total  = $invoiceInfo['invoiceAmount'] - $invoiceInfo['invoiceDiscount'];
        $paid = $smsModel->getInvoicePaidAmount($data)->fetch_assoc()['paid'];
        $due = $total - $paid;
        $smsText = $smsModel->getSMSText($smsID)->fetch_assoc()['smsTemplate'];
        $smsText = str_replace("#SHOPNAME#", $shopName, $smsText);
        $smsText = str_replace("#INV_NO#", $data , $smsText);
        $smsText = str_replace("#TIME#", $time , $smsText);
        $smsText = str_replace("#DATE#", $date , $smsText);
        $smsText = str_replace("#TOTAL#", $total , $smsText);
        $smsText = str_replace("#PAID#", $paid , $smsText);
        $smsText = str_replace("#DUE#", $due , $smsText);
        echo $smsText;
        
        $receipent = $smsModel->getSCInfo($scID)->fetch_assoc()['scContactNo'];
        
        $result = (int)self::sendSMS($receipent, $smsText);
        $qty = 0;
        if($result==1900){
          $qty = (int)(strlen($smsText)/160)+1;
          $result = "success";
        }else if($result==1903){
          $result = "contact";
        }else if($result==1905){
          $result = "invalid";
        }
        
        $log = $smsModel->addSMSLog($scID,$receipent, $smsText, $qty, strlen($smsText));
        
        echo $result;
      }
    }
    return 0;
    //print_r($dashModel->getSMSTemplate()->fetch_assoc());
  }
  
  
  private static function sendSMS($phone, $text){
    try
    {
      $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl"); 
      $paramArray = array(
        'userName'=>"01770810050",
        'userPassword'=>"74606", 
        'mobileNumber'=> $phone, 
        'smsText'=>$text,
        'type'=>"TEXT",
        'maskName'=> "", 
        'campaignName'=>'',
      );
      $value = $soapClient->__call("OneToOne", array($paramArray));
      echo "<pre>";
      var_dump($value);
      echo "</pre>";
      
      echo "<pre>";
      var_dump($value);
      echo "</pre>";
      
      $result = str_split($value->OneToOneResult, 4);
      return $result[0];

    }
    catch (Exception $e) {
    echo $e;
    }
  }
}