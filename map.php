<style type="text/css">
 

 /*# Phone*/
@media only screen and (max-width:320px){
    #map { 
     height: 600px;
     width: 100%;
     background-color: grey;
     margin-top: -18px; 
     padding-bottom: 0px;
   }
}

/*# Tablet*/
@media only screen and (min-width:321px) and (max-width:768px){
    #map { 
     height: 600px;
     width: 100%;
     background-color: grey;
     margin-top: -18px; 
     padding-bottom: 0px;
   margin-bottom: -100px; 
   }
}

/*# Desktop*/
@media only screen and (min-width:769px){
  #map { 
   height: 600px;
   width: 100%;
   background-color: grey;
   margin-bottom: -100px; 
   padding-bottom: 0px;
 }
}
</style>

<div id="map"></div>

<?php   
// SELECT `StoreID`, `StoreName`, `StoreAddress`, `ContactNo`, `st_Image1`, `st_Image2`, `st_Image3`, `lat`, `lng`, `EmailAdd` FROM `tblstore` WHERE 1
 $sql = "SELECT * FROM `tblstore` , `tblusers`  WHERE StoreID=UserID" ;  
 $mydb->setQuery($sql);
 $cur = $mydb->loadResultList();


 foreach ($cur as $result) {  
      $lat = $result->lat;
      $lng = $result->lng; 

       $data[] =array($result->StoreName,$result->StoreAddress,$result->lat,$result->lng,"index.php?q=item&store=".$result->StoreID);

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
       var locations = <?php echo json_encode($data) ?>;  
       var i ; 

       // for current location
       var directionsDisplay;
       var directionsService = new google.maps.DirectionsService();
       //zamboanga 6.9214° N, 122.0790° E
       LatLng = { lat: 6.9215, lng: 122.0790 }; 
       map = new google.maps.Map(document.getElementById('map'), {
           zoom: 13, 
           center: LatLng
       });  


     /**
        * loop through (Mysql) dynamic locations to add markers to map.
        */ 
       var i ; 
       for (i = 0; i < locations.length; i++) {
                 var title = locations[i][0];
                 var address = locations[i][1];
                 var url = locations[i][4];

           marker = new google.maps.Marker({
               position: new google.maps.LatLng(locations[i][2], locations[i][3]),
               map: map,
               icon :  red_icon,
               html:  "<div><h4>" + title + "</h4><p>" + address + "<br></div><a href='" + url + "'>View Products</a></p><p><button  id='btnDirection' class='fa fa-road' >View Route</button></p></div>"
           });

           google.maps.event.addListener(marker, 'click', (function(marker, i) {
               return function() {
                   infowindow = new google.maps.InfoWindow();  
                   infowindow.setContent(marker.html);
                   infowindow.open(map, marker);


                    // $('#btnDirection').bind('click', function() {          
                    //    alert("hello direction") 
                    //  }); 

                    $('body').on('click', '#btnDirection', function() {
                          if ("geolocation" in navigator){
                             navigator.geolocation.getCurrentPosition(function(position){

                                 var currentLatitude = position.coords.latitude;
                                 var currentLongitude = position.coords.longitude;
                                 LatLng ={lat:currentLatitude,lng:currentLongitude}
                                 directionsDisplay = new google.maps.DirectionsRenderer(); 
                                 map = new google.maps.Map(document.getElementById('map'), {
                                   zoom: 10, 
                                   center: LatLng
                               });  
                  
                                 for (i = 0; i < locations.length; i++) { 
                                     var  start = new google.maps.LatLng(currentLatitude, currentLongitude); 
                                     //var end = new google.maps.LatLng(locations[i][2], locations[i][3]);
                                     var end = new google.maps.LatLng(6.9214, 122.0790);


                                     calcRoute(start,end)

                                 } 


                             });
                           }
                   });


                 

               }
           })(marker, i));
       } 




   function calcRoute(start,end) { 
       var bounds = new google.maps.LatLngBounds();
       bounds.extend(start);
       bounds.extend(end);
       map.fitBounds(bounds);
       var request = {
           origin: start,
           destination: end,
           travelMode: google.maps.TravelMode.DRIVING
       };
       directionsService.route(request, function (response, status) {
           if (status == google.maps.DirectionsStatus.OK) {
               directionsDisplay.setDirections(response);
               directionsDisplay.setMap(map);
           } else {
               //alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
           }
       });
   }

   </script>


    