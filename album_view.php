<?php
	include 'includes/callAPI.php';

	$uid = $_GET["uid"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = albumAPI($auth, $uid);
	$main_results = json_decode($get_data, true);

	$get_data = albumsongsAPI($auth, $uid);
	$song_results = json_decode($get_data, true);

	// Get playlist info so we can have them listed in our per track menu
	$get_data = playlistsAPI($auth, '', 0);
	$playlists_results = json_decode($get_data, true);

	// Create a stripped down album title we can use in a link for series match
	$seriesMatch = smatch($main_results['name']);

	include 'includes/header_iframe.php';
?>
<script>
parent.activeMenu(0); // Call js function in parent to highlight the correct active menu item -->
parent.list = []; // Clean out the old list before we build a new one

</script>
<body>
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui two column grid">' . "\r\n"; //Two columns for album view - art on left, tracks on right.

							// Left column for album art and stats
							echo '<div class="ui four wide column">' . "\r\n";
								echo "<img class='ui massive image' src='" . $main_results['album'][0]['art'] . "' >";
								echo '<br><a href="artist_albums.php?uid=' . $main_results['album'][0]['artist']['id'] . '">';
								echo $main_results['album'][0]['artist']['name'] . '</a>';
								echo '<br>' . $main_results['album'][0]['year'];
								echo '<br>' . $main_results['album'][0]['songcount'] . ' songs';
								$result = sec2mins($main_results['album'][0]['time']);
								if ($result['hours'] > 0) {
									if ($result['hours'] > 1) {
										echo '<br>' . $result['hours'] . ' hours, ' . $result['minutes'] . ' minutes';
									} else {
										echo '<br>' . $result['hours'] . ' hour, ' . $result['minutes'] . ' minutes';
									}
								} else {
									echo '<br>' . $result['minutes'] . ' minutes';
								}
								//echo '<br>time element = ' . $albm_results['album'][0]['time'];
								//var_dump($albm_results);
							echo '</div>' . "\r\n"; // End of 1st column

							// Right column for album songs in table
								echo '<div class="ui twelve wide column">' . "\r\n";
								echo '  <div class="ui huge smoke header">' . $main_results['album'][0]['name'] . '</div>' . "\r\n";
								echo '  <button class="ui tiny button" id="playb"><i class="play icon"></i>PLAY</button>&nbsp;';
								echo '  <button class="ui tiny button" id="shufb"><i class="random icon"></i>SHUFFLE</button>&nbsp;';
								echo '  <div class="ui inline dropdown"><i class="ellipsis vertical icon"></i>' . "\r\n";
								echo '  	<div class="menu" id="albumMenu">' . "\r\n";
								echo '  	  <div class="item" id="addAll2Q">Add to queue</div>' . "\r\n";
								echo '  	  <div class="item" id="playAllNext">Play next</div>' . "\r\n";
								echo '  	  <div class="item"><a class="icn" href="albums_view.php?filt=' . $seriesMatch . '">Series match</a></div>' . "\r\n";
								echo '    </div></div>' . "\r\n";
								if ($main_results['album'][0]['flag'] == 0 ) {
									echo '<i id="albumStar" class="star outline icon"></i>';
								} else {
									echo '<i id="albumStar" class="blue star icon"></i>';
								}

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

								// Make a listener for clicking on the favourite star for album
								echo "<script>albumStar.addEventListener('click',  function() {";
								echo '	if (document.getElementById("albumStar").className !== "blue star icon") {';
								echo '   	  document.getElementById("albumStar").className = "blue star icon";';
								echo '	    $.get("includes/favAPI.php?type=album&id=' . $main_results['album'][0]['id'] . '&flag=1");';
								echo '	} else { ';
								echo '			document.getElementById("albumStar").className = "star outline icon";';
								echo '	    $.get("includes/favAPI.php?type=album&id=' . $main_results['album'][0]['id'] . '&flag=0");';
								echo '	}';
								echo '});</script>' . "\r\n";

								// Build the table that will list our tracks
								$trknum = true;		//Set flag to include a col for track numbers
								include 'includes/build_tracks.php';

							echo '</div>' . "\r\n"; // End of 2nd column

						echo '</div>' . "\r\n"; //End of content grid.
					?>
			  </div>

				<!-- Set up new playlist modal -->
			  <div class="ui modal">
					<div class="ui inverted playlist segment">
						<div class="ui huge smoke header">New Playlist</div>
				    <div class="ui input"><input class="ui input" id="newname" type="text" placeholder="Title"></div><br>
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
