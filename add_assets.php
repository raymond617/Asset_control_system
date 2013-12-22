<?php
	require_once 'class/Objects.php';
	require_once ('functions/system_function.php');
	session_start();
	if (checkLogined()==true){
		$object = $_SESSION['object'];
		if($object->getUserLevel() == 2){
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
<form action="functions/assetsProcessor.php" method="post">
	<label for="labID">Laboratory ID:</label>
	<input id="labID" name="labID" type="text" value="">
	<label for="name">Asset name:</label>
	<input id="name" name="name" type="text" value="" >
	<label for="assetID">Asset ID:</label>
	<input id="assetID" name="assetID" type="text" value="" >
	<label for="type">Asset type:</label>
	<input id="type" name="type" type="text" value="">
	<label for="days_b4_alert">Date before alert:</label>
	<input id="days_b4_alert" name="days_b4_alert" type="text" value="">
	<input id="action" name="add_asset" type="hidden" value="true">
	
	<input id="submit" type="submit" value="Add assets">
</form>
<div>

 </div>
</body>

</html>
<?php 
		}else{
			echo "You have no authorize\n redirect in 3 seconds";
			header('Refresh: 3;url=user_info.php');
		}
	}
?>		