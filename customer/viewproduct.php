<?php 
global $mydb;
	$stockoutID = isset($_GET['id']) ? $_GET['id'] : '';

	$sql = "UPDATE tblstockout SET HView=0 WHERE StockoutID='{$stockoutID}'";
	$mydb->setQuery($sql);
	$mydb->executeQuery();
	
 	$totalamount = 0;

	$sql = "SELECT * FROM tblcategory c,tblstore st,`tblproduct` p , `tblstockout` s
	       WHERE c.CategoryID=p.CategoryID AND st.StoreID=p.StoreID AND
	       p.`ProductID`=s.`ProductID` and `StockoutID`=" .$stockoutID;
	$mydb->setQuery($sql);
	$res = $mydb->loadSingleResult();

	$totalamount = $res->Price * $res->Quantity;


?> 
<style type="text/css">
.content-header {
	min-height: 50px;
	border-bottom: 1px solid #ddd;
	font-size: 20px;
	font-weight: bold;
}
.content-body {
	min-height: 350px;
	/*border-bottom: 1px solid #ddd;*/
}
.content-body >p {
	padding:10px;
	font-size: 12px;
	font-weight: bold;
	border-bottom: 1px solid #ddd;
}
.content-footer {
	min-height: 100px;
	border-top: 1px solid #ddd;

}
.content-footer > p {
	padding:5px;
	font-size: 15px;
	font-weight: bold; 
}
 
.content-footer textarea {
	width: 100%;
	height: 200px;
}
.content-footer  .submitbutton{  
	margin-top: 20px;
	/*padding: 0;*/

}
</style>
<form action="controller.php?action=approve" method="POST">
<div class="col-sm-12 content-header" style="">Product Details</div>
<div class="col-sm-12 content-body" >  
	<h3><?php echo $res->ProductName; ?></h3>
	<input type="hidden" name="JOBREGID" value="<?php echo $jobreg->REGISTRATIONID;?>">

	<div class="col-sm-6">
		<ul>
            <li><i class="fp-ht-bed"></i>Description : <?php echo $res->Description; ?></li>
            <li><i class="fp-ht-food"></i>Price : <?php echo number_format($res->Price,2);  ?></li>
            <li><i class="fa fa-sun-"></i>Quantity : <?php echo $res->Quantity; ?></li>
        </ul>
	</div> 
	<div class="col-sm-6">
		<ul> 
            <!-- <li><i class="fp-ht-tv"></i>Date Expired : <?php echo $res->DateExpire; ?></li> -->
            <li><i class="fp-ht-computer"></i>Category : <?php echo $res->Categories; ?></li>
            <li><i class="fp-ht-computer"></i>Status : <?php echo $res->Status; ?></li>
        </ul>
	</div>
	<div class="col-sm-12">
		<p>Total Amount : </p>   
		<p style="margin-left: 15px;"><?php echo $totalamount;?></p>
	</div> 
	<div class="col-sm-12"> 
		<p>Store : </p>
		<p style="margin-left: 15px;"><?php echo $res->StoreName ; ?></p> 
		<p style="margin-left: 15px;">@ <a href="<?php echo web_root;?>index.php?q=map"><?php echo $res->StoreAddress ; ?></a></p>
		<p style="margin-left: 15px;"><i class="fa fa-phone"></i> <?php echo $res->ContactNo ; ?></p>
	</div>
</div>
  
</form>