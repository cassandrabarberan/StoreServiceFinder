<?php 
    if (!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     } 

$id = $_GET['id'];
$sql ="SELECT *,sum(Stocks) as 'qty' FROM tblproduct p, tblcategory c,tblstockin s 
       WHERE p.CategoryID=c.CategoryID AND p.ProductID=s.ProductID  AND TransactionNo = '{$id}' GROUP BY CONCAT(TransactionNo,p.ProductID) ";
$mydb->setQuery($sql);
$cur = $mydb->executeQuery();
$maxrow = $mydb->num_rows($cur);
$res = $mydb->loadSingleResult(); 
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
  <div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">Update Transaction</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div> 
    <div style="font-size: 14px" class="page-header">Product Details</div>
    <div class="col-lg-12">
<?php  if ($maxrow > 0) {  ?> 
<form action="controller.php?action=edit" method="POST" >
<div class="row">
  <input type="hidden" name="ProductID" value="<?php echo $res->ProductID; ?>">
  <input type="hidden" name="TransQuantity" value="<?php echo $res->qty; ?>">
  <input type="hidden" name="TransactionNo" value="<?php echo $res->TransactionNo; ?>"> 
  <div class="column-label">Product</div>
  <div class="column-value">: <?php echo $res->ProductName; ?></div>
  <div class="column-label">Description</div>
  <div class="column-value">: <?php echo $res->Description; ?></div>
  <div class="column-label">Category</div>
  <div class="column-value">: <?php echo $res->Categories; ?></div>
  <div class="column-label">Price</div>
  <div class="column-value">: <?php echo $res->Price; ?></div>
  <div class="column-label">Quantity</div>
  <div class="column-value"><input type="number" name="Quantity" class="form-control" value="<?php echo $res->qty; ?>"></div>
  <div class="column-label">Date Expired</div>
  <div class="column-value">
    <div class="input-group date  " data-provide="datepicker" data-date="2012-12-21T15:25:00Z">
        <input type="input" class="form-control input-sm date_picker" id="DateExpire" name="DateExpire" placeholder="mm/dd/yyyy"   autocomplete="off" value="<?php echo date_format(date_create($res->DateExpire),"m/d/Y"); ?>"  required="true" /> 
        <span class="input-group-addon"><i class="fa fa-th"></i></span>
      </div> 
  </div>
</div> 
<div class="row">
  <input type="submit" name="btnSubmit" value="Save" class="btn-primary btn btn-md">
</div>
</form>
<?php }else{ ?>
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
<?php } ?>

    </div> 

<hr/>

  <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">History  </h1>
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
              $mydb->setQuery("SELECT *,s.ProductID as pid,sum(Stocks) as 'qty' FROM `tblproduct` p,`tblcategory` c,`tblstockin` s WHERE p.`CategoryID`=c.`CategoryID` AND p.`ProductID`=s.`ProductID` AND p.StoreID=".$_SESSION['ADMIN_USERID']." GROUP BY CONCAT(TransactionNo,p.ProductID)");
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
                    echo '<td align="center"><a title="Edit" href="index.php?view=edit&id='.$result->TransactionNo.'" class="btn btn-primary btn-xs  ">  <span class="fa fa-edit fw-fa"></a>
                    <a title="Delete" href="controller.php?action=delete&id='.$result->TransactionNo.'&ProductID='.$result->pid.'&TransQuantity='.$result->Stocks.'" class="btn btn-danger btn-xs  ">  <span class="fa  fa-trash-o fw-fa "></a></td>';
                    echo '</tr>';
            } 
            ?>
          </tbody>
          
        </table> 
            <div class="btn-group">
         <!--  <a href="index.php?view=add" class="btn btn-default">New</a> -->
          <?php
          if($_SESSION['ADMIN_ROLE']=='Administrator'){
          // echo '<button type="submit" class="btn btn-default" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button'
          ; }?>
        </div>
      
      
        </form>
  
 <div class="table-responsive">  