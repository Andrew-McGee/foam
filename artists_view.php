<?php
	include 'includes/callAPI.php';

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

	$get_data = artistsAPI($auth, $offset);
	$artist_results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>
parent.activeMenu(3); // Call js function in parent to highlight the correct active menu item -->
</script>
<body style="overflow:hidden">
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui one column grid">'; //Two columns - first column just for spacing.

							// Left column for album art and stats
							echo '<div class="ui four wide column">';
								echo '<br>';
								echo '<strong>Artists</strong></a>';
								echo '<br>A - Z';
								echo '<br> songs';
							echo '</div>'; // End of 1st column

							// Right column for list of artists in table
							echo '<div class="ui twelve wide column">';

								echo '<div class="ui grid">';
									echo '<div class="left floated four wide column">';
										echo '<h1 class="ui smoke header">Artists&nbsp;&nbsp;&nbsp;<i class="small user icon"></i></h1>';
									echo '</div>';
									echo '<div class="right floated right aligned four wide column">';
											echo '<a href="artists_view.php?ofst=' . $poffset . '"><i class="arrow circle left icon"></i></a>&nbsp;&nbsp;&nbsp;';
											echo '<a href="artists_view.php?ofst=' . $noffset . '"><i class="arrow circle right icon"></i></a>';
									echo '</div>';
								echo '</div>';

								//Let's make the table for the song list
								echo '<table class="ui selectable inverted black table">';
								echo '<thead><tr>';
								echo '<th>Artist</th><th>Songs</th><th>Albums</th><th>Time</th><th>Genres</th>';
								echo '</tr></thead>';
								echo '<tbody>';
								$cnt = 20; //Set counter to number of artists returned

								//Loop through the artists to display each on a table row
								for ($i = 0; $i < $cnt; $i++){
									echo '<tr id="row' . $i . '">'; // Start of the artist listing row
										echo '<td><a href="artist_albums.php?uid=' . $artist_results['artist'][$i]['id'] . '">';
										echo $artist_results['artist'][$i]['name'] . '</a></td>';

										echo '<td>' . $artist_results['artist'][$i]['songcount'] . '</td>';
										echo '<td>' . $artist_results['artist'][$i]['albumcount'] . '</td>';

										// Calculate artist play time from seconds
										$result = sec2mins($artist_results['artist'][$i]['time']);

										if ($result['hours'] == 0) {
												echo '<td>' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '</td>';
										} else {
											echo '<td>' . $result['hours'] . ':' . sprintf("%02d", $result['minutes']) . ':' . sprintf("%02d", $result['seconds']) . '</td>';
										}
										echo '<td>' . $artist_results['artist'][$i]['genre'][0] . '</td>';
									echo '</tr>'; // End of the row but theres some other stuff still to do in this loop

									// Let's add this entry to our js 'list' array in case it becomes a new playlist or queue
									echo '<script>';
									echo 'parent.list[' . $i . '] = [];';
									echo 'parent.list[' . $i . '][0] = "' . $song_results['song'][$i]['title'] . '";';
									echo 'parent.list[' . $i . '][1] = "' . $artist_results['name'] . '";';
									echo 'parent.list[' . $i . '][2] = "' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '";';
									echo 'parent.list[' . $i . '][3] = "' . $song_results['song'][$i]['art'] . '";';
									echo 'parent.list[' . $i . '][4] = "' . $song_results['song'][$i]['url'] . '";';
									echo '</script>';

								}//End of row loop

								echo '</tbody></table>';
							echo '</div>'; // End of 2nd column

						echo '</div>'; //End of content grid.
					?>
			  </div>
<!-- JS to initialise dropdowns-->
<script>
$('.ui.dropdown')
  .dropdown()
;
</script>
</body>
</html>
