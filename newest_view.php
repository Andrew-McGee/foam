<?php
	include 'includes/callAPI.php';

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake[auth];

	$get_data = statsAPI($auth, 'newest');
	$results = json_decode($get_data, true);

	//Include all the inital HTML including doctype, html, head and body tags
	//Also includes the heading and top menu
	include 'includes/header.php';
?>

<!-- Main Body -->
	<!-- 2 column grid -->
	<div class="ui two column grid">
		<div class="ui three wide sidemenu column"><!-- Start of page column 1 - left sidebar -->
			<div class="ui container"> <!-- Container to constrain width of Vertical Menu -->

				<!-- Side Vertical Menus - have a seperate menu for each section-->
				<div class="ui left compact vertical inverted side menu">

					<a class="item" href="index.php"><i class="clock icon"></i>Recent</a>
					<a class="active item" href="newest_view.php"><i class="meteor icon"></i>Newest</a>
					<a class="item" href="artists_view.php"><i class="user icon"></i>Artists</a>
					<a class="item" href="albums_view.php"><i class="record vinyl icon"></i>Albums</a>
					<a class="item" href="tracks_view.php"><i class="music icon"></i>Tracks</a>
					<a class="item" href="playlists_view.php"><i class="stream icon"></i>Playlists</a>
					<a class="item" href="frequent_view.php"><i class="chart line icon"></i>Frequent</a>
					<a class="item" href="favourites_view.php"><i class="star icon"></i>Favourites</a>
					<a class="item" href="random_view.php"><i class="dice icon"></i>Random</a>

					<div class="item">
						<h1 class="ui small dim header">Stats</h1>
						<?php
							echo 'Albums: '. $hshake[albums];
							echo '<br>Artists: '. $hshake[artists];
							echo '<br>Tracks: '. $hshake[songs];
							echo '<br>Genres: '. $hshake[genres];
							echo '<br>Playlists: '. $hshake[playlists];
						?>
					</div>
				</div>

			</div> <!-- Close container -->
		</div> <!-- End of Column 1 -->

    <div class="ui thirteen wide column"><!-- START of main column 2 -->
		  <div class="ui inverted manatee segment">
			  <div class="ui inverted space segment">
			    <h1 class="ui smoke header">Newest Albums</h1>

					<?php
					$cnt = 0; //Reset our counter to build grid of 24 entries
					echo "<div class='ui six column grid container'>";
					//Loop 4 rows
					for ($i = 1; $i <=4; $i++){
						echo "<div class='ui row'>";
						//Loop 6 columns
						for ($j = 1; $j <=6; $j++){
							echo "<div class='ui column'>";
							echo "<img class='ui small image' src='" . $results[album][$cnt][art] . "' >";
							echo '<center><br>'. $results[album][$cnt][name];
							echo '<br>'. $results[album][$cnt][artist][name];
							echo '<br>'. $results[album][$cnt][year];
							echo "</center></div>";
							$cnt++; //Increment our counter
						}
						echo "</div>";
					}
					?>
			  </div>
		  </div>
	  </div><!-- END of main column 2 -->
	</div>
<!-- Start the footer -->
  <div class="ui inverted spacecadet vertical footer segment">
    <div class="ui center aligned container">
			<h1 class="ui inverted yellow header">foam</h1>
    </div>
  </div>

</body>
<!-- JS to initialise dropdowns-->
<script>
$('.ui.dropdown')
  .dropdown()
;
</script>
</html>
