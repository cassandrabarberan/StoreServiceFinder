<?php  
require_once ("include/initialize.php");
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
switch ($action) { 
  
	case 'register' :
	doInsert();
	break;  


	case 'registerstore' :
	doInsertStore();
	break;  

	case 'login' :
	doLogin();
	break; 


	case 'login_cart' :
	doLogin_cart();
	break; 

	case 'loginRating' :
	doLogin_Rating();
	break; 

	case 'wishlist' :
	doWishList();
	break;  
	
 	case 'recoverpassword' :
	doRecover();
	break; 
	}
function doInsert() {
	if (isset($_POST['btnRegister'])) {   

			// $autonum = New Autonumber();
			// $auto = $autonum->set_autonumber('APPLICANT');
			 
		 	// `CustomerName`, `CustomerAddress`, `CustomerContact`, `Sex`, `Customer_Username`, `Customer_Password`
			$customer =New Customer(); 
			$customer->CustomerName 		= $_POST['CustomerName']; 
			$customer->CustomerAddress 		= $_POST['CustomerAddress'];
			$customer->Sex 					= $_POST['optionsRadios'];
			$customer->EmailAdd	            = $_POST['EmailAdd']; 
			$customer->Customer_Username	= $_POST['Customer_Username'];
			$customer->Customer_Password 	= sha1($_POST['Customer_Password']);
			$customer->CustomerContact 		= $_POST['CustomerContact']; 
			$customer->Latitude 			= $_POST['lat']; 
			$customer->Longhitude 			= $_POST['lng']; 
			$customer->create(); 

			message("You are successfully registered to the site. You can login now!","success");
			redirect("index.php?q=success");

		 
}
}

	function doInsertStore(){
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
			$store->ContactNo		= $_POST['ContactNo']; 
			$store->EmailAdd		= $_POST['EmailAdd']; 
			$store->lat				= $_POST['lat'];  
			$store->lng				= $_POST['lng'];  
			$store->create();

			$storID = $mydb->insert_id();

			$user = New User();
			$user->UserID 			= $storID;
			$user->FullName 		= $_POST['StoreName'];
			$user->Username			= $_POST['Username'];
			$user->Password			= sha1($_POST['Password']);
			$user->Role				="Store";
			$user->create();

			message("You are successfully registered to the site. You can login now!","success");
			redirect("index.php?q=success");
			
		}
		}

	}

 
function doLogin(){
	
	$email = trim($_POST['USERNAME']);
	$upass  = trim($_POST['PASS']);
	$h_upass = sha1($upass);
 
  //it creates a new objects of member
    $customer = new Customer();
    //make use of the static function, and we passed to parameters
    $res = $customer->CustomerAuthentication($email, $h_upass);
    if ($res==true) { 

       	message("You are now successfully login!","success");
       
       // $sql="INSERT INTO `tbllogs` (`USERID`,USERNAME, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
       //    VALUES (".$_SESSION['USERID'].",'".$_SESSION['FULLNAME']."','".date('Y-m-d H:i:s')."','".$_SESSION['UROLE']."','Logged in')";
       //    mysql_query($sql) or die(mysql_error()); 
         redirect(web_root."customer/");
     
    }else{ 

    	$user = new User();
	    //make use of the static function, and we passed to parameters
	    $res = $user->userAuthentication($email, $h_upass);
	    if ($res==true) { 
	       message("You logon as ".$_SESSION['ROLE'].".","success");
	      // if ($_SESSION['ROLE']=='Administrator' || $_SESSION['ROLE']=='Cashier'){

	        $_SESSION['ADMIN_USERID'] = $_SESSION['USERID'];
	        $_SESSION['ADMIN_FULLNAME'] = $_SESSION['FULLNAME'] ;
	        $_SESSION['ADMIN_USERNAME'] =$_SESSION['USERNAME'];
	        $_SESSION['ADMIN_ROLE'] = $_SESSION['ROLE'];
	        $_SESSION['ADMIN_PICLOCATION'] = $_SESSION['PICLOCATION'];

	        unset( $_SESSION['USERID'] );
	        unset( $_SESSION['FULLNAME'] );
	        unset( $_SESSION['USERNAME'] );
	        unset( $_SESSION['PASS'] );
	        unset( $_SESSION['ROLE'] );
	        unset($_SESSION['PICLOCATION']);

	         redirect(web_root."admin/index.php");
	      // } 
	    }else{
	      	echo "Account does not exist! Please contact Administrator.";
	        
	    } 
    } 
}

function doLogin_cart(){
	
	$email = trim($_POST['USERNAME']);
	$upass  = trim($_POST['PASS']);
	$h_upass = sha1($upass);
 
  //it creates a new objects of member
    $customer = new Customer();
    //make use of the static function, and we passed to parameters
    $res = $customer->CustomerAuthentication($email, $h_upass);
    if ($res==true) { 

       	message("You are now successfully login!","success");
       
       // $sql="INSERT INTO `tbllogs` (`USERID`,USERNAME, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
       //    VALUES (".$_SESSION['USERID'].",'".$_SESSION['FULLNAME']."','".date('Y-m-d H:i:s')."','".$_SESSION['UROLE']."','Logged in')";
       //    mysql_query($sql) or die(mysql_error()); 
         redirect(web_root."index.php?q=checkout");
     
    }else{ 
 
	     echo "Account does not exist! Please contact Administrator."; 
    } 
}

function doLogin_Rating(){
    $storeID = trim($_POST['StoreID']);
	$email = trim($_POST['USERNAME']);
	$upass  = trim($_POST['PASS']);
	$h_upass = sha1($upass);
 
  //it creates a new objects of member
    $customer = new Customer();
    //make use of the static function, and we passed to parameters
    $res = $customer->CustomerAuthentication($email, $h_upass);
    if ($res==true) { 

       	message("You are now successfully login!","success");
       
       // $sql="INSERT INTO `tbllogs` (`USERID`,USERNAME, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
       //    VALUES (".$_SESSION['USERID'].",'".$_SESSION['FULLNAME']."','".date('Y-m-d H:i:s')."','".$_SESSION['UROLE']."','Logged in')";
       //    mysql_query($sql) or die(mysql_error()); 
         redirect(web_root."index.php?q=map&search=".$storeID);
     
    }else{ 
 
	     echo "Account does not exist! Please contact Administrator."; 
    } 
}


 
 
function UploadImage($jobid=0){
	$target_dir = "customer/photos/";
	$target_file = $target_dir . date("dmYhis") . basename($_FILES["picture"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	
	if($imageFileType != "jpg" || $imageFileType != "png" || $imageFileType != "jpeg"
|| $imageFileType != "gif" ) {
		 if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
			return  date("dmYhis") . basename($_FILES["picture"]["name"]);
		}else{
			message("Error Uploading File","error");
			// redirect(web_root."index.php?q=apply&job=".$jobid."&view=personalinfo");
			// exit;
		}
	}else{
			message("File Not Supported","error");
			// redirect(web_root."index.php?q=apply&job=".$jobid."&view=personalinfo");
			// exit;
		}
} 

function doWishList(){
	global $mydb;
	$id = $_GET['id'];
	$cid = $_SESSION['CustomerID'];

	$sql = "SELECT * FROM tblwishlist WHERE ProductID='$id' AND CustomerID='$cid'";
	$mydb->setQuery($sql);
	$res = $mydb->executeQuery();
	$maxrow = $mydb->num_rows($res);
	if ($maxrow > 0) {
		# code...
		echo '<script>alert("Product is already in the wishlist.")</script>';
		echo '<script>window.location="customer/index.php?view=wishlist"</script>';
	}else {	
    	$sql = "INSERT INTO `tblwishlist` (`CustomerID`, `ProductID`, `TransDate`) VALUES ('$cid','$id',Now())";
		$mydb->setQuery($sql);
		$mydb->executeQuery();

		 echo '<script>alert("Product has been added in the wishlist.")</script>';
		 echo '<script>window.location="customer/index.php?view=wishlist"</script>';

	}



}
function doRecover(){ 
    global $mydb;
    
    if(isset($_POST['recover-submit'])){
        $email = $_POST['email'];
        
        $sql = "SELECT * FROM tblcustomer WHERE  `EmailAdd`='{$email}'";
        $mydb->setQuery($sql);
        $res = $mydb->executeQuery();
        $maxrow = $mydb->num_rows($res);
        if($maxrow > 0){
             
            $sql = "UPDATE `tblcustomer` SET `Customer_Password`=sha1(12345678910)  WHERE `EmailAdd`='{$email}'";
            $mydb->setQuery($sql);
            $mydb->executeQuery();  
          
              // the message
            $msg = "Here is the Link to Login - http://www.mediseenonline.com/". "\r\n" .
                    "Your password is : 12345678910";
             
            $to      = $email;
            $subject = 'Reset Password';
            $message =   $msg;
            $headers = 'From: mediseen';
            
            mail($to, $subject, $message, $headers);
            
            message("The password has been reset. Check your email.","success");
    	    redirect("index.php?q=success");
        }else{
            
           $email = $_POST['email'];
            
            $sql = "SELECT * FROM `tblstore` WHERE `EmailAdd`='{$email}'"; 
            $mydb->setQuery($sql);
            $resstore = $mydb->executeQuery();
            $storemaxrow = $mydb->num_rows($resstore);
            
            if($storemaxrow > 0){
                
                $store = $mydb->loadSingleResult();
                
                $sql = "UPDATE `tblusers` u  SET `Password`=sha1(12345678910)  WHERE `UserID`='{$store->StoreID}'";
                $mydb->setQuery($sql);
                $mydb->executeQuery();  
                
                  // the message
                $msg = "Here is the Link to Login - http://www.mediseenonline.com/". "\r\n" .
                        "Your password is : 12345678910";
                 
                $to      = $email;
                $subject = 'Reset Password';
                $message =   $msg;
                $headers = 'From: mediseen';
                
                mail($to, $subject, $message, $headers);
                
                message("The password has been reset. Check your email.","success");
        	    redirect("index.php?q=success");
        	    
            }else{
                
             message("The email address is not correct.","error");
             redirect("forgotpassword.php");
            }
        
        }
        
     
      
    } 
}

?>