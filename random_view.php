<?php
	include 'includes/callAPI.php';

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = statsAPI($auth, 'random', 0);
	$results = json_decode($get_data, true);

	include 'includes/header_iframe.php';
?>
<script>parent.activeMenu(9);</script> <!-- Call js function in parent to highlight the correct active menu item -->

<body style="overflow:hidden">
			  <div class="ui inverted space segment">
			    <h1 class="ui smoke header">Random Albums</h1>

					<?php
					$cnt = 0; //Reset our counter to build grid of 24 entries
					echo "<div class='ui six column grid container'>";
					//Loop 4 rows
					for ($i = 1; $i <=4; $i++){
						echo "<div class='ui row'>";
						//Loop 6 columns
						for ($j = 1; $j <=6; $j++){
							echo "<div class='ui column'>";
							echo '<a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
							echo "<img class='ui small image' src='" . $results['album'][$cnt]['art'] . "' ></a>";
							echo '<br><center><a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
							echo $results['album'][$cnt]['name'] . "</a>";
							echo '<br><a href="artist_albums.php?uid=' . $results['album'][$cnt]['artist']['id'] . '">';
							echo $results['album'][$cnt]['artist']['name'] . "</a>";
							echo '<br>'. $results['album'][$cnt]['year'];
							echo "</center></div>";
							$cnt++; //Increment our counter
						}
						echo "</div>";
					}
					?>
					</div>
</body>
</html>
