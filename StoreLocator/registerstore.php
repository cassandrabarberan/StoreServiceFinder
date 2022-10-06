<style type="text/css">
 .partition  {
    margin: 0px;
    padding: 10px;
  } 
  .partition #map {
    width: 100%;
     height:350px;
    background-color: grey;
  } 
</style>
<section id="content">
  <form name="personal" class="row form-horizontal span6  wow fadeInDown" action="process.php?action=registerstore" method="POST">
    <div class="container content">    
     <p> <?php check_message();?></p>      
     <div class="col-md-6 partition">
    <h2 class=" ">Store Information</h2> 
      <div class="form-group">
        <div class="col-md-12">
        <label class="col-md-4 control-label" for=
          "StoreName">Store Name:</label>

          <div class="col-md-8">
            <input name="JOBID" type="hidden" value="<?php echo $_GET['job'];?>">
             <input class="form-control input-sm" id="StoreName" name="StoreName" placeholder=
                "Store Name" type="text" value=""  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off">
          </div>
        </div>
      </div>

     
      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4 control-label" for=
          "StoreAddress">Address:</label>

          <div class="col-md-8">

            <!-- <input  class="form-control input-sm" id="StoreAddress" name="StoreAddress" placeholder=
              "Address" type="text" value="" required    autocomplete="off"> -->

           <textarea class="form-control input-sm" id="StoreAddress" name="StoreAddress" placeholder=
              "Address" type="text" value="" required    autocomplete="off"  ></textarea> 
          </div>
        </div>
      </div>  

       <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4 control-label" for=
          "ContactNo">Contact No.:</label>

          <div class="col-md-8">
            
             <input class="form-control input-sm" id="ContactNo" name="ContactNo" placeholder=
                "Contact No." type="text" any value="" required maxlength="11"  autocomplete="off">
          </div>
        </div>
      </div>  
      
      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4 control-label" for=
          "EmailAdd">E-mail Address:</label>
    
          <div class="col-md-8"> 
            <input  class="form-control input-sm" id="EmailAdd" name="EmailAdd" placeholder=
                "E-mail Address" type="email" autocomplete="off" required> 
          </div>
        </div>
      </div> 

      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4 control-label" for=
          "Username">Username:</label>

          <div class="col-md-8">
            <input name="deptid" type="hidden" value="">
            <input  class="form-control input-sm" id="Username" name="Username" placeholder=
                "Username"    onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off">
            </div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-12">
          <label class="col-md-4 control-label" for=
          "Password">Password:</label>

          <div class="col-md-8">
            <input name="deptid" type="hidden" value="">
            <input  class="form-control input-sm" id="Password" name="Password" placeholder=
                "Password" type="password" autocomplete="off"> 
          </div>
        </div>
      </div>  
     
      <div class="form-group">
          <div class="col-md-12">
            <label class="col-md-4 control-label" for=
            ""></label>  

            <div class="col-md-8"> 
                <label><input type="checkbox" name="condition"> By Signing up you are agree with our <a href="#" onclick="return popitup('terms.php','Terms and Condition')" target="_blank">terms and condition</a></label>
           </div>
          </div>
      </div>    
      <div class="form-group">
          <div class="col-md-12">
            <label class="col-md-4 control-label" for=
            "idno"></label>  

            <div class="col-md-8">
               <button class="btn btn-primary btn-sm" name="save" type="submit" onclick="return personalInfo();" ><span class="fa fa-save fw-fa"></span> Save</button> 
           
           </div>
          </div>
      </div>    
  </div>
  <div class="col-md-6 partition">Plot your location in the Map
  <div id="map" ></div> 
 <br/>

    <label class="col-md-2 control-label" for=
    "lat">Latitude:</label> 
    <div class="col-md-4">
      <input class="form-control input-sm" id="lat" name="lat" placeholder=
      "Latitude" type="text" any value="" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off" readonly="true">
    </div>

    <label class="col-md-2 control-label" for=
    "lng">Longhitude:</label> 
    <div class="col-md-4">

    <input class="form-control input-sm" id="lng" name="lng" placeholder=
    "Longhitude" type="text" any value="" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off" readonly="true"> 
    </div>


  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy4Fk3rT6aBGYr0w8HhlZr0vXSjINwHNA&libraries=places"> </script>

  <script type="text/javascript"> 
   
  var map ;
  var directionsDisplay;
  var directionsService;
  function initialize() { 
    var input = document.getElementById('StoreAddress');
    var searchBox = new google.maps.places.SearchBox(input); 
  }
    $(document).ready(function() {
         initialize();
    });
 


        // var infowindow; 
        // var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
        // var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
        // var locations = "";

         LatLng = {lat:14.0940, lng: 120.6890};
         map = new google.maps.Map(document.getElementById('map'), {zoom: 12, center: LatLng,mapTypeId:google.maps.MapTypeId.HYBRID});
        /**
         * Global marker object that holds all markers.
         * @type {Object.<string, google.maps.LatLng>}
         */
        var markers = {};

        /**
         * Concatenates given lat and lng with an underscore and returns it.
         * This id will be used as a key of marker to cache the marker in markers object.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {string} Concatenated marker id.
         */
        var getMarkerUniqueId= function(lat, lng) {
            return lat + '_' + lng;
        };

        /**
         * Creates an instance of google.maps.LatLng by given lat and lng values and returns it.
         * This function can be useful for getting new coordinates quickly.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {google.maps.LatLng} An instance of google.maps.LatLng object
         */
        var getLatLng = function(lat, lng) {
            return new google.maps.LatLng(lat, lng);
        };

       

        /**
         * Binds click event to given map and invokes a callback that appends a new marker to clicked location.
         */
        var addMarker = google.maps.event.addListener(map, 'click', function(e) { 

            var lat = e.latLng.lat(); // lat of clicked point
            var lng = e.latLng.lng(); // lng of clicked point
            var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object. 
             marker = new google.maps.Marker({
                position: getLatLng(lat, lng),
                map: map,
                animation: google.maps.Animation.DROP,  
                
            }); 



            markers[markerId] = marker; // cache marker in markers object 
            bindMarkerinfo(marker); // bind infowindow with click event to marker 

           document.getElementById('lat').value = lat;
           document.getElementById('lng').value = lng;

           getUserAddressBy(lat,lng);

        });

        /**
         * Binds  click event to given marker and invokes a callback function that will remove the marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
         */
        var bindMarkerinfo = function(marker) {
            google.maps.event.addListener(marker, "click", function (point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker 
                removeMarker(marker, markerId); // remove it

                document.getElementById('lat').value = "";
                document.getElementById('lng').value = "";
                document.getElementById("StoreAddress").value = "";
            });
        };

 

        /**
         * Removes given marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
         * @param {!string} markerId Id of marker.
         */
        var removeMarker = function(marker, markerId) {
            marker.setMap(null); // set markers setMap to null to remove it from map
            delete markers[markerId]; // delete marker instance from markers object
        }; 
  </script>    



<script type="text/javascript"> 

// (function () {
//     navigator.geolocation.getCurrentPosition(function (position) {
//             getUserAddressBy(position.coords.latitude, position.coords.longitude)
//         },
//         function (error) {
//             console.log("The Locator was denied :(")
//         })
    function getUserAddressBy(lat, long) {
        var xhttp = new XMLHttpRequest(); 
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var address = JSON.parse(this.responseText)
                // alert(address.results[0].formatted_address) 

                document.getElementById("StoreAddress").value  = address.results[0].formatted_address; 
            }
        };
        xhttp.open("GET", "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+long+"&key=AIzaSyAy4Fk3rT6aBGYr0w8HhlZr0vXSjINwHNA", true);
        xhttp.send();
    }
// })();


  $("#StoreAddress").on("keyup",function(){ 
      var geocoder = new google.maps.Geocoder();
      var address = $(this).val();
      if (address=='' ) {
          $("#lat").val('');
          $("#lng").val('');
      }else{
         geocoder.geocode( { 'address': address}, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
              var latitude = results[0].geometry.location.lat();
              var longitude = results[0].geometry.location.lng();

              $("#lat").val(latitude);
              $("#lng").val(longitude); 
            } 
          }); 
      } 
  });  


</script>
  </div>
</div> 
</form>
</section>
 
