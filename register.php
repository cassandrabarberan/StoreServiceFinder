<section id="content">
	<div class="container content">
		<p> <?php check_message(); ?></p>
		<form name="personal" class="row form-horizontal span6  wow fadeInDown" action="process.php?action=register" method="POST">
			<h2 class=" ">Customer Information</h2>
			<div class="row">
				<div class="form-group">
					<div class="col-md-8">
						<label class="col-md-4 control-label" for="CustomerName">Fullname:</label>

						<div class="col-md-8">
							<input name="JOBID" type="hidden" value="<?php echo $_GET['job']; ?>">
							<input class="form-control input-sm" id="CustomerName" name="CustomerName" placeholder="Fullname" type="text" value="" onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off">
						</div>
					</div>
				</div>


				<div class="form-group">
					<div class="col-md-8">
						<label class="col-md-4 control-label" for="CustomerAddress">Address:</label>

						<div class="col-md-8">

							<textarea class="form-control input-sm" id="CustomerAddress" name="CustomerAddress" placeholder="Address" type="text" value="" required onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off"></textarea>
							<input type="hidden" name="lat" id="lat">
							<input type="hidden" name="lng" id="lng">
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-8">
						<label class="col-md-4 control-label" for="Gender">Sex:</label>

						<div class="col-md-8">
							<div class="col-lg-5">
								<div class="radio">
									<label><input checked id="optionsRadios1" checked="True" name="optionsRadios" type="radio" value="Female">Female</label>
								</div>
							</div>

							<div class="col-lg-4">
								<div class="radio">
									<label><input id="optionsRadios2" name="optionsRadios" type="radio" value="Male"> Male</label>
								</div>
							</div>

						</div>
					</div>
				</div>


				<div class="form-group">
					<div class="col-md-8">
						<label class="col-md-4 control-label" for="CustomerContact">Contact No.:</label>

						<div class="col-md-8">

							<!--input class="form-control input-sm" id="CustomerContact" name="CustomerContact" placeholder="Contact No." type="text" any value="" required required maxlength="11" onkeyup="javascript:capitalize(this.id, this.value);" autocomplete="off">-->
							<input class="form-control input-sm" id="CustomerContact" name="CustomerContact" placeholder="Contact No." type="text" any value="" required maxlength="11" autocomplete="off" onkeypress="return restrictAlphabets(event)">
							<script type="text/javascript">
								function restrictAlphabets(e) {
									var x = e.which || e.keycode;
									if ((x >= 48 && x <= 57))
										return true;
									else return false;
								}
							</script>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-8">
						<label class="col-md-4 control-label" for="EmailAdd">E-mail Address:</label>

						<div class="col-md-8">
							<input class="form-control input-sm" id="EmailAdd" name="EmailAdd" placeholder="E-mail Address" type="email" autocomplete="off" required>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-8">
						<label class="col-md-4 control-label" for="Customer_Username">Username:</label>

						<div class="col-md-8">
							<input class="form-control input-sm" id="Customer_Username" name="Customer_Username" placeholder="Username" autocomplete="off">
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-8">
						<label class="col-md-4 control-label" for="Customer_Password">Password:</label>

						<div class="col-md-8">
							<input class="form-control input-sm" id="Customer_Password" name="Customer_Password" placeholder="Password" type="password" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-8">
						<label class="col-md-4 control-label" for=""></label>

						<div class="col-md-8">
							<label><input type="checkbox" name="condition"> By Sign up you are agree with our <a href="#" onclick="return popitup('terms.php','Terms and Condition')" target="_blank">terms and condition</a></label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-8">
						<label class="col-md-4 control-label" for="idno"></label>

						<div class="col-md-8">
							<button class="btn btn-primary btn-sm" name="btnRegister" type="submit" onclick="return personalInfo();"><span class="fa fa-save fw-fa"></span> Save</button>

						</div>
					</div>
				</div>
		</form>
	</div>
</section>

<script type="text/javascript" src=" https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
	var map = null;
	var directionsDisplay = null;
	var directionsService = null;

	function initialize() {
		var myLatlng = new google.maps.LatLng(10.640739, 122.968956);
		var myOptions = {
			zoom: 7,
			center: {
				lat: 10.640739,
				lng: 122.968956
			},
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
<div id="results" style="width: 990px; height: 500px;display: none;">
	<div id="map_canvas" style="width: 80%; height: 100%; float: left;"></div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy4Fk3rT6aBGYr0w8HhlZr0vXSjINwHNA&libraries=places"> </script>

<script type="text/javascript">
	$("#CustomerAddress").on("keyup", function() {
		var geocoder = new google.maps.Geocoder();
		var address = $(this).val();
		if (address == '') {
			$("#lat").val('');
			$("#lng").val('');
		} else {
			geocoder.geocode({
				'address': address
			}, function(results, status) {

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