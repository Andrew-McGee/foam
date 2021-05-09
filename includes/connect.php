<?php
// Verify login info for Ampache API and set cookies.
// If remember me was selected make cookie not expire until the sessionTime parm, otherwise cookie lasts only for this browser session.

	include '../config/foam.conf.php';

	$sessionTime = 365 * 24 * 3600; // Seconds in 1 year

	//Let's try and login with the passed credentials
	$curl = curl_init();

  //Build the handshake string to get auth key

  $time = time();
  $key = hash('sha256', $_POST["pass"]);
  $passphrase = hash('sha256',$time . $key);
  $url = $_POST["host"].'/server/json.server.php?action=handshake&auth='.$passphrase.'&timestamp='.$time.'&user='.$_POST["name"];

  // CURL options.
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
  ));

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

  //Execute
  $result = curl_exec($curl);
  if(!$result){die("Connection Failure");}
  curl_close($curl);

	$hshake = json_decode($get_data, true);

	// If we don't have an auth token returned something went wrong - redirect back to login screen with an error msg
	if (!isset($hshake['auth'])) {
		header ('Location: ../auth.php?authError="Login Failed"');
	}


	if(!empty($_POST["remember"])) {
		setcookie ("host",$_POST["host"],time()+ $sessionTime, "/");
		setcookie ("name",$_POST["name"],time()+ $sessionTime, "/");
		setcookie ("pass",$_POST["pass"],time()+ $sessionTime, "/");
		echo "Cookies Set Successfully";
	} else {
		setcookie ("host",$_POST["host"],0, "/");
		setcookie ("name",$_POST["name"],0, "/");
		setcookie ("pass",$_POST["pass"],0, "/");
		echo "Cookies expire at end of session";
	}

	header ('Location: ../index.php');

?>
