<html>
	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/title.php'); ?> Profile</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" href="/css/footer.css">
	<script src="js/menu.js"></script>
	</head>
	<body>
		<header>
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/sharemycar/webapp/lib/header_users.php"); ?>
		</header>

		<main>

			<div id="conteiner">
			            <div class="pi">
			                <h1>Personal Information</h1>
			                <div class="photo">
			                    <img src="images/noimg.png">
			                </div>
			                <label class="textinfopi" >Name:</label>
			                <label class="textvaluepi">Nathaniel</label><br/>
			                <label class="textinfopi">Last Name: </label>
			                <label class="textvaluepi">Rodriguez</label><br/>
			                <label  class="textinfopi" >Email:</label>
			                <label class="textvaluepi">Example@example.com</label><br/>
			                <label  class="textinfopi" >CellPhone:</label>
			                <label class="textvaluepi">(XXX)XXX-XX-XX</label>
			            </div>
			            <div class="ci">
			                <h1>Collage Infromation</h1>
			                <label class="textinfoci" >University:</label>
			                <label class="textvalueci">Instituto Tecnologico de Tijuana</label><br/>
			                <label class="textinfoci">State:</label>
			                <label class="textvalueci">Baja California</label>
			                <label class="textinfoci" >City:</label>
			                <label class="textvalueci">Tijuana</label><br/>
			                <label class="textinfoci" >Control#:</label>
			                <label class="textvalueci">031611922</label>
			                <label class="textinfoci" >Turn:</label>
			                <label class="textvalueci" >Morning</label>
			            </div>
			       <div class="cri">
			                <h1>Collage Infromation</h1>
			                <label class="textinfocri" >Color:</label>
			                <label class="textvaluecri" >color</label>
			                <label class="textinfocri" >Model:</label>
			                <label class="textvaluecri" >Model</label>
			                <label class="textinfocri" >Plates:</label>
			                <label class="textvaluecri" >Plates</label>
			                <label class="textinfocri" >Licence Number:</label>
			                <label class="textvaluecri" >Licence Number</label>
			        </div>
			        </div>

		</main>
		  <footer class="footer footer--darkblue">
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/sharemycar/webapp/lib/footer_users.php"); ?>
   		</footer>
	</body>
</html>
