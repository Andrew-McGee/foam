<?php
	include 'includes/callAPI.php';

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake[auth];

	$get_data = statsAPI($auth, 'recent');
	$results = json_decode($get_data, true);

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
				active_menu('recent', $hshake);
			?>

			</div> <!-- Close container -->
		</div> <!-- End of Column 1 -->

    <div class="ui fourteen wide column"><!-- START of main column 2 -->
		  <div class="ui inverted manatee segment">
			  <div class="ui inverted space segment">
			    <h1 class="ui smoke header">Recent Albums</h1>

					<?php
					$cnt = 0; //Reset our counter to build grid of 24 entries
					echo "<div class='ui six column grid container'>";
					//Loop 4 rows
					for ($i = 1; $i <=4; $i++){
						echo "<div class='ui row'>";
						//Loop 6 columns
						for ($j = 1; $j <=6; $j++){
							echo "<div class='ui column'>";
							echo '<a href="album_view.php?uid=' . $results[album][$cnt][id] . '">';
							echo "<img class='ui small image' src='" . $results[album][$cnt][art] . "' ></a>";
							echo '<center><br>'. $results[album][$cnt][name];
							echo '<br><a href="artist_albums.php?uid=' . $results[album][$cnt][artist][id] . '">';
							echo $results[album][$cnt][artist][name] . "</a>";
							echo '<br>'. $results[album][$cnt][year];
							echo "</center></div>";
							$cnt++; //Increment our counter
						}
						echo "</div>";
					}
					?>
				  </div>
			  </div>
		  </div>
		</div><!-- END of main column 2 -->
	</div>

	<?php
		include 'includes/footer.php';
	?>
