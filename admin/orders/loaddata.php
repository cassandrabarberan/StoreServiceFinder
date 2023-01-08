<?php
require_once("../../include/initialize.php");
//checkAdmin();
if (!isset($_SESSION['ADMIN_USERID'])){
	redirect(web_root."admin/index.php");
}

$msg="";




$productID = $_POST['ProductID'];
$sql ="SELECT *,sum(Remaining) as 'qty' FROM  tblstockin s, tblproduct p, tblcategory c WHERE s.ProductID=p.ProductID AND p.CategoryID=c.CategoryID AND p.ProductID = '{$productID}' AND p.StoreID=".$_SESSION['ADMIN_USERID'];
$mydb->setQuery($sql);
$cur = $mydb->executeQuery();
$maxrow = $mydb->num_rows($cur);
$res = $mydb->loadSingleResult(); 
?> 
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/select2/select2.css">
<style type="text/css"> 
	.column-label {
		float: left;
		width: 15%;
		padding: 5px;
		font-weight: bold;

	}
	.column-value {
		font-weight: bold;
		float: left;
		width: 35%;
		padding: 5px;
		color: blue;
	}
	.column-value > input {
		height: 50px;
		font-size:   30px;
	}
	.row:after{
		content: "";
		display: table;
		clear: both;
	}
</style>
<?php  if ($maxrow > 0) {  ?> 
<div class="row">
	<input type="hidden" name="ProductID" value="<?php echo $res->ProductID; ?>">
	<div class="column-label">Product</div>
	<div class="column-value">: <?php echo $res->ProductName; ?></div>
	<div class="column-label">Description</div>
	<div class="column-value">: <?php echo $res->Description; ?></div>
	<div class="column-label">Category</div>
	<div class="column-value">: <?php echo $res->Categories; ?></div>
	<div class="column-label">Price</div>
	<div class="column-value">: <?php echo $res->Price; ?></div>
	<div class="column-label">Reamining Qty</div>
	<div class="column-value">: <?php echo $res->qty; ?></div>
	<div class="column-label">Date Expired</div>
	<div class="column-value">: <?php echo $res->DateExpire; ?></div>
	<div class="column-label">Quantity</div>
	<div class="column-value"><input type="number" id="Quantity" name="Quantity" class="form-control"></div> 
</div> 
<div class="row">
	<a href="#" id="btnAddtoCart" name="btnAddtoCart" class="btn-primary btn btn-md fa fa-shopping-cart" data-id="<?php echo $res->ProductID; ?>">Add to Cart</a>
</div>
<?php
	if (isset($_POST['QTY'])) {
		# code... 
		$pid = $res->ProductID;
		$product = $res->ProductName . ' | ' . $res->Description . ' | '.$res->Categories;
		$price = $res->Price;
		$q = $_POST['QTY'];

		if ($q>$res->qty) {
			# code...
			$msg = '<label class="col-md-12 label label-danger">The product is out of stock!</label>';
		}else{
			$subtotal = $price * $q;
			admin_addtocart($pid,$product,$price,$q,$subtotal);

		}


	}

	if (isset($_POST['updateCart'])) {
		# code...  
		$productID=$_POST['ProductID']; 
		$qty=intval(isset($_POST['QTY']) ? $_POST['QTY'] : "");  
		if ($qty>$res->qty) {
			# code...
			$msg = '<label class="col-md-12 label label-danger">The product is out of stock!</label>';
		}else{
			admin_editproduct($productID,$qty); 
		}
	      
	}

	if (isset($_POST['deleteCart'])) {
		# code...  
		$productID=$_POST['ProductID'];  
		admin_removetocart($productID); 
	      
	}
	// $pid = $res->ProductID;
	// $product = $res->ProductName . ' | ' . $res->Description . ' | '.$res->Categories;
	// $price = $res->Price;
	// $q = 1;
	// $subtotal = $price * $q;
	// addtocart($pid,$product,$price,$q,$subtotal);

 }else{ ?>
	<div class="row">
	<div class="column-label">Product</div>
	<div class="column-value">: None</div>
	<div class="column-label">Description</div>
	<div class="column-value">: None</div>
	<div class="column-label">Category</div>
	<div class="column-value">: None</div>
	<div class="column-label">Price</div>
	<div class="column-value">: None</div>
	<div class="column-label">Quantity</div>
	<div class="column-value">: None</div> 
	<div class="column-label">Date Expired</div>
	<div class="column-value">: None</div> 
	</div>
<?php }  ?>
<br/>
<br/>
<br/>
<div><?php echo $msg;?></div>
 <form class="wow fadeInDownaction" action="controller.php?action=add" Method="POST">       
        <div class="table-responsive" style="min-height: 90px;">          
        <table id="table" class="table table-striped table-bordered table-hover"  style="font-size:12px" cellspacing="0">
        
          <thead>
            <tr> 
              <th>Product</th> 
              <th>Price</th>
              <th>Quantity</th> 
              <th>Subtotal</th> 
              <th width="14%" >Action</th> 
            </tr> 
          </thead> 
          <tbody>
            <?php 
              $cart = 0;
			  $subtotal = 0;


              if (!empty($_SESSION['admin_gcCart'])){   
                $count_cart = count($_SESSION['admin_gcCart']); 
                    for ($i=0; $i < $count_cart  ; $i++) { 

                        	echo'<tr> 
                    				<td>'.$_SESSION['admin_gcCart'][$i]['product'].'</td>
                    				<td>'.$_SESSION['admin_gcCart'][$i]['price'].'</td>
                    				<td><input style="height:25px;width:50px" type="number" name="qty" id="'.$_SESSION['admin_gcCart'][$i]['productID'].'qty" required class="cartqty" data-id="'.$_SESSION['admin_gcCart'][$i]['productID'].'"   value="'.$_SESSION['admin_gcCart'][$i]['qty'].'" autocomplete="off" /> </td>
                    				<td> <output id="Osubtot'.$_SESSION['admin_gcCart'][$i]['productID'].'">'.$_SESSION['admin_gcCart'][$i]['subtotal'].'</output></td>
                    				<td><a class="delCart btn btn-xs btn-danger" style="text-decoration:none;" href="#" data-id="'.$_SESSION['admin_gcCart'][$i]['productID'].'">Remove</a></td>
                        		</tr>';   
                    			$cart += $_SESSION['admin_gcCart'][$i]['qty'];
                    			$subtotal += $_SESSION['admin_gcCart'][$i]['subtotal'];
                   } 


                  }  
              echo  '<tfoot>
					<tr>
						<td colspan="3" ><p class="stot">Total</p></td>
						<td> &#8369 <span id="sum" class="stot">'. $subtotal.'</span></td>
						<td>
					</tr>
				</tfoot>';
            ?>
          </tbody> 
        </table> 
      </div>       
 </form>
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>plugins/select2/select2.full.min.js"></script> 
<script type="text/javascript">
  $(function(){
     $('.select2').select2();
  });

  $("#btnAddtoCart").on("click",function(){
    var productID = $(this).data("id");
    var qty = $("#Quantity").val();

    // alert(productID)
    $.ajax({
      type:"POST",  
      url: "loaddata.php",    
      dataType: "text",  //expect html to be returned  
      data:{ProductID:productID,QTY:qty},               
      success: function(data){    
       $('#loaddata').hide();   
       $('#loaddata').fadeIn(); 
       $('#loaddata').html(data);   
      } 
    })
  });
 
 
$(document).on("click", ".cartqty", function () { 
  $(this).select();
 
}); 

$(".cartqty").on("focusout",  function(){

    var id  = $(this).data('id');
    var inptqty = document.getElementById(id+"qty").value; 
    // var subtot; 
// alert(inptqty)
    $.ajax({
        type:"POST",
        url:  "loaddata.php",
        dataType: "text",
        data:{ProductID:id,QTY:inptqty,updateCart:"yes"},
        success: function(data) {
	       $('#loaddata').hide();   
	       $('#loaddata').fadeIn(); 
	       $('#loaddata').html(data);  
	     }
    });


});


$(".delCart").on("click",  function(){

    var id  = $(this).data('id'); 
    // var subtot; 
// alert(inptqty)
    $.ajax({
        type:"POST",
        url:  "loaddata.php",
        dataType: "text",
        data:{ProductID:id,deleteCart:"yes"},
        success: function(data) {
	       $('#loaddata').hide();   
	       $('#loaddata').fadeIn(); 
	       $('#loaddata').html(data);  
	     }
    });


});
</script>