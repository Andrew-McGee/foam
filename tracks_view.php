<?php
	include 'includes/callAPI.php';

	// Check if we have a filter parm
	if (!empty($_GET["filt"])) {
		$filt = $_GET["filt"];
		$plfilt = $filt;
	} else {
		$filt = '';
		$plfilt = 'Filter...';
	}

	// Check if we have an offset value passed for pagination
	if (!empty($_GET["ofst"])) {
		$offset = $_GET["ofst"];
	} else {
		$offset = 0;
	}

	//Set up some offset values for our next and prev buttons
  if ($offset == 0) {
		$poffset = 0;
	} else {
		$poffset = $offset - 20;
	}
	$noffset = $offset + 20;

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = songsAPI($auth, $filt, $offset);
	$song_results = json_decode($get_data, true);
	$cnt = count($song_results['song']); //Set counter to number of songs returned
	$main_results['songcount'] = $cnt;

	// Get playlist info so we can have them listed in our per track menu
	$get_data = playlistsAPI($auth, '', 0);
	$playlists_results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>
parent.activeMenu(5); // Call js function in parent to highlight the correct active menu item -->
parent.list = []; // Clean out the old list before we build a new one

</script>
<body>
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui one column grid">' . "\r\n"; //Two columns - first column just for spacing.

							// Left column for album art and stats
							echo '<div class="ui four wide column">' . "\r\n";
							  echo '<i class="massive bordered feature music icon"></i>';
								echo '<br><br>';
								echo '<strong>Tracks</strong></a>';
								echo '<br>A - Z';
								echo '<br> songs';
							echo '</div>'; // End of 1st column

							// Right column for list of songs in table
							echo '<div class="ui twelve wide column">';

								echo '<div class="ui middle aligned grid">';
									echo '<div class="left floated four wide column">';
										echo '<h1 class="ui smoke header">Tracks&nbsp;&nbsp;&nbsp;<i class="small music icon"></i></h1>';
									echo '</div>' . "\r\n";

									// Tag column
									echo '<div class="three wide column">' . "\r\n";
										if ($filt !== '') {echo '<div class="ui filter large label">' . $filt . '&nbsp;<a class="icn" href="tracks_view.php"><i class="icon close"></i></a></div>';}
									echo '</div>' . "\r\n";

									// Filter bar column
									echo '<div class="three wide column">' . "\r\n";
										echo '<form class="ui form" method="GET" action="tracks_view.php">' . "\r\n";
											echo '<div class="field">' . "\r\n";
												echo '<div class="ui small icon input">' . "\r\n";
										  		echo '<input name="filt" type="text" placeholder="' . $plfilt . '" value="' . $filt . '"><i class="filter icon"></i>';
												echo '</div>' . "\r\n";
											echo '</div>' . "\r\n";
										echo '</form>' . "\r\n";
									echo '</div>' . "\r\n";

									// Pagination column
									echo '<div class="right floated right aligned four wide column">' . "\r\n";
											if ($offset > 0) echo '<a class="icn" href="tracks_view.php?filt=' . $filt . '&ofst=' . $poffset . '"><i class="arrow circle left icon"></i></a>&nbsp;&nbsp;&nbsp;';
											if ($cnt == 20) echo '<a class="icn" href="tracks_view.php?filt=' . $filt . '&ofst=' . $noffset . '"><i class="arrow circle right icon"></i></a>';
									echo '</div>' . "\r\n";
								echo '</div>' . "\r\n";

								// Build the table that will list our tracks
								include 'includes/build_tracks.php';

							echo '</div>' . "\r\n"; // End of 2nd column

						echo '</div>' . "\r\n"; //End of content grid.
					?>
			  </div>

				<!-- Set up new playlist modal -->
			  <div class="ui modal">
					<div class="ui inverted space segment">
						<div class="ui huge smoke header">New Playlist</div>
				    <div class="item"><input id="newname" type="text" placeholder="Title"></div><br>
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
