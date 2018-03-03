<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard/style.css">
    <link rel="stylesheet" href="css/dashboard/footer.css">
    <!--<link rel="stylesheet" href="css/dashboard/menuStyle.css">-->
    <link href="css/dashboard/chart.css" rel="stylesheet"></link>
    <script src="js/dashboard/chart.js" charset="utf-8"></script>
    <script src="js/dashboard/svg.js" charset="utf-8"></script>
    <title> Dashboard </title>
  </head>
  <body onload="init()">
    <header>
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/header_admin.php"); ?>
    </header>
    <div class="box3">
      <div class="day">Active Users</div>
        <div class="now">
          <div class="value">
            85%
          </div>
        </div>
          <div style="clear:both"></div>
    </div>
    <div class="box">
      <div class="day">Registered Drivers</div>
        <div class="now">
          <div class="value">
            190
          </div>
        </div>
          <div style="clear:both"></div>
    </div>
    <div class="box1">
      <div class="day">Registered Users</div>
        <div class="now">
          <div class="value">
            90
          </div>
        </div>
          <div style="clear:both"></div>
    </div>
    <div id="map" class="map">
		</div>

    <script>
			  function initMap() {
				var uluru = {lat: -25.363, lng: 131.044};
				var map = new google.maps.Map(document.getElementById('map'), {
				  zoom: 4,
				  center: uluru
				});
				var marker = new google.maps.Marker({
				  position: uluru,
				  map: map
				});
			  }
			</script>

      <div class="svg">
          <svg id="chart"></svg>
          <div style="clear:both"></div>
      </div>

    <script async defer
			   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4PiTd6ZW7-qZIvMXGbZ0IBtAg82ylKgE&callback=initMap">
		</script>
  </body>
</html>
