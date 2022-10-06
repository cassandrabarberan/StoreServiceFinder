<?php 
require_once("include/initialize.php"); 
$content='home.php';
$view = (isset($_GET['q']) && $_GET['q'] != '') ? $_GET['q'] : '';
switch ($view) { 
	case 'apply' :
        $title="Submit Application";	
		$content='applicationform.php';		
		break;
	case 'login' : 
        $title="Login";	
		$content='login.php';		
		break;
	case 'nearstore' :
        $title="Stores Near You";	
		$content='nearstore.php';		
		break;
	case 'viewroutes' :
        $title="Stores Near You";	
		$content='viewroutes.php';		
		break;
	case 'company' :
        $title="Stores";	
		$content='company.php';		
		break;
	case 'map' :
		$title = "Map"; 
		$content='map.php';		
		break;		
	case 'category' :
        $title='Search for Category';	
		$content='category.php';		
		break;	
	case 'checkout' :
        $title='Checkout';	
		$content='checkout.php';		
		break; 

	case 'products' :
        $title="Product Details";	
		$content='viewproduct.php';		
		break;

	case 'product' :
        $title="Products";	
		$content='product.php';		
		break;
	case 'success' :
        $title="Success";	
		$content='success.php';		
		break;
	case 'register/customer' :
        $title="Register New Membership";	
		$content='register.php';		
		break;
	case 'register/store' :
        $title="Register New Membership";	
		$content='registerstore.php';		
		break;
	case 'Contact' :
        $title='Contact Us';	
		$content='Contact.php';		
		break;	
	case 'About' :
        $title='About Us';	
		$content='About.php';		
		break;	
	case 'advancesearch' :
        $title='Advance Search';	
		$content='advancesearch.php';		
		break;	

	case 'result' :
		$search = isset($_POST['SEARCH']) ? $_POST['SEARCH'] : '';
        $title='Result for ' . $search;	
		// $content='advancesearchresult.php';		
		$content ='search_result.php';
		break;
	case 'item' :
        $title='View Items';	
		// $content='advancesearchresult.php';		
		$content ='viewstoreitem.php';
		break;

	case 'search/store' :
        $title='Search by Store';	
		$content='searchbystore.php';		
		break;	
	case 'search/category' :
        $title='Search by Category';	
		$content='searchbycategory.php';		
		break;	
	case 'search-jobtitle' :
        $title='Search by Job Title';	
		$content='searchbytitle.php';		
		break;	
	case 'cart' :
        $title='Cart';	
		$content='cart.php';		
		break;	 

	case 'terms' :
        $title='Terms and Condition';	
		$content='terms.php';		
		break;	

	default :
	    $active_home='active';
	    $title="Home";	
		$content ='home.php';		
}
require_once("theme/templates.php");
?>