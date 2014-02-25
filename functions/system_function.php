<?php
function checkLogined(){
	if (isset($_SESSION['approved']) && $_SESSION['approved']==1 && isset($_SESSION['object'])){
		return true;
	}else return false;
}
function rootPath(){
    return $_SERVER['DOCUMENT_ROOT']."/Asset_control_system/";
}
function checkWithIn2Times($start,$end,$timeToCheck){
    if($timeToCheck>=$start && $timeToCheck<=$end)
        return true;
    else
        return false;
}