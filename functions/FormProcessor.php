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
    }/*else if(isset($_GET['search_form'])){
        $search_type = $_GET['search_type'];
        $input = $_GET['input'];
        try{
            if(strcmp($search_type,"form_id")==0){
                if(checkFormExpire($input)==true){
                    echo "Form expired";
                    header('Refresh: 3;url=../forms/lendingPage.php');
                }else{
                    header('Location:../forms/lendingPage.php?form_id='.$input);
                }
            }else if(strcmp($search_type,"id")==0){
                header('Location:../forms/reserved_form.php?student_id='.$input);
            }
        }catch (Exception $e){
            //echo "Delete assets failed.\n";
            header('Location:../lendingPage.php');
        }
    }*/
    else if(isset($_POST['lent'])){
        $asset_list = $_POST['asset'];
        $status = $_POST['status'];
        $form_id = $_POST['formID'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $bench = $_POST['bench'];
        try{
            if(lendingAsset($form_id,$asset_list,$start_time,$end_time,$bench)==TRUE){
                echo 'lending success!';
                header('Refresh: 3;url=../forms/lendingPage.php');
            }else{
                echo 'Lending fail!<br> error occur.';
                header('Refresh: 3;url=../forms/lendingPage.php');
            }
        }catch (Exception $e){
            echo "module process fail\n";
        
        }
    }
    else if(isset($_GET['delete_form'])){
        $form_id = $_GET['form_id'];
        try{
            if(deleteFormM($form_id)==true){
                echo 'Delete form success!';
                header('Refresh: 3;url=../form_management.php');
            }else{
                echo 'Delete form fail!';
                header('Refresh: 3;url=../form_management.php');
            }
        }catch (Exception $e){
            echo "module fail.\n";
            header('Location:../form_management.php');
        }
    }else if(isset($_POST['return'])){
        $asset_id = $_POST['asset_id'];
        if(returnAsset($asset_id)==true){
            echo 'Asset id:'.$asset_id.' return success !';
            header('Refresh: 3;url=../forms/returnPage.php');
        }else{
            echo 'Asset id:'.$asset_id.' return fail !';
            header('Refresh: 3;url=../forms/returnPage.php');
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
