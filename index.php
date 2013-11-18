<?php
 	session_start();
  	require('functions.php');
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
<div id="loginOut">
<?php if(!isset($_SESSION['approved']) || $_SESSION['approved']==0){?>
	<form action="login.php" method="post">
		<label for="id">OUID:</label>
		<input id="id" name="id" type="text" placeholder="OUID">
		<label for="id">Password:</label>
		<input id="password" name="password" type="password" placeholder="PASSWORD">
		<input id="loginSubmit" type="submit" value="Login">
	</form>
<?php }else if (isset($_SESSION['approved']) && $_SESSION['approved']==1){?>
	<form action="logout.php" method="get">
		<span>Welcome, <?php echo $_SESSION['username'];?></span>
		<p><input id="logout" type="submit" value="Logout">
		<a href="userInfo.php">change Information</a></p>
	</form>		
<?php }?>
</div>
</body>
</html>