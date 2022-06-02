<?php
include 'system/Model.php';
class mainModel extends Model
{
	public function loginVerify($login, $password)
    {
        $sql = "SELECT userID, name, phone, email, username, rank, language, businessID FROM businessCredentials WHERE (email = '$login' OR username = '$login' OR phone = '$login') AND password = '$password'";
        echo $sql;
		return $this->db->fetch($sql);
    }
	
	public function updatePassword($userID, $password)
    {
        $sql = "UPDATE businessCredentials SET password = '$password' WHERE userID = '$userID'";
		return $this->db->execute($sql);
    }
	
    public function getDBAndTimezome($bID)
    {
        $sql = "SELECT businessName, businessNameSMS, businessAddress, businessPhone, businessDBName, businessTimeZone, businessCurrency FROM businessInfo WHERE businessID = '$bID'";
        return $this->db->fetch($sql);
    }

    public function test(){
        $sql = "SELECT * FROM businessInfo";
        return $this->db->fetch($sql);
    }
    public function setPrimaryDB(){
        return $this->db->selectDB();
    }

    public function setSecondaryDB(){
        return $this->db->selectDB($_SESSION['data']['businessDBName']);
    }
    public function setActivity($name, $page){
		$this->db->selectDB($_SESSION['data']['businessDBName']);
    date_default_timezone_set($_SESSION['data']['businessTimeZone']);
		$date = date('Y-m-d');
		$time = date('H:i:s');
    $dateTime = $date." ".$time;
		$sql = "INSERT INTO activity_log ( `name`, `dateTime`, `page`) VALUES ( '$name', '$dateTime', '$page')";
     
    return $this->db->fetch($sql);
  }

  
}
