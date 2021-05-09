<?php
	// Check if we have an id parm (we should always)
	if (!empty($_GET["id"])) {
		$id = $_GET["id"];
	} else {
		exit;
	}

	// Check if we have an id parm (we should always)
	if (isset($_GET["flag"])) {
		$flag = $_GET["flag"];
	}
  if ($flag != 0 && $flag != 1) {
    exit;
  }

	// Check if we have a type parm (we should always)
	if (!empty($_GET["type"])) {
		$type = $_GET["type"];
	}
  if ($type != 'song' && $type != 'album') {
    exit;
  }

  $auth = 'new';
  $call = 'hshake';
  $result = c_init($auth, $call);
  //error_log("favAPI.php: Handshake call complete.", 0);

	$hshake = json_decode($result, true);
	$auth=$hshake['auth'];

  // Flag API call to set or unset a favourite song or album
  $call = '?action=flag&type=' . $type . '&id=' . $id . '&flag=' . $flag;

  $result = c_init($auth, $call);
  //error_log("favAPI.php: Tag call complete.", 0);
  //
  // Generic CURL stuff used by the various calls to call the Ampache API.
  //
  function c_init($auth, $call){

    $curl = curl_init();

    //If the call is initial handsake we need to build a different format
    if ($call == 'hshake') {

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

      //Build the handshake string to get auth key
      $time = time();
      $key = hash('sha256', $amppas);
      $passphrase = hash('sha256',$time . $key);
      $url = $ampurl.'/server/json.server.php?action=handshake&auth='.$passphrase.'&timestamp='.$time.'&version=350001&user='.$ampusr;
      //error_log("favAPI.php: Handshake call built and ready.", 0);
    } else {

      //Non-handshake calls can be built from this format using the url and parms
      $url = $ampurl . '/server/json.server.php' . $call . '&auth=' . $auth;
      //error_log("favAPI.php: Tag call built and ready.", 0);
      //error_log("favAPI.php: call = $call", 0);
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
