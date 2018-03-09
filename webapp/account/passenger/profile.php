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
	</head>
	<body>
		<header>
			<?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/header_users.php'); ?>
		</header>
		<main class="main">
      <nav id="nav" class="nav" style="visibility: hidden; width: 0px;">
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/nav_users.php'); ?>
      </nav>
      <section id="section" class="section">
        <h1 class="title">Profile</h1>
        <hr class="title__hr">
        <div class="section__two-columns">
          <h3 class="section__title">Personal Information</h3>
          <img class="section__image" src="/sharemycar/webapp/images/eric.jpg">
          <div class="section__label-input section__label-input--sma">
            <label class="section__label" for="name">Name</label><br>
            <input id="name" class="form__input" type="text" name="name" value="Eric" readonly>
          </div>
          <div class="section__label-input section__label-input--sma">
            <label class="section__label" for="lastName">Last Name</label><br>
            <input id="lastName" class="form__input" type="text" name="lastName" value="Juarez" readonly>
          </div>
          <div class="section__label-input section__label-input--sma">
            <label class="section__label" for="email">E-mail</label><br>
            <input id="email" class="form__input" type="text" name="email" value="0315108790@miutt.edu.mx">
          </div>
          <div class="section__label-input section__label-input--sma">
            <label class="section__label" for="cellPhone">Cell Phone</label><br>
            <input id="cellPhone" class="form__input" type="text" name="cellPhone" value="6641234567">
          </div>
        </div>
        <div class="section__two-columns">
          <h3 class="section__title">Collage Information</h3>
          <div class="section__label-input section__label-input--med">
            <label class="section__label" for="university">University</label><br>
            <input id="university" class="form__input" type="text" name="university" value="Universidad Tecnológica de Tijuana" readonly>
          </div>
          <div class="section__label-input section__label-input--med">
            <label class="section__label" for="controlNumber">Control Number</label><br>
            <input id="controlNumber" class="form__input" type="text" name="controlNumber" value="0315108790" readonly>
          </div>
          <div class="section__label-input section__label-input--med">
            <label class="section__label" for="city">City</label><br>
            <input id="city" class="form__input" type="text" name="city" value="Tijuana" readonly>
          </div>
          <div class="section__label-input section__label-input--med">
            <label class="section__label" for="state">State</label><br>
            <input id="state" class="form__input" type="text" name="state" value="Baja California" readonly>
          </div>
        </div>
      </section>
    </main>
		<footer class="footer footer--darkblue">
      		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/footer.php'); ?>
   		</footer>
	</body>
</html>
