<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/Asset_control_system/functions/connectDB.php');
$pdo = connectDB();

/* function getNewFormID() {
  global $pdo;
  try {
  $stmt = $pdo->prepare("select max(form_id) from appl_form");
  $stmt->execute();
  $maxFormID = $stmt->fetch();
  $maxFormID++;
  return $maxFormID;
  } catch (Exception $e) {
  echo "retrive max form id fail";
  }
  } */

function formSubmit(array $userIDs, array $assets_id, $project_title, $professor_id, $course_code, $bench, $status, $start_time, $end_time) {
    global $pdo;
    //$newFormID=getNewFormID();
    $count = 0;
    $stmt = $pdo->prepare('insert into appl_form (status,course_code,project_title,admin_id,prof_id) values (?,?,?,?,?)');
    $stmt2 = $pdo->prepare('insert into form_r_asset (form_id,asset_id,start_time,end_time,status) values (?,?,?,?,?)');
    $stmt3 = $pdo->prepare('insert into users_r_form (id,form_id) values (?,?)');
    try {
        if ($stmt->execute(array('1', $course_code, $project_title, 10002000, $professor_id)) == true) {
            $count++;
        }
        $newID = $pdo->lastInsertId();
        foreach ($userIDs as $value) {
            $stmt3->execute(array($value, $newID));
            $count++;
        }
        foreach ($assets_id as $value) {
            $stmt2->execute(array($newID, $value, $start_time, $end_time, '1'));
            $count++;
        }
        if ($stmt2->execute(array($newID, $bench, $start_time, $end_time, '1')) == true) {
            $count++;
        }
        if ($count == 2 + count($userIDs) + count($assets_id))
            return true;
        else {
            return false;
        }
    } catch (PDOException $e) {
        //echo $e;
        return FALSE;
    }
}

function listAllForms() {
    global $pdo;
    $stmt = $pdo->prepare('select * from appl_form ORDER BY `apply_timestamp` 
LIMIT 0 , 30');
    $stmt->execute();
    $FormInfoArray = $stmt->fetchAll();
    $fullFormArray = array();
    foreach ($FormInfoArray as $row) {
        $one_column = $row;
        $userArray = listAllUsersFromForm($row['form_id']);
        $AssetArray = listAllAssetsFromFormWithoutBench($row['form_id']);
        $bench = findTheBenchFromForm($row['form_id']);
        $one_column['user_array'] = $userArray;
        $one_column['asset_array'] = $AssetArray;
        $one_column['bench'] = $bench;
        array_push($fullFormArray, $one_column);
    }
    return $fullFormArray;
}

function listAllUsersFromForm($form_id) {
    global $pdo;
    $stmt = $pdo->prepare('select id from users_r_form where form_id =?');
    $stmt->execute(array($form_id));
    $userIDArray = $stmt->fetchAll();
    return $userIDArray;
}

function listAllAssetsFromFormWithoutBench($form_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT f.form_id, f.asset_id, f.start_time, f.end_time, f.status, a.name
FROM form_r_asset f, assets a
WHERE f.asset_id = a.asset_id
AND form_id =?
AND a.type <> "bench"
LIMIT 0 , 30');
    $stmt->execute(array($form_id));
    $AssetInfoArray = $stmt->fetchAll();
    return $AssetInfoArray;
}

function findTheBenchFromForm($form_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT f.asset_id, a.name,f.start_time,f.end_time from assets a, form_r_asset f where f.asset_id = a.asset_id and type = "bench" and form_id = ?');
    $stmt->execute(array($form_id));
    $bench = $stmt->fetchAll();
    return $bench;
}

function showOneForm($form_id) {
    global $pdo;
    $stmt = $pdo->prepare('select * from appl_form where form_id = ?');
    $stmt->execute(array($form_id));
    $FormInfo = $stmt->fetchAll();
    $OneFormInfo = $FormInfo[0];
    $userArray = listAllUsersFromForm($OneFormInfo['form_id']);
    $AssetArray = listAllAssetsFromFormWithoutBench($OneFormInfo['form_id']);
    $bench = findTheBenchFromForm($OneFormInfo['form_id']);
    $OneFormInfo['user_array'] = $userArray;
    $OneFormInfo['asset_array'] = $AssetArray;
    $OneFormInfo['bench'] = $bench;
    return $OneFormInfo;
}
function showOneFormDetail($form_id){
    global $pdo;
    $stmt = $pdo->prepare('select * from appl_form where form_id = ?');
    $stmt->execute(array($form_id));
    $FormInfo = $stmt->fetchAll();
    $OneFormInfo = $FormInfo[0];
    $userArray = listAllUsersFromForm($OneFormInfo['form_id']);
    $AssetArray = listAllAssetsFromFormWithoutBench($OneFormInfo['form_id']);
    $bench = findTheBenchFromForm($OneFormInfo['form_id']);
    $OneFormInfo['user_array'] = $userArray;
    $OneFormInfo['asset_array'] = $AssetArray;
    $OneFormInfo['bench'] = $bench;
    return $OneFormInfo;
}
function deleteFormM($form_id){
    
}
