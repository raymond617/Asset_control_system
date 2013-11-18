<?php
session_start();
require('functions.php');

class API {
	
private $pdo;
private $userName;
private $email;

	function __construct($config)
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
	}
	function checkIdPassword($id,$password){
		$stmt = $this->pdo->prepare('SELECT * FROM lts_users where id = ? AND password = ?');
		$stmt->execute(array($id,$password));
		$userInfoArray = $stmt->fetchAll();
		if(count($userInfoArray)>0){
			$this->userName = $userInfoArray[0]['username'];
			$this->email = $userInfoArray[0]['email'];
			if($array['level']==2){
				return 2;	
			}else{
				return 1;
			}
		}else{
			return 0;
		}
	}
	function getUserName() {
		return $this->userName;
	}
	function getEmail() {
		return $this->email;
	}
}
/////////////////////////////////////////////////////////////////
try
{
	$api = new API(returnDBInfo());

	if ($api->checkIdPassword($_POST["id"],$_POST["password"])==2) {
		$_SESSION['adminLoggedIn'] = 'true';
		$_SESSION['username']=$api->getUserName();
		$_SESSION['email']=$api->getEmail();
		$_SESSION['approved'] = 1;
		header("location: ./admin.php");
	} else if ($api->checkIdPassword($_POST["id"],$_POST["password"])== 1) {
			$_SESSION['username']=$api->getUserName();
			$_SESSION['email']=$api->getEmail();
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