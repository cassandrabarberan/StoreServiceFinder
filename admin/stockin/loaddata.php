<?php
require_once("../../include/initialize.php");
//checkAdmin();
if (!isset($_SESSION['ADMIN_USERID'])){
	redirect(web_root."admin/index.php");
}
$storeID = $_SESSION['ADMIN_USERID'];
$productID = $_POST['ProductID'];
$sql ="SELECT * FROM tblproduct p, tblcategory c WHERE p.CategoryID=c.CategoryID AND ProductID = '{$productID}' AND p.StoreID='$storeID'";
$mydb->setQuery($sql);
$cur = $mydb->executeQuery();
$maxrow = $mydb->num_rows($cur);
$res = $mydb->loadSingleResult(); 
$msg="";
?> 
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
<!-- <form action="controller.php?action=add" method="POST" > -->
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
	<div class="column-label">Quantity</div>
	<div class="column-value"><input type="number" name="Quantity" id="Quantity" class="form-control"></div>
	<div class="column-label">Date Expired</div>
	<div class="column-value">
		<div class="col-md-8">
			<div class="input-group date  " data-provide="datepicker" data-date="2012-12-21T15:25:00Z">
				<input type="input" class="form-control input-sm date_picker" id="DateExpire" name="DateExpire" placeholder="mm/dd/yyyy"   autocomplete="off" required /> 
				<span class="input-group-addon"><i class="fa fa-th"></i></span>
			</div>
		</div>
	</div>
</div> 
<!-- <div class="row">
	<input type="submit" name="btnSubmit" value="Save" class="btn-primary btn btn-md">
</div> -->
<div class="row">
	<a href="#" id="btnAddtoCart" name="btnAddtoCart" class="btn-primary btn btn-md fa fa-shopping-cart" data-id="<?php echo $res->ProductID; ?>">Add to Cart</a>
</div>
<?php
	if (isset($_POST['date_expired'])) {
		# code... 
		$pid = $res->ProductID;
		$product = $res->ProductName . ' | ' . $res->Description . ' | '.$res->Categories;
		$price = $res->Price;
		$q = $_POST['QTY']; 
		$date_expired = $_POST['date_expired'];

		$subtotal = $price * $q;
		admin_multi_addtocart($pid,$product,$price,$q,$subtotal,$date_expired); 
	}

	if (isset($_POST['updateCart'])) {
		# code...  
		$productID=$_POST['ProductID']; 
		$qty=intval(isset($_POST['QTY']) ? $_POST['QTY'] : "");  
	 
	    admin_multi_editproduct($productID,$qty);  
	      
	}

	if (isset($_POST['deleteCart'])) {
		# code...  
		$productID=$_POST['ProductID'];  
		admin_multi_removetocart($productID); 
	      
	}
 

  }else{ ?>
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
<?php } ?> 

<form class="wow fadeInDownaction" action="controller.php?action=add" Method="POST" style="margin-top: 20px;">       
        <div class="table-responsive" style="min-height: 90px;">          
        <table id="table" class="table table-striped table-bordered table-hover"  style="font-size:12px" cellspacing="0">
        
          <thead>
            <tr> 
              <th>Date Expired</th>  
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

              if (!empty($_SESSION['admin_multi_gcCart'])){   
                $count_cart = count($_SESSION['admin_multi_gcCart']); 
                    for ($i=0; $i < $count_cart  ; $i++) { 

                        	echo'<tr> 
                    				<td>'.$_SESSION['admin_multi_gcCart'][$i]['date_expired'].'</td>
                    				<td>'.$_SESSION['admin_multi_gcCart'][$i]['product'].'</td>
                    				<td>'.$_SESSION['admin_multi_gcCart'][$i]['price'].'</td>
                    				<td><input style="height:25px;width:50px" type="number" name="qty" id="'.$_SESSION['admin_multi_gcCart'][$i]['productID'].'qty" required class="cartqty" data-id="'.$_SESSION['admin_multi_gcCart'][$i]['productID'].'"   value="'.$_SESSION['admin_multi_gcCart'][$i]['qty'].'" autocomplete="off" /> </td>
                    				<td> <output id="Osubtot'.$_SESSION['admin_multi_gcCart'][$i]['productID'].'">'.$_SESSION['admin_multi_gcCart'][$i]['subtotal'].'</output></td>
                    				<td><a class="delCart btn btn-xs btn-danger" style="text-decoration:none;" href="#" data-id="'.$_SESSION['admin_multi_gcCart'][$i]['productID'].'">Remove</a></td>
                        		</tr>';   
                    			$cart += $_SESSION['admin_multi_gcCart'][$i]['qty'];
                    			$subtotal += $_SESSION['admin_multi_gcCart'][$i]['subtotal'];
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
<?php  if (!empty($_SESSION['admin_multi_gcCart'])){    ?>
<input type="submit" name="btnSubmit" value="Save" class="btn-primary btn btn-md">   
<?php } ?>
      </div>   
 </form>

<script type="text/javascript" src="<?php echo web_root; ?>plugins/jQuery/jQuery-2.1.4.min.js"> </script> 

<script type="text/javascript" src="<?php echo web_root; ?>plugins/datepicker/bootstrap-datepicker.js" ></script> 
<script type="text/javascript" src="<?php echo web_root; ?>plugins/datepicker/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo web_root; ?>plugins/datepicker/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
 

<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>plugins/input-mask/jquery.inputmask.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script> 
 <script type="text/javascript">
 $('#datemask2').inputmask({
  mask: "2/1/y",
  placeholder: "mm/dd/yyyy",
  alias: "date",
  hourFormat: "24"
});
$('#DateExpire').inputmask({
  mask: "2/1/y",
  placeholder: "mm/dd/yyyy",
  alias: "date",
  hourFormat: "24"
});

$('.date_picker').datetimepicker({
  format: 'mm/dd/yyyy',
  startDate : '01/01/1950', 
  language:  'en',
  weekStart: 1,
  todayBtn:  1,
  autoclose: 1,
  todayHighlight: 1, 
  startView: 2,
  minView: 2,
  forceParse: 0 

});


$("#btnAddtoCart").on("click",function(){
    var productID = $(this).data("id");
    var qty = $("#Quantity").val(); 
    var DateExpire = $("#DateExpire").val();
    // alert(qty);
    if (qty=="") {
    	$("#Quantity").focus();
    	 return false;
    }
    if (DateExpire=="") {
    	 $("#DateExpire").focus();
    	 return false;
    }
    $.ajax({
      type:"POST",  
      url: "loaddata.php",    
      dataType: "text",  //expect html to be returned  
      data:{ProductID:productID,QTY:qty,date_expired:DateExpire},               
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