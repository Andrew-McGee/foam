<?php
	include 'includes/callAPI.php';

	$get_data = handshakeAPI();
	$stats = json_decode($get_data, true);

	$auth=$stats[auth];

	$get_data = recentAPI($auth);
	$recent = json_decode($get_data, true);

?>

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

<body>
<!-- Start the header -->
<div class="ui fixed inverted amaranth massive text menu">
		<div class="item">
			<h1 class="ui inverted yellow header">
      foam
			</h1>
		</div>
  	<div class="right item">
			A Fomantic Ampache web player.
		</div>
</div> <!-- End the header -->

<!-- Main Body -->
	<!-- 2 column grid -->
	<div class="ui two column grid">
		<div class="ui three wide sidemenu column"><!-- Start of page column 1 - left sidebar -->
			<div class="ui container"> <!-- Container to constrain width of Vertical Menu -->

				<!-- Side Vertical Menus - have a seperate menu for each section-->
				<div class="ui left fixed compact vertical inverted spacecadet menu">

					<a class="item" href="/recent_view.php"><i class="clock icon"></i>Recent</a>
					<a  class="item" href="/newest_view.php"><i class="meteor icon"></i>Newest</a>
					<a class="item" href="/artists_view.php"><i class="user icon"></i>Artists</a>
					<a class="item" href="/albums_view.php"><i class="record vinyl icon"></i>Albums</a>
					<a class="item" href="/tracks_view.php"><i class="music icon"></i>Tracks</a>
					<a class="item" href="/playlists_view.php"><i class="stream icon"></i>Playlists</a>
					<a class="item" href="/favourites_view.php"><i class="star icon"></i>Favourites</a>
				</div>

				<div class="ui segment">
					<h1 class="ui small header">Stats</h1>
					<?php
					echo '<p><br>Albums: '. $stats[albums];
					echo '<br>Artists: '. $stats[artists];
					echo '<br>Tracks: '. $stats[songs];
					echo '<br>Genres: '. $stats[genres];
					echo '<br>Playlists: '. $stats[playlists];
					echo '</p>';
					?>
				</div>

			</div> <!-- Close container -->
		</div> <!-- End of Column 1 -->

    <div class="ui thirteen wide column"><!-- START of page column 2 - middle main content -->
		  <div class="ui inverted manatee segment">
			  <div class="ui inverted space segment">
			    <h1 class="ui smoke header">Welcome to foam</h1>
			    <p>This is some placeholder text that will eventually be replaced by containers with album, artist or song information.</p>
					<p>Here is a response from Ampache API handshake:</p>
					<p>
					<?php

					echo '<p><pre>auth= '. $response[auth];
					echo '<br>api= '. $response[api];
					echo '<br>albums= '. $response[albums];
					echo '<br>artists= '. $response[artists];
					echo '<br>genres= '. $response[genres];
					echo '<br>playlists= '. $response[playlists];
					echo '</pre></p>';

					echo '<p>Now here is a response from Ampache recent API (Albums):</p>';

					$cnt = 0;

					echo "<div class='ui six column grid container'>";

					for ($i = 1; $i <=4; $i++){
						echo "<div class='ui row'>";
						for ($j = 1; $j <=6; $j++){
							echo "<div class='ui column'>";
							echo "<img class='ui small image' src='" . $recent[album][$cnt][art] . "' >";
							echo '<center><br>'. $recent[album][$cnt][name];
							echo '<br>'. $recent[album][$cnt][artist][name];
							echo '<br>'. $recent[album][$cnt][year];
							echo "</center></div>";
							$cnt++;
						}
						echo "</div>";
					}


					?>
					</p>
			  </div>
		  </div>
	  </div><!-- END of page column 2 -->
	</div>
<!-- Start the footer -->
  <div class="ui inverted spacecadet vertical footer segment">
    <div class="ui center aligned container">
			<h1 class="ui inverted yellow header">foam</h1>
    </div>
  </div>

</body>
<!-- JS to initialise dropdowns-->
<script>
$('.ui.dropdown')
  .dropdown()
;
</script>
</html>
