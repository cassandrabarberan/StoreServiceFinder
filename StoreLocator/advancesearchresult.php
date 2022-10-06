<?php 
	$searchfor = (isset($_GET['searchfor']) && $_GET['searchfor'] != '') ? $_GET['searchfor'] : '';
	
?>

 <style type="text/css">
  #map {
    height: 400px;
    width: 100%;
    background-color: grey;
  }
</style>
<style type="text/css">
	/*    --------------------------------------------------
	:: General
	-------------------------------------------------- */
body {
	font-family: 'Open Sans', sans-serif;
	color: #353535;
}
.content {
	padding: 30px;
	min-height: 500px;
}
.content h1 {
	text-align: center;
}
.content .content-footer p {
	color: #6d6d6d;
    font-size: 12px;
    text-align: center;
}
.content .content-footer p a {
	color: inherit;
	font-weight: bold;
}

/*	--------------------------------------------------
	:: Table Filter
	-------------------------------------------------- */
.panel {
	border: 1px solid #ddd;
	background-color: #fcfcfc;
}
.panel .btn-group {
	margin: 15px 0 30px;
} 
.table-filter {
	background-color: #fff;
	border-bottom: 1px solid #eee;
}
.table-filter tbody tr:hover {
	cursor: pointer;
	background-color: #eee;
}
.table-filter tbody tr td {
	padding: 10px;
	vertical-align: middle;
	border-top-color: #eee;
}
.table-filter tbody tr.selected td {
	background-color: #eee;
}
.table-filter tr td:first-child {
	width: 38px;
}
.table-filter tr td:nth-child(2) {
	width: 35px;
}
 
.table-filter .star {
	color: #ccc;
	text-align: center;
	display: block;
}
.table-filter .star.star-checked {
	color: #F0AD4E;
}
.table-filter .star:hover {
	color: #ccc;
}
.table-filter .star.star-checked:hover {
	color: #F0AD4E;
}
.table-filter .media-photo {
	width: 35px;
}
.table-filter .media-body {
    display: block;
    /* Had to use this style to force the div to expand (wasn't necessary with my bootstrap version 3.3.6) */
}
.table-filter .media-meta {
	font-size: 11px;
	color: #999;
}
.table-filter .media .title {
	color: #2BBCDE;
	font-size: 14px;
	font-weight: bold;
	line-height: normal;
	margin: 0;
}
.table-filter .media .title span {
	font-size: .8em;
	margin-right: 20px;
}
.table-filter .media .title span.pagado {
	color: #5cb85c;
}
.table-filter .media .title span.pendiente {
	color: #f0ad4e;
}
.table-filter .media .title span.cancelado {
	color: #d9534f;
}
.table-filter .media .summary {
	font-size: 14px;
}
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
					


					switch ($searchfor) {
						case 'bystore':
							# code...
						echo 'Result : '  . $search . ' | Store : ' . $store;
							break;
						case 'advancesearch':
							# code... 
						echo 'Result : '  . $search . ' | Store : ' . $store . ' | category : ' . $category; 
						    break;
						case 'byfunction':
							# code... 
						echo 'Result : '  . $search . ' | category : ' . $category; 
						    break; 
						
						default:
							# code...
							break;
					}


					?>
				</div>
			</div>
			 
			<div class="col-md-6 ">  
						<div class="table-container">  

						    <?php  
									 $search = isset($_POST['SEARCH']) ? $_POST['SEARCH'] : '';
									 $store = isset($_POST['Store']) ? stripslashes($_POST['Store']) : '';
									 $category = isset($_POST['Category']) ? $_POST['Category'] : '';


   								 $sql = "SELECT *,sum(Remaining) as 'qty' FROM tblstockin st, `tblproduct` p, `tblcategory` c,`tblstore` s WHERE st.ProductID=p.ProductID AND p.`CategoryID`=c.`CategoryID` AND p.`StoreID`=s.`StoreID`AND Categories LIKE '%$category%' AND ProductName LIKE '%$search%' AND s.StoreID LIKE '%$store' GROUP BY p.ProductID" ;
 
							    // $sql = "SELECT * FROM tblinventory i,`tblstore` s,`tblproduct` p ,`tblcategory` c
							    //         WHERE i.ProductID=p.ProductID and s.StoreID=p.StoreID AND p.CategoryID=c.CategoryID AND Categories LIKE '%$category%' AND ProductName LIKE '%$search%' AND s.StoreID LIKE '%$store'" ;
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
							  		<div class="row">
							          <div class="panel panel-primary">
							              <div class="panel-header">
							                   <div style="border-bottom: 1px solid #ddd;padding: 10px;font-size: 20px;font-weight: bold;color: #000;margin-bottom: 5px;"><a href="<?php echo web_root.'index.php?q=viewjob&search='.$result->JOBID;?>"><?php echo $result->Categories ;?></a> 
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
							                                 <li>Price :<?php echo $result->Price ;?></li> 
							                                 <li>Expired Date : <?php echo date_format(date_create($result->DateExpire),'M d, Y'); ?></li> 
							                                 <li>Remaining :<?php echo $result->Remaining ;?></li> 
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
							                    	<input type="number" min="1" placeholder="Quantity" name="QTY<?php echo $result->ProductID ;?>" value="1" class="form-control" style="margin-bottom: 5px;">

							                    	 <?php 
 
				                                    if ( $result->Remaining > 0 && $expStatus=='active' ) {  
				                                   echo  '<button type="submit"  class="btn btn-main btn-next-tab"><i class="fa fa-shopping-cart"></i> Order Now !</button>';
				                                    }else{   
				                                      if (isset($_SESSION['CustomerID'])) {
				                                         echo '<a class="btn btn-main btn-next-tab" href="process.php?action=wishlist&id='.$result->ProductID.'">Add to Whish List</a>'; 
				                                      }else{
				                                          echo '<a data-target="#myModal" data-toggle="modal" href="" class="btn btn-main btn-next-tab">Add to Whish List </a>';

				                                      }
				                                    } ?>

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
							      </div>
				    </form>	 
							<?php  } ?>  
				</div> 
			</div>
			<div class="col-md-6"> 
				<div id="map"></div>
<script type="text/javascript" > 
   var geocoder;
var map;
var address = document.getElementById("address").value;

function initMap() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  var myOptions = {
    zoom: 18,
    center: latlng,
    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
    },
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById("map"), myOptions);
  if (geocoder) {
    geocoder.geocode({
      'address': address
    }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

          var infowindow = new google.maps.InfoWindow({
            content: '<b>' + address + '</b>',
            size: new google.maps.Size(150, 50)
          });

          var marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            title: address
          });
          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
          });

        } else {
          alert("No results found");
        }
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
}
google.maps.event.addDomListener(window, 'load', initialize); 

</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTanm_xZQi4_RHeCAxerOqXN96NUwrbZU&callback=initMap">
</script>    


			</div>   
		</section>
		
	</div>
</div>