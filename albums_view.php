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
		$poffset = $offset - 25;
	}
	$noffset = $offset + 25;

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = albumsAPI($auth, $filt, $offset);
	$results = json_decode($get_data, true);
	$total = count($results['album']);

	include 'includes/header_iframe.php';
?>
<script>parent.activeMenu(4);</script> <!-- Call js function in parent to highlight the correct active menu item -->

<body style="overflow:hidden">
			  <div class="ui inverted space segment">
					<div class='ui middle aligned grid'>
						<div class="left floated four wide column">
							<h1 class="ui smoke header">Albums&nbsp;&nbsp;&nbsp;<i class="small record vinyl icon"></i></h1>
						</div>

						<!-- Tag column -->
									<div class="three wide column">
										<?php
										if ($filt !== '') {echo '<div class="ui filter large label">' . $filt . '&nbsp;<a href="albums_view.php"><i class="icon close"></i></a></div>';}
										?>
									</div>

						<!-- Filter bar -->
						<div class="two wide column">
							<form class="ui form" method="GET" action="albums_view.php">
								<div class="field">
									<div class="ui small icon input">
							  		<input name="filt" type="text" placeholder="<?php echo $plfilt;?>"><i class="search link icon"></i>
									</div>
								</div>
							</form>
						</div>

						<div class="right floated right aligned four wide column">
								<a class="icn" href="albums_view.php?filt=<?php echo $filt;?>&ofst=<?php echo $poffset;?>"><i class="arrow circle left icon"></i></a>&nbsp;&nbsp;&nbsp;
								<a class="icn" href="albums_view.php?filt=<?php echo $filt;?>&ofst=<?php echo $noffset;?>"><i class="arrow circle right icon"></i></a>
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
