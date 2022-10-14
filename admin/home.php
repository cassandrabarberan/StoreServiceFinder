<style type="text/css">
  #stretch img {
    width: 100%;
    height: 50px;
  }
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">

              <?php
               

                $sql = "SELECT COUNT(*) as NUM FROM tblproduct p,`tblstockout` s WHERE p.ProductID=s.ProductID AND `Status`='Pending' AND StoreID=".$_SESSION['ADMIN_USERID'];
                $mydb->setQuery($sql);
                $orders = $mydb->loadSingleResult();
                echo '<h3>'.$orders->NUM.'</h3>';

              ?>
           

              <p>Pending Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php
                $sql = "SELECT COUNT(*) as NUM FROM `tblproduct` WHERE StoreID=".$_SESSION['ADMIN_USERID'];
                $mydb->setQuery($sql); 
                $product = $mydb->loadSingleResult();
                echo '<h3>'.$product->NUM.'</h3>';

              ?>
              <p>All Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php

                // $expiry_date = "2017-12-31 00:00:00";
                // $today = date('d-m-Y',time()); 
                // $exp = date('d-m-Y',strtotime($expiry_date));
                // $expDate =  date_create($exp);
                // $todayDate = date_create($today);
                // $diff =  date_diff($todayDate, $expDate);
                // if($diff->format("%R%a")>0){
                // echo "active";
                // }else{
                // echo "inactive";
                // }
                // echo "Remaining Days ".$diff->format("%R%a days");
 
                $sql = "SELECT Sum(ExpiredQty) as NUM FROM tblproduct p,`tblstockin` s WHERE p.ProductID=s.ProductID  AND StoreID=".$_SESSION['ADMIN_USERID'];
                $mydb->setQuery($sql); 
                $product = $mydb->loadSingleResult();
                echo '<h3>'.$product->NUM.'</h3>';

              ?>

              <p>Expires Product</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php
                 $sql = "SELECT Sum(Remaining) as NUM FROM tblproduct p,`tblstockin` s WHERE p.ProductID=s.ProductID  AND StoreID=".$_SESSION['ADMIN_USERID'];
                $mydb->setQuery($sql);
                $inventory = $mydb->loadSingleResult();
                echo '<h3>'.$inventory->NUM.'</h3>';

              ?>
              <p>Overall Stocks</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">

          	  <?php
                 $sql = "SELECT *, Sum(Remaining) as NUM FROM tblproduct p,`tblstockin` s WHERE p.ProductID=s.ProductID  AND StoreID=".$_SESSION['ADMIN_USERID']." GROUP BY p.ProductID";
                $mydb->setQuery($sql);
                $res = $mydb->loadResultList();
                foreach ($res as $row) {
                	# code...
                	$productname[] = $row->ProductName;
                	$qty[] = $row->NUM;
                }

              ?>
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right"> 
              <li class=""><a href="#charts_inventory" data-toggle="tab">Pie</a></li>
              <li class="active"><a href="#lowstocks" data-toggle="tab">Stocks</a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Inventory</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="tab-pane " id="charts_inventory" >
                <canvas  class="chart" style=" height: 100px;" id="chartjs_pie"></canvas>
              </div> 
              <div class="tab-pane active" id="lowstocks" style=" height: 300px;">

                <div style="font-size: 23px">List of Expired Products</div>
                
              <table id="dash-table" class="table table-striped  table-hover table-responsive" style="font-size:12px; display:inline-table" cellspacing="0">

                <thead>
                  <tr> 
                  <th width="50px">Pictures</th>
                  <th>Product</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Expired Date</th> 
                  <th>Categories</th>
                  <th>Status</th> 
                  </tr> 
                </thead> 
                <tbody>
                  <?php    
                    $sql ="SELECT *, Sum(Remaining) as NUM FROM `tblproduct` p,`tblstockin` i, `tblcategory` c,`tblstore` s WHERE p.`ProductID`=i.`ProductID` AND p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID`  AND p.`StoreID`=".$_SESSION['ADMIN_USERID']."   GROUP BY p.ProductID"; 
                    $mydb->setQuery($sql);
                    $cur = $mydb->loadResultList();

                  foreach ($cur as $result) { 
                   

                  $expiry_date = $result->DateExpire;
                  $today = date('d-m-Y',time()); 
                  $exp = date('d-m-Y',strtotime($expiry_date));
                  $expDate =  date_create($exp);
                  $todayDate = date_create($today);
                  $diff =  date_diff($todayDate, $expDate);
                  if($diff->format("%R%a")>0){

                    $expStatus =  "active";
                  }else{
                     echo '<tr>'; 
                    echo '<td id="stretch"><img class="img-circle" src="products/'. $result->Image1.'" /></td>';
                    echo '<td>'. $result->ProductName.'</td>';
                    echo '<td>' . $result->Description.'</a></td>';
                    echo '<td>' . $result->Price.'</a></td>'; 
                    echo '<td>'. $result->NUM.'</td>'; 
                    echo '<td>'. $result->DateExpire.'</td>';
                    echo '<td>'. $result->Categories.'</td>';  
                    $expStatus =  "Expired";

                    echo '<td>'.$expStatus.'</td>'; 
                    echo '</tr>';
                    }  
                  } 
                  ?>
                </tbody>
                
              </table>
              </div> 
            </div>
          </div>
          <!-- /.nav-tabs-custom -->

           
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  
  