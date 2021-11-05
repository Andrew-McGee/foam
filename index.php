<?php
	include 'includes/callAPI.php';

	$get_data = handshakeAPI();
	$hshake = json_decode($get_data, true);

	//Include all the inital HTML including doctype, html, head and body tags
	//Also includes the heading and top microplayer menu
	//Include function to build side menu - we call it later
	include 'includes/header.php';
	include 'includes/menu.php';

?>
<script>
  function resizeIframe(obj) {
		obj.style.height = 0;
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
  }
</script>

<!-- Main Body -->
	<!-- 2 column grid -->
	<div class="ui two column grid">

		<div class="ui two wide sidemenu column"><!-- Start of page column 1 - left sidebar -->
			<div class="ui container"> <!-- Container to constrain width of Vertical Menu -->
			<!-- Include the side menu code -->
			<?php
				active_menu($hshake);
			?>
			</div> <!-- Close container -->
		</div> <!-- End of Column 1 -->

    <div class="ui fourteen wide column"><!-- START of main column 2 -->
		  <div class="ui inverted manatee segment">
				<iframe src="recent_view.php" name="iframe_main" width="100%" frameborder="0" scrolling="no" title="Main Body View" onload="resizeIframe(this);"></iframe>
		  </div>
		</div><!-- END of main column 2 -->

	</div>

<!-- JS to initialise dropdowns-->
<script>
$('.ui.dropdown')
  .dropdown()
;
</script>
</body>
</html>
