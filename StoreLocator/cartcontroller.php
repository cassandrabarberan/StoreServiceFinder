<?php 
require_once ("include/initialize.php"); 
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	addProduct();
	break;
	
	case 'edit' :
	doEdit();
	break; 
	
	case 'delete' :
	doDelete();
	break;

	case 'submitorder' :
	doSubmitOrder();
	break;
  
} 

function addProduct(){
global $mydb;
    $productID = $_POST['ProductID'];
	$sql ="SELECT * FROM tblproduct p, tblcategory c WHERE p.CategoryID=c.CategoryID AND ProductID = '{$productID}'";
	$mydb->setQuery($sql);
	$cur = $mydb->executeQuery();
	$maxrow = $mydb->num_rows($cur);

	if ($maxrow>0) {
		# code...
		$res = $mydb->loadSingleResult(); 
 

		$pid = $res->ProductID;
		$product = $res->ProductName . ' | ' . $res->Description . ' | '.$res->Categories;
		$price = $res->Price;
	 	$q = $_POST['QTY'.$pid];
		$subtotal = $price * $q;
		addtocart($pid,$product,$price,$q,$subtotal);
	}

	redirect("index.php?q=cart");
	
}
function doSubmitOrder(){
	global $mydb;

		$filename = UploadImage("Prescription");
		$Prescription = "photos/". $filename ;

		$autonum = New Autonumber();
		$res = $autonum->set_autonumber('ORDERNO');
		$orderno = $res->AUTO;

			$totalamount = 0;
			if (!empty($_SESSION['gcCart'])){   
			$count_cart = count($_SESSION['gcCart']); 
			for ($i=0; $i < $count_cart  ; $i++) { 

			$customerID = $_SESSION['CustomerID'];
			$productID = $_SESSION['gcCart'][$i]['productID'];
			$qty = $_SESSION['gcCart'][$i]['qty'];

				$sql = "UPDATE `tblstockin` SET Sold=1,Remaining=0,DateSold=Now() WHERE ProductID='{$productID}' AND ExpiredQty=0 AND `Remaining`>0 ORDER BY `DateExpire` ASC LIMIT {$qty}";
				$mydb->setQuery($sql);
				$mydb->executeQuery();
 

				$sql = "INSERT INTO `tblstockout`  (`CustomerID`, `ProductID`, `Quantity`, `DateSold`,OrderNO,HView,AttachmentFile,Remarks) VALUES('{$customerID}','{$productID}','{$qty}',Now(),'{$orderno}',1,'{$Prescription}','Your order is under process.')";
				$mydb->setQuery($sql);
				$mydb->executeQuery(); 

				$totalamount += $_SESSION['gcCart'][$i]['subtotal'];

			}

				$sql = "INSERT INTO `tblsummary` (`OrderNo`, `TotalAmount`, `TransDate`) VALUES ('{$orderno}','{$totalamount}',NOW())";
				$mydb->setQuery($sql);
				$mydb->executeQuery(); 

			$autonum = New Autonumber(); 
			$autonum->auto_update('ORDERNO');

			unset($_SESSION['gcCart']);

			message("Orders created successfully!", "success");

		    redirect("index.php?q=success");

		}
}

function UploadImage(){
	$target_dir = "admin/orders/photos/";
	$target_file = $target_dir . date("dmYhis") . basename($_FILES["Prescription"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	
	if($imageFileType != "jpg" || $imageFileType != "png" || $imageFileType != "jpeg"
|| $imageFileType != "gif" ) {
		 if (move_uploaded_file($_FILES["Prescription"]["tmp_name"], $target_file)) {
			return  date("dmYhis") . basename($_FILES["Prescription"]["name"]);
		}else{
			// echo "Error Uploading File";
			// exit;
		}
	}else{
			// echo "File Not Supported";
			// exit;
		}
} 

// if (isset($_POST['updateCart'])) {
// 	# code...  
// 	$productID=$_POST['ProductID']; 
// 	$qty=intval(isset($_POST['QTY']) ? $_POST['QTY'] : "");  
// 	editproduct($productID,$qty); 
      
// }

// if (isset($_POST['deleteCart'])) {
// 	# code...  
// 	$productID=$_POST['ProductID'];  
// 	removetocart($productID); 
      
// }
?>