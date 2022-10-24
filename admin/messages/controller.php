<?php
require_once ("../../include/initialize.php");
	  if (!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."index.php");
     }

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;
	
	case 'cancel' :
	doCancel();
	break;

	case 'photos' :
	doupdateimage();
	break; 

	case 'sendmessage' :
	doSendMessage();
	break;
 
	}

	function doEdit(){

		$_SESSION['Latitude'] = $_POST['lat'];
		$_SESSION['Longhitude']= $_POST['lng']; 
	 
		$cus = new Customer(); 
		$cus->CustomerName 			= $_POST['CustomerName'];
		$cus->CustomerAddress 		= $_POST['CustomerAddress']; 
		$cus->Sex 					= $_POST['optionsRadios'];
		$cus->CustomerContact 		= $_POST['CustomerContact']; 
		$cus->EmailAdd 	            = $_POST['EmailAdd']; 
		$cus->Customer_Username 	= $_POST['Customer_Username']; 
		$cus->Latitude 				= $_POST['lat']; 
		$cus->Longhitude 			= $_POST['lng']; 
		$cus->update($_SESSION['CustomerID']);

		message("Account has been updated!", "success");
		redirect(web_root."customer/index.php?view=accounts"); 
	}

	function doCancel(){
			global $mydb;
			$stockoutID = $_GET['id'];
			$sql = "UPDATE `tblstockout`  SET Status  = 'Cancelled' WHERE StockoutID='{$stockoutID}'";
			$mydb->setQuery($sql);
			$mydb->executeQuery(); 

			message("Orders has been cancelled!", "success");
			// redirect("index.php?view=view&id=".$_POST['EMPLOYEEID']);
			redirect("index.php");
	}
   
	function doupdateimage(){
 
			$errofile = $_FILES['photo']['error'];
			$type = $_FILES['photo']['type'];
			$temp = $_FILES['photo']['tmp_name'];
			$myfile =$_FILES['photo']['name'];
		 	$location="photos/".$myfile;


		if ( $errofile > 0) {
				message("No Image Selected!", "error");
				redirect("index.php?view=view&id=". $_GET['id']);
		}else{
	 
				@$file=$_FILES['photo']['tmp_name'];
				@$image= addslashes(file_get_contents($_FILES['photo']['tmp_name']));
				@$image_name= addslashes($_FILES['photo']['name']); 
				@$image_size= getimagesize($_FILES['photo']['tmp_name']);

			if ($image_size==FALSE ) {
				message("Uploaded file is not an image!", "error");
				redirect("index.php?view=view&id=". $_GET['id']);
			}else{
					//uploading the file
					move_uploaded_file($temp,"photos/" . $myfile);
		 	
					 

						$customer = New Customer();
						$customer->Customer_Photo	= $location;
						$customer->update($_SESSION['CustomerID']);
						redirect(web_root."customer/");
						 
							
					}
			}
			 
		}


 
function UploadImage(){
	$target_dir = "photos/";
	$target_file = $target_dir . date("dmYhis") . basename($_FILES["picture"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	
	if($imageFileType != "jpg" || $imageFileType != "png" || $imageFileType != "jpeg"
|| $imageFileType != "gif" ) {
		 if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
			return  date("dmYhis") . basename($_FILES["picture"]["name"]);
		}else{
			echo "Error Uploading File";
			exit;
		}
	}else{
			echo "File Not Supported";
			exit;
		}
} 


function doSendMessage(){
	global $mydb;

		$id  = $_POST['MessageID']; 
		$text = $_POST['MessageText'];  
		$createdBy = $_SESSION['ADMIN_FULLNAME'];
		$sql = "INSERT INTO `tblreplymessages`(`MessageID`, `ReplyText`,`CreatedBy`)  VALUES ('{$id}','{$text}','{$createdBy}')";
		$mydb->setQuery($sql);
		$mydb->executeQuery(); 

		redirect("index.php?view=readmessage&id=".$id);

}

?>