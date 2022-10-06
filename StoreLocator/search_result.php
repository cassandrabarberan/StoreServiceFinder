<?php 
	$searchfor = (isset($_GET['searchfor']) && $_GET['searchfor'] != '') ? $_GET['searchfor'] : '';
	
?>

 <style type="text/css">
  #map {
    height: 500px;
    width: 100%;
    background-color: grey;
  }
</style>
<style type="text/css">
	/*    --------------------------------------------------
	:: General
	-------------------------------------------------- */
</style>
<div class="container">
	<div class="row">

		<section class="content">
			<div >
				<div class="btn-group">
					<?php 


					 $search = isset($_POST['SEARCH']) ? ($_POST['SEARCH']!='') ? $_POST['SEARCH'] : 'All' : 'All';
					 $company = isset($_POST['Store']) ? ($_POST['Store']!='') ? $_POST['Store'] : 'All' : 'All';
					 $category = isset($_POST['Category']) ? ($_POST['Category']!='') ? $_POST['Category'] : 'All' : 'All';

					$sql = "SELECT * FROM tblstore WHERE StoreID='$company'";
					$mydb->setQuery($sql);
					$cur = $mydb->executeQuery();
					$maxrow = $mydb->num_rows($cur);

					if ($maxrow > 0) {
						# code...
						$str = $mydb->loadSingleResult();
						$store = $str->StoreName;
 
					}else{
						$store = "All";
					}
					


					// switch ($searchfor) {
					// 	case 'bystore':
					// 		# code...
					// 	$result_search =  'Result : '  . $search . ' | Store : ' . $store;
					// 		break;
					// 	case 'advancesearch':
					// 		# code... 
					// 	$result_search =  'Result : '  . $search . ' | Store : ' . $store . ' | category : ' . $category; 
					// 	    break;
					// 	case 'byfunction':
					// 		# code... 
					// 	$result_search =  'Result : '  . $search . ' | category : ' . $category; 
					// 	    break; 
						
					// 	default:
					// 		# code...
					// 		break;
					// }
            $result_search =  'Result : '  . $search ;

					?>
				</div>
			</div>
			 
			<div class="col-md-12 ">   

						    <?php  
						    $n=0;
									 $search = isset($_POST['SEARCH']) ? $_POST['SEARCH'] : '';
									 $store = isset($_POST['Store']) ? stripslashes($_POST['Store']) : '';
									 $category = isset($_POST['Category']) ? $_POST['Category'] : '';


   								 // $sql = "SELECT *  FROM `tblproduct` p, `tblcategory` c,`tblstore` s WHERE  p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID`AND Categories LIKE '%$category%' AND ProductName LIKE '%$search%' AND s.StoreID LIKE '%$store' GROUP BY p.StoreID" ; 

                    $sql = "SELECT *  FROM `tblproduct` p, `tblcategory` c,`tblstore` s WHERE  p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID`AND (Categories LIKE '%$search%' OR ProductName LIKE '%$search%' ) GROUP BY p.StoreID" ; 
							    $mydb->setQuery($sql);
							    $cur = $mydb->loadResultList();


							    foreach ($cur as $result) {  
							    	   $lat = $result->lat;
							    	   $lng = $result->lng;  

							    	   $distance = distance($_COOKIE["lat"], $_COOKIE["lng"],  $lat,  $lng, 'k');

							    	    $data[] =array( $result->StoreName,$result->StoreAddress,$result->lat,$result->lng,'index.php?q=viewroutes&search='.$result->StoreID.'&lat='.$result->lat.'&lng='.$result->lng.'&distance='.$distance);
										 
							    }

								 // echo json_encode($data);
							  ?>  
  <div style="border-bottom: 1px solid #ddd;padding: 5px 0px;"><?php echo $result_search;?></div>
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
                html:  "<div><h4>" + title + "</h4><p>" + address + "<br></div><a href='" + url + "'>View Route</a></p></div>"
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow = new google.maps.InfoWindow();  
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
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
		
	</div>
</div>
