<?php
	 if(!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     }

?> 
	<div class="row">
    <div class="col-lg-12">
            <h1 class="page-header">List of Products   <a href="index.php?view=add" class="btn btn-primary btn-xs  ">  <i class="fa fa-plus-circle fw-fa"></i> Add New Product</a> </h1>
       		</div>
        	<!-- /.col-lg-12 -->
   		 </div>
                
 
						<form class="wow fadeInDownaction" action="controller.php?action=delete" Method="POST">   		
							<table id="tree_table" class="table table-striped  table-hover table-responsive mytbl" style="font-size:12px" cellspacing="0">
								<label>Search For </label> : <input class="search" placeholder="Search" />
							  <thead> 
							  	<tr>
									<th>Product ID</th>
									<th>Product</th>
									<th>Description</th>
									<th>Price</th>
									<th>Quantity</th>
									<!-- <th>Expired Date</th>  -->
									<th>Categories</th>
									<?php if($_SESSION['ADMIN_ROLE']=='Administrator'){ ?>
									<th>Store</th>
									<?php } ?>
									<th width="18%" >Action</th> 
							  	</tr>	
							  </thead> 
							  <tbody>
							  	<?php   

									if($_SESSION['ADMIN_ROLE']=='Administrator'){
									  $sql ="SELECT *,sum(Remaining) as 'qty' FROM tblstockin st, `tblproduct` p, `tblcategory` c,`tblstore` s WHERE st.ProductID=p.ProductID AND p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID` GROUP BY p.ProductID";
					 
									}else{
									    $sql ="SELECT *,sum(Remaining) as 'qty' FROM tblstockin st, `tblproduct` p, `tblcategory` c,`tblstore` s WHERE st.ProductID=p.ProductID AND p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID` AND p.`StoreID`=".$_SESSION['ADMIN_USERID']." GROUP BY p.ProductID";
					 
									}	 
							  	
							  		$mydb->setQuery($sql);
							  		$cur = $mydb->loadResultList();

									foreach ($cur as $result) { 

											$st=0;
											$sld =0;
											$exp=0;
											$rm =0;


							  		echo '<tr data-tt-id="1'.$result->ProductID.'">';
							  		// echo '<td width="5%" align="center"></td>';
							  		echo '<td>'. $result->ProductID.'</td>';
							  		echo '<td>'. $result->ProductName.'</td>';
							  		echo '<td>' . $result->Description.'</a></td>';
							  		echo '<td>&#8369 ' . number_format($result->Price,2).'</a></td>'; 
							  		echo '<td>'. $result->qty.'</td>';  
							  		echo '<td>'. $result->Categories.'</td>';  
							  		if($_SESSION['ADMIN_ROLE']=='Administrator'){
							  			echo '<td>'. $result->StoreName.'</td>';  
							  		}
 
					  				echo '<td align="center" >     
					  		              <a title="Edit" href="index.php?view=edit&id='.$result->ProductID.'"  class="btn btn-info btn-xs  ">
					  		             <span class="fa fa-edit fw-fa"></span> Edit</a>  
					  		             <a title="Remove" href="controller.php?action=delete&id='.$result->ProductID.'"  class="btn btn-danger btn-xs  ">
					  		             <span class="fa fa-trash-o fw-fa"></span> Remove</a> 
					  					 </td>';
							  		echo '</tr>';

							  		
										echo '<tr style="font-size:14px; background-color:#DCDCDC;"  data-tt-id="2" data-tt-parent-id="1'.$result->ProductID.'">';
											echo '<th></th>';
											echo '<th>ID</th>'; 
											echo '<th  >Expired Date</th> '; 
											// echo '<th>Status</th>';
											echo '<th >Stock</th>';
											echo '<th>Sold</th>';
											echo '<th>Expired</th>';
											echo '<th>Available Stocks</th>';
											if($_SESSION['ADMIN_ROLE']=='Administrator'){
									  			echo '<th></th>';  
									  		}
										echo '</tr>';
										// echo '<table class="table table-bordered table-hover">';
										$query="SELECT *,sum(`Stocks`) as 'st',sum(`Sold`) as 'sld',sum(`Remaining`) as 'rm',sum(`ExpiredQty`) as 'exp' FROM  `tblcategory` c,`tblproduct` p,`tblstockin` s WHERE  p.`CategoryID`=c.`CategoryID` AND p.`ProductID`=s.`ProductID` AND p.`ProductID`=".$result->ProductID."   GROUP BY CONCAT(`DateExpire`,p.ProductID)"; 
										$mydb->setQuery($query);
										$row = $mydb->loadResultList(); 
										foreach ($row as $res) {
											echo '<tr style="font-size:13px;" data-tt-id="2" data-tt-parent-id="1'.$res->ProductID.'">';
											echo '<td></td>';
											echo '<td>'. $res->ProductID.'</td>';
											echo '<td>'. $res->DateExpire.'</td>'; 
											echo '<td>'. $res->st.'</td>';
											echo '<td>' . $res->sld.'</a></td>'; 
											echo '<td>'. $res->exp.'</td>'; 
											echo '<td>'. $res->rm.'</td>';
											if($_SESSION['ADMIN_ROLE']=='Administrator'){
									  			echo '<td></td>';  
									  		}

											echo '</tr>';

											$st =$st + $res->st;
											$sld +=$res->sld;
											$exp +=$res->exp;
											// $rm +=$res->rm;

										}
										echo '<tr style="font-size:14px; background-color:#DCDCDC;"  data-tt-id="2" data-tt-parent-id="1'.$result->ProductID.'">';
										echo '<th></th>';
										echo '<th colspan="2">Total</th>';
										echo '<th>'. $st.'</th>';
										echo '<th>' . $sld.'</a></th>'; 
										echo '<th>'. $exp.'</th>'; 
										echo '<th>'. $result->qty.'</th>';
											if($_SESSION['ADMIN_ROLE']=='Administrator'){
									  			echo '<th></th>';  
									  		}

										echo '</tr>';
							  	} 
							  	?>
							  </tbody>
								
							</table>
 
							 
							</form>
       
                 
 