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

	$get_data = statsAPI($auth, 'frequent', $offset);
	$results = json_decode($get_data, true);
	$total = count($results['album']);

	include 'includes/header_iframe.php';
?>
<script>parent.activeMenu(7);</script> <!-- Call js function in parent to highlight the correct active menu item -->

<body style="overflow:hidden">
			  <div class="ui inverted space segment">
					<div class='ui middle aligned grid'>
						<div class="left floated five wide column">
							<h1 class="ui smoke header">Frequent Albums&nbsp;&nbsp;&nbsp;<i class="small chart line icon"></i></h1>
						</div>
						<div class="right floated right aligned five wide column">
							<?php
								if ($offset > 0) echo '<a class="icn" href="frequent_view.php?ofst=' . $poffset . '"><i class="arrow circle left icon"></i></a>&nbsp;&nbsp;&nbsp;';
								if ($total == 24) echo '<a class="icn" href="frequent_view.php?ofst=' . $noffset . '"><i class="arrow circle right icon"></i></a>';
							?>
						</div>
					</div>

					<?php
					$cnt = 0; //Reset our counter to build grid of 24 entries
					echo "<div class='ui six column grid container'>";
					//Loop 4 rows
					for ($i = 1; $i <=4; $i++){
						echo "<div class='ui row'>";
						//Loop 6 columns
						for ($j = 1; $j <=6; $j++){
							echo "<div class='ui column'>";

							if ($cnt < $total) {
								echo '<a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
								echo "<img class='ui small image' src='" . $results['album'][$cnt]['art'] . "' ></a>";
								echo '<br><center><a href="album_view.php?uid=' . $results['album'][$cnt]['id'] . '">';
								echo $results['album'][$cnt]['name'] . "</a>";
								echo '<br><a href="artist_albums.php?uid=' . $results['album'][$cnt]['artist']['id'] . '">';
								echo $results['album'][$cnt]['artist']['name'] . "</a>";
								echo '<br>'. $results['album'][$cnt]['year'] . '</center>';
							}
							echo "</div>";
							$cnt++; //Increment our counter
						}
						echo "</div>";
					}
					echo "</div>";
					?>
			  </div>
</body>
</html>
