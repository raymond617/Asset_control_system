<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/Asset_control_system/functions/connectDB.php');
$pdo = connectDB();

function getNewFormID() {
    global $pdo;
    try {
        $stmt = $pdo->prepare("select max(form_id) from appl_form");
        $stmt->execute();
        $maxFormID = $stmt->fetch();
        $maxFormID = $maxFormID + 1;
        return $maxFormID;
    } catch (Exception $e) {
        echo "retrive max form id fail";
    }
}

function formSubmit(array $userIDs, array $assets_id, $project_title, $professor_id, $course_code, $bench, $timestamp, $status,$start_time,$end_time) {
    global $pdo;
    $newFormID=getNewFormID();
    $count=0;
    $stmt = $pdo->prepare('insert into appl_form (form_id,apply_timestamp,status,course_code,project_title,admin_id,prof_id) values (?,?,?,?,?,?,?)');
    $stmt2 = $pdo->prepare('insert into form_r_asset (form_id,asset_id,start_time,end_time,status) values (?,?,?,?,?)');
    $stmt3 = $pdo->prepare('insert into users_r_form (id,form_id) values (?,?)');
    try {
        if($stmt->execute(array($newFormID, time(), 'l', $course_code, $project_title, 10002000,$professor_id)) ==true){
            $count++;
        }
        foreach($userIDs as $value){
            $stmt3->execute(array($value,$newFormID));
            $count++;
        }
        foreach($assets_id as $value){
            $stmt2->execute(array($newFormID,$value,$start_time,$end_time,'l'));
            $count++;
        }
        if($stmt2->execute(array($newFormID,$bench,$start_time,$end_time,'l'))==true){
            $count++;
        }
        if($count == 2+count($userIDs)+count($assets_id))    
            return true;
         else {
            return false;
        }
    } catch (PDOException $e) {
        //echo $e;
        return FALSE;
    }
}
