<?php
	include 'includes/callAPI.php';

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = statsAPI($auth, 'random', 0);
	$results = json_decode($get_data, true);
	$total = count($results['album']);

	include 'includes/header_iframe.php';
?>
<script>parent.activeMenu(9);</script> <!-- Call js function in parent to highlight the correct active menu item -->

<body>
			  <div class="ui inverted space segment">
					<div class='ui middle aligned grid'>
						<div class="left floated four wide column">
							<h1 class="ui smoke header">Random Albums&nbsp;&nbsp;&nbsp;<i class="small dice icon"></i></h1>
						</div>
						<div class="right floated right aligned four wide column">
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
								echo '<a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
								echo "<img class='ui small image' src='" . $results['album'][$cnt]['art'] . "' ></a>";
							}
							echo "</div>";
							$cnt++; //Increment our counter
						}
						$cnt = $cnt - 6; // Jump back 6 so we can build the same albums again
						//Build out title and artist row with 6 columns
						for ($j = 1; $j <=6; $j++){
							echo "<div class='ui column'>";
							if ($cnt < $total) {
								echo '<br><center><a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
								echo $results['album'][$cnt]['name'] . "</a>";
								echo '<br><a href="artist_albums.php?uid=' . $results['album'][$cnt]['artist']['id'] . '">';
								echo $results['album'][$cnt]['artist']['name'] . "</a>";
								echo '<br>'. $results['album'][$cnt]['year'] . '</center>';
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
