<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<!--style sheets-->
    <link href="../css/admin/header.css" rel="stylesheet"></link>
		<link href="../css/admin/style.css" rel="stylesheet"></link>
		<link href="../css/admin/footer.css" rel="stylesheet"></link>
		<!--scripts-->
		<script src="../js/index.js"></script>
	</head>
	<body onLoad="init()">
		<header id="nav">
			<?php require_once("../lib/admin/header.php"); ?>
		</header>
		<div id="sidemenu">
			<a href="#"><img class="iconSideMenu" src="../images/home.png">  Home</a>
			<a href="#"><img class="iconSideMenu" src="../images/report.png">  Reports</a>
			<a href="#"><img class="iconSideMenu" src="../images/blacklist.png">  Black List</a>
		</div>
		<div id="content">
			<div class="filters">
				<label>Filter by profile: </label>
				<select class="soflow">
					<option>Select profile</option>
					<option>Passenger</option>
					<option>Driver</option>
				</select>
			</div>

			<div class="reports">
				<div class="badPerson">
				    <div class="reportImg"><img src="../images/default.png"></div>
				    <div class="information">
				        <div class="name">Maria Felix De La Olla</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>

				<div class="badPerson">
				    <div class="reportImg"><img src="../images/default.png"></div>
				    <div class="information">
				        <div class="name">Eric Luis Juarez Cendejas</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>

				<div class="badPerson">
				    <div class="reportImg"><img src="../images/default.png"></div>
				    <div class="information">
				        <div class="name">Raul Reyes Rodriguez</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>

				<div class="badPerson">
				    <div class="reportImg"><img src="../images/default.png"></div>
				    <div class="information">
				        <div class="name">Pablo Lagarda Rodriguez</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>

				<div class="badPerson">
				    <div class="reportImg"><img src="../images/default.png"></div>
				    <div class="information">
				        <div class="name">Fernando Coronel Salinas</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>



				<!--
				<div class="report">
	  					<div class="userImage">
	  						<img src="../images/default.png">
	  					</div>
	  					<div class="userImage">
	  						<div class="nameAndRating"><label>UserName</label></div>
	  						<div class="nameAndRating"><label>Stars</label></div>
	  					</div>
  				</div>-->

			</div>

		</div>
    <footer>
      <?php //require_once('../lib/admin/footer.php'); ?>
    </footer>
</body>

</html>
