<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/Asset_control_system/functions/connectDB.php');
$pdo = connectDB();

/*function getNewFormID() {
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
}*/

function formSubmit(array $userIDs, array $assets_id, $project_title, $professor_id, $course_code, $bench, $status,$start_time,$end_time) {
    global $pdo;
    //$newFormID=getNewFormID();
    $count=0;
    $stmt = $pdo->prepare('insert into appl_form (status,course_code,project_title,admin_id,prof_id) values (?,?,?,?,?)');
    $stmt2 = $pdo->prepare('insert into form_r_asset (form_id,asset_id,start_time,end_time,status) values (?,?,?,?,?)');
    $stmt3 = $pdo->prepare('insert into users_r_form (id,form_id) values (?,?)');
    try {
        if($stmt->execute(array( 'l', $course_code, $project_title, 10002000,$professor_id)) ==true){
            $count++;
        }
        $newID = $pdo->lastInsertId();
        foreach($userIDs as $value){
            $stmt3->execute(array($value,$newID));
            $count++;
        }
        foreach($assets_id as $value){
            $stmt2->execute(array($newID,$value,$start_time,$end_time,'l'));
            $count++;
        }
        if($stmt2->execute(array($newID,$bench,$start_time,$end_time,'l'))==true){
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
function listAllForms(){
    global $pdo;
    
}