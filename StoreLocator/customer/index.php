<?php 
require_once("../include/initialize.php");  
if (!isset($_SESSION['CustomerID'])) {
	# code...
	redirect(web_root.'index.php');
}
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
switch ($view) { 
	case 'orders' :
	    $title="Profile";	
        $_SESSION['orders']	='active' ; 
		$content ='profile.php';
		break;

	case 'notification' :
	    $title="Profile";	
        $_SESSION['notification']	='active' ; 
		$content ='profile.php';
		break; 
  
	case 'accounts' : 
	    $title="Profile";	
        $_SESSION['accounts']	='active' ;
        $content ='profile.php';
		break;
  
	case 'viewproduct' : 
	    $title="Profile";	
        $_SESSION['orders']	='active' ;
        $content ='profile.php';
		break;

	case 'wishlist' : 
	    $title="Profile";	
        $_SESSION['wishlist']	='active' ;
        $content ='profile.php';
		break;
	 
	default : 
	    $title="Profile";	 
		$content ='profile.php';		
}
require_once("../theme/templates.php");
?>