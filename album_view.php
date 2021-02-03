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
		<div class="ui three wide sidemenu column"><!-- Start of page column 1 - left sidebar -->
			<div class="ui container"> <!-- Container to constrain width of Vertical Menu -->

			<!-- Include the side menu code -->
			<?php
				include 'includes/menu.php';
				active_menu('none', $hshake);
			?>

			</div> <!-- Close container -->
		</div> <!-- End of Column 1 -->

    <div class="ui thirteen wide column"><!-- START of main column 2 -->
		  <div class="ui inverted manatee segment"> <!-- START of content container -->
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui two column grid">'; //Two columns for album view - art on left, tracks on right.

							// Left column for album art and stats
							echo '<div class="ui three wide column">';
								echo "<img class='ui huge image' src='" . $albm_results[art] . "' >";
								echo '<br>Artist: ' . $albm_results[artist];
								echo '<br>Songs: ' . $albm_results[songcount];
								echo '<br>Time: ' . $albm_results[time];
								echo '<br>Year: ' . $albm_results[year];
							echo '</div>'; // End of 1st column

							// Right column for album songs in table
							echo '<div class="ui thirteen wide column">';
								echo '<h1 class="ui large smoke header">' . $albm_results[name] . '</h1>';
								//Let's make the table for the song list
								echo '<table class="ui very basic table">';
								echo '<thead><tr>';
								echo '<th>Title</th><th>Artist</th><th>Time</th><th>DL</th>';
								echo '</tr></thead>';
								echo '<tbody>';
								//Loop through the songs to display each on a table row
								$cnt = $albm_results[songcount]; //Set counter to number of songs on album
								for ($i = 0; $i < $cnt; $i++){
									echo '<tr>';
									echo '<td>' . $song_results[song][$cnt][title] . '</td>';
									echo '<td>' . $song_results[song][$cnt][artist][name] . '</td>';
									echo '<td>' . $song_results[song][$cnt][time] . '</td>';
									echo '<td><i class="download icon"></i></td>';
									echo '</tr>';
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