<?php
require_once("include/initialize.php");

if (isset($_POST['updateCart'])) {
	# code...  
	$productID=$_POST['ProductID']; 
	$qty=intval(isset($_POST['QTY']) ? $_POST['QTY'] : "");  
	editproduct($productID,$qty); 
      
}

if (isset($_POST['deleteCart'])) {
	# code...  
	$productID=$_POST['ProductID'];  
	removetocart($productID); 
      
}



 ?>
         
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
			  $count_cart=0;


              if (!empty($_SESSION['gcCart'])){   
                $count_cart = count($_SESSION['gcCart']); 
                    for ($i=0; $i < $count_cart  ; $i++) { 

                        	echo'<tr> 
                    				<td>'.$_SESSION['gcCart'][$i]['product'].'</td>
                    				<td>'.$_SESSION['gcCart'][$i]['price'].'</td>
                    				<td><input style="height:25px;width:50px" type="number" name="qty" id="'.$_SESSION['gcCart'][$i]['productID'].'qty" required class="cartqty" min="1" data-id="'.$_SESSION['gcCart'][$i]['productID'].'"   value="'.$_SESSION['gcCart'][$i]['qty'].'" autocomplete="off" /> </td>
                    				<td> <output id="Osubtot'.$_SESSION['gcCart'][$i]['productID'].'">'.$_SESSION['gcCart'][$i]['subtotal'].'</output></td>
                    				<td><a class="delCart btn btn-xs btn-danger" style="text-decoration:none;" href="#" data-id="'.$_SESSION['gcCart'][$i]['productID'].'">Remove</a></td>
                        		</tr>';   
                    			$cart += $_SESSION['gcCart'][$i]['qty'];
                    			$subtotal += $_SESSION['gcCart'][$i]['subtotal'];
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
        <?php if ($count_cart > 0) { 
        	if (isset($_SESSION['CustomerID'])) {

	        		    echo '<a href="index.php?q=checkout" class="btn btn-primary pull-right">Check Out <i class="fa fa-arrow-right"></i></a>';
	        		# code...
	        	}else{

	        		    echo '<a data-target="#myModalcart_login" data-toggle="modal" href="" class="btn btn-primary pull-right">Check Out <i class="fa fa-arrow-right"></i></a>';

	        	}
            }
         ?>  


         

<script type="text/javascript"> 

$(".cartqty").on("focusout",  function(){

    var id  = $(this).data('id');
    var inptqty = document.getElementById(id+"qty").value; 
    // var subtot; 
 // alert(inptqty)
    $.ajax({
        type:"POST",
        url:  "loadcart.php",
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
 // alert(id)
    $.ajax({
        type:"POST",
        url:  "loadcart.php",
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