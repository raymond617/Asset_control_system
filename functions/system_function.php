<?php
function checkLogined(){
	if (isset($_SESSION['approved']) && $_SESSION['approved']==1 && isset($_SESSION['object'])){
		return true;
	}else return false;
}