 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Main content -->
    <section class="content">
      <div class="row"> 
        <!-- /.col -->
        <?php if (!isset($_GET['p'])) {  ?>
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">List of Orders</h3> 
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table id="dash-table" class="table table-striped table-bordered table-hover"  style="font-size:12px" cellspacing="0">
                    <thead>
                      <tr>

                      <th>DateOrder</th>
                      <th>OrderNo</th>
                      <th>Customer</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th> 
                    <th>Categories</th>
                    <th>Remarks</th>

                    <th width="14%" >Action</th> 
                      </tr> 
                    </thead> 
                    <tbody>
                      <?php 
                       // `COMPANYID`, `OCCUPATIONTITLE`, `REQ_NO_EMPLOYEES`, `SALARIES`, `DURATION_EMPLOYEMENT`, `QUALIFICATION_WORKEXPERIENCE`, `JOBDESCRIPTION`, `PREFEREDSEX`, `SECTOR_VACANCY`, `JOBSTATUS`
                        $mydb->setQuery("SELECT *,s.ProductID as pid FROM `tblproduct` p,`tblcategory` c,`tblstockout` s,tblcustomer cs WHERE p.`CategoryID`=c.`CategoryID` AND p.`ProductID`=s.`ProductID` AND s.CustomerID=cs.CustomerID AND s.CustomerID=".$_SESSION['CustomerID']);
                        $cur = $mydb->loadResultList(); 
                      foreach ($cur as $result) {
                          echo '<tr>';
                              // echo '<td width="5%" align="center"></td>';
                              // echo '<td>
                              //      <input type="checkbox" name="selector[]" id="selector[]" value="'.$result->CATEGORYID. '"/>
                      //    ' . $result->CATEGORIES.'</a></td>';
                      echo '<td>'. $result->DateSold.'</td>';
                      echo '<td>'. $result->OrderNo.'</td>';
                      echo '<td>'. $result->CustomerName.'</td>';
                      echo '<td>'. $result->ProductName.'</td>';
                      echo '<td>' . $result->Description.'</a></td>';
                      echo '<td>' . $result->Price.'</a></td>'; 
                      echo '<td>'. $result->Quantity.'</td>';  
                      echo '<td>'. $result->Categories.'</td>';  
                      echo '<td>'. $result->Remarks.'</td>';  

                      if ($result->Status=="Cancelled" || $result->Status=="Confirmed" || $result->Status=="Accepted"  ) {
                        # code...
                        echo '<td><a title="View" href="index.php?view=viewproduct&id='.$result->StockoutID.'" class="  ">  <span class="fa fa-edit fw-fa"></a></td>';
                      }else{
                      echo '<td align="center"><a title="View" href="index.php?view=viewproduct&id='.$result->StockoutID.'" class="  ">  <span class="fa fa-edit fw-fa"></a>
                      <a title="Cancel" href="controller.php?action=cancel&id='.$result->StockoutID.'&ProductID='.$result->pid.'&TransQuantity='.$result->Quantity.'" class=" ">  <span class="fa  fa-times fw-fa "></a></td>';

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
   
 