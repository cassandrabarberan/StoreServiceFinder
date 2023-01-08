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
  <div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">Stock In </h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
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
                if (isset($_GET['id'])) {
                    # code...
                   if ($row->ProductID==$_GET['id']) {
                     # code...   
                     echo '<option SELECTED value='.$row->ProductID.'>'.$row->ProductName.'</option>';
                   } 
                }else{
                     echo '<option value='.$row->ProductID.'>'.$row->ProductName.'</option>';
                }
           
            }
          ?>
        </select>
      </div>
      
    </div>
    <div style="font-size: 14px" class="page-header">Product Details</div>
    <div class="col-lg-12">
      <div id="loaddata" style="min-height:130px" > 
      </div>
    </div> 

<hr/>
