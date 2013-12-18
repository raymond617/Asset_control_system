<?php
require('../functions/connectDB.php');
$pdo = connectDB();
function addAssets(){
	
}
function getAssetsByID($id){
	$stmt = $pdo->prepare('SELECT * FROM assets where id = ?');
	$stmt->execute(array($this->id));
	$assetInfoArray = $stmt->fetchAll();
	return $assetInfoArray;
}