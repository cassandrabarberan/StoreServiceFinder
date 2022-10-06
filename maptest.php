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
<?php  $storeID = isset($_GET['search']) ? $_GET['search'] : ""; ?>

<?php 

if (isset($_POST['submitRating']) ) {
  # code...
  $ratingNo = $_POST['ratingNo'];
  $storeID = $_POST['storeID'];
  $cus_username = $_SESSION['Customer_Username'];
  $fedback = $_POST['fedback'];
  $sql = "INSERT INTO `tblrating` (`RatingNo`, `StoreID`, `Customer_Username`, `RateDate`, `FeedBack`) 
         VALUES ({$ratingNo},{$storeID},'{$cus_username}',NOW(),'{$fedback}')";
  $mydb->setQuery($sql);
  $mydb->executeQuery();

   redirect(web_root.'index.php?q=map&search='.$storeID);
}

 if ($storeID!="") {

    $sql = "SELECT * FROM `tblstore` s, `tblusers` u WHERE StoreID=UserID AND StoreID=".$storeID;
    $mydb->setQuery($sql);
    $store = $mydb->loadSingleResult(); 

 ?>
 <div class="row"> 
  <div class="col-md-6">
    <div class="col-lg-12">
     <div class="stretch"> 
         <img src="<?php echo web_root.'admin/user/'.$store->PicLoc;?>"> 
      </div>
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
          <div> 
               <?php 
               $sql = "SELECT * FROM `tblrating` r,tblcustomer c WHERE r.Customer_Username=c.Customer_Username AND  `StoreID`=".$store->StoreID;
               $mydb->setQuery($sql);
               $cur = $mydb->loadResultList();

               foreach ($cur as $result) { 
                ?>
                 <div class="col-md-12">
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
           
            <form action="" method="POST">
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

                    <input type="hidden" name="storeID" value="<?php echo $store->StoreID;?>" /> 
                 <div class="col-lg-12 row" > <button type="submit" name="submitRating" class="btn btn-primary ">Submit</button></div>
               <?php }else{
                 echo '<div class="col-lg-12 row" ><a data-target="#myModal_Rating" data-toggle="modal" href="" data-id="'. $store->StoreID.'" class="btn btn-primary" id="storeID_rating">Submit</a></div>';

               } ?>
            </form>

          </div>
      </div>
  </div> 
  <div class="col-md-6"><div id="map"></div></div>
</div>



<?php 
}else{
 echo '<div id="map"></div>';
}
?>

 
<?php  
  if($storeID==""){
     $sql = "SELECT *  FROM `tblproduct` p, `tblcategory` c,`tblstore` s WHERE  p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID`  GROUP BY  p.`StoreID`" ; 

  }else{
    $sql = "SELECT *  FROM `tblproduct` p, `tblcategory` c,`tblstore` s WHERE  p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID` AND s.StoreID={$storeID}  GROUP BY  p.`StoreID`" ; 

  }
  $mydb->setQuery($sql);
  $cur = $mydb->loadResultList();


  foreach ($cur as $result) {  
       $lat = $result->lat;
       $lng = $result->lng; 
       $data[] =array( $result->StoreName,$result->StoreAddress,"index.php?q=item&store=".$result->StoreID);
     
  }  
  echo json_encode($data);
  ?>
<script type="text/javascript" >   
   var markers = <?php echo json_encode($data)?>;
    var geocoder;
    var map;
    var LatLng;
    var url;
    console.log(markers);

    function initMap() {
        // LatLng = {lat: <?php echo $lat;?>, lng: <?php echo $lng;?>};
        LatLng = {lat:14.0940, lng: 120.6890};
        map = new google.maps.Map(document.getElementById('map'), {zoom: 10, center: LatLng});
         // map = new google.maps.Map(document.getElementById('map'), { mapTypeId: google.maps.MapTypeId.SATELLITE,zoom: 15, center: LatLng});
        geocoder = new google.maps.Geocoder();

        for (i = 0; i < markers.length; i++) { 
           setMarkers(markers,i);
        }
    }


function setMarkers(locations, i) {
  var title = locations[i][0];
  var address = locations[i][1];
  var url = locations[i][2];
  geocoder.geocode({
      'address': locations[i][1]
    },

    function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var marker = new google.maps.Marker({ 
          map: map,
          position: results[0].geometry.location,
          title: title,
          animation: google.maps.Animation.DROP,
          address: address,
          url: url
        })
        infoWindow(marker, map, title, address, url);
        bounds.extend(marker.getPosition());
        map.fitBounds(bounds);
      } else {
        //alert("geocode of " + address + " failed:" + status);
      }
    });
}



function infoWindow(marker, map, title, address, url) {
  google.maps.event.addListener(marker, 'click', function() {
    var html = "<div><h4>" + title + "</h4><p>" + address + "<br></div><a href='" + url + "'>View location</a></p></div>";
    iw = new google.maps.InfoWindow({
      content: html,
      maxWidth: 350
    });
    iw.open(map, marker);
  });
}

function createMarker(results) {
  var marker = new google.maps.Marker({ 
    map: map,
    position: results[0].geometry.location,
    title: title,
    animation: google.maps.Animation.DROP,
    address: address,
    url: url
  })
  bounds.extend(marker.getPosition());
  map.fitBounds(bounds);
  infoWindow(marker, map, title, address, url);
  return marker;
}
   
</script> 
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTanm_xZQi4_RHeCAxerOqXN96NUwrbZU&callback=initMap">
</script>     