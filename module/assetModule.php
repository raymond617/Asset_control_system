<?php
require_once('../functions/connectDB.php');
$pdo = connectDB();
function addAssets($asset_id,$type,$status,$name,$days_b4_alert,$lab_id){
	$stmt = $pdo->prepare('insert into assets (asset_id,type,status,name,days_b4_alert,lab_id) values (?,?,?,?,?,?)');
        if($stmt->execute(array($asset_id,$type,$status,$name,$days_b4_alert,$lab_id))==true){
            return true;
        }else
            return false;
}
function getAssetsByID($id){
	$stmt = $pdo->prepare('SELECT * FROM assets where id = ?');
	$stmt->execute(array($this->id));
	$assetInfoArray = $stmt->fetchAll();
        if(count($assetInfoArray)>0)
            return $assetInfoArray;
        else
            return null;
}