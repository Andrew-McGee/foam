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
		$poffset = $offset - 20;
	}
	$noffset = $offset + 20;

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = songsAPI($auth, $offset);
	$song_results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>
parent.activeMenu(5); // Call js function in parent to highlight the correct active menu item -->
parent.list = []; // Clean out the old list before we build a new one

// Function to hide star and elipse on track listing row
function hideicon(num) {
		if (document.getElementById("hiddenstar"+num).className !== "blue star icon") {
    	document.getElementById("hiddenstar"+num).setAttribute("style", "opacity:0 !important");
		}
    document.getElementById("hiddenelipse"+num).setAttribute("style", "opacity:0 !important");
}
// Function to reveal star and elipse on track listing row
function revealicon(num) {
    document.getElementById("hiddenstar"+num).setAttribute("style", "opacity:1 !important");
    document.getElementById("hiddenelipse"+num).setAttribute("style", "opacity:1 !important");
}
</script>
<body style="overflow:hidden">
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui one column grid">'; //Two columns - first column just for spacing.

							// Left column for album art and stats
							echo '<div class="ui four wide column">';
								echo '<br>';
								echo '<strong>Tracks</strong></a>';
								echo '<br>A - Z';
								echo '<br> songs';
							echo '</div>'; // End of 1st column

							// Right column for list of songs in table
							echo '<div class="ui twelve wide column">';

								echo '<div class="ui grid">';
									echo '<div class="left floated four wide column">';
										echo '<h1 class="ui smoke header">Tracks&nbsp;&nbsp;&nbsp;<i class="small music icon"></i></h1>';
									echo '</div>';
									echo '<div class="right floated right aligned four wide column">';
											echo '<a href="tracks_view.php?ofst=' . $poffset . '"><i class="arrow circle left icon"></i></a>&nbsp;&nbsp;&nbsp;';
											echo '<a href="tracks_view.php?ofst=' . $noffset . '"><i class="arrow circle right icon"></i></a>';
									echo '</div>';
								echo '</div>';

								//Let's make the table for the song list
								echo '<table class="ui selectable inverted black table">';
								echo '<thead><tr>';
								echo '<th>Title</th><th>Artist</th><th></th><th>Time</th><th>DL</th>';
								echo '</tr></thead>';
								echo '<tbody>';
								$cnt = 20; //Set counter to number of songs returned

								//Loop through the songs to display each on a table row
								for ($i = 0; $i < $cnt; $i++){
									echo '<tr id="row' . $i . '">'; // Start of the song listing row
										echo '<td id="trk' . ($i + 1) . '"><strong>' . $song_results['song'][$i]['title'] . '</strong></td>';
										echo '<td><a href="artist_albums.php?uid=' . $song_results['song'][$i]['artist']['id'] . '">';
										echo $song_results['song'][$i]['artist']['name'] . '</a></td>';

										// hidden star and elipse reveal on mouseover row (see listeners below)
										// some code here to test if song is flagged or not (favourite = blue star)
										$fav = $song_results['song'][$i]['flag'];
										if ($fav == true) {
											$favi = "blue star icon";
										} else {
											$favi = "hidden star outline icon";
										}

										echo '<td><i class="' . $favi . '" id="hiddenstar' . $i . '"></i>&nbsp';
										echo '<div class="ui inline dropdown"><i class="hidden ellipsis vertical icon" id="hiddenelipse' . $i . '"></i>';
										echo '	<div class="menu" id="albumMenu">';
										echo '		<div class="item" id="addT2Q' . $i . '">Add to queue</div>';
										echo '		<div class="item" id="playNext' . $i . '">Play next</div>';
										echo '		<div class="item"><a href="album_view.php?uid=' . $song_results['song'][$i]['album']['id'] . '">Go to album</a></div>';
										echo '		<div class="item">Go to artist</div>';
										echo '	</div>';
										echo '</div></td>';

										// Calculate song length from seconds
										$result = sec2mins($song_results['song'][$i]['time']);
										echo '<td>' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '</td>';

										echo '<td><a href="' . $song_results['song'][$i]['url'] . '"><i class="download icon"></i></a></td>';
									echo '</tr>'; // End of the row but theres some other stuff still to do in this loop

									// Let's add this entry to our js 'list' array in case it becomes a new playlist or queue
									echo '<script>';
									echo 'parent.list[' . $i . '] = [];';
									echo 'parent.list[' . $i . '][0] = "' . $song_results['song'][$i]['title'] . '";';
									echo 'parent.list[' . $i . '][1] = "' . $song_results['song'][$i]['artist']['name'] . '";';
									echo 'parent.list[' . $i . '][2] = "' . $result['minutes'] . ':' . sprintf("%02d", $result['seconds']) . '";';
									echo 'parent.list[' . $i . '][3] = "' . $song_results['song'][$i]['art'] . '";';
									echo 'parent.list[' . $i . '][4] = "' . $song_results['song'][$i]['url'] . '";';
									echo '</script>';

									// Make a listener for clicking on this track title
									echo "<script>trk" . ($i + 1) . ".addEventListener('click', function() {";
									echo "  parent.newSingle('" . $i . "');";
									echo '});</script>';

									// Make a listener for hovering over a row to make star and elipse visible
									echo "<script>row" . $i . ".addEventListener('mouseover', function() {";
									echo "	revealicon('" . $i . "');";
									echo "});</script>";

									// Make a listener for moving off a row to make star and elipse invisible
									echo "<script>row" . $i . ".addEventListener('mouseout',  function() {";
									echo "	hideicon('" . $i . "');";
									echo "});</script>";

									// Make a listener for add track to queue (addT2Q) menu item
									echo "<script>addT2Q" . $i . ".addEventListener('click',  function() {";
									echo "	parent.addT2Q('" . $i . "');";
									echo "});</script>";

									// Make a listener for playNext menu item
									echo "<script>playNext" . $i . ".addEventListener('click',  function() {";
									echo "	parent.playNext('" . $i . "');";
									echo "});</script>";

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
