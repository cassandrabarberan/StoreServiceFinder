<?php
require_once("include/initialize.php");
if (isset($_SESSION['gcCart'])) {
  # code...
   $count_cart = count($_SESSION['gcCart']); 
}else{ 
    $count_cart=0;
}

echo $count_cart;


?>