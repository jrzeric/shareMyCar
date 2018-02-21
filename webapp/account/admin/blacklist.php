<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/title.php'); ?> Blacklist</title>
		<!--style sheets-->
    <link href="../css/admin/header.css" rel="stylesheet"></link>
		<link href="../css/admin/style.css" rel="stylesheet"></link>
		<link href="/css/footer.css" rel="stylesheet"></link>
		<link rel="stylesheet" href="css/style.css">
		<!--scripts-->
		<script src="/js/index.js"></script>

	</head>
	<body>
		<header id="nav">
			<?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/header_admin.php"); ?>
		</header>
		<div id="sidemenu">
			<a href="#"><img class="iconSideMenu" src="/images/home.png">  Home</a>
			<a href="#"><img class="iconSideMenu" src="/images/report.png">  Reports</a>
			<a href="#"><img class="iconSideMenu" src="/images/blacklist.png">  Black List</a>
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
				<a href="#openwindow">
					<div class="badPerson">
				    <div class="reportImg"><img src="/images/default.png"></div>
				    <div class="information">
				        <div class="name">Maria Felix De La Olla</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/account/lib/popup.php'); ?>
			</a>

				<div class="badPerson">
				    <div class="reportImg"><img src="/images/default.png"></div>
				    <div class="information">
				        <div class="name">Eric Luis Juarez Cendejas</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>

				<div class="badPerson">
				    <div class="reportImg"><img src="/images/default.png"></div>
				    <div class="information">
				        <div class="name">Raul Reyes Rodriguez</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>

				<div class="badPerson">
				    <div class="reportImg"><img src="/images/default.png"></div>
				    <div class="information">
				        <div class="name">Pablo Lagarda Rodriguez</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>

				<div class="badPerson">
				    <div class="reportImg"><img src="/images/default.png"></div>
				    <div class="information">
				        <div class="name">Fernando Coronel Salinas</div>
		                <div class="unBanAt">2 days to unban</div>
				    </div>
				</div>



				<!--
				<div class="report">
	  					<div class="userImage">
	  						<img src="/images/default.png">
	  					</div>
	  					<div class="userImage">
	  						<div class="nameAndRating"><label>UserName</label></div>
	  						<div class="nameAndRating"><label>Stars</label></div>
	  					</div>
  				</div>-->

			</div>

		</div>
    <footer class="footer footer--black">
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/lib/footer_admin.php"); ?>
    </footer>
</body>

</html>
