<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/title.php'); ?> Register</title>
		<link href="css/register.css" rel="stylesheet"></link>
    <link href="css/footer.css" rel="stylesheet"></link>
	</head>
	<body>
    <header>
      <?php require_once("lib/header_register.php"); ?>
    </header>
		<main>
      <h1>Registration</h1>
      <div class="form-section">
        <label class="form-section__title">Location information</label>
        <div class="form-section-blank">
          <select id="country" class="form-section__blank--three-columns" name="country" disabled>
            <option value="MX">México</option>
          </select>
          <select id="state" class="form-section__blank--three-columns" name="state" disabled>
            <option value="BC">Baja California</option>
          </select>
          <select id="city" class="form-section__blank--three-columns" name="city" disabled>
            <option value="TJ">Tijuana</option>
          </select>
        </div>
      </div>
      <div class="form-section">
        <label class="form-section__title">School Information</label>
        <div class="form-section-blank">
          <input id="controlnumber" class="form-section__blank--three-columns" type="text" name="" value="" placeholder="CONTROL NUMBER">
          <select id="turn" class="form-section__blank--three-columns" name="turn">
            <option value="0">SELECT TURN</option>
          </select>
          <select id="ampm" class="form-section__blank--three-columns" name="ampm">
            <option value="0">MORNING / EVENING</option>
          </select>
        </div>
      </div>
      <div class="form-section">
        <label class="form-section__title">Car Information</label>
        <div class="form-section-blank">
          <select id="brand" class="form-section__blank--three-columns" name="state">
            <option value="0">SELECT BRAND</option>
          </select>
          <select id="capacity" class="form-section__blank--three-columns" name="state">
            <option value="0">SELECT CAPACITY</option>
          </select>
          <select id="color" class="form-section__blank--three-columns" name="city">
            <option value="0">SELECT COLOR</option>
          </select>
        </div>
      </div>
      <div class="form-section">
        <label class="form-section__title">Legal Information</label>
        <div class="form-section-blank">
          <input id="plates" class="form-section__blank--three-columns" type="text" name="" value="" placeholder="PLATES">
          <input id="licencse" class="form-section__blank--three-columns" type="text" name="" value="" placeholder="LICENSE PLATE">
          <input id="security" class="form-section__blank--three-columns" type="text" name="" value="" placeholder="SECURITY NUMBER">
        </div>
      </div>
			<a href="register1.php"><button class="previus-page">PREVIOUS</button></a>
			<a href="index.php"><button class="next-page">FINISH</button></a>
		</main>
	</body>
	<footer>
		<?php require_once("lib/footer.php"); ?>
	</footer>
</html>
