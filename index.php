<?php
	require_once 'functions/Objects.php';
	require_once ('functions/system_function.php');
 	session_start();
	//require('functions/connectDB.php');
	//$db=connectDB();
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href=""/>
<style  type="text/css">
#loginOut{
	float:right;
}
</style>
</head>

<body>
<?php include dirname(__FILE__)."/common_content/login_panel.php";	// div of login panel?>

</body>
</html>