<?php
	include 'includes/callAPI.php';

	$uid = $_GET["uid"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake[auth];

	$get_data = albumAPI($auth, $uid);
	$albm_results = json_decode($get_data, true);

	$get_data = albumsongsAPI($auth, $uid);
	$song_results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>parent.activeMenu(0);</script> <!-- Call js function in parent to highlight the correct active menu item -->

<body style="overflow:hidden">
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui two column grid">'; //Two columns for album view - art on left, tracks on right.

							// Left column for album art and stats
							echo '<div class="ui four wide column">';
								echo "<img class='ui massive image' src='" . $albm_results[art] . "' >";
								echo '<br><a href="artist_albums.php?uid=' . $albm_results[artist][id] . '">';
								echo $albm_results[artist][name] . '</a>';
								echo '<br>' . $albm_results[year];
								echo '<br>' . $albm_results[songcount] . ' songs';
								$result = sec2mins($albm_results[time]);
								if ($result[hours] > 0) {
									if ($result[hours] > 1) {
										echo '<br>' . $result[hours] . ' hours, ' . $result[minutes] . ' minutes';
									} else {
										echo '<br>' . $result[hours] . ' hour, ' . $result[minutes] . ' minutes';
									}
								} else {
									echo '<br>' . $result[minutes] . ' minutes';
								}
							echo '</div>'; // End of 1st column

							// Right column for album songs in table
							echo '<div class="ui twelve wide column">';
								echo '<div class="ui huge smoke header">' . $albm_results[name] . '</div>';
								echo '<button class="ui tiny button" id="playb"><i class="play icon"></i>PLAY</button>';
								echo '&nbsp;<button class="ui tiny button" id="shufb"><i class="random icon"></i>SHUFFLE</button>';
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
								echo '<th>#</th><th>Title</th><th>Artist</th><th>Time</th><th>DL</th>';
								echo '</tr></thead>';
								echo '<tbody>';
								$cnt = $albm_results[songcount]; //Set counter to total number of songs on album

								//Loop through the songs to display each on a table row
								for ($i = 0; $i < $cnt; $i++){
									echo '<tr>';
									echo '<td id="tno' . ($i + 1) . '">' . $song_results[song][$i][track] . '</td>';
									echo '<td id="trk' . ($i + 1) . '"><strong>' . $song_results[song][$i][title] . '</strong></td>';
									echo '<td><a href="artist_albums.php?uid=' . $song_results[song][$i][artist][id] . '">';
									echo $song_results[song][$i][artist][name] . '</a></td>';
									$result = sec2mins($song_results[song][$i][time]);
									echo '<td>' . $result[minutes] . ':' . sprintf("%02d", $result[seconds]) . '</td>';
									echo '<td><a href="' . $song_results[song][$i][url] . '"><i class="download icon"></i></a></td>';
									echo '</tr>';

									// Let's add this entry to our js 'list' array in case it becomes a new playlist or queue
									echo '<script>';
									echo 'parent.list[' . $i . '] = [];';
									echo 'parent.list[' . $i . '][0] = "' . $song_results[song][$i][title] . '";';
									echo 'parent.list[' . $i . '][1] = "' . $song_results[song][$i][artist][name] . '";';
									echo 'parent.list[' . $i . '][2] = "' . $result[minutes] . ':' . sprintf("%02d", $result[seconds]) . '";';
									echo 'parent.list[' . $i . '][3] = "' . $albm_results[art] . '";';
									echo 'parent.list[' . $i . '][4] = "' . $song_results[song][$i][url] . '";';
									echo '</script>';

									// Make a listener for clicking on this track title
									echo "<script>trk" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  parent.newQueue('" . $i . "');";
									echo '});</script>';

									// Make a listener for clicking on this track number
									echo "<script>tno" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  parent.newQueue('" . $i . "');";
									echo '});</script>';
								} //End of row loop

								echo '</tbody></table>';
							echo '</div>'; // End of 2nd column

						echo '</div>'; //End of content grid.
					?>
			  </div>
</body>
</html>
