<?php
	include 'includes/callAPI.php';

	$uid = $_GET["uid"];

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	$auth=$hshake['auth'];

	$get_data = playlistAPI($auth, $uid);
	$main_results = json_decode($get_data, true);

	$get_data = playlistsongsAPI($auth, $uid);
	$song_results = json_decode($get_data, true);

	// Get playlist info so we can have them listed in our per track menu
	$get_data = playlistsAPI($auth, '', 0);
	$playlists_results = json_decode($get_data, true);

	include 'includes/header_iframe.php';

	$main_results['album'][0]['songcount'] = $main_results['items']
?>
<script>
parent.activeMenu(0); // Call js function in parent to highlight the correct active menu item -->
parent.list = []; // Clean out the old list before we build a new one

</script>
<body>
			  <div class="ui inverted space segment">
					<?php
						echo '<div class="ui one column grid">' . "\r\n"; //Two columns - first column just for spacing.

							// Left column for stats
							echo '<div class="ui four wide column">' . "\r\n";
							  echo '<i class="massive bordered feature stream icon"></i>';
								echo '<br><br>';
								echo '<strong>' . $main_results['name'] . '</strong>';
								echo '<br>(Playlist)';
								echo '<br>' . $main_results['items'] . ' songs';
							echo '</div>' . "\r\n"; // End of 1st column

							// Right column for album songs in table
							echo '<div class="ui twelve wide column">' . "\r\n";
								echo '<div class="ui huge smoke header">' . $main_results['name'] . '</div>' . "\r\n";
								echo '<button class="ui tiny grey button" id="playb"><i class="play icon"></i>PLAY</button>';
								echo '&nbsp;<button class="ui tiny grey button" id="shufb"><i class="random icon"></i>SHUFFLE</button>';
								echo '&nbsp;<div class="ui inline dropdown"><i class="ellipsis vertical icon"></i>' . "\r\n";
								echo '	<div class="menu" id="albumMenu">' . "\r\n";
								echo '	<div class="item" id="addAll2Q">Add to queue</div>' . "\r\n";
								echo '	<div class="item" id="playAllNext">Play next</div>' . "\r\n";
								echo '	<div class="item" id="renpl">Rename playlist</div>' . "\r\n";
								echo '	<div class="item" id="delpl">Delete playlist</div>' . "\r\n";
								echo '</div></div>' . "\r\n";
								// Make a listener for clicking on the play button
								echo "\r\n<script>playb.addEventListener('click', function() {";
								echo "  parent.newQueue('0');";
								echo '});</script>' . "\r\n";

								// Make a listener for clicking on the shuffle button
								echo "<script>shufb.addEventListener('click', function() {";
								echo "  parent.shuffle('0');";
								echo '});</script>' . "\r\n";

								// Make a listener for Add to Queue menu item
								echo "<script>addAll2Q.addEventListener('click', function() {";
								echo "	parent.addAll2Q();";
								echo '});</script>' . "\r\n";

								// Make a listener for Add All to play next menu item
								echo "<script>playAllNext.addEventListener('click', function() {";
								echo "	parent.playAllNext();";
								echo '});</script>' . "\r\n";

								// Make a listener for clicking rename playlist menu item
								echo "<script>renpl.addEventListener('click',  function() {";
								echo "	$('.rename.ui.modal')";
								echo "    .modal({";
								echo "       onApprove : function() {";
								echo "         var nn = document.getElementById('rename').value;";
								echo '         $.get("includes/playlistAPI.php?action=rename&song=" + nn + "&filter=' . $uid . '", function(){';
								echo '           location.reload();';  // Do a reload so we can see the change
								echo '           });';
								echo "       }";
								echo "     })";
								echo "    .modal('show')";
								echo "  ;";
								echo '});</script>' . "\r\n";

								// Make a listener for clicking delete playlist menu item
								echo "<script>delpl.addEventListener('click',  function() {";
								echo "	$('.delete.ui.modal')";
								echo "    .modal({";
								echo "       onApprove : function() {";
								echo '         $.get("includes/playlistAPI.php?action=delete&song=8888&filter=' . $uid . '", function(){';
								echo '           window.location.href="playlists_view.php";';  // back to the playlists_view as this playlist will be deleted
								echo '           });';
								echo "       }";
								echo "     })";
								echo "    .modal('show')";
								echo "  ;";
								echo '});</script>' . "\r\n";

								// Build the table that will list our tracks
								$plylst = true;		//Set flag to include extra playlist functions
								include 'includes/build_tracks.php';

							echo '</div>' . "\r\n"; // End of 2nd column

						echo '</div>' . "\r\n"; //End of content grid.
					?>
			  </div>

				<!-- Set up new playlist modal -->
			  <div class="ui new modal">
					<div class="ui inverted playlist segment">
						<div class="ui huge smoke header">New Playlist</div>
				    <div class="ui input"><input id="newname" type="text" placeholder="Title"></div><br>
						<div class="actions">
							<button class="ui tiny cancel button" id="cancel">CANCEL</button>&nbsp;
							<button class="ui tiny approve button" id="save">SAVE</button>
						</div>
					</div>
			  </div>

				<!-- Set up rename playlist modal -->
			  <div class="ui rename modal">
					<div class="ui inverted playlist segment">
						<div class="ui huge smoke header">Rename Playlist</div>
				    <div class="ui input"><input id="rename" type="text" placeholder="Title"></div><br>
						<div class="actions">
							<button class="ui tiny cancel button" id="cancel">CANCEL</button>&nbsp;
							<button class="ui tiny approve button" id="save">SAVE</button>
						</div>
					</div>
			  </div>

				<!-- Set up delete playlist modal -->
			  <div class="ui delete modal">
					<div class="ui inverted playlist segment">
						<div class="ui huge smoke header">Delete Playlist</div><br>
						<div class="ui huge smoke header">Are You Sure?</div>
						<div class="actions">
							<button class="ui tiny cancel button" id="cancel">NO</button>&nbsp;
							<button class="ui tiny approve button" id="save">YES</button>
						</div>
					</div>
			  </div>

<!-- JS to initialise dropdowns-->
<script>
$('.ui.dropdown')
  .dropdown()
;
</script>
</body>
</html>
