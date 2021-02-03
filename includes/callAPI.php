<?php
//
// Handshake API function for inital authentication to Ampache API
//
function handshakeAPI(){
  $call = 'hshake';
  $auth = 'new';

  $result = c_init($auth, $call);

  return $result
}

//
// Stats API call for recent, newest, frequent, random etc
//
function statsAPI($auth, $filter){

  $call = '?action=stats&type=album&limit=24&filter=' . $filter;

  $result = c_init($auth, $call);

  return $result
}

//
// Generic CURL stuff used by the various calls to call the Ampache API.
//
function c_init($auth, $call){
  include 'config/foam.conf.php';

  $curl = curl_init();

  //If the call is initial handsake we need to build a different format
  if ($call == 'hshake') {

    //Build the handshake string to get auth key
    $time = time();
    $key = hash('sha256', $amppas);
    $passphrase = hash('sha256',$time . $key);
    $url = $ampurl.'/server/json.server.php?action=handshake&auth='.$passphrase.'&timestamp='.$time.'&version=350001&user='.$ampusr;

  } else {

    //Non-handshake calls can be built from this format using the url and parms
    $url = $ampurl . '/server/json.server.php' . $call . '&auth=' . $auth;
  }

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

  return $result;
}
?>
