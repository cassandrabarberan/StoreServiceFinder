<style type="text/css">
  .stretch img{
    width: 100%;
    height: 200px;
  }
    .gold {
    color: gold;
}
.comment span {
  width: 1px;
  font-size:12px;
  margin-left: 10px;
  padding-top: 10px;
  font-weight: bold;
}
.comment i {
  font-size: 30px;
  position: absolute;
}
.info-blocks{
  min-height: 450px;
  border:1px solid #ddd;
  padding: 0px;
}

  .info-blocks:hover{

    background-color: #fff;
      /*border: .5px #ddd solid;*/
      cursor: pointer;
     box-shadow: 
        0 0 1px 1px #ddd, /* middle magenta */
        0 0 1px 1px #000; /* outer cyan */
  }
  .info-blocks-in{
    background-color: #fff;
  }
  .info-blocks a,
   .info-blocks a:hover{
    color: #000;
    text-decoration: none;
  }

</style>
    <section id="content">
        <div class="container content">     
        <!-- Service Blcoks -->  
        <div class="row">
            <?php 
                  $sql = "SELECT * FROM `tblstore` s, `tblusers` u WHERE StoreID=UserID";
                  $mydb->setQuery($sql);
                  $stor = $mydb->loadResultList(); 

                  foreach ($stor as $store ) { 
            ?>
                    <div class="col-sm-4 info-blocks" > 
                       <div class="stretch">
                        <a href="<?php echo web_root.'index.php?q=viewroutes&search='.$store->StoreID.'&lat='.$store->lat.'&lng='.$store->lng;?>">
                         <img src="<?php echo web_root.'admin/user/'.$store->PicLoc;?>">
                       </a>
                       </div>
                          <a href="<?php echo web_root.'index.php?q=viewroutes&search='.$store->StoreID.'&lat='.$store->lat.'&lng='.$store->lng;?>">
                        <div class="info-blocks-in" style="background-color: #fff;">
                            <h3><?php echo $store->StoreName;?></h3> 
                             <p><i class="fa fa-map-marker"></i> <?php echo $store->StoreAddress;?></p>
                    <p><i class="fa fa-phone"></i> <?php echo $store->ContactNo;?></p>

                        <?php 

                            $sql = "SELECT count(*) as comment, SUM(RatingNo) as Ratings FROM `tblrating` WHERE `StoreID`=".$store->StoreID. " GROUP BY StoreID;";
                            $mydb->setQuery($sql);
                            $cur = $mydb->executeQuery();
                            $maxrow = $mydb->num_rows($cur);
                            if ($maxrow > 0) {
                              # code...
                              $rating = $mydb->loadSingleResult(); 
                              if ($rating->Ratings >= 100) {
                                # code...
                                 $ratings =(100 * 5 ) / 100;
                              }else{
                                 $ratings =($rating->Ratings * 5 ) / 100;
                              }
                                
                               for ($i=0; $i < $ratings ; $i++) { 
                                  # code...
                                  echo  '<i style = "font-size:30px" class="fa fa-star gold"></i>';
                                } 
                                echo  '<div class="comment"><i class="fa fa-comment-o"></i>
                                           <span  >'.$rating->comment.'</span></div>';
                            
                            }else{

                                $ratings = 5;
                                for ($i=0; $i < $ratings ; $i++) {  
                                  echo  '<i style = "font-size:30px" class="fa fa-star"></i>';
                                } 
                                echo  '<div class="comment"><i class="fa fa-comment-o"></i>
                                           <span  >0</span></div>';
                            
                            } 
                           
                         ?>
                       
                        </div>
                      </a>
                    </div>

            <?php } ?>

 
 
         </div> 
        </div>
    </section>