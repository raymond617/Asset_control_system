<?php
require_once ('../functions/system_function.php');
require_once ('../module/FormModule.php');
session_start();

/////////////////////////////////////////////////////


try {
    if(isset($_GET['search_form'])){
        $search_type = $_GET['search_type'];
        $input = $_GET['input'];
        try{
            if(strcmp($search_type,"form_id")==0){
                if(!checkFormApproval($input)){
                    echo "Still wait for approval";
                    header('Refresh: 3;url=../forms/lendingPage.php');
                }else if(strcmp(checkFormExpire($input),"notfound")==0){
                    echo "not existed";
                    header('Refresh: 3;url=../forms/lendingPage.php');
                }else if(checkFormExpire($input)==true){
                    echo "Form expired";
                    header('Refresh: 3;url=../forms/lendingPage.php');
                }else{
                    header('Location:../forms/lendingPage.php?form_id='.$input);
                }
            }else if(strcmp($search_type,"student_id")==0){
                header('Location:../forms/reserved_form.php?student_id='.$input);
            }
        }catch (Exception $e){
            //echo "Delete assets failed.\n";
            header('Location:../lendingPage.php');
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
