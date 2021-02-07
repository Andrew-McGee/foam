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
  <link rel="stylesheet" href="css/main.css" type="text/css" />
</head>

<!-- Start the main body -->
<body>
<!-- Start the top menu - changed to a grid container -->
<div class="ui inverted top segment">
	<div class="ui middle aligned seven column grid">

		  <!-- Title -->
			<div class="one wide column">
				<h1 class="ui inverted yellow header">foam</h1>
			</div>

			<!-- Search bar -->
			<div class="two wide column">
				<div class="ui mini icon input">
				  <input type="text" placeholder="Search...">
				  <i class="search link icon"></i>
				</div>
			</div>

			<!-- Micro player -->
			<div class="four wide column"> <!-- Transport Controls -->
				<div class="ui horizontal basic segments">
					<div class="ui segment">
						<span class="ui small text">MICROPLAY</span>
					</div>
					<div class="ui segment">
						<i class="bordered step backward icon" id="backBtn"></i>
					</div>
					<div class="ui segment">
						<i class="bordered play icon" id="playBtn"></i>
					</div>
					<div class="ui segment">
						<i class="bordered pause icon" id="pauseBtn"></i>
					</div>
					<div class="ui segment">
						<i class="bordered step forward icon" id="frwdBtn"></i>
					</div>
					<div class="ui segment">
						<span class="ui medium text" id="timer">00:23</span>
					</div>
				</div>
			</div>

			<div class="two wide column">
				<div class="ui small blue slider" id="track1"></div>
			</div>

			<div class="four wide column">
				<table><tr>
					<td><span class="ui medium text" id="length">04:13</span></td>
					<td><img class="ui image"  id="playrThumb" src="img/vinyl.png" width="50" height="50"></td>
					<td><strong><div class="ui small text" id="playrTitle"></strong></div>
					<div class="ui small text" id="playrArtist"></div></td>
					<td><i class="sort down icon" id="queueBtn"></i></td>
					<td><i class="volume mute icon" id="muteBtn"></i></td>
					<td><i class="volume up icon" id="volBtn"></i></td>
				</tr></table>
			</div>

			<div class="two wide column">
				<div class="ui small blue slider" id="vol1"></div>
			</div>

			<!-- Tagline -->
	  	<div class="one wide column" id="status_msg">
				A Fomantic Ampache web player.
			</div>
	</div>
</div> <!-- End the top segment -->

<!-- Scripts -->
<script src="dist/howler.js"></script>
<script src="js/player.js"></script>
