<html>
	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/title.php'); ?> Passenger Spots </title>
		<link rel="stylesheet" href="/sharemycar/webapp/css/header_users.css">
		<link rel="stylesheet" href="/sharemycar/webapp/css/nav_users.css">
		<link rel="stylesheet" href="/sharemycar/webapp/css/profile.css">
		<link rel="stylesheet" href="/sharemycar/webapp/css/footer.css">
    <script src="/sharemycar/webapp/js/menu.js"></script>
    <script src="/sharemycar/webapp/js/profile.js"></script>
		<script src="/sharemycar/webapp/account/driver/js/script.js"></script>
	</head>
	<body onload="initProfilePassenger()">
		<header>
			<?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/header_users.php'); ?>
		</header>
		<main class="main">
      <nav id="nav" class="nav" style="visibility: hidden; width: 0px;">
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/nav_users.php'); ?>
      </nav>
      <section id="section" class="section">
        <h1 class="title" id="profileTitle">Profile</h1>
        <hr class="title__hr">
        <div class="section__two-columns">
          <h3 class="section__title" id="personalInformationTitle">Personal Information</h3>
          <img id="imgProfile" class="section__image" src="/sharemycar/webapp/images/eric.jpg">
          <div class="section__label-input section__label-input--sma">
            <label class="section__label" for="name" id="txtName_txtmodel">Name</label><br>
            <input id="nameInput" class="form__input" type="text" value="" readonly>
          </div>
          <div class="section__label-input section__label-input--sma">
            <label class="section__label" for="lastName" id="txtLastName_txtLicensePlate">Last Name</label><br>
            <input id="lastNameInput" class="form__input" type="text" name="lastName" value="" readonly>
          </div>
          <div class="section__label-input section__label-input--sma">
            <label class="section__label" for="email" id="txtEmail_txtDriverLicense">E-mail</label><br>
            <input id="emailInput" class="form__input" type="text" name="email" value="" readonly>
          </div>
          <div class="section__label-input section__label-input--sma">
            <label class="section__label" for="cellPhone" id="txtCellPhone_txtColor">Cell Phone</label><br>
            <input id="cellPhoneInput" class="form__input" type="text" name="cellPhone" value="">
          </div>
        </div>
        <div class="section__two-columns">
          <h3 class="section__title" id="collageInformationTitle">Collage Information</h3>
          <div class="section__label-input section__label-input--med">
            <label class="section__label" for="university" id="txtUniversity_txtInsurance">University</label><br>
            <input id="universityInput" class="form__input" type="text" name="university" value="" readonly>
          </div>
          <div class="section__label-input section__label-input--med">
            <label class="section__label" for="controlNumber" id="txtControlNumber_txtSpaceCar">Control Number</label><br>
            <input id="controlNumberInput" class="form__input" type="text" name="controlNumber" value="" readonly>
          </div>
          <div class="section__label-input section__label-input--med">
            <label class="section__label" for="city" id="txtCity_txtOwner">City</label><br>
            <input id="cityInput" class="form__input" type="text" name="city" value="" readonly>
          </div>
          <div class="section__label-input section__label-input--med">
            <label class="section__label" for="state" id="txtState">State</label><br>
            <input id="stateInput" class="form__input" type="text" name="state" value="" readonly>
          </div>
        </div>

					<input type="button" class="button_switch" value="Edit info" id="btnEdit"/>
					<input type="button" class="button_switch" value="Show car info" onclick="hiddenElements()" id="btnChangeData"/>
      </section>
    </main>
<!--		<footer class="footer footer--darkblue">
      		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/footer.php'); ?>
   		</footer> -->
	</body>
</html>
