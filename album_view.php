<?php
	include 'includes/callAPI.php';

	$uid = $_GET["uid"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake[auth];

	$get_data = albumAPI($auth, 'random');
	$albm_results = json_decode($get_data, true);

	$get_data = albumsongsAPI($auth, 'random');
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
			    <h1 class="ui smoke header">Album Title</h1>
					<?php
						echo '<div class="ui two column grid">'; //Two columns for album view - art on left, tracks on right.
							echo '<div class="ui three wide sidemenu column">';

							echo "<img class='ui large image' src='" . $albm_results[art] . "' >";
							echo '<br>Songs: ' . $albm_results[songcount];

							echo '</div>'
						echo '</div>' //End of content grid.
					?>
			  </div>
		  </div> <!-- End of the content container -->
	  </div><!-- END of main column 2 -->
	</div>

	<?php
		include 'includes/footer.php';
	?>
