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

	$get_data = artistsAPI($auth, $filt, $offset);
	$artist_results = json_decode($get_data, true);
	$cnt = count($artist_results['artist']); //Set counter to number of artists returned

	include 'includes/header_iframe.php';
?>
<script>
parent.activeMenu(3); // Call js function in parent to highlight the correct active menu item -->
</script>
<body>
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui one column grid">'; //Two columns - first column just for spacing.

							// Left column for album art and stats
							echo '<div class="ui four wide column">' . "\r\n";
								echo '<i class="massive bordered feature user icon"></i>';
								echo '<br><br>';
								echo '<strong>Artists</strong></a>';
								echo '<br>A - Z';
								echo '<br> songs';
							echo '</div>'; // End of 1st column

							// Right column for list of artists in table
							echo '<div class="ui twelve wide column">';

								echo '<div class="ui middle aligned grid">';
									echo '<div class="left floated four wide column">';
										echo '<h1 class="ui smoke header">Artists&nbsp;&nbsp;&nbsp;<i class="small user icon"></i></h1>';
									echo '</div>';

									// Tag column
									echo '<div class="three wide column">';
										if ($filt !== '') {echo '<div class="ui filter large label">' . $filt . '&nbsp;<a class="icn" href="artists_view.php"><i class="icon close"></i></a></div>';}
									echo '</div>';

									// Filter bar column
									echo '<div class="three wide column">';
										echo '<form class="ui form" method="GET" action="artists_view.php">';
											echo '<div class="field">';
												echo '<div class="ui small icon input">';
										  		echo '<input name="filt" type="text" placeholder="' . $plfilt . '" value="' . $filt . '"><i class="filter icon"></i>';
												echo '</div>';
											echo '</div>';
										echo '</form>';
									echo '</div>';

									// Pagination
									echo '<div class="right floated right aligned four wide column">';
											if ($offset > 0) echo '<a class="icn" href="artists_view.php?filt=' . $filt . '&ofst=' . $poffset . '"><i class="arrow circle left icon"></i></a>&nbsp;&nbsp;&nbsp;';
											if ($cnt == 20) echo '<a class="icn" href="artists_view.php?filt=' . $filt . '&ofst=' . $noffset . '"><i class="arrow circle right icon"></i></a>';
									echo '</div>';
								echo '</div>';

								//Let's make the table for the song list
								echo '<table class="ui selectable inverted black table">';
								echo '<thead><tr>';
								echo '<th>Artist</th><th>Songs</th><th>Albums</th><th>Time</th><th>Genres</th>';
								echo '</tr></thead>';
								echo '<tbody>';

								//Loop through the artists to display each on a table row
								for ($i = 0; $i < $cnt; $i++){
									echo '<tr class="albm-row" id="row' . $i . '">'; // Start of the artist listing row
										echo '<td><a href="artist_albums.php?uid=' . $artist_results['artist'][$i]['id'] . '">';
										echo $artist_results['artist'][$i]['name'] . '</a></td>';

										echo '<td>' . $artist_results['artist'][$i]['songcount'] . '</td>';
										echo '<td>' . $artist_results['artist'][$i]['albumcount'] . '</td>';

										// Calculate artist play time from seconds
										$result = sec2mins($artist_results['artist'][$i]['time']);

										// If we have only minutes and seconds format differently than if we have hours
										if ($result['hours'] == 0) {
												echo '<td>' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '</td>';
										} else {
											echo '<td>' . $result['hours'] . ':' . sprintf("%02d", $result['minutes']) . ':' . sprintf("%02d", $result['seconds']) . '</td>';
										}
										// Display the genres for this artist - if there are any set
										if (isset($artist_results['artist'][$i]['genre'][0]['name'])) {
											echo '<td>' . $artist_results['artist'][$i]['genre'][0]['name'] . '</td>';
										} else {
											echo '<td></td>';
										}
									echo '</tr>'; // End of the row

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
