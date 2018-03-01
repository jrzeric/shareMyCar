<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Estilos-->
    <link href="css/register.css" rel="stylesheet"></link>
    <link href="/css/footer.css" rel="stylesheet"></link>
    <link href="/css/popup.css" rel="stylesheet"></link>
    <script src="js/selectrole.js"></script> 
    <title> Select your role </title>
  </head>
  <body onload="init()">
    <header>
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/header_admin.php");?>
		</header>

    <form class="form-center">
      <h1>Select your role</h1>
      <ul>
      <li>
        <input type="radio" id="f-option" name="selector" onclick="showOptions(this.value)" value="Passenger">
        <label for="f-option">Passenger</label>
        
        <div class="check"></div>
      </li>
      
      <li>
        <input type="radio" id="s-option" name="selector" onclick="showOptions(this.value)" value="Driver">
        <label for="s-option">Driver</label>
        
        <div class="check"><div class="inside"></div></div>
      </li>
    </ul>  
    </form>

    <div id="driver" class="form-center" style="visibility: hidden;">
      <select id="brands" class="form-section__blank--two-columns" onchange="fillModels()">
        <option>Select your Brand</option>
      </select>
      <select id="models" class="form-section__blank--two-columns">
        <option>Select your Model</option>
      </select>
      <input type="text" id="licenseplate" class="form-section__blank--three-columns" placeholder="Your License Plate">
      <input type="text" id="driverlicense" class="form-section__blank--three-columns" placeholder="Your Driver Licence">
      <input type="text" id="color" class="form-section__blank--three-columns" placeholder="The Color of the car">
      <input type="text" id="insurance" class="form-section__blank--three-columns" placeholder="Your Insurance">
      <input type="number" max="6" min="1" id="space" class="form-section__blank--three-columns" placeholder="Space of the car">
      <input type="text" id="owner" class="form-section__blank--three-columns" placeholder="Owner of the car">
      <br>


    </div>

    <div id="button" style="visibility: hidden;">
      <button class="finish" >Finish</button>
    </div>

  </body>
</html>
