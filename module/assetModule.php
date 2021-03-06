<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/Asset_control_system/functions/connectDB.php');
$pdo = connectDB();

function addAssets($asset_id, $type, $status, $name, $days_b4_alert, $lab_id) {
    global $pdo;
    $stmt = $pdo->prepare('insert into assets (asset_id,type,status,name,days_b4_alert,lab_id) values (?,?,?,?,?,?)');
    try {
        if ($stmt->execute(array($asset_id, $type, $status, $name, $days_b4_alert, $lab_id)) == true) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        //echo $e;
        return FALSE;
    }
}

function getAssetsByID($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM assets where asset_id = ?');
    $stmt->execute(array($id));
    $assetInfoArray = $stmt->fetchAll();
    if (count($assetInfoArray) > 0)
        return $assetInfoArray;
    else
        return null;
}
function getAssetNameByID($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT name FROM assets where asset_id = ?');
    $stmt->execute(array($id));
    $assetInfoArray = $stmt->fetchAll();
    if (count($assetInfoArray) > 0)
        return $assetInfoArray;
    else
        return null;
}

function updateAsset($asset_id, $type, $status, $name, $days_b4_alert, $lab_id) {
    global $pdo;
    $stmt = $pdo->prepare('update assets set type=? , status=?, name=?, days_b4_alert=? ,lab_id=? where asset_id = ?');
    try {
        if ($stmt->execute(array($type, $status, $name, $days_b4_alert, $lab_id, $asset_id)) == true) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        //echo $e;
        return FALSE;
    }
}

function deleteAsset($asset_id) {
    global $pdo;
    $stmt = $pdo->prepare('delete from assets where asset_id =?');
    try {
        if ($stmt->execute(array($asset_id)) == true) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        //echo $e;
        return FALSE;
    }
}

function getBenchList() {
    global $pdo;
    $stmt = $pdo->prepare('SELECT asset_id,name FROM assets where type = ?');
    $stmt->execute(array("bench"));
    $benches = $stmt->fetchAll();
    if (count($benches) > 0)
        return $benches;
    else
        return null;
}
function getAssetTypesM(){
    global $pdo;
    $stmt = $pdo->prepare('SELECT DISTINCT type FROM assets where type <> "bench"');
    $stmt->execute();
    $types = $stmt->fetchAll();
    return $types;
}
function getAssetByTypes($types){
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM assets where type = ?');
    $stmt->execute(array($types));
    $assets = $stmt->fetchAll();
    return $assets;
}
function getBenchTimesList($id,$status){
    global $pdo;
    $stmt = $pdo->prepare('SELECT start_time, end_time
FROM `form_r_asset` f, assets a
WHERE f.status =?
AND a.type = "bench"
AND f.asset_id =?
AND a.asset_id = f.asset_id');
    $stmt->execute(array($status,$id));
    $benchTimeList = $stmt->fetchAll();
    return $benchTimeList;
}
function getAssetTimesList($id,$status){
    global $pdo;
    $stmt = $pdo->prepare('SELECT start_time, end_time
FROM `form_r_asset` f, assets a
WHERE f.status =?
AND f.asset_id =?
AND a.asset_id = f.asset_id');
    $stmt->execute(array($status,$id));
    $benchTimeList = $stmt->fetchAll();
    return $benchTimeList;
}

function getAssetWithSOP(array $asset_id){
    global $pdo;
    $ids = join(',',$asset_id);
    $stmt = $pdo->query('SELECT asset_id,name,sop FROM `assets` WHERE sop is not null and asset_id IN ('.$ids.')');
    $stmt->execute();
    $assetWithSOPList = $stmt->fetchAll();
    return $assetWithSOPList;
}
function getAssetReserveTime($id){
    global $pdo;
    $stmt = $pdo->prepare('SELECT start_time, end_time, status
FROM `form_r_asset`
WHERE asset_id =?');
    $stmt->execute(array($id));
    $benchTimeList = $stmt->fetchAll();
    return $benchTimeList;
}