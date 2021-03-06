<?php
	include 'includes/callAPI.php';

	$uid = $_GET["uid"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = artistAPI($auth, $uid);
	$artist_results = json_decode($get_data, true);

	$get_data = artistsongsAPI($auth, $uid);
	$song_results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>parent.activeMenu(0);</script> <!-- Call js function in parent to highlight the correct active menu item -->

<body style="overflow:hidden">
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui one column grid">'; //Two columns - first column just for spacing.

							// Left column for album art and stats
							echo '<div class="ui four wide column">';
								echo '<br><a href="artist_albums.php?uid=' . $artist_results['id'] . '">';
								echo '<strong>' . $artist_results['name'] . '</strong></a>';
								echo '<br>' . $artist_results['albumcount'] . ' albums';
								echo '<br>' . $artist_results['songcount'] . ' songs';
							echo '</div>'; // End of 1st column

							// Right column for album songs in table
							echo '<div class="ui twelve wide column">';
								echo '<div class="ui huge smoke header">' . $artist_results['name'] . '</div>';
								echo '<button class="ui tiny grey button" id="playb"><i class="play icon"></i>PLAY</button>';
								echo '&nbsp;<button class="ui tiny grey button" id="shufb"><i class="random icon"></i>SHUFFLE</button>';
								echo '&nbsp;<i class="ellipsis vertical icon"></i>';
								// Make a listener for clicking on the play button
								echo "<script>playb.addEventListener('click', function() {";
								echo "  parent.newQueue('0');";
								echo '});</script>';

								// Make a listener for clicking on the shuffle button
								echo "<script>shufb.addEventListener('click', function() {";
								echo "  parent.shuffle('0');";
								echo '});</script>';

								//Let's make the table for the song list
								echo '<table class="ui selectable inverted black table">';
								echo '<thead><tr>';
								echo '<th>Title</th><th>Album</th><th>Time</th><th>DL</th>';
								echo '</tr></thead>';
								echo '<tbody>';
								$cnt = $artist_results['songcount']; //Set counter to number of songs on album

								//Loop through the songs to display each on a table row
								for ($i = 0; $i < $cnt; $i++){
									echo '<tr>';
									echo '<td id="trk' . ($i + 1) . '"><strong>' . $song_results['song'][$i]['title'] . '</strong></td>';
									echo '<td><a href="album_view.php?uid=' . $song_results['song'][$i]['album']['id'] . '">';
									echo $song_results['song'][$i]['album']['name'] . '</a></td>';
									$result = sec2mins($song_results['song'][$i]['time']);
									echo '<td>' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '</td>';
									echo '<td><a href="' . $song_results['song'][$i]['url'] . '"><i class="download icon"></i></a></td>';
									echo '</tr>';

									// Let's add this entry to our js 'list' array in case it becomes a new playlist or queue
									echo '<script>';
									echo 'parent.list[' . $i . '] = [];';
									echo 'parent.list[' . $i . '][0] = "' . $song_results['song'][$i]['title'] . '";';
									echo 'parent.list[' . $i . '][1] = "' . $artist_results['name'] . '";';
									echo 'parent.list[' . $i . '][2] = "' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '";';
									echo 'parent.list[' . $i . '][3] = "' . $song_results['song'][$i]['art'] . '";';
									echo 'parent.list[' . $i . '][4] = "' . $song_results['song'][$i]['url'] . '";';
									echo '</script>';

									// Make a listener for clicking on this track title
									echo "<script>trk" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  parent.newQueue('" . $i . "');";
									echo '});</script>';
								}//End of row loop

								echo '</tbody></table>';
							echo '</div>'; // End of 2nd column

						echo '</div>'; //End of content grid.
					?>
			  </div>
</body>
</html>
