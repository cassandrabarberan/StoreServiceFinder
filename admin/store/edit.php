<?php
    if (!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     }


  $storeID = $_GET['id'];
  $store = New Store();
  $res = $store->single_store($storeID);

?> 
 <form class="form-horizontal span6" action="controller.php?action=edit" method="POST">

       
            <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">Update Company</h1>
          </div>
          <!-- /.col-lg-12 -->
       </div> 
                  <div class="form-group">
                    <div class="col-md-8">
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
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "StoreAddress">Store Address:</label> 
                      <div class="col-md-8">
                        <textarea class="form-control input-sm" id="StoreAddress" name="StoreAddress" placeholder=
                            "Address" type="text" value="" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off"><?php echo $res->StoreAddress ;?></textarea> 
                      </div>
                    </div>
                  </div> 
                  <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "lat">Latitude:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="lat" name="lat" placeholder=
                                "Latitude" type="text" any value="<?php echo $res->lat;?>" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off">
                          </div>
                        </div>
                      </div> 
                        <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "lng">Longhitude:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="lng" name="lng" placeholder=
                                "Longhitude" type="text" any value="<?php echo $res->lng;?>" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off">
                          </div>
                        </div>
                      </div> 
                  <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "ContactNo">Contact No.:</label>

                      <div class="col-md-8">
                         <input class="form-control input-sm" id="ContactNo" name="ContactNo" placeholder=
                            "Contact No." type="text" value="<?php echo $res->ContactNo ;?>">
                      </div>
                    </div>
                  </div>

               <!--  <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "COMPANYMISSION">Company Mission:</label>

                      <div class="col-md-8">
                        
                         <textarea class="form-control input-sm" id="COMPANYMISSION" name="COMPANYMISSION" placeholder=
                            "Company Mission" type="text" value="" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off"><?php echo $res->COMPANYMISSION ;?></textarea>
                      </div>
                    </div>
                  </div>  -->



            
             <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "idno"></label>

                      <div class="col-md-8">
                      <!-- <a href="index.php" class="btn btn_fixnmix"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;<strong>Back</strong></a> -->
                      <button class="btn btn-primary btn-sm" name="save" type="submit" ><span class="fa fa-save fw-fa"></span> Save</button>
                   
                      </div>
                    </div>
                  </div>

              
   
        </form>


        <script type="text/javascript" src=" https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  
  <script type="text/javascript">
    var map = null;
    var directionsDisplay = null;
    var directionsService = null;
    function initialize() {
        var myLatlng = new google.maps.LatLng(6.9214,122.0790);
        var myOptions = {
            zoom: 7,
            center: {lat:6.9214, lng:122.0790},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map($("#map_canvas").get(0), myOptions);
      directionsDisplay = new google.maps.DirectionsRenderer();
      directionsService = new google.maps.DirectionsService();
      var input = document.getElementById('StoreAddress');
      var searchBox = new google.maps.places.SearchBox(input); 
    } 
    $(document).ready(function() {
        initialize();
    });
 
  </script>  
  <div  id="results" style="width: 990px; height: 500px;display: none;">
    <div id="map_canvas" style="width: 80%; height: 100%; float: left;"></div>
  </div> 
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTanm_xZQi4_RHeCAxerOqXN96NUwrbZU&libraries=places"> </script>

<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyDTanm_xZQi4_RHeCAxerOqXN96NUwrbZU"></script>  -->
<script type="text/javascript">

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

              // alert(latitude);
              // alert(longitude)
            } 
          }); 
      }

     

  });


</script>

       