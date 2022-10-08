
<?php
require_once ("../../include/initialize.php");
 	 if (!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     }


$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;
	
	case 'delete' :
	doDelete();
	break;

 
	}
   
	function doInsert(){
		global $mydb;
		if(isset($_POST['save'])){

 // `COMPANYNAME`, `COMPANYADDRESS`, `COMPANYCONTACTNO`
		if ( $_POST['StoreName'] == "" || $_POST['StoreAddress'] == "" || $_POST['ContactNo'] == "" ) {
			$messageStats = false;
			message("All field is required!","error");
			redirect('index.php?view=add');
		}else{	
			$store = New Store();
			$store->StoreName		= $_POST['StoreName'];
			$store->StoreAddress	= $_POST['StoreAddress'];
			$store->ContactNo	= $_POST['ContactNo']; 
			$store->lat	= $_POST['lat']; 
			$store->lng	= $_POST['lng']; 
			$store->create();

			$storID = $mydb->insert_id();

			$user = New User();
			$user->UserID 			= $storID;
			$user->FullName 		= $_POST['StoreName'];
			$user->Username			= $_POST['StoreName'];
			$user->Password			= sha1($_POST['StoreName']);
			$user->Role				="Store";
			$user->create();

			message("New store created successfully!", "success");
			redirect("index.php");
			
		}
		}

	}

	function doEdit(){
		if(isset($_POST['save'])){

			$store = New Store();
			$store->StoreName		= $_POST['StoreName'];
			$store->StoreAddress	= $_POST['StoreAddress'];
			$store->ContactNo	= $_POST['ContactNo']; 
			$store->lat	= $_POST['lat']; 
			$store->lng	= $_POST['lng']; 
			$store->update($_POST['StoreID']);

			$user = New User(); 
			$user->FullName 		= $_POST['StoreName'];
			$user->Username			= $_POST['StoreName'];
			$user->Password			= sha1($_POST['StoreName']);
			$user->Role				="Store";
			$user->update($_POST['StoreID']);

			message("Store has been updated!", "success");
			redirect("index.php");
		}

	}


	function doDelete(){
		global $mydb;
		// if (isset($_POST['selector'])==''){
		// message("Select a records first before you delete!","error");
		// redirect('index.php');
		// }else{

			$id = $_GET['id'];

			$store = New Store();
			$store->delete($id);

			$user = New User();
			$user->delete($id);

			$sql = "SELECT * FROM `tblproduct` WHERE `StoreID`=".$id;
			$mydb->setQuery($sql);
			$cur = $mydb->loadSingleResult();

			$pid = $cur->ProductID;

		    $sql = "DELETE FROM `tblproduct`  WHERE ProductID=".$pid;
			$mydb->setQuery($sql);
			$mydb->executeQuery();


			$sql = "DELETE FROM `tblstockin`  WHERE ProductID=".$pid;
			$mydb->setQuery($sql);
			$mydb->executeQuery();

			$sql = "DELETE FROM `tblstockout`  WHERE ProductID=".$pid;
			$mydb->setQuery($sql);
			$mydb->executeQuery();


			message("Store has been Deleted!","info");
			redirect('index.php');

		// $id = $_POST['selector'];
		// $key = count($id);

		// for($i=0;$i<$key;$i++){

		// 	$category = New Category();
		// 	$category->delete($id[$i]);

		// 	message("Category already Deleted!","info");
		// 	redirect('index.php');
		// }
		// }
		
	}
?>