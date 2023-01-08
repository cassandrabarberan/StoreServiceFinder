<?php
require_once ("../../include/initialize.php");
if(!isset($_SESSION['ADMIN_USERID'])){
  redirect(web_root."admin/index.php");
 }

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'confirm' :
	doConfirm();
	break; 
	
	case 'cancel' :
	doCancel();
	break;

	case 'accepted' :
	doAccepted();
	break; 
 

	}
   
	function doInsert(){
		global $mydb;
		if(isset($_POST['CartSubmit'])){
		$autonum = New Autonumber();
		$res = $autonum->set_autonumber('ORDERNO');
		$orderno = $res->AUTO;

			$stocks = 0;
			$sold = 0;
			$remaining = 0;
			  if (!empty($_SESSION['admin_gcCart'])){   
                $count_cart = count($_SESSION['admin_gcCart']); 
                    for ($i=0; $i < $count_cart  ; $i++) { 
                    	$productID = $_SESSION['admin_gcCart'][$i]['productID'];
                    	$qty = $_SESSION['admin_gcCart'][$i]['qty']; 
                    	$totalamount = $_SESSION['admin_gcCart'][$i]['subtotal'];
                    	$customerID = $_POST['CustomerID'];

                    	// $sql ="SELECT * FROM `tblstockin` WHERE `Remaining`>0 ORDER BY `DateExpire` ASC LIMIT 4"

                    	$sql = "UPDATE `tblstockin` SET Sold=1,Remaining=0 WHERE ProductID='{$productID}' AND `Remaining`>0 ORDER BY `DateExpire` ASC LIMIT {$qty}";
                    	$mydb->setQuery($sql);
                    	$mydb->executeQuery();
 

                    	$sql = "INSERT INTO `tblstockout`  (`CustomerID`, `ProductID`, `Quantity`,`TotalAmount`, `DateSold`,Status,OrderNo) VALUES('{$customerID}','{$productID}','{$qty}','{$totalamount}',Now(),'Confirmed','{$orderno}')";
                    	$mydb->setQuery($sql);
                    	$mydb->executeQuery();

                   
                    }

                    unset($_SESSION['admin_gcCart']);

					$autonum = New Autonumber(); 
					$autonum->auto_update('ORDERNO');

                    message("Orders created successfully!", "success");
				// redirect("index.php?view=view&id=".$_POST['EMPLOYEEID']);
		    	   redirect("index.php");
                }else{
                	message("Transaction is Invalid.", "success");
				// redirect("index.php?view=view&id=".$_POST['EMPLOYEEID']);
		    	   redirect("index.php?view=add");

                }

		}

	} 

	function doConfirm(){
		global $mydb;

			$stockoutID = $_GET['id'];
			$productID = $_GET['ProductID'];
		    $qty = $_GET['qty'];


	

			// $sql = "UPDATE `tblstockin` SET Sold=1,Remaining=0 WHERE ProductID='{$productID}' AND `Remaining`>0 ORDER BY `DateExpire` ASC LIMIT $qty";
			// $mydb->setQuery($sql);
			// $mydb->executeQuery();

			$sql = "UPDATE `tblstockout`  SET Status  = 'Confirmed',Remarks='Your order has been confirmed. Please get it in the store before 8 hours to avoid cancellation of order.' WHERE StockoutID='{$stockoutID}'";
			$mydb->setQuery($sql);
			$mydb->executeQuery();

			message("Orders has been confirmed!", "success");
			// redirect("index.php?view=view&id=".$_POST['EMPLOYEEID']);
			redirect("index.php");

	}

function doAccepted(){
		global $mydb;

			$stockoutID = $_GET['id'];
			$productID = $_GET['ProductID'];
		    $qty = $_GET['qty'];


	

			// $sql = "UPDATE `tblstockin` SET Sold=1,Remaining=0 WHERE ProductID='{$productID}' AND `Remaining`>0 ORDER BY `DateExpire` ASC LIMIT $qty";
			// $mydb->setQuery($sql);
			// $mydb->executeQuery();

			$sql = "UPDATE `tblstockout`  SET Status  = 'Accepted',Remarks='Order has been recieved.' WHERE StockoutID='{$stockoutID}'";
			$mydb->setQuery($sql);
			$mydb->executeQuery();

			message("Orders has been recieved!", "success");
			// redirect("index.php?view=view&id=".$_POST['EMPLOYEEID']);
			redirect("index.php");

	}
	function doCancel(){
			global $mydb;
			$stockoutID = $_GET['id'];

			$sql = "SELECT * FROM `tblstockout` WHERE StockoutID='{$stockoutID}'";
			$mydb->setQuery($sql);
			$cur = $mydb->executeQuery();
			$maxrow = $mydb->num_rows($cur);

			if ($maxrow > 0) { 
				$res = $mydb->loadSingleResult();
				$qty = $res->Quantity;
				$productID = $res->ProductID;

					$sql = "UPDATE `tblstockout`  SET Status  = 'Cancelled',Remarks='Your order has been cancelled' WHERE StockoutID='{$stockoutID}'";
					$mydb->setQuery($sql);
					$mydb->executeQuery();

					$sql = "UPDATE `tblstockin` SET Sold=0,Remaining=1 WHERE ProductID='{$productID}' AND `Remaining`=0 AND `ExpiredQty`=0 ORDER BY `DateExpire` ASC LIMIT {$qty}";
					$mydb->setQuery($sql);
					$mydb->executeQuery();  

			}else{ 
				$sql = "UPDATE `tblstockout`  SET Status  = 'Cancelled',Remarks='Your order has been cancelled' WHERE StockoutID='{$stockoutID}'";
				$mydb->setQuery($sql);
				$mydb->executeQuery(); 
			}



			message("Orders has been cancelled!", "success");
			// redirect("index.php?view=view&id=".$_POST['EMPLOYEEID']);
			redirect("index.php");

	}
?>