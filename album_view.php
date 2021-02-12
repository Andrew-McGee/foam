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

	//Include all the inital HTML including doctype, html, head and body tags
	//Also includes the heading and top menu
	include 'includes/header.php';
?>

<!-- Main Body -->
	<!-- 2 column grid -->
	<div class="ui two column grid">
		<div class="ui two wide sidemenu column"><!-- Start of page column 1 - left sidebar -->
			<div class="ui container"> <!-- Container to constrain width of Vertical Menu -->

			<!-- Include the side menu code -->
			<?php
				include 'includes/menu.php';
				active_menu('none', $hshake);
			?>

			</div> <!-- Close container -->
		</div> <!-- End of Column 1 -->

    <div class="ui fourteen wide column"><!-- START of main column 2 -->
		  <div class="ui inverted manatee segment"> <!-- START of content container -->
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
								echo '<button class="ui tiny grey button"><i class="play icon"></i>PLAY</button>';
								echo '&nbsp;<button class="ui tiny grey button"><i class="random icon"></i>SHUFFLE</button>';
								echo '&nbsp;<i class="ellipsis vertical icon"></i>';
								//Let's make the table for the song list
								echo '<table class="ui selectable inverted black table">';
								echo '<thead><tr>';
								echo '<th>#</th><th>Title</th><th>Artist</th><th>Time</th><th>DL</th>';
								echo '</tr></thead>';
								echo '<tbody>';
								//Loop through the songs to display each on a table row
								$cnt = $albm_results[songcount]; //Set counter to number of songs on album
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
									//For each table row make a listener for clicking on this track title or track number
									echo "<script>trk" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  playnew('" . $song_results[song][$i][url] . "');";
									echo 'document.getElementById("playrThumb").src="' . $albm_results[art] . '";';
									echo 'document.getElementById("playrTitle").textContent="' . $song_results[song][$i][title] . '";';
									echo 'document.getElementById("playrArtist").textContent="' . $song_results[song][$i][artist][name] . '";';
									echo '});</script>';

									echo "<script>tno" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  playnew('" . $song_results[song][$i][url] . "');";
									echo 'document.getElementById("playrThumb").src="' . $albm_results[art] . '";';
									echo 'document.getElementById("playrTitle").textContent="' . $song_results[song][$i][title] . '";';
									echo 'document.getElementById("playrArtist").textContent="' . $song_results[song][$i][artist][name] . '";';
									echo '});</script>';
								}
								echo '</tbody></table>';
							echo '</div>'; // End of 2nd column

						echo '</div>'; //End of content grid.
					?>
			  </div>
		  </div> <!-- End of the content container -->
	  </div><!-- END of main column 2 -->
	</div>

	<?php
		include 'includes/footer.php';
	?>
