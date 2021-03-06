<?php
	include 'includes/callAPI.php';

	$uid = $_GET["uid"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = artistAPI($auth, $uid);
	$artistresults = json_decode($get_data, true);

	$get_data = artistalbumsAPI($auth, $uid);
	$results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>parent.activeMenu(0);</script> <!-- Call js function in parent to highlight the correct active menu item -->

<body style="overflow:hidden">
			  <div class="ui inverted space segment">
					<?php
					echo '<h1 class="ui smoke header">' . $artistresults['name'] . '</h1>';

					$cnt = 0; //Reset our counter to build grid of 24 entries
					echo "<div class='ui six column grid container'>";
					//Loop 4 rows
					for ($i = 1; $i <=4; $i++){
						echo "<div class='ui row'>";
						//Loop 6 columns
						for ($j = 1; $j <=6; $j++){
							//Check if this is our first time round then put a special link to All Songs in the top left
							if ($i == 1 && $j ==1) {
								echo "<div class='ui column'>";
								echo '<a href="artist_tracks.php?uid=' . $artistresults['id'] . '">';
								echo "<img class='ui small image' src='img/allsongs.png' ></a>";
								echo "</div>";
								$cnt--;
							} else {
								echo "<div class='ui column'>";
								echo '<a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
								echo "<img class='ui small image' src='" . $results['album'][$cnt]['art'] . "' ></a>";
								echo '<br><center><a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
								echo $results['album'][$cnt]['name'] . "</a>";
								echo '<br>'. $results['album'][$cnt]['artist']['name'];
								echo '<br>'. $results['album'][$cnt]['year'];
								echo "</center></div>";
							}
							$cnt++; //Increment our counter
						}
						echo "</div>";
					}
					echo "</div>";
					?>
					</div>
</body>
</html>
