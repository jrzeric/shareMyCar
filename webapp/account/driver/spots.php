<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/title.php'); ?> Spots</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="/css/footer.css">
    <!-- Register spots (thunder011) -->
    <script src="/js/registerspots.js"></script>
  	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpSKM1HkrXvYq98gLOY2s9FHMUYLfvfX0" type="text/javascript"></script>
  </head>
  <body onload="init()">
    <header>
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/header_users.php"); ?>
    </header>
    <main>
      <h1 class="title">Spots</h1>
  	  <div class="box">
    	  <h2>Select day:</h2>
    		<select>
    			<option>Monday</option>
    			<option>Tuesday</option>
    			<option>Wednesday</option>
    			<option>Thursday</option>
    			<option>Friday</option>
    			<option>Saturday</option>
    		</select>
  	  </div>
  		<div id="map" style="width: 80%; height: 600px;"></div>
    </main>
    <footer class="footer footer--darkblue">
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/footer_users.php"); ?>
    </footer>
  </body>
</html>
