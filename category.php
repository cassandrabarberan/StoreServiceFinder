
 <style type="text/css">
  #map {
    height: 600px;
    width: 100%;
    background-color: grey;
  }
  .content {
    margin-top: -30px;  }


  /* width */
 #content ::-webkit-scrollbar {
  width: 10px;
}

/* Track */
 #content ::-webkit-scrollbar-track {
  background: #f1f1f1; 
}

/* Handle */
 #content ::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
 #content ::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
#body-content {
  margin-top: 900px;
}
</style>
    <section id="content">
        <div class="container content"  >   
        <div class="col-md-6" style="height: 600px;overflow-y: scroll">
           <?php
 if (isset($_GET['search'])) {
     # code...
    $category = $_GET['search'];
 }else{
     $category = '';

 }

 $sql ="SELECT *,sum(Remaining) as 'qty' FROM tblstockin st, `tblproduct` p, `tblcategory` c,`tblstore` s WHERE st.ProductID=p.ProductID AND p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID`AND c.CategoryID=".$category ." GROUP BY p.ProductID";

  
    $mydb->setQuery($sql);
    $cur = $mydb->loadResultList();


    foreach ($cur as $result) { 


      $expiry_date = $result->DateExpire;
      $today = date('d-m-Y',time()); 
      $exp = date('d-m-Y',strtotime($expiry_date));
      $expDate =  date_create($exp);
      $todayDate = date_create($today);
      $diff =  date_diff($todayDate, $expDate);
      if($diff->format("%R%a")>0){

      $expStatus =  "active";
      }else{
      $expStatus =  "Expired";
      }

        $lat = $result->lat;
        $lng = $result->lng;
       $data[] =array( $result->StoreName,$result->StoreAddress,$result->lat,$result->lng,"index.php?q=item&store=".$result->StoreID);
  ?> 
<style type="text/css"> 
#myCarousel<?php echo  $result->ProductID ?> {
  margin-top: 5px;
}
.stretch img{ 
 width: 100%;
 height: 50%;
}
</style> 
    <form class="" action="cartcontroller.php?action=add" method="POST">
          <div class="panel panel-primary">
              <div class="panel-header">
                   <div style="border-bottom: 1px solid #ddd;padding: 10px;font-size: 20px;font-weight: bold;color: #000;margin-bottom: 5px;"><a href="index.php?q=products&id=<?php echo $result->ProductID;?>"><?php echo $result->Categories ;?></a> 
                  </div> 
              </div>
              <div class="panel-body contentbody">
                    <div class="col-sm-8"> 
                        <div class="col-sm-12">
                            <p>Store :</p>
                             <ul style="list-style: none;"> 
                                <li><?php echo $result->StoreName ;?></li> 
                            </ul> 
                        </div>
                        <div class="col-sm-12"> 
                            <p>Product</p>
                            <ul style="list-style: none;"> 
                                 <li>Name : <?php echo $result->ProductName ;?></li> 
                                 <li>Description : <?php echo $result->Description ;?></li> 
                                 <li>Price :<?php echo number_format($result->Price,2) ;?></li> 
                                 <li>Expired Date : <?php echo date_format(date_create($result->DateExpire),'M d, Y'); ?></li>  
                                 <li>Remaining Quantity :<?php echo $result->qty ;?></li> 
                                 <li>Status :<?php echo $expStatus ;?></li> 
                            </ul> 
                         </div>
                        <div class="col-sm-12">
                            <p>Location :  <?php echo  $result->StoreAddress ?></p>
                            <p>Contact No :  <?php echo  $result->ContactNo ?></p>  

<input type="hidden" id="address" value="<?php echo $result->StoreAddress;?>">
                        </div>
                    </div>
                    <div class="col-sm-4"> 
                     <input type="hidden" name="ProductID" value="<?php echo  $result->ProductID ?>">
                                   <!--  <input type="number" min="1" placeholder="Quantity" name="QTY<?php echo $result->ProductID ;?>" value="1" class="form-control" style="margin-bottom: 5px;"> -->

                                   <?php 
 
                                   //  if ( $result->qty > 0 && $expStatus=='active' ) {  
                                   // echo  '<button type="submit"  class="btn btn-main btn-next-tab"><i class="fa fa-shopping-cart"></i> Order Now !</button>';
                                   //  }else{   
                                   //    if (isset($_SESSION['CustomerID'])) {
                                   //       echo '<a class="btn btn-main btn-next-tab" href="process.php?action=wishlist&id='.$result->ProductID.'">Add to Whish List</a>'; 
                                   //    }else{
                                   //        echo '<a data-target="#myModal" data-toggle="modal" href="" class="btn btn-main btn-next-tab">Add to Whish List </a>';

                                   //    }
                                   //  } 
                                    ?>
                             <div class="row stretch">
                                      <!-- <img src=" <?php echo web_root.'admin/products/'. $result->Image1 ?>"> -->
                                       <div id="myCarousel<?php echo  $result->ProductID ?>" class="carousel slide" data-ride="carousel">
                                  <!-- Indicators -->
                                  <ol class="carousel-indicators">
                                    <li data-target="#myCarousel<?php echo  $result->ProductID ?>" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel<?php echo  $result->ProductID ?>" data-slide-to="1"></li>
                                    <li data-target="#myCarousel<?php echo  $result->ProductID ?>" data-slide-to="2"></li>
                                  </ol>

                                  <!-- Wrapper for slides -->
                                  <div class="carousel-inner">
                                    <div class="item active">
                                    <img src=" <?php echo web_root.'admin/products/'. $result->Image1 ?>" style="height: 150px;" >
                                    </div>

                                    <div class="item">
                                    <img src=" <?php echo web_root.'admin/products/'. $result->Image2 ?>" style="height: 150px;" >
                                    </div>
                                  
                                    <div class="item">
                                    <img src=" <?php echo web_root.'admin/products/'. $result->Image3 ?>" style="height: 150px;" >
                                    </div>
                                  </div>

                                  <!-- Left and right controls -->
                                  <a class="left carousel-control" href="#myCarousel<?php echo  $result->ProductID ?>" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="right carousel-control" href="#myCarousel<?php echo  $result->ProductID ?>" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                                </div>

                             </div>
                      </div>
                </div> 
              <div class="panel-footer"> 
              </div>
          </div> 
        </form>
<?php  } ?>   
        </div>  
        <div class="col-md-6">
 <div id="map"></div>
 <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy4Fk3rT6aBGYr0w8HhlZr0vXSjINwHNA&libraries=places"> </script>

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
        LatLng = {lat:14.0940, lng: 120.6890};
         map = new google.maps.Map(document.getElementById('map'), {zoom: 10, center: LatLng});
 

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
                html:  "<div><h4>" + title + "</h4><p>" + address + "<br></div><a href='" + url + "'>View Products</a></p></div>"
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow = new google.maps.InfoWindow();  
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                    locate();
                }
            })(marker, i));
        }

 

        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;

            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                    callback(request.responseText, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }


 
    </script>

     </div>
    </section>  
