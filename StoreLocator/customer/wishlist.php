 <!-- Content Wrapper. Contains page content -->
 
<?php
 if(isset($_GET['id'])) {

   $productID = $_GET['id'];
   $sql ="SELECT * FROM tblproduct p, tblcategory c WHERE p.CategoryID=c.CategoryID AND ProductID = '{$productID}'";
  $mydb->setQuery($sql);
  $cur = $mydb->executeQuery();
  $maxrow = $mydb->num_rows($cur);

    if ($maxrow>0) {
      # code...
      $res = $mydb->loadSingleResult(); 
   

      $pid = $res->ProductID;
      $product = $res->ProductName . ' | ' . $res->Description . ' | '.$res->Categories;
      $price = $res->Price;
      $q =1;
      $subtotal = $price * $q;
      addtocart($pid,$product,$price,$q,$subtotal);
    }
    redirect(web_root."index.php?q=cart");
 }
  
  ?>

  <div class="content-wrapper"> 
    <!-- Main content -->
    <section class="content">
      <div class="row"> 
        <!-- /.col -->
        <?php if (!isset($_GET['p'])) {  ?>
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Wish List</h3> 
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table id="dash-table" class="table table-striped table-bordered table-hover"  style="font-size:12px" cellspacing="0">
                    <thead>
                      <tr>  
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price</th> 
                        <!-- <th>Expired Date</th>  -->
                        <th>Categories</th>
                        <th></th> 
                      </tr> 
                    </thead> 
                    <tbody>
                      <?php 
                       // `COMPANYID`, `OCCUPATIONTITLE`, `REQ_NO_EMPLOYEES`, `SALARIES`, `DURATION_EMPLOYEMENT`, `QUALIFICATION_WORKEXPERIENCE`, `JOBDESCRIPTION`, `PREFEREDSEX`, `SECTOR_VACANCY`, `JOBSTATUS`
                       $sql ="SELECT * FROM `tblwishlist` w, `tblproduct` p, `tblcategory` c WHERE w.`ProductID`=p.`ProductID` AND p.`CategoryID`=c.`CategoryID` AND `CustomerID`=".$_SESSION['CustomerID'];
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList(); 
                      foreach ($cur as $result) {

                        // $expiry_date = $result->DateExpire;
                        // $today = date('d-m-Y',time()); 
                        // $exp = date('d-m-Y',strtotime($expiry_date));
                        // $expDate =  date_create($exp);
                        // $todayDate = date_create($today);
                        // $diff =  date_diff($todayDate, $expDate);
                        // if($diff->format("%R%a")>0){

                        // $expStatus =  "active";
                        // }else{
                        // $expStatus =  "Expired";
                        // }
                          echo '<tr>'; 
                          echo '<td>'. $result->ProductName.'</td>';
                          echo '<td>' . $result->Description.'</td>';
                          echo '<td>' . $result->Price.'</a></td>';  
                          // echo '<td>'. $result->DateExpire.'</td>';
                          echo '<td>'. $result->Categories.'</td>';  

                          $sql = "SELECT *,SUM(`Remaining`) as Remain FROM tblproduct pr,`tblstockin` p,`tblwishlist` w WHERE pr.`ProductID`=p.`ProductID`  AND p.`ProductID`=w.`ProductID` AND p.`ProductID`='".$result->ProductID."' AND `CustomerID`='".$_SESSION['CustomerID']."' GROUP BY p.`ProductID`";
                          $mydb->setQuery($sql);
                          $cur = $mydb->executeQuery();
                          $maxrow = $mydb->num_rows($cur);

                          if($maxrow > 0){

                           echo '<td><a href="'.web_root.'customer/index.php?view=wishlist&id='.$result->ProductID.'">Order Now!</a></td>';   
                          }else{

                           echo '<td></td>';   
                          }

                          echo '</tr>';
                      } 
                      ?>
                    </tbody>
                    
                  </table> 
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div> 
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
        <?php }else{
          require_once ("viewjob.php");          
        } ?>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
   
 