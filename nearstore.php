<?php 
// validating cookie
// if (!isset($_COOKIE['lat'])) {
//   # code...
//   echo '<script>alert("Please allow to know your location in order to proceed.")</script>';
//   redirect("index.php");
// }
?>
<style type="text/css">
  .stretch img{
    width: 100%; 
    height: 130px;
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
  text-align: left;
  text-decoration: none; 
  padding: 1px;
  margin: 0px;
  background-color: #fff;
  margin-bottom: 10px; 
}

.info-blocks:hover{    
  background-color: #fff;  
}
 .info-blocks-in{    
  padding: 0px;
  margin: 0px;
}

.info-blocks-in p,
.info-blocks-in h4 {
  margin: 0px;
  padding: 0px;
}
 
</style>
  <section id="content">
    <div class="container">  
      <h4>Store near you.....</h4>
      <hr/>   
        <!-- Service Blcoks --> 
        <div class="row">
           <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
           <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTanm_xZQi4_RHeCAxerOqXN96NUwrbZU&libraries=places"> </script>
          <script type="text/javascript">
                
                var directionsDisplay;
                var directionsService = new google.maps.DirectionsService();
                 if ("geolocation" in navigator){
                    navigator.geolocation.getCurrentPosition(function(position){

                        var currentLatitude = position.coords.latitude;
                        var currentLongitude = position.coords.longitude;  

                         lat("lat",currentLatitude,'.3');
                         lng("lng",currentLongitude,'.3'); 
 

                    });

                  } 



               function lat(name, value, days) {
                  var expires;
                  if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toGMTString();
                  }
                  else {
                    expires = "";
                  }
                  document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
                }



           
                function lng(name, value, days) {
                  var expires;
                  if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toGMTString();
                  }
                  else {
                    expires = "";
                  }
                  document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
                }
 
  
          </script>
          <?php 
          // validating cookie
            if (!isset($_COOKIE['lat'])) {
              # code...
             // redirect("index.php?q=nearstore");
            }
          ?>

            <?php  
                  $listDistance = array(); 
                  $sql = "SELECT * FROM `tblstore` s, `tblusers` u WHERE StoreID=UserID";
                  $mydb->setQuery($sql);
                  $store = $mydb->loadResultList(); 

                  foreach ($store as $nearstore ) { 

                  
                    // echo '<i class="fa fa-road"></i> '.distance($_COOKIE["cookie_lat"], $_COOKIE["cookie_lng"],  $nearstore->lat,  $nearstore->lng, 'k').' KM <br/>'; 
 
               

                     $distance = distance($_COOKIE["lat"], $_COOKIE["lng"],  $nearstore->lat,  $nearstore->lng, 'k');

                     $dis  = array($distance,$nearstore->StoreID); 
                     array_push($listDistance, $dis); 
  


             } 
             
            sort($listDistance);

            $max = count($listDistance); 
            //  print_r($listDistance);

            // echo "KM".$listDistance[0][0].": ID: ".$listDistance[0][1].".<br>";
            // echo "KM".$listDistance[1][0].": ID: ".$listDistance[1][1].".<br>";
            // echo "KM".$listDistance[2][0].": ID: ".$listDistance[2][1].".<br>";
            // echo "KM".$listDistance[3][0].": ID: ".$listDistance[3][1].".<br>";

            foreach ($listDistance as $key => $value) {
              # code... 
                // echo "KM".$listDistance[$key][0].": ID: ".$listDistance[$key][1].".<br>"; 
// SELECT `StoreID`, `StoreName`, `StoreAddress`, `ContactNo`, `st_Image1`, `st_Image2`, `st_Image3`, `lat`, `lng`, `EmailAdd` FROM `tblstore` WHERE 1
                 $sql = "SELECT * FROM `tblstore` s, `tblusers` u WHERE StoreID=UserID AND  StoreID= '".$listDistance[$key][1]."' ";
                 $mydb->setQuery($sql);
                 $res = $mydb->loadSingleResult();
            ?>

                             <div id="bh" class="col-sm-12 info-blocks" > 
                       <div class="col-md-2 stretch" style="padding: 0px"> 
                         <img src="<?php echo web_root.'admin/user/'.$res->PicLoc;?>"> 
                       </div>
                       <div class="col-md-10" style="padding: 0px 0px 0px 0px"> 
                          <div class="info-blocks-in" style="padding: 0px 0px 0px 10px;background-color: #fff">
                              <h4><?php echo $res->StoreName;?></h4> 
                               <!-- <p><?php echo $res->BHDescription;?></p> -->
                               <p><i class="fa fa-map-marker"></i> <?php echo $res->StoreAddress;?></p>
                               <p><i class="fa fa-road"></i> <?php echo  $listDistance[$key][0];?> KM</p>
                               <p><i class="fa fa-phone"></i> <?php echo $res->ContactNo;?></p>
                               <p> 

                                 <?php 

                                    $sql = "SELECT count(*) as comment, SUM(RatingNo) as Ratings FROM `tblrating` WHERE `StoreID`=".$res->StoreID. " GROUP BY StoreID;";
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
                                          echo  '<i style = "font-size:12px" class="fa fa-star gold"></i>';
                                        } 
                                          
                                    
                                    }else{

                                        $ratings = 5;
                                        for ($i=0; $i < $ratings ; $i++) {  
                                          echo  '<i style = "font-size:12px" class="fa fa-star"></i>';
                                        } 
                                      
                                    
                                    } 
                                   
                                 ?>  
                               
                              </p>



                               <p> <a href="<?php echo web_root.'index.php?q=viewroutes&search='.$res->StoreID.'&lat='.$nearstore->lat.'&lng='.$nearstore->lng.'&distance='.$distance; ?>"><i class="fa fa-map-marker"></i> View Location</a></p>
                          </div>  
                        </div> 
                    </div>

          
        <?php    
         } 
        ?> 

                   
         </div> 
       </div>
    </section>

 