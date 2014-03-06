<?php
require_once ('../functions/system_function.php');
require_once ('../module/FormModule.php');
session_start();

/////////////////////////////////////////////////////


try {
    if (isset($_POST['experiment_reservation'])) {
        $project_title = $_POST['project_title'];
        $professor_id = $_POST['professor_id'];
        $course_code = $_POST['course_code'];
        $bench = $_POST['bench'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];        
        $student_id_list = $_POST['studID'];
        $asset_list = $_POST['asset'];
        try{
            if(formSubmit($student_id_list, $asset_list, $project_title, $professor_id, $course_code, $bench,'l',$start_time,$end_time)==true){
                echo 'Form submit success!';
                header('Refresh: 3;url=../forms/experiment_reservation_form.php');
            }else{
                echo 'Form submit fail!<br> error occur.';
                header('Refresh: 3;url=../forms/experiment_reservation_form.php');
            }
        }catch (Exception $e){
            echo "Create object failed.\n";
        
        }
        /*foreach ($student_id_list as $key){
            echo $key."<br>";
        }
        echo $start_time."<br>";
        echo $end_time."<br>";
        
        $ts_start=  strtotime($start_time);
        echo $ts_start."<br>";
        $ts_end=  strtotime($end_time);
        echo $ts_end."<br>";
        */
    }else if(isset($_POST['row_selected'])){
        $list_of_forms = $_POST['row_selected'];
        try{
            foreach($list_of_assets as $value){
                $_SESSION['object']::deleteAsset($value);   
            }
                //echo 'delete assets success!';
                header('Location:../edit_asset.php');
        }catch (Exception $e){
            //echo "Delete assets failed.\n";
            header('Location:../edit_asset.php');
        }
    }else if(isset($_POST['form_approve'])){
        $form_id = $_POST['formID'];
        //$student_id_list = $_POST['studID'];
        $project_title = $_POST['project_title'];
        //$appl_time = $_POST['appl_time'];
        $course_code = $_POST['course_code'];
        //$professor_id = $_POST['professor_id'];
        $asset_list = $_POST['asset'];
        $status = $_POST['status'];
        $bench = $_POST['bench'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];  
        try{
            if(edit_and_approveForm($form_id,$project_title,$course_code,$asset_list,$status,$bench,$start_time,$end_time)==TRUE){
                echo 'Form approve success!';
                header('Refresh: 3;url=../form_approve_management.php');
            }else{
                echo 'Form approve fail!<br> error occur.';
                header('Refresh: 3;url=../form_approve_management.php');
            }
        }catch (Exception $e){
            echo "module process fail\n";
        
        }
    }
} catch (Exception $e) {
    echo "Exception.\n";
    exitWithHttpError(500);
}

function exitWithHttpError($error_code, $message = '') {
    switch ($error_code) {
        case 400: header("HTTP/1.0 400 Bad Request");
            break;
        case 403: header("HTTP/1.0 403 Forbidden");
            break;
        case 404: header("HTTP/1.0 404 Not Found");
            break;
        case 500: header("HTTP/1.0 500 Server Error");
            break;
    }

    header('Content-Type: text/plain');

    if ($message != '')
        header('X-Error-Description: ' . $message);

    exit;
}
