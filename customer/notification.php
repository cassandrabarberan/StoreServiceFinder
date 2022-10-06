<style type="text/css">
    .mailbox-controls .btn {
      padding: 3px 8px;
      margin: 0px 2px;
    }
</style>
 <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
    
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Notification</h3>

             <!--  <div class="box-tools pull-right" style="margin-bottom: 5px;">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Notification">
                  <span class="fa fa-search form-control-feedback" style="margin-top: -25px"></span>
                </div>
              </div> -->
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
         
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    <?php 
                        $sql = "SELECT * FROM tblproduct p,`tblstockout` s WHERE p.ProductID=s.ProductID AND `CustomerID`='".$_SESSION['CustomerID']."' ORDER BY StockoutID Desc";
                        $mydb->setQuery($sql);
                        $cur = $mydb->executeQuery();
                        $maxrow = $mydb->num_rows($cur);

                        if ($maxrow>0) {
                            $cur = $mydb->loadResultList();
                            foreach ($cur as $result) {
                              # code...
                              echo '<tr>'; 
                              echo '<td class="mailbox-name"><a href="index.php?view=viewproduct&id='.$result->StockoutID.'">'.$result->ProductName.'</a></td>';
                              echo '<td class="mailbox-subject">'.$result->Status.' | '.$result->Remarks.'</td>';  
                              echo '</tr>';
                            } 
                        } 


                      $sql = "SELECT *,SUM(`Remaining`) as Remain FROM tblproduct pr,`tblstockin` p,`tblwishlist` w WHERE pr.`ProductID`=p.`ProductID`  AND p.`ProductID`=w.`ProductID` AND `CustomerID`='".$_SESSION['CustomerID']."' GROUP BY p.`ProductID`";
                      $mydb->setQuery($sql);
                        $cur = $mydb->executeQuery();
                        $maxrow = $mydb->num_rows($cur);

                        if ($maxrow>0) {
                            $cur = $mydb->loadResultList();
                            foreach ($cur as $result) {
                              # code...
                              echo '<tr>'; 
                              echo '<td class="mailbox-name"><a href="'.web_root.'index.php?q=products&id='.$result->ProductID.'">'.$result->ProductName.'</a></td>'; 
                              echo '<td class="mailbox-subject">in stock</td>';  
                              echo '</tr>';
                            } 
                        } 

                    ?> 
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
     
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>