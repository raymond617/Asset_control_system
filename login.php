<?php
session_start();
require('functions/connectDB.php');

class API {
	
	private $pdo;
	private $userName;
	private $email;
	private $id;
	function __construct(){
		$this->pdo = connectDB(); //get the connection
	}
	/*function __construct($config)
	{
		try{
			// Create a connection to the database.
			$this->pdo = new PDO(
			       'mysql:host=' .$config['db']['host'].';
				    dbname=' .$config['db']['dbname'], 
					$config['db']['username'],
					$config['db']['password'],
					array());
	
			// If there is an error executing database queries, we want PDO to
			// throw an exception. Our exception handler will then exit the script
			// with a "500 Server Error" message.
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			// We want the database to handle all strings as UTF-8.
			$this->pdo->query('SET NAMES utf8');
	
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}*/
	function checkIdPassword($id,$password){
		$stmt = $this->pdo->prepare('SELECT * FROM lts_users where id = ? AND password = ?');
		$stmt->execute(array($id,$password));
		$userInfoArray = $stmt->fetchAll();
		if(count($userInfoArray)>0){
			$this->userName = $userInfoArray[0]['username'];
			$this->email = $userInfoArray[0]['email'];
			$this->id = $userInfoArray[0]['id'];
			if($array['level']==2){
				return 2;	//admin level
			}else{
				return 1;	//user level
			}
		}else{
			return 0; 		//login fail
		}
	}
	function getUserName() {
		return $this->userName;
	}
	function getEmail() {
		return $this->email;
	}
	function getId(){
		return $this->id;
	}
}
/////////////////////////////////////////////////////////////////
try
{
	//$api = new API(returnDBInfo());
	$api = new API();
	
	if ($api->checkIdPassword($_POST["id"],$_POST["password"])==2) {
		$_SESSION['adminLoggedIn'] = 'true';
		$_SESSION['username']=$api->getUserName();
		$_SESSION['email']=$api->getEmail();
		$_SESSION['id']=$api->getId();
		$_SESSION['approved'] = 1;
		header("location: ./admin.php");
	} else if ($api->checkIdPassword($_POST["id"],$_POST["password"])== 1) {
			$_SESSION['username']=$api->getUserName();
			$_SESSION['email']=$api->getEmail();
			$_SESSION['id']=$api->getId();
			$_SESSION['approved'] = 1;
			header("location:".$_SERVER['HTTP_REFERER']);
	} else {
			$_SESSION['approved'] = 0;
			header("location:".$_SERVER['HTTP_REFERER']);
	}
	
}
catch (Exception $e)
{
	exitWithHttpError(500);
}
function exitWithHttpError($error_code, $message = '')
{
	switch ($error_code)
	{
		case 400: header("HTTP/1.0 400 Bad Request"); break;
		case 403: header("HTTP/1.0 403 Forbidden"); break;
		case 404: header("HTTP/1.0 404 Not Found"); break;
		case 500: header("HTTP/1.0 500 Server Error"); break;
	}

	header('Content-Type: text/plain');

	if ($message != '')
	header('X-Error-Description: ' . $message);

	exit;
}