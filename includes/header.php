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
<div class="ui six column fluid grid container">

	  <!-- Title -->
		<div class="column">
			<h1 class="ui inverted yellow header">foam</h1>
		</div>

		<!-- Search bar -->
		<div class="column">
			<div class="ui mini icon input">
			  <input type="text" placeholder="Search...">
			  <i class="search link icon"></i>
			</div>
		</div>

		<!-- Micro player -->
		<div class="column">
			<span class="ui small text">MICROPLAY</span>
			<i class="step backward icon"></i>
			<i class="play icon"></i>
			<i class="step forward icon"></i>
		</div>

		<div class="column">
			<span class="ui small text">00:23</span>
			<div class="ui small slider" id="track1"></div>
			<span class="ui small text">04:13</span>
		</div>

		<div class="column">
			<i class="hamburger icon"></i>
			<i class="volume up icon"></i>
			<i class="volume mute icon"></i>
		</div>

		<!-- Tagline -->
  	<div class="column">
			A Fomantic Ampache web player.
		</div>
</div> <!-- End the top menu -->
