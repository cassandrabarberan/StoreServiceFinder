  <?php 
    $customer = new Customer();
    $cus = $customer->single_customer($_SESSION['CustomerID']);
  ?>
  
<form class="form-horizontal" method="POST" action="controller.php?action=edit">  
      <div class="col-sm-12">  
            <div class="box-header with-border">
              <h3 class="box-title">Accounts</h3> 
            </div> 
              <div class="form-group">
                <div class="col-md-7">
                <label class="col-md-4 control-label" for=
                  "CustomerName">Fullname:</label>

                  <div class="col-md-8">
                    <input name="JOBID" type="hidden" value="<?php echo $_GET['job'];?>">
                     <input class="form-control input-sm" id="CustomerName" name="CustomerName" placeholder=
                        "Fullname" type="text" value="<?php echo $cus->CustomerName;?>"  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off">
                  </div>
                </div>
              </div> 
              <div class="form-group">
                <div class="col-md-7">
                  <label class="col-md-4 control-label" for=
                  "CustomerAddress">Address:</label>

                  <div class="col-md-8">

                   <textarea class="form-control input-sm" id="CustomerAddress" name="CustomerAddress" placeholder=
                      "Address" type="text" value="" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off"><?php echo $cus->CustomerAddress;?></textarea>
                      <input type="hidden" name="lat" id="lat" value="<?php echo $cus->Latitude;?>">
                      <input type="hidden" name="lng" id="lng" value="<?php echo $cus->Longhitude;?>">
                  </div>
                </div>
              </div> 

              <div class="form-group">
                <div class="col-md-7">
                  <label class="col-md-4 control-label" for=
                  "Gender">Sex:</label>

                  <div class="col-md-8">
                   <div class="col-lg-5">
                      <div class="radio">
                        <label><input <?php echo ($cus->Sex=="Famale") ? "Checked" : ""; ?>  id="optionsRadios1" checked="True" name="optionsRadios" type="radio" value="Female">Female</label>
                      </div>
                    </div>

                    <div class="col-lg-4">
                      <div class="radio">
                        <label><input <?php echo ($cus->Sex=="Male") ? "Checked" : ""; ?> id="optionsRadios2"   name="optionsRadios" type="radio" value="Male"> Male</label>
                      </div>
                    </div> 
                   
                  </div>
                </div>
              </div> 
 

               <div class="form-group">
                <div class="col-md-7">
                  <label class="col-md-4 control-label" for=
                  "CustomerContact">Contact No.:</label>

                  <div class="col-md-8">
                    
                     <input class="form-control input-sm" id="CustomerContact" name="CustomerContact" placeholder=
                        "Contact No." type="text" any value="<?php echo $cus->CustomerContact;?>" required  onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off">
                  </div>
                </div>
              </div>  
              
             <div class="form-group">
                <div class="col-md-7">
                  <label class="col-md-4 control-label" for=
                  "EmailAdd">E-mail Address:</label>

                  <div class="col-md-8"> 
                    <input  class="form-control input-sm" id="EmailAdd" name="EmailAdd" placeholder=
                        "E-mail Address" value="<?php echo $cus->EmailAdd;?>"  autocomplete="off" required>
                    </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-7">
                  <label class="col-md-4 control-label" for=
                  "Customer_Username">Username:</label>

                  <div class="col-md-8"> 
                    <input  class="form-control input-sm" id="Customer_Username" name="Customer_Username" placeholder=
                        "Username" value="<?php echo $cus->Customer_Username;?>"  autocomplete="off">
                    </div>
                </div>
              </div>
  
              <div class="form-group">
                <div class="col-md-7">
                  <label class="col-md-4 control-label" for=
                  "submit"></label>

                  <div class="col-md-8">
                     <button class="btn btn-primary btn-sm" name="submit" type="submit" ><span class="fa fa-save"></span> Submit </button>
                    </div>
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
        var myLatlng = new google.maps.LatLng(10.640739,122.968956);
        var myOptions = {
            zoom: 7,
            center: {lat:10.640739, lng:122.968956},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map($("#map_canvas").get(0), myOptions);
      directionsDisplay = new google.maps.DirectionsRenderer();
      directionsService = new google.maps.DirectionsService();
      var input = document.getElementById('CustomerAddress');
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
  <script type="text/javascript">

  $("#CustomerAddress").on("keyup",function(){ 
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