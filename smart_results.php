<?php
	include 'includes/callAPI.php';

	// Check if we have a search parm (we should always)
	if (!empty($_GET["search"])) {
		$search = $_GET["search"];
	} else {
		$search = '';
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
		$poffset = $offset - 25;
	}
	$noffset = $offset + 25;

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = smartAPI($auth, $search, 'artist');
	$artist_results = json_decode($get_data, true);

	$get_data = smartAPI($auth, $search, 'album');
	$album_results = json_decode($get_data, true);

	$get_data = smartAPI($auth, $search, 'song');
	$song_results = json_decode($get_data, true);

	// Get playlist info so we can have them listed in our per track menu
	$get_data = playlistsAPI($auth, '', 0);
	$playlist_results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>
parent.activeMenu(0);
parent.list = []; // Clean out the old list before we build a new one
</script>

<body>
			  <div class="ui inverted space segment">
					<div class='ui middle aligned grid'>
						<div class="left floated column">
							<h1 class="ui smoke header"><i class="small search icon"></i>&nbsp;&nbsp;&nbsp;Smart Search Results:
							&nbsp; <?php echo $search; ?></h1>
						</div>
					</div>

					<?php
					// This section contains the artist search results
					// Only show this section if we have results
					if (count($artist_results['artist']) !== 0) {
						echo '<div class="ui middle aligned grid">';
						echo '  <div class="left floated four wide column">';
						echo '    <h1 class="ui smoke header">Artists&nbsp;&nbsp;&nbsp;<i class="small user icon"></i></h1>';
						echo '  </div>';
						echo '  <div class="right floated right aligned four wide column">';
						echo '    <a class="icn" href="artists_view.php?filt=' . $search . '"><i class="arrow circle right icon"></i></a>';
						echo '  </div>';
						echo '</div>';

							// Build the artist tags in columns
							echo '<div class="ui six column grid container">';
							$cnt = count($artist_results['artist']);
							for ($i = 0; $i < $cnt; $i++){
								echo '<div class="column">' . "\r\n";
								echo '  <a class="icn" href="artist_albums.php?uid=' . $artist_results['artist'][$i]['id'] . '">' . "\r\n";
								echo '  <button class="ui tiny button"><i class="user icon"></i>' . $artist_results['artist'][$i]['name'] . '</button></a>';
								echo '</div>';
							}
							echo '</div>';
						}
					//  End of artist search results

					// This section contains the album search results
					// Only show this section if we have results
					if (count($album_results['album']) !== 0) {
							echo '<div class="ui middle aligned grid">';
								echo '<div class="left floated four wide column">';
									echo '<h1 class="ui smoke header">Albums&nbsp;&nbsp;&nbsp;<i class="small record vinyl icon"></i></h1>';
								echo '</div>';
								echo '<div class="right floated right aligned four wide column">';
										echo '<a class="icn" href="albums_view.php?filt=' . $search . '"><i class="arrow circle right icon"></i></a>';
								echo '</div>';
							echo '</div>';

							$cnt = count($album_results['album']);
							echo '<div class="ui six column grid container">';
								echo '<div class="ui row">';
									//Loop 6 columns
									for ($j = 0; $j < $cnt; $j++){
										echo '<div class="ui column">';
										echo '  <a href="album_view.php?uid=' . $album_results['album'][$j]['id'] . '">';
										echo "  <img class='ui small image' src='" . $album_results['album'][$j]['art'] . "' ></a>";
										echo '  <br><center><a href="album_view.php?uid=' . $album_results['album'][$j]['id'] . '">';
										echo $album_results['album'][$j]['name'] . "</a>";
										echo '  <br><a href="artist_albums.php?uid=' . $album_results['album'][$j]['artist']['id'] . '">';
										echo $album_results['album'][$j]['artist']['name'] . "</a>";
										echo '  <br>'. $album_results['album'][$j]['year'];
										echo '  </center></div>';
									}
								echo '</div>';
							echo '</div>';
						}
						// End of album search results

						// This section contains the track search results
						// Only show this section if we have results
						if (count($song_results['song']) !== 0) {
									echo '<div class="ui middle aligned grid">';
									echo '  <div class="left floated four wide column">';
									echo '    <h1 class="ui smoke header">Tracks&nbsp;&nbsp;&nbsp;<i class="small music icon"></i></h1>';
									echo '  </div>';
									echo '  <div class="right floated right aligned four wide column">';
									echo '    <a class="icn" href="tracks_view.php?filt=' . $search . '"><i class="arrow circle right icon"></i></a>';
									echo '  </div>';
									echo '</div>';

									//Let's make the table for the song list
									echo '<table class="ui selectable inverted black table">' . "\r\n";
									echo '  <thead><tr>';
									echo '    <th>Title</th><th>Artist</th><th></th><th>Time</th><th>DL</th>';
									echo '  </tr></thead>' . "\r\n";
									echo '  <tbody>' . "\r\n";

									//Loop through the songs to display each on a table row
									$cnt = count($song_results['song']);
									if ($cnt > 6) {
										$cnt = 6; //Reset our counter to build max 5 rows of songs
									}
									for ($i = 0; $i < $cnt; $i++){
										echo "\r\n" . '<tr class="albm-row" id="row' . $i . '">' . "\r\n"; // Start of the song listing row
											echo '<td id="trk' . ($i + 1) . '"><strong>' . $song_results['song'][$i]['title'] . '</strong></td>' . "\r\n";
											echo '<td><a href="artist_albums.php?uid=' . $song_results['song'][$i]['artist']['id'] . '">';
											echo $song_results['song'][$i]['artist']['name'] . '</a></td>' . "\r\n";

											// hidden star and elipse reveal on mouseover row (see listeners below)
											// some code here to test if song is flagged or not (favourite = blue star)
											$fav = $song_results['song'][$i]['flag'];
											if ($fav == true) {
												$favi = "blue star icon";
											} else {
												$favi = "hidden star outline icon";
											}
											echo '<td><i class="' . $favi . '" id="hiddenstar' . $i . '"></i>&nbsp;' . "\r\n";

											// Here's the code for the hidden drop down menu that appears on each track row under vertical elipsis
											echo '<div class="ui inline dropdown"><i class="hidden ellipsis vertical icon" id="hiddenelipse' . $i . '"></i>' . "\r\n";
											echo '	<div class="menu" id="albumMenu">' . "\r\n";
											echo '		<div class="item" id="addT2Q' . $i . '">Add to queue</div>' . "\r\n";
											echo '		<div class="item" id="playNext' . $i . '">Play next</div>' . "\r\n";
											echo '		<div class="item" id="playOnly' . $i . '">Play only</div>' . "\r\n";
											echo '		<div class="item" id="addT2P' . $i . '">Add to playlist' . "\r\n";
											echo '      <div class="menu">' . "\r\n";  // Add to playlist spawns another submenu
											echo '        <div class="item" id="newplaylist' . $i . '"><center><button class="ui tiny basic button">NEW</button></center></div>' . "\r\n";
											// Loop to add all our known playlists to the sub menu
											$j = 0;
											foreach ($playlist_results['playlist'] as $playlist) {
												echo '      <div class="item" id="playlist' . $i . "_" . $j . '">' . $playlist['name'] . '</div>' . "\r\n";
												$j++;
											}
											echo '      </div>' . "\r\n";
											echo '    </div>' . "\r\n";
											echo '		<div class="item"><a class="icn" href="album_view.php?uid=' . $song_results['song'][$i]['album']['id'] . '">Go to album</a></div>' . "\r\n";
											echo '		<div class="item"><a class="icn" href="artist_albums.php?uid=' . $song_results['song'][$i]['artist']['id'] . '">Go to artist</a></div>' . "\r\n";
											echo '	</div>' . "\r\n";
											echo '</div></td>' . "\r\n";

											// Calculate song length from seconds
											$result = sec2mins($song_results['song'][$i]['time']);
											echo '<td>' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '</td>' . "\r\n";

											echo '<td><a href="' . $song_results['song'][$i]['url'] . '"><i class="download icon"></i></a></td>' . "\r\n";
										echo '</tr>' . "\r\n"; // End of the row but theres some other stuff still to do in this loop

										// Let's add this entry to our js 'list' array in case it becomes a new playlist or queue
										$safeTitle = addslashes($song_results['song'][$i]['title']);  // escapes any quotes in the title
										echo "\r\n" . '<script>' . "\r\n";
										echo ' parent.list[' . $i . '] = [];' . "\r\n";
										echo ' parent.list[' . $i . '][0] = "' . $safeTitle . '";' . "\r\n";
										echo ' parent.list[' . $i . '][1] = "' . $song_results['song'][$i]['artist']['name'] . '";' . "\r\n";
										echo ' parent.list[' . $i . '][2] = "' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '";' . "\r\n";
										echo ' parent.list[' . $i . '][3] = "' . $song_results['song'][$i]['art'] . '";' . "\r\n";
										echo ' parent.list[' . $i . '][4] = "' . $song_results['song'][$i]['url'] . '";' . "\r\n";
										echo ' parent.list[' . $i . '][5] = "' . $song_results['song'][$i]['album']['id'] . '";' . "\r\n";
										echo ' parent.list[' . $i . '][6] = "' . $song_results['song'][$i]['id'] . '";' . "\r\n";
										echo '</script>' . "\r\n";

										// Make a listener for clicking on this track title
										echo "<script>trk" . ($i + 1) . ".addEventListener('click', function() {";
										echo "  parent.newSingle('" . $i . "');";
										echo '});</script>' . "\r\n";

										// Make a listener for clicking the favourite star
										echo "<script>hiddenstar" . $i . ".addEventListener('click',  function() {";
										echo '	if (document.getElementById("hiddenstar' . $i . '").className !== "blue star icon") {';
										echo '   	  document.getElementById("hiddenstar' . $i . '").className = "blue star icon";';
										echo '	    $.get("includes/favAPI.php?type=song&id=' . $song_results['song'][$i]['id'] . '&flag=1");';
										echo '	} else { ';
										echo '			document.getElementById("hiddenstar' . $i . '").className = "hidden star outline icon";';
										echo '	    $.get("includes/favAPI.php?type=song&id=' . $song_results['song'][$i]['id'] . '&flag=0");';
										echo '	}';
										echo '});</script>' . "\r\n";

										// Make a listener for add track to queue (addT2Q) menu item
										echo "<script>addT2Q" . $i . ".addEventListener('click',  function() {";
										echo "	parent.addT2Q('" . $i . "');";
										echo "});</script>" . "\r\n";

										// Make a listener for playNext menu item
										echo "<script>playNext" . $i . ".addEventListener('click',  function() {";
										echo "	parent.playNext('" . $i . "');";
										echo "});</script>" . "\r\n";

										// Make a listener for playOnly menu item
										echo "<script>playOnly" . $i . ".addEventListener('click',  function() {";
										echo "	parent.newSingle('" . $i . "');";
										echo "});</script>" . "\r\n";

										// Make a listener for clicking the add to playlist menu item - we need a loop to create 1 for each playlist
										$j = 0;
										foreach ($playlist_results['playlist'] as $playlist) {
											echo "<script>playlist" . $i . "_" . $j . ".addEventListener('click',  function() {";
											echo '	    $.get("includes/playlistAPI.php?action=add&filter=' . $playlist['id'] . '&song=' . $song_results['song'][$i]['id'] . '");';
											echo '});</script>' . "\r\n";
											$j++;
										}

										// Make a listener for clicking new playlist menu item
										echo "<script>newplaylist" . $i . ".addEventListener('click',  function() {";
										echo "	$('.ui.modal')";
										echo "    .modal({";
										echo "       onApprove : function() {";
										echo "         var nn = document.getElementById('newname').value;";
										echo '         $.get("includes/playlistAPI.php?action=new&filter=" + nn + "&song=' . $song_results['song'][$i]['id'] . '");';
										echo "         location.reload();";  // Do a reload so we can see the change"
										echo "       }";
										echo "     })";
										echo "    .modal('show')";
										echo "  ;";
										echo '});</script>' . "\r\n";

									}//End of row loop

									echo '</tbody></table>' . "\r\n";
							}
							// End of track search results

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
