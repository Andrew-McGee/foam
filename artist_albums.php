<?php
	include 'includes/callAPI.php';

	$uid = $_GET["uid"];

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

	$get_data = artistAPI($auth, $uid);
	$artistresults = json_decode($get_data, true);

	$get_data = artistalbumsAPI($auth, $uid);
	$results = json_decode($get_data, true);
	$total = count($results['album']);

	include 'includes/header_iframe.php';
?>
<script>parent.activeMenu(0);</script> <!-- Call js function in parent to highlight the correct active menu item -->

<body>
			  <div class="ui inverted space segment">
					<div class='ui grid'>
						<div class="left floated four wide column">
							<h1 class="ui smoke header"><?php echo $artistresults['name']; ?></h1>
						</div>
						<div class="right floated right aligned four wide column">
							<?php
								if ($offset > 0) echo '<a class="icn" href="playlists_view.php?ofst=' . $poffset . '"><i class="arrow circle left icon"></i></a>&nbsp;&nbsp;&nbsp;';
								if ($total == 24) echo '<a class="icn" href="playlists_view.php?ofst=' . $noffset . '"><i class="arrow circle right icon"></i></a>';
							?>
						</div>
					</div>

					<?php
					$cnt = 0; //Reset our counter to build grid of 24 entries
					echo "<div class='ui six column grid container'>";
					//Loop 4 rows
					for ($i = 1; $i <=4; $i++){
						echo "<div class='ui row'>";

						//Build out the cover art row with 6 columns
						for ($j = 1; $j <=6; $j++){
							echo "<div class='ui column'>";
							if ($cnt < $total) {
								//Check if this is our first time round then put a special link to All Songs in the top left
								if ($i == 1 && $j ==1) {
									echo '<a href="artist_tracks.php?uid=' . $artistresults['id'] . '">';
									echo '<div class="ui fluid container">';
									echo '  <center><i class="huge bordered music icon"></i></center>';
									echo '</div></a>';
									//echo "<img class='ui small image' src='img/allsongs.png' ></a>";
									$cnt--; // Decrement counter because this was a sepcial case and we want to continue from the start
								} else {
									echo '<a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
									echo "<img class='ui small image' src='" . $results['album'][$cnt]['art'] . "' ></a>";
								}
							}
							echo "</div>";
							$cnt++; //Increment our counter
						}
						$cnt = $cnt - 6; // Jump back 6 so we can build the same albums again
						//Build out title and artist row with 6 columns
						for ($j = 1; $j <=6; $j++){
							echo "<div class='ui column'>";
							if ($cnt < $total) {
								//Check if this is our first time round then put a special link to All Songs in the top left
								if ($i == 1 && $j == 1) {
									echo '<br><center><a href="artist_tracks.php?uid=' . $artistresults['id'] . '"><strong>All Songs</strong></a>';
									echo '<br>' . $artistresults['albumcount'] . ' albums';
									echo '<br>' . $artistresults['songcount'] . ' songs';
									if (isset($artistresults['genre'][0]['name'])) {
										echo '<br>' . $artistresults['genre'][0]['name'] . '</center>';
									}
								} else {
									echo '<br><center><a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
									echo $results['album'][$cnt]['name'] . "</a>";
									echo '<br>'. $results['album'][$cnt]['artist']['name'];
									echo '<br>'. $results['album'][$cnt]['year'] . '</center>';
								}
							}
							echo "</div>";
							$cnt++; //Increment our counter
						}
						echo "</div>"; // end of row
					}
					echo "</div>"; // end of grid container
					?>
					</div>
</body>
</html>
