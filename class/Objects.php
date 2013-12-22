<?php
//require(__DIR__.'/../functions/connectDB.php');
require_once ('/../functions/connectDB.php');
abstract class UserInfo{
	//private $pdo;
	private $email;
	private $contact_no;
	private $username;
	private $password;
	private $id;
	private $user_type;
	private $user_level;

	public function __construct($id){
		//$this->pdo = connectDB(); //get the connection
		$this->id = $id;
		$this->getUserInfo(connectDB());
	}
	public function getUserInfo($pdo){
		$stmt = $pdo->prepare('SELECT * FROM lts_users where id = ?');
		$stmt->execute(array($this->id));
		$userInfoArray = $stmt->fetchAll();
		if(count($userInfoArray)>0){
			$this->username = $userInfoArray[0]['username'];
			$this->email = $userInfoArray[0]['email'];
			$this->contact_no = $userInfoArray[0]['contact_no'];
			$this->password = $userInfoArray[0]['password'];
			$this->user_type = $userInfoArray[0]['user_type'];
			$this->user_level = $userInfoArray[0]['user_level'];
		}
	}
	public function getID(){
		return $this->id;
	}
	public function getUserName(){
		return $this->username;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getContact_no(){
		return $this->contact_no;
	}
	public function getPassword(){
		return $this->password;
	}
	public function changePassword($oldPassword,$newPassword,$confirmPassword){
		if(strcmp($oldPassword,$this->password)==0 && strcmp($newPassword,$confirmPassword)==0){
			$pdo = connectDB();
			$stmt = $pdo->prepare('update lts_users set password = ? where id =?');
			$stmt->execute(array($newPassword,$this->id));
			$this->getUserInfo(connectDB()); // for renew the session
			return true;
		}else{
			return false;
		}
	}
	public function updateInformation($name,$email,$contact){
		$pdo = connectDB();
		$stmt = $pdo->prepare('update lts_users set username = ?,email=?,contact_no=? where id =?');
		if($stmt->execute(array($name,$email,$contact,$this->id))==true){
			$this->getUserInfo(connectDB()); // for renew the session
			return true;
		}else
			return false;
	}
	public function getUserType(){
		return $this->user_type;
	}
	public function getUserLevel(){
	return $this->user_level;
	}
	
}
/////////////////////////////
/*
 try{
$userInfo = new UserInfo();
echo "print something \n";
echo $_SESSION['id'];

}catch(Exception $a){
echo "failed";

}
*/
class AdminObject extends UserInfo{
	public function __construct($id){
		parent::__construct($id);
	}
	

}
class TeacherObject extends UserInfo{
	public function __construct($id){
		parent::__construct($id);
	}

}
class UserObject extends UserInfo{
	public function __construct($id){
		parent::__construct($id);
	}
	
}
?>