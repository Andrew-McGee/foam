<?php
	include 'includes/callAPI.php';

	$filt = $_GET["filt"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$albums = explode(",", $filt);
	$total_albums = count($albums);
	$supalist = [];

	for ($cnt = 0; $cnt < $total_albums; $cnt++){
		$get_data = albumsongsAPI($auth, $albums[$cnt]);
		$song_results = json_decode($get_data, true);
		// Merge all the song results from each album each loop
		$supalist = array_merge($supalist, $song_results['song']);
	}

	shuffle($supalist); // Randomise the array
	$total_supalist = count($supalist);  // How many songs in total

	if ($total_supalist > 100) $supalist = array_slice($supalist, 0, 100); // Return the first 100 elements only
	$total_supalist = count($supalist);  // Now total songs should be 100 or less

	$song_results['song'] = $supalist;
	$main_results['album'][0]['songcount'] = $total_supalist;

	// Get playlist info so we can have them listed in our per track menu
	$get_data = playlistsAPI($auth, '', 0);
	$playlists_results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>
parent.activeMenu(0); // Call js function in parent to highlight the correct active menu item -->
parent.list = []; // Clean out the old list before we build a new one

</script>
<body>
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui one column grid">' . "\r\n"; //Two columns - first column just for spacing.

							// Left column for stats
							echo '<div class="ui four wide column">' . "\r\n";
							  echo '<i class="massive bordered feature blender icon"></i>';
								echo '<br><br>';
								echo '<strong>SUPA-MIX</strong>';
								echo '<br>' . $total_supalist . ' songs';
								echo '<br>Blended from ' . $total_albums . ' albums';
							echo '</div>' . "\r\n"; // End of 1st column

							// Right column for album songs in table
							echo '<div class="ui twelve wide column">' . "\r\n";
								echo '<div class="ui huge smoke header">SUPA-MIX</div>' . "\r\n";
								echo '<button class="ui tiny grey button" id="playb"><i class="play icon"></i>PLAY</button>';
								echo '&nbsp;<button class="ui tiny grey button" id="shufb"><i class="random icon"></i>SHUFFLE</button>';
								echo '&nbsp;<div class="ui inline dropdown"><i class="ellipsis vertical icon"></i>' . "\r\n";
								echo '	<div class="menu" id="albumMenu">' . "\r\n";
								echo '	<div class="item" id="addAll2Q">Add to queue</div>' . "\r\n";
								echo '	<div class="item" id="playAllNext">Play next</div>' . "\r\n";
								echo '</div></div>' . "\r\n";
								// Make a listener for clicking on the play button
								echo "\r\n<script>playb.addEventListener('click', function() {";
								echo "  parent.newQueue('0');";
								echo '});</script>' . "\r\n";

								// Make a listener for clicking on the shuffle button
								echo "<script>shufb.addEventListener('click', function() {";
								echo "  parent.shuffle('0');";
								echo '});</script>' . "\r\n";

								// Make a listener for Add to Queue menu item
								echo "<script>addAll2Q.addEventListener('click', function() {";
								echo "	parent.addAll2Q();";
								echo '});</script>' . "\r\n";

								// Make a listener for Add All to play next menu item
								echo "<script>playAllNext.addEventListener('click', function() {";
								echo "	parent.playAllNext();";
								echo '});</script>' . "\r\n";

								// Build the table that will list our tracks
								$trknum = false;		//Set flag to include a col for track numbers
								$plylst = false;		//Set flag to include a col for track numbers
								include 'includes/build_tracks.php';

							echo '</div>' . "\r\n"; // End of 2nd column

						echo '</div>' . "\r\n"; //End of content grid.
					?>
			  </div>

				<!-- Set up new playlist modal -->
			  <div class="ui new modal">
					<div class="ui inverted playlist segment">
						<div class="ui huge smoke header">New Playlist</div>
				    <div class="ui input"><input id="newname" type="text" placeholder="Title"></div><br>
						<div class="actions">
							<button class="ui tiny cancel button" id="cancel">CANCEL</button>&nbsp;
							<button class="ui tiny approve button" id="save">SAVE</button>
						</div>
					</div>
			  </div>

<!-- JS to initialise dropdowns-->
<script>
$('.ui.dropdown')
  .dropdown()
;
</script>
</body>
</html>
