
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

			 $trans = New Autonumber();
		     $trans_res = $trans->set_autonumber('TransNo');
		     $trasno = date('Y').$trans_res->AUTO;

			  if (!empty($_SESSION['admin_multi_gcCart'])){   
                $count_cart = count($_SESSION['admin_multi_gcCart']); 

                    for ($i=0; $i < $count_cart  ; $i++) { 

						$ProductID = $_SESSION['admin_multi_gcCart'][$i]['productID'];
						$Quantity = $_SESSION['admin_multi_gcCart'][$i]['qty']; 

						 
						@$DateExpire = date_format(date_create($_SESSION['admin_multi_gcCart'][$i]['date_expired']),'Y-m-d');

						 	$sql = "SELECT  * FROM `tblproduct` WHERE `ProductID`='{$ProductID}'";
						 	$mydb->setQuery($sql);
						 	$cur = $mydb->executeQuery(); 
						 	$maxrow = $mydb->num_rows($cur);
						 	if ($maxrow > 0) {  
						 		$res = $mydb->loadSingleResult();
						 		for ($a=0; $a < $Quantity ; $a++) { 
						 			# code... 

						 		     // echo $res->ProductName .' '.$a.')</script>';

									$sql = "INSERT INTO  `tblstockin` (`TransactionNo`, `ProductID`, `Stocks`, `Remaining`, `DateExpire`, `DateReceive`) 
									VALUES ('{$trasno}','{$ProductID}',1,1,'{$DateExpire}',Now())";
									$mydb->setQuery($sql);
									$mydb->executeQuery();


		 			 
		 						}
		 					} 

                    }
               }

               $autonum = New Autonumber(); 
			   $autonum->auto_update('TransNo');

			   unset($_SESSION['admin_multi_gcCart']);

			    message("New transaction created successfully!", "success");
				redirect("index.php");
 
	}

	function doEdit(){
		global $mydb;
		$product_quantity=0;
		$total_quanity=0;
		if(isset($_POST['btnSubmit'])){ 
 
		if ( $_POST['Quantity'] == "" || $_POST['Quantity'] == 0) {
			$messageStats = false;
			message("All field is required!","error");
			redirect('index.php');
		}else{	
			$ProductID = $_POST['ProductID'];
			$TransactionNo = $_POST['TransactionNo'];  
			@$DateExpire = date_format(date_create($_POST['DateExpire']),'Y-m-d');
			$Quantity = $_POST['Quantity'];

			$sql = "SELECT *,sum(Sold) as 'SoldQty' FROM tblstockin WHERE TransactionNo='{$TransactionNo}' GROUP BY CONCAT(TransactionNo,ProductID)";
			$mydb->setQuery($sql);
			$sold = $mydb->loadSingleResult();

			$soldqty= $sold->SoldQty;


			if ($Quantity>= $soldqty ) {
				# code...
				$sql = "DELETE FROM tblstockin WHERE Remaining > 0 AND TransactionNo='{$TransactionNo}' AND `ProductID`='{$ProductID}'";
				$mydb->setQuery($sql);
				$mydb->executeQuery();

				$sql = "SELECT  * FROM `tblproduct` WHERE `ProductID`='{$ProductID}'";
				$mydb->setQuery($sql);
				$cur = $mydb->executeQuery(); 
				$maxrow = $mydb->num_rows($cur);

				if ($maxrow > 0) {  
				for ($i=0; $i < $Quantity - $soldqty; $i++) {  

						// echo '<script>alert('.$i.')</script>'; 

						$sql = "INSERT INTO  `tblstockin` (`TransactionNo`, `ProductID`, `Stocks`, `Remaining`, `DateExpire`, `DateReceive`) 
						VALUES ('{$TransactionNo}','{$ProductID}',1,1,'{$DateExpire}',Now())";
						$mydb->setQuery($sql);
						$mydb->executeQuery(); 

				}
					message("The quantity has been updated.", "success");
					redirect("index.php?view=edit&id=".$TransactionNo);


			}else{

					message("The set quantity is invalid because ", "error");
					redirect("index.php?view=edit&id=".$TransactionNo);

			}
 
		}


	}
  }
}


function doDelete(){
		global $mydb; 
		
		$ProductID = $_GET['ProductID'];
		$TransactionNo = $_GET['id']; 

		# code...
		$sql = "DELETE FROM tblstockin WHERE Remaining > 0 AND TransactionNo='{$TransactionNo}' and ProductID='{$ProductID}'";
		$mydb->setQuery($sql);
		$mydb->executeQuery();

		message("Transaction has been deleted.", "error");
		redirect("index.php?view=edit&id=".$TransactionNo); 
 
} 
?>