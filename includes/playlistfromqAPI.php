<?php
	// Check if we have a filter parm (we should always)
	// filter should contain new playlist name
	if (!empty($_GET["filter"])) {
		$filter = $_GET["filter"];
	} else {
		exit;
	}

	// Check if we have a song parm (we should always)
	// song should contain array of song uids
	if (isset($_GET["songs"])) {
		$songs = $_GET["songs"];
	} else {
    exit;
  }

  $auth = 'new';
  $call = 'hshake';
  $result = c_init($auth, $call);
  //error_log("playlistAPI.php: Handshake call complete.", 0);

	$hshake = json_decode($result, true);
	$auth=$hshake['auth'];

  // lets first create playlist with playlist_create API call
		$filter = urlencode($filter);
		$call = '?action=playlist_create&name=' . $filter;
		$result = c_init($auth, $call);
		//error_log("playlistAPI.php: " . $action . " call complete.", 0);
		$playlist = json_decode($result, true);
		$filter = $playlist['id'];

	// Let's loop through our array of songs and add each one to our new playlist

	foreach ($songs as $song) {
		// Playlist add song API call
		$call = '?action=playlist_add_song&filter=' . $filter . '&song=' . $song;
		$result = c_init($auth, $call);
	}

  function c_init($auth, $call){

    $curl = curl_init();

	    // Let's check the cookies are set
	    if (isset($_COOKIE["host"])) {
	      $ampurl = $_COOKIE["host"];
	    } else {
	      header ('Location: auth.php');
	    }
	    if (isset($_COOKIE["name"])) {
	      $ampusr = $_COOKIE["name"];
	    } else {
	      header ('Location: auth.php');
	    }
	    if (isset($_COOKIE["pass"])) {
	      $amppas = $_COOKIE["pass"];
	    } else {
	      header ('Location: auth.php');
	    }

    //If the call is initial handsake we need to build a different format
    if ($call == 'hshake') {

      //Build the handshake string to get auth key
      $time = time();
      $key = hash('sha256', $amppas);
      $passphrase = hash('sha256',$time . $key);
      $url = $ampurl.'/server/json.server.php?action=handshake&auth='.$passphrase.'&timestamp='.$time.'&version=350001&user='.$ampusr;
      //error_log("playlistAPI.php: Handshake call built and ready.", 0);
    } else {

      //Non-handshake calls can be built from this format using the url and parms
      $url = $ampurl . '/server/json.server.php' . $call . '&auth=' . $auth;
      //error_log("playlistAPI.php: call = $call", 0);
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
