<?php
session_start();
include_once("functions/user_info_functions.php");


if (isset($_SESSION['approved']) && $_SESSION['approved']==1){
	//$userInfo = new UserInfo($_SESSION['id']);
	$userInfo = new UserInfo();
	$userInfo->getUserInfo($_SESSION['id']);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href=""/>
</head>
<body>
<div>

<?php
if(isset($_POST['username'])){
	foreach($_POST as $a){
		echo $a." ";
	}
	echo "POST";
	//echo userInfo.updateInfo($_POST);
}else{	
?>
<form action="" method="post">
		<label for="username">User name:</label>
		<input id="username" name="username" type="text" value="<?php echo $userInfo->getUserName();?>" tabindex="1">
		<label for="email">Email:</label>
		<input id="email" name="email" type="email" value="<?php echo $userInfo->getEmail();?>" tabindex="2">
		<label for="contact_no">Contact no.:</label>
		<input id="contact_no" name="contact_no" type="text" value="<?php echo $userInfo->getContact_no();?>" tabindex="3">
		<label for="oldPassword">Old password:</label>
		<input id="oldPassword" name="oldPassword" type="password" placeholder="old password" tabindex="4">
		<label for="newPassword">New password:</label>
		<input id="newPassword" name="newPassword" type="password" placeholder="new password" tabindex="5">
		<input id="updateSubmit" type="submit" value="Update Information">
</form>
<?php }?>
</div>
</body>
</html>
<?php 
}else{
	header("location:".$_SERVER['HTTP_REFERER']);
}?>