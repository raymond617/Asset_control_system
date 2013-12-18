<?php
session_start();
class A{
	private $id;
	public function __construct($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}
}
class B extends A{
	private $name;
	public function __construct($id,$name){
		parent::__construct($id);
		$this->name = $name;
	}
	public function getName(){
		return $this->name;
	}
}
$user = new B(12345,"John");
$_SESSION['user']= $user;
$_SESSION['class'] = "year 4";
$test = $_SESSION['user'];
/*$_SESSION['user']= serialize($user);

$test = unserialize($_SESSION['user']);*/
var_dump($_SESSION);
echo $test->getName();
echo "<a href=\"test2.php\">next</a>";
?>