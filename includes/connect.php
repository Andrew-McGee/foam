<?php
// Verify login info for Ampache API and set cookies.
// If remember me was selected make cookie not expire until the sessionTime parm, otherwise cookie lasts only for this browser session.

	include '../config/foam.conf.php';

	// Set some vars for our passed credentials
	$host = $_POST["host"];
	$user = $_POST["name"];
	$pass = $_POST["pass"];

	// Check if hostname includes http or https - if not add http to front
	if (substr($host, 0, 7) != "http://" && substr($host, 0, 8) != "https://") $host = "http://" . $host;

	//Let's try and login with the passed credentials
	$curl = curl_init();

  //Build the handshake string to get auth key

  $time = time();
  $key = hash('sha256', $pass);
  $passphrase = hash('sha256',$time . $key);
  $url = $host.'/server/json.server.php?action=handshake&auth='.$passphrase.'&timestamp='.$time.'&user='.$user;

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

	$hshake = json_decode($result, true);

	// If we don't have an auth token returned something went wrong - redirect back to login screen with an error msg
	if (!isset($hshake['auth'])) {
		header ('Location: ../auth.php?authError="Login Failed"');
	}

	// Now let's set the cookies with login info
	if(!empty($_POST["remember"])) {
		setcookie ("host",$host,time()+ $sessionTime, "/");
		setcookie ("name",$user,time()+ $sessionTime, "/");
		setcookie ("pass",$pass,time()+ $sessionTime, "/");
		echo "Cookies Set Successfully";
	} else {
		setcookie ("host",$host,0, "/");
		setcookie ("name",$user,0, "/");
		setcookie ("pass",$pass,0, "/");
		echo "Cookies expire at end of session";
	}

	header ('Location: ../index.php');

?>
