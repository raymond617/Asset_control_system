<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
	require_once 'class/Objects.php';
	require_once ('functions/system_function.php');
 	session_start();
        if (checkLogined()==true && $_SESSION['object']->getUserLevel() == 3){
            $object = $_SESSION['object'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style  type="text/css">
#loginOut{
	float:right;
}
</style>
    </head>
    <body>
        <a href="add_assets.php">Add new asset</a>
        <?php include dirname(__FILE__)."/common_content/login_panel.php";	// div of login panel?>
    </body>
</html>
<?php
        }else{
            echo "must login as admin";
            header('Refresh: 3;url=index.php');
        }
?>