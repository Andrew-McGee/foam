<?php
	// Check if we have a filter parm (we should always)
	// filter should contain uid of playlist
	if (!empty($_GET["filter"])) {
		$filter = $_GET["filter"];
	} else {
		exit;
	}

	// Check if we have a song parm (we should always)
	// song should contain uid of song
	if (isset($_GET["song"])) {
		$song = $_GET["song"];
	} else {
    exit;
  }

	// Check if we have an action parm (we should always)
	// action must contain 'add' or 'remove'
	if (isset($_GET["action"])) {
		$action = $_GET["action"];
	}
  if ($action != 'add' && $action != 'remove') {
    exit;
  }

  $auth = 'new';
  $call = 'hshake';
  $result = c_init($auth, $call);
  error_log("playlistAPI.php: Handshake call complete.", 0);

	$hshake = json_decode($result, true);
	$auth=$hshake['auth'];

  // Playlist add or remove song API call - $action determines if add or remove
  $call = '?action=playlist_' . $action . '_song&filter=' . $filter . '&song=' . $song;

  $result = c_init($auth, $call);
  error_log("playlistAPI.php: " . $action . " call complete.", 0);
  //
  // Generic CURL stuff used by the various calls to call the Ampache API.
  //
  function c_init($auth, $call){
    include '../config/foam.conf.php';

    $curl = curl_init();

    //If the call is initial handsake we need to build a different format
    if ($call == 'hshake') {

      //Build the handshake string to get auth key
      $time = time();
      $key = hash('sha256', $amppas);
      $passphrase = hash('sha256',$time . $key);
      $url = $ampurl.'/server/json.server.php?action=handshake&auth='.$passphrase.'&timestamp='.$time.'&version=350001&user='.$ampusr;
      error_log("playlistAPI.php: Handshake call built and ready.", 0);
    } else {

      //Non-handshake calls can be built from this format using the url and parms
      $url = $ampurl . '/server/json.server.php' . $call . '&auth=' . $auth;
      error_log("playlistAPI.php: call = $call", 0);
    }

    // CURL options.
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
    ));

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    // CURL Execute
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);

    return $result;
  }

?>
