<?php
	include 'includes/header_iframe.php';
	include 'config/foam.conf.php';

	if(!empty($_GET["authError"])) {
		$authError = $_GET["authError"];
	}
?>

<body>
			<div class="ui middle aligned container">
			  <div class="ui inverted space compact segment">
					<?php if (isset($authError)) echo '<h2 class="ui inverted red header">' . $authError . '</h2>'; ?>
					<h1 class="ui inverted yellow header">foam</h1>
					<form class="ui form" method="POST" action="includes/connect.php">
						<div class="field">
							<label>Host (hostname:port)</label>
			  			<input name="host" type="text" size="35" placeholder="host:port"
								<?php if (!empty($defHost)) echo ' value="' . $defHost . '"'?> >
						</div>
						<div class="field">
							<label>User</label>
							<input name="name" type="text" size="35" placeholder="username"
							<?php if (!empty($defUser)) echo ' value="' . $defUser . '"'?> ><br>
						</div>
						<div class="field">
							<label>Password</label>
							<input name="pass" type="text" size="35" placeholder="password"
							<?php if (!empty($defHost)) echo ' value="' . $defPass . '"'?> ><br>
						</div>
						  <div class="field">
						    <div class="ui checkbox">
						      <input name="remember" type="checkbox" tabindex="0" class="hidden">
						      <label>Remember me</label>
						    </div>
						  </div>
						<button class="ui button" type="submit" id="authButton">SUBMIT</button>
					</form>
				</div>
			</div>
<!-- JS to initialise form elements-->
<script>
$('.ui.checkbox')
  .checkbox()
;
</script>
</body>
</html>
