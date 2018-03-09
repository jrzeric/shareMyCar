<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/title.php'); ?> Spots</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="/sharemycar/webapp/css/footer.css">
    <link rel="stylesheet" href="/sharemycar/webapp/css/header_users.css">
    <link rel="stylesheet" href="/sharemycar/webapp/css/nav_users.css">
    <link rel="stylesheet" href="/sharemycar/webapp/css/profile.css">
    <link rel="stylesheet" href="/sharemycar/webapp/css/footer.css">
    <script src="/sharemycar/webapp/js/menu.js"></script>
    <!-- Register spots (thunder011) -->
    <script src="/sharemycar/webapp/js/registerspots.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpSKM1HkrXvYq98gLOY2s9FHMUYLfvfX0" type="text/javascript"></script>
  </head>
  <body onload="init()">
    <header>
      <?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/header_users.php'); ?>
    </header>
    <main class="main">
      <nav id="nav" class="nav" style="visibility: hidden; width: 0px;">
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/nav_users.php'); ?>
      </nav>
      <section id="section" class="section">
        <h1 class="title">View and register your Spots</h1>
        <div class="box">
          <label>Select day:</label>
          <select id="days" onchange="changeDay()">
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
          </select>
        </div>
        <br>
      <div id="map" style="width: 80%; height: 600px;"></div>
      </section>
    </main>
    <footer class="footer footer--darkblue">
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/sharemycar/webapp/lib/footer_users.php"); ?>
    </footer>
  </body>
</html>
