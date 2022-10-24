<?php
require_once("../../include/initialize.php");
 if(!isset($_SESSION['ADMIN_USERID'])){
	redirect(web_root."admin/index.php");
}

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
 $title="Inbox"; 
 $header=$view; 
switch ($view) {
	case 'list' :
		$content    = 'message.php';		
		break; 
	case 'readmessage' :
		$content    = 'readmessage.php';		
		break; 
    case 'compose' :
		$content    = 'createmessage.php';		
		break;

	default :
		$content    = 'message.php';		
}
require_once ("../theme/templates.php");
?>
  
