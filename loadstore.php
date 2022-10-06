<?php
require_once("include/initialize.php"); 
$sql = "SELECT  * FROM `tblstore` ";
$mydb->setQuery($sql);
$res = $mydb->loadResultList();
foreach ($res as $row) {
	# code...
	$storeAdd[] = $row->StoreAddress; 
}
echo json_encode($storeAdd);
?>