<?php  
      if (!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     }
if(!$_SESSION['ADMIN_ROLE']=='Administrator'){
  redirect(web_root."admin/index.php");
}
  @$USERID = $_SESSION['ADMIN_USERID'];
    if($USERID==''){
  redirect("index.php");
}
  $user = New User();
  $singleuser = $user->single_user($USERID);

  $store = New Store();
  $res = $store->single_store($USERID);

 
  ?>
  <style type="text/css">
   .partition  #map {
    height: 400px;
    width: 100%;
    background-color: grey;
  }
  .partition {
    margin: 0px;
    padding: 0px
  }
</style>
 <form class="form-horizontal span6" action="controller.php?action=edit&view=" method="POST">
<div class="container"> 
 <!--        <div class="col-md-2 partition">
         <a  data-target="#myModal" data-toggle="modal" href="" title="Click here to Change Image." >
            <img alt="" style="width:500px; height:400px;>"
             title="" class="img-circle img-thumbnail isTooltip" src="<?php echo web_root.'admin/user/'. $singleuser->PicLoc;?>" data-original-title="Usuario"> 
         </a>  
        </div> -->
        <div class="col-md-6 partition">
            <h1><strong>Store Profile</strong></h1><br>
  
                         <input id="USERID" name="USERID" type="Hidden" value="<?php echo $singleuser->UserID; ?>"> 
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="col-md-4 control-label" for=
                      "StoreName">Store Name:</label>

                      <div class="col-md-8">

                        <input type="hidden" name="StoreID" value="<?php echo $res->StoreID ;?>">
                         <input class="form-control input-sm" id="StoreName" name="StoreName" placeholder=
                            "Company Name" type="text" value="<?php echo $res->StoreName ;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="col-md-4 control-label" for=
                      "StoreAddress">Store Address:</label> 
                      <div class="col-md-8">
                        <textarea class="form-control input-sm" id="StoreAddress" name="StoreAddress" placeholder=
                            "Address" type="text" value="" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off" readonly="true"><?php echo $res->StoreAddress ;?></textarea>  
                         <!-- <input class="form-control input-sm" id="COMPANYADDRESS" name="COMPANYADDRESS" placeholder="Company Address" value="<?php echo $res->COMPANYADDRESS ;?>" />  -->
                      </div>
                    </div>
                  </div> 
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="col-md-4 control-label" for=
                      "ContactNo">Contact No.:</label>

                      <div class="col-md-8">
                         <input class="form-control input-sm" id="ContactNo" name="ContactNo" placeholder=
                            "Contact No." type="number" value="<?php echo $res->ContactNo ;?>">
                      </div>
                    </div>
                  </div>  
                  
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="col-md-4 control-label" for=
                      "U_NAME">Name:</label>

                      <div class="col-md-8">
                        <input name="deptid" type="hidden" value="">
                         <input class="form-control input-sm" id="U_NAME" name="U_NAME" placeholder=
                            "Account Name" type="text" value="<?php echo $singleuser->FullName; ?>">
                      </div>
                    </div>
                  </div>
                  
                 <div class="form-group">
                    <div class="col-md-12">
                      <label class="col-md-4 control-label" for=
                      "EmailAdd">Email Address:</label>

                      <div class="col-md-8">
                        <input name="deptid" type="hidden" value="">
                         <input class="form-control input-sm" id="EmailAdd" name="EmailAdd" placeholder=
                            "Email Address" type="text" value="<?php echo $res->EmailAdd; ?>">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="col-md-4 control-label" for=
                      "U_USERNAME">Username:</label>

                      <div class="col-md-8">
                        <input name="deptid" type="hidden" value="">
                         <input class="form-control input-sm" id="U_USERNAME" name="U_USERNAME" placeholder=
                            "Email Address" type="text" value="<?php echo $singleuser->Username; ?>">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="col-md-4 control-label" for=
                      "U_PASS">Password:</label>

                      <div class="col-md-8">
                        <input name="deptid" type="hidden" value="">
                         <input class="form-control input-sm" id="U_PASS" name="U_PASS" placeholder=
                            "Account Password" type="Password" value="" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="col-md-4 control-label" for=
                      "U_ROLE">Role:</label>

                      <div class="col-md-8">
                       <select class="form-control input-sm" name="U_ROLE" id="U_ROLE">
                         <?php if($_SESSION['Role']=="Administrator"){ ?>
                          <option value="Administrator"  <?php echo ($singleuser->Role=='Administrator') ? 'selected="true"': '' ; ?>>Administrator</option>
                        <?php }else{ ?>
                           <option value="Store"  <?php echo ($singleuser->Role=='Store') ? 'selected="true"': '' ; ?>>Store Administrator</option>
                        <?php } ?> 
                          <option value="Staff" <?php echo ($singleuser->Role=='Staff') ? 'selected="true"': '' ; ?>>Staff</option>  
                        </select> 
                      </div>
                    </div>
                  </div>

            
             <div class="form-group">
                    <div class="col-md-12">
                      <label class="col-md-4 control-label" for=
                      "idno"></label>

                      <div class="col-md-8">
                         <button class="btn btn-primary " name="save" type="submit" ><span class="fa fa-save fw-fa"></span> Save</button>
                          <!-- <a href="index.php" class="btn btn-info"><span class="fa fa-arrow-circle-left fw-fa"></span>&nbsp;<strong>List of Users</strong></a> -->
                      </div>
                    </div>
                  </div> 
             
        </div>
        <div class="col-md-6 partition">
           <div id="map" ></div>  
                <label class="col-md-2 control-label" for=
                "lat">Latitude:</label> 
                <div class="col-md-4">
                  <input class="form-control input-sm" id="lat" name="lat" placeholder=
                  "Latitude" type="text" any value="<?php echo $res->lat;?>" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off" readonly="true">
                </div>

                <label class="col-md-2 control-label" for=
                "lng">Longhitude:</label> 
                <div class="col-md-4">

                <input class="form-control input-sm" id="lng" name="lng" placeholder=
                "Longhitude" type="text" any value="<?php echo $res->lng;?>" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off" readonly="true"> 
                </div>

        </div> 
</div>
        
 

  </form>
      


     <!-- Modal -->
          <div class="modal fade" id="myModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal" type=
                  "button">×</button>

                  <h4 class="modal-title" id="myModalLabel">Choose Image.</h4>
                </div>

                <form action="controller.php?action=photos" enctype="multipart/form-data" method="post">
                  <div class="modal-body">
                    <div class="form-group">
                      <div class="rows">
                        <div class="col-md-12">
                          <div class="rows">
                            <div class="col-md-8">
                            <input class="mealid" type="hidden" name="mealid" id="mealid" value="">
                              <input name="MAX_FILE_SIZE" type=
                              "hidden" value="1000000"> <input id=
                              "photo" name="photo" type=
                              "file">
                            </div>

                            <div class="col-md-4"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Close</button> <button class="btn btn-primary"
                    name="savephoto" type="submit">Upload Photo</button>
                  </div>
                </form>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->



  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTanm_xZQi4_RHeCAxerOqXN96NUwrbZU&libraries=places"> </script>

  <script type="text/javascript"> 
   
  var map ;
  var directionsDisplay;
  var directionsService; 

        var infowindow; 
        var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
        var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
        var locations = "";
         LatLng = {lat:6.9214, lng: 122.0790};
         map = new google.maps.Map(document.getElementById('map'), {zoom: 12, center: LatLng});
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
            var marker = new google.maps.Marker({
                position: getLatLng(lat, lng),
                map: map,
                animation: google.maps.Animation.DROP,
                
            }); 



            markers[markerId] = marker; // cache marker in markers object 
            bindMarkerinfo(marker); // bind infowindow with click event to marker 

           document.getElementById('lat').value = lat;
           document.getElementById('lng').value = lng;
           getUserAddressBy(lat, lng);

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
                 document.getElementById("StoreAddress").value ="";
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



        function getUserAddressBy(lat, lng) {
        var xhttp = new XMLHttpRequest(); 
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var address = JSON.parse(this.responseText)
                // alert(address.results[0].formatted_address) 

                document.getElementById("StoreAddress").value  = address.results[0].formatted_address; 
            }
        };
        xhttp.open("GET", "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&key=AIzaSyDTanm_xZQi4_RHeCAxerOqXN96NUwrbZU", true);
        xhttp.send();
    }
  </script> 