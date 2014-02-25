<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Asset_control_system/functions/connectDB.php');
$pdo = connectDB();
function addAssets($asset_id,$type,$status,$name,$days_b4_alert,$lab_id){
        global $pdo;
	$stmt = $pdo->prepare('insert into assets (asset_id,type,status,name,days_b4_alert,lab_id) values (?,?,?,?,?,?)');
        try{
            if($stmt->execute(array($asset_id,$type,$status,$name,$days_b4_alert,$lab_id))==true){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            //echo $e;
            return FALSE;
        }
}
function getAssetsByID($id){
        global $pdo;
	$stmt = $pdo->prepare('SELECT * FROM assets where asset_id = ?');
	$stmt->execute(array($id));
	$assetInfoArray = $stmt->fetchAll();
        if(count($assetInfoArray)>0)
            return $assetInfoArray;
        else
            return null;
}
function updateAsset($asset_id,$type,$status,$name,$days_b4_alert,$lab_id){
    global $pdo;
    $stmt = $pdo->prepare('update assets set type=? , status=?, name=?, days_b4_alert=? ,lab_id=? where asset_id = ?');
    try{
            if($stmt->execute(array($type,$status,$name,$days_b4_alert,$lab_id,$asset_id))==true){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            //echo $e;
            return FALSE;
        }
}
function getBenchList(){
    global $pdo;
	$stmt = $pdo->prepare('SELECT asset_id,name FROM assets where type = ?');
	$stmt->execute(array("bench"));
	$benches = $stmt->fetchAll();
        if(count($benches)>0)
            return $benches;
        else
            return null;
}