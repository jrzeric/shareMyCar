<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/title.php'); ?> Register</title>
		<link href="css/register.css" rel="stylesheet"></link>
    <link href="/css/footer.css" rel="stylesheet"></link>
	</head>
	<body>
    <header>
      <?php require_once("/lib/header_register.php"); ?>
    </header>
		<main>
      <h1>Registration</h1>
      <div class="form-section">
        <label class="form-section__title">Personal information</label>
        <div class="form-section-blank">
          <input id="firtname" class="form-section__blank--three-columns" type="text" name="" value="" placeholder="FIRST NAME">
          <input id="lastname" class="form-section__blank--three-columns" type="text" name="" value="" placeholder="LAST NAME">
          <input id="surname" class="form-section__blank--three-columns" type="text" name="" value="" placeholder="SECOND LAST NAME">
        </div>
      </div>
      <div class="form-section">
        <label class="form-section__title">Contact information</label>
        <div class="form-section-blank">
          <input id="cellphone" class="form-section__blank--two-columns" type="text" name="" value="" placeholder="CELL PHONE NUMBER">
          <input id="email" class="form-section__blank--two-columns" type="email" name="" value="" placeholder="EMAIL">
          <input id="password" class="form-section__blank--two-columns" type="password" name="" value="" placeholder="PASSWORD">
          <input id="repassword" class="form-section__blank--two-columns" type="password" name="" value="" placeholder="CONFIRM PASSWORD">
        </div>
      </div>
      <div class="form-section">
        <label class="form-section__title">Select your location</label>
        <div class="form-section-blank">
          <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d13462.926138912491!2d-116.94100998022462!3d32.47987175!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2smx!4v1517604683740" width="10" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>
			<a href="register2.php"><button class="next-page">Next</button></a>
		</main>
      <footer class="footer footer--darkblue">
  		<?php require_once("/lib/footer.php"); ?>
  	</footer>
	</body>
</html>
