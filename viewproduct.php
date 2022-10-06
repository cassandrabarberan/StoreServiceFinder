<style type="text/css">
.stretch {
    margin-top: 5px;
}
 .stretch img{ 
 width: 100%; 
}
#watermark { position: absolute; bottom:5px;   opacity:0.5; z-index:00; color:white;  top: 0  }
</style>
    <section id="content">
        <div class="container content"> 
        <div class="table-container">  

                            <?php  
                                     $search = isset($_GET['id']) ? $_GET['id'] : ''; 
                                         $sql = "SELECT *,sum(Remaining) as 'qty' FROM tblstockin st, `tblproduct` p, `tblcategory` c,`tblstore` s WHERE st.ProductID=p.ProductID AND p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID` AND p.`ProductID` = '$search' GROUP BY p.ProductID";
 
                                // $sql = "SELECT * FROM tblinventory i,`tblstore` s,`tblproduct` p ,`tblcategory` c
                                //         WHERE i.ProductID=p.ProductID and s.StoreID=p.StoreID AND p.CategoryID=c.CategoryID AND p.ProductID = '$search'" ;
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
                                    $expStatus =  "Expired";
                                    }
                              ?>  

                            <form class="" action="cartcontroller.php?action=add" method="POST">
                                    <div class="row">
                                      <div class="panel panel-primary">
                                          <div class="panel-header">
                                               <div style="border-bottom: 1px solid #ddd;padding: 10px;font-size: 20px;font-weight: bold;color: #000;margin-bottom: 5px;"><a href="<?php echo web_root.'index.php?q=viewjob&search='.$result->JOBID;?>"><?php echo $result->Categories ;?></a> 
                                              </div> 
                                          </div>
                                          <div class="panel-body contentbody">
                                                <div class="col-sm-8"> 
                                                    <div class="col-sm-12">
                                                        <p>Store :</p>
                                                         <ul style="list-style: none;"> 
                                                            <li><?php echo $result->StoreName ;?></li> 
                                                        </ul> 
                                                    </div>
                                                    <div class="col-sm-12"> 
                                                        <p>Product</p>
                                                        <ul style="list-style: none;"> 
                                                             <li>Name : <?php echo $result->ProductName ;?></li> 
                                                             <li>Description : <?php echo $result->Description ;?></li> 
                                                             <li>Price :<?php echo $result->Price ;?></li> 
                                                             <li>Expired Date : <?php echo date_format(date_create($result->DateExpire),'M d, Y'); ?></li> 
                                                             <li>Remaining :<?php echo $result->qty ;?><input type="hidden" id="RQTY" value="<?php echo $result->qty ;?>"></li> 
                                                             <li>Status :<?php echo $expStatus ;?></li> 
                                                        </ul> 
                                                     </div>
                                                    <div class="col-sm-12">
                                                        <p>Location :  <?php echo  $result->StoreAddress ?></p>
                                                        <p>Contact No :  <?php echo  $result->ContactNo ?></p>  
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="hidden" name="ProductID" value="<?php echo  $result->ProductID ?>"> 
                                                       <?php 
 
                                                          // if ( $result->qty > 0 && $expStatus=='active' ) {  
                                                          //      echo  '  <input type="number" min="1" placeholder="Quantity" id="QTY" name="QTY'.$result->ProductID.'" value="1" class="form-control" style="margin-bottom: 5px;">
                                                          //      <button type="submit"  class="btn btn-main btn-next-tab"><i class="fa fa-shopping-cart"></i> Order Now !</button>';
                                                          // }else{   
                                                          //   if (isset($_SESSION['CustomerID'])) {
                                                          //      echo '<a class="btn btn-main btn-next-tab" href="process.php?action=wishlist&id='.$result->ProductID.'">Whish List</a>'; 
                                                          //   }else{
                                                          //       echo '<a data-target="#myModal" data-toggle="modal" href="" class="btn btn-main btn-next-tab">Whish List </a>';

                                                          //   }
                                                          // }
                                                           ?>

                                                    <div class="row stretch">
                                                        <!-- <img src=" <?php echo web_root.'admin/products/'. $result->Image1 ?>"> -->
                                                         <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                                <!-- Indicators -->
                                                                <ol class="carousel-indicators">
                                                                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                                                  <li data-target="#myCarousel" data-slide-to="1"></li>
                                                                  <li data-target="#myCarousel" data-slide-to="2"></li>
                                                                </ol>

                                                                <!-- Wrapper for slides -->
                                                                <div class="carousel-inner">
                                                                  <div class="item active">
                                                                  <img src=" <?php echo web_root.'admin/products/'. $result->Image1 ?>" style="height: 250px;">
                                                                  </div>

                                                                  <div class="item">
                                                                  <img src=" <?php echo web_root.'admin/products/'. $result->Image2 ?>" style="height: 250px;">
                                                                  </div>
                                                                
                                                                  <div class="item">
                                                                  <img src=" <?php echo web_root.'admin/products/'. $result->Image3 ?>" style="height: 250px;">
                                                                  </div>
                                                                </div>

                                                                <!-- Left and right controls -->
                                                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                                                  <span class="glyphicon glyphicon-chevron-left"></span>
                                                                  <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                                                  <span class="glyphicon glyphicon-chevron-right"></span>
                                                                  <span class="sr-only">Next</span>
                                                                </a>
                                                              </div>

                                                    </div>

                                                </div>
                                            </div> 
                                          <div class="panel-footer"> 
                                          </div>
                                      </div> 
                                  </div>
                    </form>  
                     <?php   if ( $result->qty <= 0 || $expStatus!='active' ) {   ?>
                        <div id="watermark">
                              <img src="<?php echo web_root;?>dist/img/soldout.png">
                       </div>
                     <?php } ?>
                            <?php  } ?>  
                </div>      
     
        </div>

    </section> 