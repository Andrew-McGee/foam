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
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Fomantic UI -->
	<link rel="stylesheet" type="text/css" href="dist/semantic.min.css">
	<script src="dist/semantic.min.js"></script>

<!-- CSS Overrides -->
  <link rel="stylesheet" href="config/settheme.php" type="text/css" />
	<link rel="stylesheet" href="css/main.css" type="text/css" />
</head>

<!-- Start the main body -->
<body>
<!-- Start the top menu - changed to a grid container -->
<div class="ui inverted top segment">
	<div class="ui middle aligned seven column grid">

		  <!-- Title -->
			<div class="one wide column">
				<h1 class="ui space header">foam</h1>
			</div>

			<!-- Search bar -->
			<div class="two wide column">
				<form class="ui form" method="GET" target="iframe_main" action="smart_results.php">
					<div class="field">
						<div class="ui mini icon input">
						  <input name="search" type="text" placeholder="Search...">
						  <i class="search link icon"></i>
						</div>
					</div>
				</form>
			</div>

			<!-- Micro player -->
			<div class="two wide column"> <!-- Transport Controls -->
				<table><tr>
					<td><span class="ui small text">MICROPLAY</span></td>
					<td><i class="bordered step backward icon" id="backBtn"></i></td>
					<td><i class="bordered play icon" id="playBtn"></i></td>
					<td><i class="bordered step forward icon" id="frwdBtn"></i></td>
				</tr></table>
			</div>

			<div class="three wide column"> <!-- Duration and track slider -->
				<table><tr>
					<td><span class="ui medium text" id="timer">00:00</span></td>
					<td style="width:70%"><div class="ui small blue track slider" id="track1"></div></td></td>
					<td><span class="ui medium text" id="length">00:00</span></td>
				</tr></table>
			</div>

			<div class="three wide column">
				<table><tr>
					<td><a id="albmLink" href="albums_view.php" target="iframe_main">
						<img id="playrThumb" src="img/vinyl.png" height="50"></a></td>
					<td><strong><div class="ui small space header" id="playrTitle"></div></strong>
					<div class="ui small text" id="playrArtist"></div></td>
				</tr></table>
			</div>

			<div class="three wide column"> <!-- Queue dropdown and volume slider -->
				<table><tr>
						<td><div class="ui inline dropdown">
							<i class="big caret down icon toggle-down" id="queueBtn"></i>
						  <div class="menu" id="queueMenu">
			        <div class="active item">No Music Here!</div>
      			</div>
					</div></td>
					<td style="width:70%"><div class="ui small blue vol slider" id="vol1"></div></td>
					<td><i class="bordered volume up icon" id="volBtn"></i></td>
				</tr></table>
			</div>

			<!-- Tagline -->
	  	<div class="two wide column" id="status_msg">
				A Fomantic Ampache web player.
			</div>
	</div>
</div> <!-- End the top segment -->

<!-- Set up new playlist pfromq modal -->
<div class="ui pfromq modal">
	<div class="ui inverted space segment">
		<div class="ui huge smoke header">New Playlist</div>
    <div class="item"><input id="newname" type="text" placeholder="Title"></div><br>
		<div class="actions">
			<button class="ui tiny cancel button" id="cancel">CANCEL</button>&nbsp;
			<button class="ui tiny approve button" id="save">SAVE</button>
		</div>
	</div>
</div>

<!-- Scripts -->
<script src="dist/howler.js"></script>
<script src="js/player.js"></script>
