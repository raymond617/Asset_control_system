<?php

require_once ('../class/assetObject.php');
try {
    if ($_POST['add_asset']) {
        $assetGetArray = array('labID' => $_POST['labID'],
            'name' => $_POST['name'],
            'assetID' => $_POST['assetID'],
            'type' => $_POST['type'],
            'daysB4Alert' => $_POST['days_b4_alert'],
                'status'=>'U');
        $assetOject = assetObject::withRow($assetGetArray);
        if($assetOject->addAssetToDB() == true){
            echo 'add asset success!';
            header('Refresh: 3;url=add_assets.php');
        }
    }
} catch (Exception $e) {
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
    if ($message != ''){
        header('X-Error-Description: ' . $message);
    }
    exit;
}