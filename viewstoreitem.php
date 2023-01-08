  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- styles -->
    <style type="text/css">
      #map {
    height: 600px;
    width: 100%;
    background-color: grey;
  }
 </style>
 <?php
 if (isset($_GET['store'])) {
   # code...
     $search = $_GET['store'];  

     $sql = "SELECT * FROM `tblstore` s, `tblusers` u WHERE StoreID=UserID AND StoreID = '" .$search ."'";
      $mydb->setQuery($sql);
      $store = $mydb->loadSingleResult(); 
      $storeID = $store->StoreID; 
      $storename = $store->StoreName;
        $data[] =array( $store->StoreName,$store->StoreAddress,$store->lat,$store->lng,"index.php?q=item&store=".$store->StoreID);
 }else{
    $search = "";
 }
 
if (isset($_GET['product'])) {
  # code...
  $product = $_GET['product'];
}else{
  $product ='';
}
 ?>
     
 <section id="content">
  <div class="row content">
    <div class="col-md-12">
       
       <div class="col-md-6">
            <input type="hidden" id="address" value="<?php echo $store->StoreAddress;?>">
            <div id="map" ></div> 
        </div>

         <div class="col-md-6"> 
          <h2><?php echo $storename;?></h2>
          <!-- <p style="font-weight: bolder;">List of Products</p> -->
          <div class="table-responsive">
           <table id="dash-table" class="table table-bordered"> 
            <thead>
              <th>Product</th>
              <th>Description</th>
              <th>Category</th>
              <th>Price</th>
              <th>Quantity</th>
            </thead>
            <tbody> 
          <?php

              $sql = "SELECT *,sum(Remaining) as 'qty' FROM tblstockin st, `tblproduct` p, `tblcategory` c,`tblstore` s WHERE st.ProductID=p.ProductID AND p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID` AND s.StoreID = '".$storeID."' AND (ProductName Like '%{$product}%' OR Categories Like '%{$product}%') GROUP BY p.ProductID";

              // $sql = "SELECT * FROM tblinventory i,`tblstore` s,`tblproduct` p ,`tblcategory` c
              // WHERE i.ProductID=p.ProductID AND s.StoreID=p.StoreID AND p.CategoryID=c.CategoryID AND Remaining > 0 AND s.StoreID=".$search ;
              $mydb->setQuery($sql);
              $cur = $mydb->loadResultList(); 
              foreach ($cur as $result) {  
                echo '<tr>';
                echo  '<td><a title="Order Now!"  href="index.php?q=products&id='.$result->ProductID.'">'.$result->ProductName.'</a></td>';
                echo  '<td>'.$result->Description.'</td>';
                echo  '<td>'.$result->Categories.'</td>';
                echo  '<td>'.number_format($result->Price,2).'</td>';
                echo  '<td>'.$result->qty.'</td>';
                echo  '</tr>'; 
              } 
          ?> 
           </tbody>
          </table>
          </div>
        </div>
    </div> 
  </div>
</section>


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
                map = new google.maps.Map(document.getElementById('map'), {zoom: 10, center: LatLng});  
 
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