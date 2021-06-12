<?php
	include 'includes/callAPI.php';

	$uid = $_GET["uid"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = albumAPI($auth, $uid);
	$albm_results = json_decode($get_data, true);

	$get_data = albumsongsAPI($auth, $uid);
	$song_results = json_decode($get_data, true);

	// Get playlist info so we can have them listed in our per track menu
	$get_data = playlistsAPI($auth);
	$playlist_results = json_decode($get_data, true);

	// Create a stripped down album title we can use in a link for series match
	$seriesMatch = smatch($albm_results['name']);

	include 'includes/header_iframe.php';
?>
<script>
parent.activeMenu(0); // Call js function in parent to highlight the correct active menu item -->
parent.list = []; // Clean out the old list before we build a new one

</script>
<body style="overflow:hidden">
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui two column grid">' . "\r\n"; //Two columns for album view - art on left, tracks on right.

							// Left column for album art and stats
							echo '<div class="ui four wide column">' . "\r\n";
								echo "<img class='ui massive image' src='" . $albm_results['art'] . "' >";
								echo '<br><a href="artist_albums.php?uid=' . $albm_results['artist']['id'] . '">';
								echo $albm_results['artist']['name'] . '</a>';
								echo '<br>' . $albm_results['year'];
								echo '<br>' . $albm_results['songcount'] . ' songs';
								$result = sec2mins($albm_results['time']);
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
								echo '  <div class="ui huge smoke header">' . $albm_results['name'] . '</div>' . "\r\n";
								echo '  <button class="ui tiny button" id="playb"><i class="play icon"></i>PLAY</button>&nbsp;';
								echo '  <button class="ui tiny button" id="shufb"><i class="random icon"></i>SHUFFLE</button>&nbsp;';
								echo '  <div class="ui inline dropdown"><i class="ellipsis vertical icon"></i>' . "\r\n";
								echo '  	<div class="menu" id="albumMenu">' . "\r\n";
								echo '  	  <div class="item" id="addAll2Q">Add to queue</div>' . "\r\n";
								echo '  	  <div class="item" id="playAllNext">Play next</div>' . "\r\n";
								echo '  	  <div class="item"><a class="icn" href="albums_view.php?filt=' . $seriesMatch . '">Series match</a></div>' . "\r\n";
								echo '    </div></div>' . "\r\n";
								if ($albm_results['flag'] == 0 ) {
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
								echo '	    $.get("includes/favAPI.php?type=album&id=' . $albm_results['id'] . '&flag=1");';
								echo '	} else { ';
								echo '			document.getElementById("albumStar").className = "star outline icon";';
								echo '	    $.get("includes/favAPI.php?type=album&id=' . $albm_results['id'] . '&flag=0");';
								echo '	}';
								echo '});</script>' . "\r\n";

								//Let's make the table for the song list
								echo "\r\n" . '<table class="ui selectable inverted black table">' . "\r\n";
								echo '<thead><tr>';
								echo '<th>#</th><th>Title</th><th>Artist</th><th></th><th>Time</th><th>DL</th>';
								echo '</tr></thead>' . "\r\n";
								echo '<tbody>' . "\r\n";
								$cnt = $albm_results['songcount']; //Set counter to total number of songs on album

								//Loop through the songs to display each on a table row
								for ($i = 0; $i < $cnt; $i++){
									echo "\r\n" . '<tr class="queue-row" id="row' . $i . '">' . "\r\n"; // Start of the track listing row
										echo '<td id="tno' . ($i + 1) . '">' . $song_results['song'][$i]['track'] . '</td>' . "\r\n";
										echo '<td id="trk' . ($i + 1) . '"><strong>' . $song_results['song'][$i]['title'] . '</strong></td>' . "\r\n";
										echo '<td><a href="artist_albums.php?uid=' . $song_results['song'][$i]['artist']['id'] . '">';
										echo $song_results['song'][$i]['artist']['name'] . '</a></td>' . "\r\n";

										// hidden star and elipse reveal on mouseover row (see listeners below)
										// some code here to test if song is flagged or not (favourite = blue star)
										$fav = $song_results['song'][$i]['flag'];
										if ($fav == true) {
											$favi = "blue star icon"; // Blue star if it's a fav
										} else {
											$favi = "hidden star outline icon";  // Hidden star outline if not fav
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
									echo ' parent.list[' . $i . '][3] = "' . $albm_results['art'] . '";' . "\r\n";
									echo ' parent.list[' . $i . '][4] = "' . $song_results['song'][$i]['url'] . '";' . "\r\n";
									echo ' parent.list[' . $i . '][5] = "' . $song_results['song'][$i]['album']['id'] . '";' . "\r\n";
									echo ' parent.list[' . $i . '][6] = "' . $song_results['song'][$i]['id'] . '";' . "\r\n";
									echo '</script>' . "\r\n";

									// ** TEMP NOTE ** Remove these duplicate functions and create single named functions for better performance
									// Make a listener for clicking on this track title
									echo "<script>trk" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  parent.newQueue('" . $i . "');";
									echo '});</script>' . "\r\n";

									// Make a listener for clicking on this track number
									echo "<script>tno" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  parent.newQueue('" . $i . "');";
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
									echo '});</script>' . "\r\n";

									// Make a listener for playNext menu item
									echo "<script>playNext" . $i . ".addEventListener('click',  function() {";
									echo "	parent.playNext('" . $i . "');";
									echo '});</script>' . "\r\n";

									// Make a listener for playOnly menu item
									echo "<script>playOnly" . $i . ".addEventListener('click',  function() {";
									echo "	parent.newSingle('" . $i . "');";
									echo '});</script>' . "\r\n";

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

								} //End of row loop

								echo '</tbody></table>' . "\r\n";
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
