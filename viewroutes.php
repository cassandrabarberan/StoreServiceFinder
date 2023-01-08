

<style type="text/css">
  #map {
    height: 500px;
    width: 100%;
    background-color: grey;
  }
  .stretch img{
    width: 100%;
    height: 200px;
  } 
.gold {
  color: gold;
}
.rating {
    float:left;
}

/* :not(:checked) is a filter, so that browsers that don’t support :checked don’t 
   follow these rules. Every browser that supports :checked also supports :not(), so
   it doesn’t make the test unnecessarily selective */
.rating:not(:checked) > input {
        position: absolute;
        /* top: -9999px; */
        clip: rect(0, 0, 0, 0);
        height: 0;
        width: 0;
        overflow: hidden;
        opacity: 0;
}

.rating:not(:checked) > label {
    float:right;
    width:1em;
    padding:0 .1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:200%;
    line-height:1.2;
    color:#ddd;
    text-shadow:1px 1px #bbb, 2px 2px #666, .1em .1em .2em rgba(0,0,0,.5);
}

.rating:not(:checked) > label:before {
    content: '★ ';
}

.rating > input:checked ~ label {
    color: #f70;
    text-shadow:1px 1px #c60, 2px 2px #940, .1em .1em .2em rgba(0,0,0,.5);
}

.rating:not(:checked) > label:hover,
.rating:not(:checked) > label:hover ~ label {
    color: gold;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

.rating > input:checked + label:hover,
.rating > input:checked + label:hover ~ label,
.rating > input:checked ~ label:hover,
.rating > input:checked ~ label:hover ~ label,
.rating > label:hover ~ input:checked ~ label {
    color: #ea0;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

.rating > label:active {
    position:relative;
    top:2px;
    left:2px;
}

.tableRating tr td {
  padding: 5px 20px;

}
</style>
<?php  
  $StoreID = isset($_GET['search']) ? $_GET['search'] : ""; 
  // $distance = isset($_GET['distance']) ? $_GET['distance'] : "";


if (!isset($_COOKIE['lat'])) {
    # code...
    echo '<script>alert("Please allow to know your location in order to proceed.")</script>';
    redirect("index.php");
} 


if (isset($_POST['submitRating']) ) {
  # code...
  $ratingNo = $_POST['ratingNo'];
  $StoreID = $_POST['StoreID'];
  $cus_username = $_SESSION['Customer_Username'];
  $fedback = $_POST['fedback'];
  $sql = "INSERT INTO `tblrating` (`RatingNo`, `StoreID`, `Customer_Username`, `RateDate`, `FeedBack`) 
         VALUES ({$ratingNo},{$StoreID},'{$cus_username}',NOW(),'{$fedback}')";
  $mydb->setQuery($sql);
  $mydb->executeQuery();

   redirect(web_root.'index.php?q=viewroutes&search='.$StoreID);
}

 if ($StoreID!="") {

    $sql = "SELECT * FROM `tblstore` s, `tblusers` u WHERE StoreID=UserID AND StoreID=".$StoreID;
    $mydb->setQuery($sql);
    $store = $mydb->loadSingleResult(); 


  $distance = distance($_COOKIE["lat"], $_COOKIE["lng"],  $store->lat,  $store->lng, 'k');



 ?>
 <section id="content" class="container">
  <h2>Store</h2>
  <hr>
 <div class=""> 

  <div class="col-md-6"><div id="map"></div></div>
  <div class="col-md-6"> 
     <div class="stretch"> 
         <img src="<?php echo web_root.'admin/user/'.$store->PicLoc;?>"> 
      </div>
       <div class="info-blocks-in">
          <h3><?php echo $store->StoreName;?></h3> 
                               <!-- <p><?php echo $store->BHDescription;?></p>  -->
                     <p><i class="fa fa-map-marker"></i> <?php echo $store->StoreAddress;?></p>
            <p><i class="fa fa-phone"></i> <?php echo $store->ContactNo;?></p>
            <p><i class="fa fa-road"></i> <?php   echo $distance.' KM'; ?></p>
             <p class="col-md-6"><a  class="btn btn-primary" href="index.php?q=item&store=<?php echo $store->StoreID;?>"><i class="fa fa-list"></i> View Products</a></p>
             <p class="col-md-6">
     <?php if (isset($_SESSION['CustomerID'])) { ?> 

                    <a class="btn btn-success" href="<?php echo web_root.'customer/index.php?view=compose&store='.$store->StoreID;?>"><i class="fa fa-envelope-o"></i> Send a Message</a>
               <?php }else{
                 echo '<a data-target="#myModal_SendMessage" data-toggle="modal" href="" data-id="'. $store->StoreID.'" class="btn btn-primary" id="storeID_message"><i class="fa fa-envelope-o"></i> Send a Message</a>';

               } ?>

              </p>

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
          <div style="margin-bottom: 20px;border-bottom: 1px #ddd solid;padding-top: 20px;border-top: 1px solid #ddd"> 
               <?php 
               $sql = "SELECT * FROM `tblrating` r,tblcustomer c WHERE r.Customer_Username=c.Customer_Username AND  `StoreID`=".$store->StoreID;
               $mydb->setQuery($sql);
               $cur = $mydb->loadResultList();

               foreach ($cur as $result) { 
                ?>
                 <div class="row">
                 <div class="col-md-4">
                       <img width="100px;" class="img-circle img-border" src="<?php echo web_root.'customer/'.$result->Customer_Photo ?>"/></div>
                 <div class="col-md-8">
                    <p style="font-size: 19px; color: red;font-weight: bold;"><?php echo $result->Customer_Username ?></p>
                    <p><?php echo $result->FeedBack ?></p>
                    <p width="20%">
                     <?php for ($i=0; $i < $result->RatingNo; $i++) { ?>
                     <i   class="fa fa-star gold"></i>
                     <?php } ?>
                   </p>
                 </div>
                 </div>
             <?php  }  ?> 
          </div> 


          <div>
            <form action="" method="POST"  > 
              <h1>Leave Comment</h1>
              <label class="">Feed Back</label>
              <div><textarea name="fedback" class="form-control" rows="9"></textarea></div>
              <br/>
                 <div class="rating"> 
                    <input type="radio" id="star5" name="ratingNo" value="5" /><label for="star5" title="Rocks!">5 stars</label>
                    <input type="radio" id="star4" name="ratingNo" value="4" /><label for="star4" title="Pretty good">4 stars</label>
                    <input type="radio" id="star3" name="ratingNo" value="3" /><label for="star3" title="Not Bad">3 stars</label>
                    <input type="radio" id="star2" name="ratingNo" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
                    <input type="radio" id="star1" name="ratingNo" value="1" /><label for="star1" title="Mahal Masyado">1 star</label>
                </div>
                <div style="clear: all;"></div>
                <?php if (isset($_SESSION['CustomerID'])) { ?> 

                    <input type="hidden" name="StoreID" id="StoreID" value="<?php echo $store->StoreID;?>" /> 
                 <div class="col-lg-12 row" > <button type="submit" name="submitRating" class="btn btn-primary ">Submit</button></div>
               <?php }else{
                 echo '<div class="col-lg-12 row" ><a data-target="#myModal_Rating" data-toggle="modal" href="" data-id="'. $store->StoreID.'" class="btn btn-primary" id="StoreID_rating">Submit</a></div>';

               } ?>
            </form>

          </div>
  </div> 
</div>
</section>

<?php  }  ?>

 
<?php   
  $sql = "SELECT *  FROM  `tblstore` s WHERE  StoreID={$StoreID}" ;  
  $mydb->setQuery($sql);
  $cur = $mydb->loadResultList();


  foreach ($cur as $result) {  
       $lat = $result->lat;
       $lng = $result->lng; 

        $data[] =array( $result->StoreName,$result->StoreAddress,$result->lat,$result->lng,"index.php?q=item&store=".$result->StoreID);
 
 }   
  ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCf6S1zyhpO7b0ullahzfdpFk1N465D7sQ&libraries=places"> </script>

<script>
        /**
         * Create new map
         */
        var infowindow;
        var map;
        var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
        var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
        var marker; 
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var locations = <?php echo json_encode($data) ?>;  
        var i ; 

         if ("geolocation" in navigator){
            navigator.geolocation.getCurrentPosition(function(position){

                var currentLatitude = position.coords.latitude;
                var currentLongitude = position.coords.longitude;
                LatLng ={lat:currentLatitude,lng:currentLongitude}
                directionsDisplay = new google.maps.DirectionsRenderer(); 
                map = new google.maps.Map(document.getElementById('map'), {zoom: 13, center: LatLng});  
 
                for (i = 0; i < locations.length; i++) { 
                    var  start = new google.maps.LatLng(currentLatitude, currentLongitude); 
                    var end = new google.maps.LatLng(locations[i][2], locations[i][3]);


                    calcRoute(start,end)

                } 


            });
          }
       
        //  LatLng = {lat:7.649989930233852, lng:126.01883687540885};  
        //  directionsDisplay = new google.maps.DirectionsRenderer(); 
        //  map = new google.maps.Map(document.getElementById('map'), {zoom: 10, center: LatLng});  
    

        
        // for (i = 0; i < locations.length; i++) { 
        //         var  start = new google.maps.LatLng(7.649989930233852, 126.01883687540885); 
        //         var end = new google.maps.LatLng(locations[i][2], locations[i][3]); 

        //         calcRoute(start,end) 
 
        // } 
        
 
   

    function calcRoute(start,end) { 
        var bounds = new google.maps.LatLngBounds();
        bounds.extend(start);
        bounds.extend(end);
        map.fitBounds(bounds);
        var request = {
            origin: start,
            destination: end, 
            optimizeWaypoints: false,
            durationInTraffic: true,
            provideRouteAlternatives: true,
            avoidHighways: false,
            avoidTolls: false,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);
            } else {
                alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
            }
        });
    }


function locate(){
    document.getElementById("btnAction").disabled = true;
    document.getElementById("btnAction").innerHTML = "Processing...";
    if ("geolocation" in navigator){
      navigator.geolocation.getCurrentPosition(function(position){ 
        var currentLatitude = position.coords.latitude;
        var currentLongitude = position.coords.longitude;

        var infoWindowHTML = "Latitude: " + currentLatitude + "<br>Longitude: " + currentLongitude;
        var infoWindow = new google.maps.InfoWindow({map: map, content: infoWindowHTML});
        var currentLocation = { lat: currentLatitude, lng: currentLongitude };
        infoWindow.setPosition(currentLocation);
        document.getElementById("btnAction").style.display = 'none';
      });
    }
  }
  
    </script>

