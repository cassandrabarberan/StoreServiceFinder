<?php 
	  if (!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     } 
?>

	<div class="row">
       	 <div class="col-lg-12">
            <h1 class="page-header">History <a href="index.php?view=add" class="btn btn-primary btn-xs  ">  <i class="fa fa-plus-circle fw-fa"></i> Add New Stocks</a>  </h1>
       		</div>
        	<!-- /.col-lg-12 -->
   		 </div>
	 		    <form action="controller.php?action=delete" Method="POST">  	
			     <div class="table-responsive">					
				<table id="dash-table" class="table table-striped table-bordered table-hover"  style="font-size:12px" cellspacing="0">
				
				  <thead>
				  	<tr>

				    <th>Transaction #</th>
					<th>Product</th>
					<th>Description</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Expired Date</th> 
					<th>Categories</th>
					<th width="14%" >Action</th> 
				  	</tr>	
				  </thead> 
				  <tbody>
				  	<?php 
				  	 // `COMPANYID`, `OCCUPATIONTITLE`, `REQ_NO_EMPLOYEES`, `SALARIES`, `DURATION_EMPLOYEMENT`, `QUALIFICATION_WORKEXPERIENCE`, `JOBDESCRIPTION`, `PREFEREDSEX`, `SECTOR_VACANCY`, `JOBSTATUS`
				  		$mydb->setQuery("SELECT *,s.ProductID as pid,sum(Stocks) as 'qty' FROM `tblproduct` p,`tblcategory` c,`tblstockin` s WHERE p.`CategoryID`=c.`CategoryID` AND p.`ProductID`=s.`ProductID` AND p.StoreID=".$_SESSION['ADMIN_USERID']." GROUP BY CONCAT(TransactionNo,p.ProductID) ");
				  		$cur = $mydb->loadResultList(); 
						foreach ($cur as $result) {
				  		  echo '<tr>';
			              // echo '<td width="5%" align="center"></td>';
			              // echo '<td>
			              //      <input type="checkbox" name="selector[]" id="selector[]" value="'.$result->CATEGORYID. '"/>
			              //    ' . $result->CATEGORIES.'</a></td>';
			              echo '<td>'. $result->TransactionNo.'</td>';
			              echo '<td>'. $result->ProductName.'</td>';
			              echo '<td>' . $result->Description.'</a></td>';
			              echo '<td>' . $result->Price.'</a></td>'; 
			              echo '<td>'. $result->qty.'</td>'; 
			              echo '<td>'. $result->DateExpire.'</td>';
			              echo '<td>'. $result->Categories.'</td>';  
			              echo '<td align="center"><a title="Edit Transaction" href="index.php?view=edit&id='.$result->TransactionNo.'" class="btn btn-primary btn-xs  ">  <span class="fa fa-edit fw-fa"></a>
			              <a title="Delete Transaction" href="controller.php?action=delete&id='.$result->TransactionNo.'&ProductID='.$result->pid.'&TransQuantity='.$result->Stocks.'" class="btn btn-danger btn-xs  ">  <span class="fa  fa-trash-o fw-fa "></a></td>';
			              echo '</tr>';
				  	} 
				  	?>
				  </tbody>
					
				</table> 
			</div>
				</form> 