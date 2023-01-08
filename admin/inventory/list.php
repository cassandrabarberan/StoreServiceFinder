<?php
	 if(!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     }

?> 
	<div class="row">
    <div class="col-lg-12">
            <h1 class="page-header">List of Products  </h1>
       		</div>
        	<!-- /.col-lg-12 -->
   		 </div>
                
 
						<form class="wow fadeInDownaction" action="controller.php?action=delete" Method="POST">   		
							<table id="dash-table" class="table table-striped  table-hover table-responsive" style="font-size:12px" cellspacing="0">

							  <thead>
							  	<tr>
									<th>Product ID</th>
									<th>Product</th>
									<th>Description</th>
									<th>Categories</th>
									<th>Stocks</th>
									<th>Sold</th>
									<th>Expired</th>
									<th>Remaining</th> 
									<!-- <th width="14%" >Action</th>  -->
							  	</tr>	
							  </thead> 
							  <tbody>
							  	<?php   
							  		// $mydb->setQuery("SELECT * 
											// 			FROM  `tblusers` WHERE TYPE != 'Customer'");
							  	// `ProductID`, `ProductName`, `Description`, `Price`, `DateExpire`,Categories,StoreName
							  		$sql ="SELECT *,sum(Stocks) as 'sto',sum(Sold) as sol,sum(`ExpiredQty`) as exp,sum(Remaining) as rem  FROM tblstockin st, `tblproduct` p, `tblcategory` c,`tblstore` s WHERE st.ProductID=p.ProductID AND p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID` AND p.`StoreID`=".$_SESSION['ADMIN_USERID']." GROUP BY p.ProductID";

							  		$mydb->setQuery($sql);
							  		$cur = $mydb->loadResultList();

									foreach ($cur as $result) { 
							  		echo '<tr>';
							  		// echo '<td width="5%" align="center"></td>';
							  		echo '<td>'. $result->ProductID.'</td>';
							  		echo '<td>'. $result->ProductName.'</td>';
							  		echo '<td>' . $result->Description.'</a></td>';
							  		echo '<td>'. $result->Categories.'</td>';  
							  		echo '<td>' . $result->sto.'</a></td>'; 
							  		echo '<td>' . $result->sol.'</a></td>'; 
							  		echo '<td>' . $result->exp.'</a></td>'; 
							  		echo '<td>'. $result->rem.'</td>';  
					  				// echo '<td align="center" >    
					  		  //            <a title="View" href="index.php?view=view&id='.$result->ProductID.'"  class="btn btn-info btn-xs  ">
					  		  //            <span class="fa fa-info fw-fa"></span> View</a>
					  		  //             <a title="Edit" href="index.php?view=edit&id='.$result->ProductID.'"  class="btn btn-info btn-xs  ">
					  		  //            <span class="fa fa-edit fw-fa"></span> Edit</a>  
					  		  //            <a title="Remove" href="controller.php?action=delete&id='.$result->ProductID.'"  class="btn btn-danger btn-xs  ">
					  		  //            <span class="fa fa-trash-o fw-fa"></span> Remove</a> 
					  				// // 	 </td>';
					  				// echo '<td align="center" >     
					  		  //             <a title="Edit" href="index.php?view=edit&id='.$result->ProductID.'"  class="btn btn-info btn-xs  ">
					  		  //            <span class="fa fa-edit fw-fa"></span> Edit</a>  
					  		  //            <a title="Remove" href="controller.php?action=delete&id='.$result->ProductID.'"  class="btn btn-danger btn-xs  ">
					  		  //            <span class="fa fa-trash-o fw-fa"></span> Remove</a> 
					  				// 	 </td>';
							  		echo '</tr>';
							  	} 
							  	?>
							  </tbody>
								
							</table>
 
							 
							</form>
       
                 
 