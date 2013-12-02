<?php
require('connectDB.php');
class UserInfo{
	private $pdo;
	private $email;
	private $contact_no;
	private $username;
	private $password;


	public function __construct(){
		$this->pdo = connectDB(); //get the connection
		//$this->getUserInfo();
	}
	public function getUserInfo($id){
		$stmt = $this->pdo->prepare('SELECT * FROM lts_users where id = ?');
		$stmt->execute(array($id));
		$userInfoArray = $stmt->fetchAll();
		if(count($userInfoArray)>0){
			$this->username = $userInfoArray[0]['username'];
			$this->email = $userInfoArray[0]['email'];
			$this->contact_no = $userInfoArray[0]['contact_no'];
			$this->password = $userInfoArray[0]['password'];
		}
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
	//function updateInfo($input){

	//}
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
?>
