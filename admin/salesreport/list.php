<?php
	 if(!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     }

?> 
	 
<style type="text/css">
  .row {
    margin-bottom: 5px;
  }
</style>
  <!-- =============================================== -->
 <form action="" method="POST">
 	<section class="content-header row">
	<div class="col-md-3"> </div>
	<div class="col-md-6"> 
		<div class="panel">
			<div class="panel-header"></div>
				<div class="panel-body ">  
					 <div class="row">
					  <div class="col-sm-12 search1">
					    <label class="col-sm-3">Date From:</label>
					    <div class="col-sm-9">
					      <div class="input-group date">
					        <div class="input-group-addon">
					          <i class="fa fa-calendar"></i>
					        </div>
					        <input required autocomplete="off" type="text" value="<?php echo isset($_POST['date_from']) ? $_POST['date_from'] : DATE('m/d/Y'); ?>" name="date_from" class="form-control pull-right date_picker" id="datemask2" placeholder="mm/dd/yyyy">
					      </div>
					    </div>
					  </div>
					</div>   
					 <div class="row">
					  <div class="col-sm-12 search1">
					    <label class="col-sm-3">Date To:</label>
					    <div class="col-sm-9">
					      <div class="input-group date">
					        <div class="input-group-addon">
					          <i class="fa fa-calendar"></i>
					        </div>
					        <input required autocomplete="off" type="text" value="<?php echo isset($_POST['date_to']) ? $_POST['date_to'] : DATE('m/d/Y'); ?>" name="date_to" class="form-control pull-right date_picker" id="datemask2" placeholder="mm/dd/yyyy">
					      </div>
					    </div>
					  </div>
					</div>   
					  <div class="row">
					  <div class="col-sm-12 search1">
					    <label class="col-sm-3"></label>
					    <div class="col-sm-9">
					       <input type="submit" name="submit" class="btn-lg btn-success">
					    </div>
					  </div>
					</div>  
				</div>
		</div> 
		
	</div> 
	<div class="col-md-3"> </div>
</section> 
</form>

  <section class="content">
  	<?php 
  	$sql = "SELECT * FROM `tblstore` WHERE `StoreID`=".$_SESSION['ADMIN_USERID'];
  	$mydb->setQuery($sql);
  	$store = $mydb->loadSingleResult();
  	?>

  	<p style="text-align: center;font-size: 15px"><?php echo $store->StoreName ?> <br>
	<?php echo $store->StoreAddress ?> <br>
	Sales Report <br/>
	As of <?php echo date('m/d/Y');?>

 
	 <?php
	     // $date_taken = isset($_POST['date_taken']) ? date_format(date_create($_POST['date_taken']),"Y-m-d") : "";
	     //  $course  = isset($_POST['Course']) ? $_POST['Course'] : "";
	     //  $semester = isset($_POST['Semester']) ? $_POST['Semester'] : ""; 
	 ?>

	 <p  style="font-size:15px;text-align: center;">
    Inclusive Dates: <?php echo isset($_POST['date_from']) ? "From : " .$_POST['date_from'] : "Month-Day-Year" ?> | <?php echo isset($_POST['date_to']) ? " To : " .$_POST['date_to'] : "Month-Day-Year" ?></p>
  </p>
  	  
 <div class="row no-print">
  <center><button type="button" class="btn-lg btn-info pull-center" button onclick="myFunction()">Print Report</button></center>
</div>
  <table class="table table-bordered" style="font-size:15px ;">
  	<thead>
  		<th>ProductID</th>
  		<th>Products</th>
  		<th>Price</th>
  		<th>Sold Qty</th>
  		<th>Total Amount</th>
  	</thead>
  	<tbody>
		  <?php

		  $datefrom =isset($_POST['date_from'])  ?  date_format(date_create($_POST['date_from']),'Y-m-d') : "";
	      $dateto = isset($_POST['date_to'])  ? date_format(date_create($_POST['date_to']),'Y-m-d') : "";

		  $tot=0;
		  $totalamount=0;
		  $totalqty=0;
		  $totalprice=0;

		  $sql ="SELECT *,sum(Quantity) as qty,sum(TotalAmount) as tot FROM `tblproduct` p,`tblstockout` s WHERE p.`ProductID`=s.`ProductID` AND DATE(`DateSold`) >= '".$datefrom ."' AND DATE(`DateSold`) <= '".$dateto."' AND p.`StoreID`=".$_SESSION['ADMIN_USERID']." GROUP BY p.ProductID";
		  $mydb->setQuery($sql);
		  $cur = $mydb->loadResultList();
		  foreach ($cur as $result) {
		  	# code...
		  	$tot = $result->Price * $result->qty;
		  	echo '<tr>';
		  	echo '<td>'.$result->ProductID.'</td>';
		  	echo '<td>'.$result->ProductName.' | '  .$result->Description.'</td>';
		  	echo '<td>&#8369 '.number_format($result->Price,2).'</td>';
		  	echo '<td>'.$result->qty.'</td>';
		  	echo '<td>&#8369 '.number_format($tot,2).'</td>';
		  	echo '</tr>';

		  	$totalprice +=$result->Price;
		  	$totalqty +=$result->qty;
		  	$totalamount+=$tot;
		  }

		?>
  		
  	</tbody>
  	<tfoot>
  		<th colspan="2">Total</th>
  		<th>&#8369 <?php echo number_format($totalprice,2);?></th>
  		<th><?php echo $totalqty;?></th>
  		<th>&#8369 <?php echo number_format($totalamount,2);?></th>
  	</tfoot>
  </table>


  <script> 
  function myFunction(){ 
    window.print();
    
  }

  </script>  
  </section> 