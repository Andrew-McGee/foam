<!-- Header for foam - Copyright 2021 Andrew McGee -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<title>foam</title>
	<meta charset="UTF-8">
	<meta name="Generator" content="Atom">
	<meta name="Author" content="Andrew McGee">
	<meta name="Keywords" content="Ampache, Fomantic, media player, web player">
	<meta name="Description" content="A Fomantic UI and Ampache web player frontend.">

	<!-- favicon stuff -->
	<link rel="icon" type="image/x-icon" sizes="16x16" href="/favicon.ico"/>

<!-- JQuery from CDN -->
	<script src="dist/jquery.min.js"></script>

<!-- Fomantic UI -->
	<link rel="stylesheet" type="text/css" href="dist/semantic.min.css">
	<script src="dist/semantic.min.js"></script>

<!-- CSS Overrides -->
  <link rel="stylesheet" href="config/settheme.php" type="text/css" />
	<link rel="stylesheet" href="css/main.css" type="text/css" />
	<link rel="stylesheet" href="css/spectograph.css" type="text/css" />
</head>

<!-- Start the main body -->
<body>
<!-- Start the top menu - changed to a grid container -->
<div class="ui inverted top fixed menu">

		  <!-- Title -->
			<div class="item">
				<h1 class="ui space header">foam</h1>
			</div>

			<!-- Search bar -->
			<div class="item">
				<form class="ui form" method="GET" target="iframe_main" action="smart_results.php">
					<div class="field">
						<div class="ui mini icon input">
						  <input name="search" type="text" placeholder="Search...">
						  <i class="search icon"></i>
						</div>
					</div>
				</form>
			</div>

			<!-- Micro player -->
			<div class="borderless item"> <!-- Transport Controls -->
				<table><tr>
					<td><span class="ui small text">MICROPLAY</span></td>
					<td><i class="bordered step backward icon" id="backBtn"></i></td>
					<td><i class="bordered play icon" id="playBtn"></i></td>
					<td><i class="bordered step forward icon" id="frwdBtn"></i></td>
				</tr></table>
			</div>

			<div class="horizontally fitted borderless item"> <!-- Track timer -->
					<span class="ui medium text" id="timer">00:00</span>
			</div>

			<div class="borderless slider item"> <!-- Duration and track slider -->
				<div class="ui small blue track slider" id="track1"></div>
			</div>

			<div class="horizontally fitted borderless item"> <!-- Track Length -->
				<span class="ui medium text" id="length">00:00</span>
			</div>

			<div class="borderless item"> <!-- Spectograph -->
					<div class="spectrograph">
						<div class="spectrograph__off" id="specto1"></div>
						<div class="spectrograph__off" id="specto2"></div>
						<div class="spectrograph__off" id="specto3"></div>
						<div class="spectrograph__off" id="specto4"></div>
						<div class="spectrograph__off" id="specto5"></div>
					</div>
			</div>

			<div class="borderless item"> <!-- Volume mute button -->
					<i class="bordered volume up icon" id="volBtn"></i>
			</div>

			<div class="borderless slider item"> <!-- Volume slider -->
					<div class="ui small blue vol slider" id="vol1"></div>
			</div>

			<div class="item"> <!-- spacer for border -->
			</div>

			<div class="borderless item"> <!-- Song title and album thumbnail -->
				<table><tr>
					<td><a id="albmLink" href="albums_view.php" target="iframe_main">
						<img id="playrThumb" src="img/vinyl.png" height="50"></a></td>
					<td><strong><div class="ui small space header" id="playrTitle"></div></strong>
					<div class="ui small text" id="playrArtist"></div></td>
				</tr></table>
			</div>

			<div class="borderless item"> <!-- Queue dropdown -->
				<table><tr>
						<td><div class="ui inline dropdown">
							<i class="big caret down icon toggle-down" id="queueBtn"></i>
						  <div class="menu" id="queueMenu">
			        <div class="active item">No Music Here!</div>
      			</div>
					</div></td>
				</tr></table>
			</div>

			<!-- Tagline -->
			<div class="right menu">
	  		<div class="item" id="status_msg">
					A Fomantic Ampache web player.
				</div>
			</div>

</div> <!-- End the top menu -->

<!-- Set up new playlist pfromq modal -->
<div class="ui pfromq modal">
	<div class="ui inverted playlist segment">
		<div class="ui huge smoke header">New Playlist</div>
    <div class="item"><input id="newname" type="text" placeholder="Title"></div><br>
		<div class="actions">
			<button class="ui tiny cancel button" id="cancel">CANCEL</button>&nbsp;
			<button class="ui tiny approve button" id="save">SAVE</button>
		</div>
	</div>
</div>

<!-- Scripts -->
<script src="dist/howler.core.min.js"></script>
<script src="js/player.js"></script>
<script src="js/dragger.js"></script>
