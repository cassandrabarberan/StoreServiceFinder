<?php 
    if (!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     } 
?>
<style type="text/css"> 
  .column {
    float: left;
    width: 25%;
    padding: 5px;
  }
  .row:after{
    content: "";
    display: table;
    clear: both;
  }
</style>  
    <div class="col-lg-12">
      <label class="col-lg-2">Find Product</label>
      <div class="col-lg-4">
        <select class="form-control select2" id="findProduct" name="ProductID">
          <option>Select</option>
          <?php
            $sql="Select * FROM tblproduct WHERE StoreID=".$_SESSION['ADMIN_USERID'];
            $mydb->setQuery($sql);
            $cur  = $mydb->loadResultList();
            foreach ($cur as $row) {
              # code...
              echo '<option value='.$row->ProductID.'>'.$row->ProductName.'</option>';
            }
          ?>
        </select>
      </div>
      
    </div>

<form action="controller.php?action=add" method="POST" >
    <div style="font-size: 14px" class="page-header">Product Details</div>
    <div class="col-lg-12">
      <div id="loaddata" style="min-height:130px" > 
      </div>
    </div>  
<div class="row">
<label class="col-md-2">
    Customer
  </label>  
   <div class="col-md-4">
      <select class="form-control select2" id="CustomerID" name="CustomerID">
        <option>Select</option>
        <?php
          $sql="Select * FROM tblcustomer";
          $mydb->setQuery($sql);
          $cur  = $mydb->loadResultList();
          foreach ($cur as $row) {
            # code...
            echo '<option value='.$row->CustomerID.'>'.$row->CustomerName.'</option>';
          }
        ?>
      </select>
    
</div> 
</div> 
<input type="submit" class="btn btn-primary btn-sm" value="Submit Order" id="CartSubmit" name="CartSubmit">
</form>

   