<?php
// callAPI function for all pages that need to call the Ampache API
//

function callAPI(){
  include 'config/foam.conf.php';

  $curl = curl_init();

  //Build the handshake string
  $time = time();
  $key = hash('sha256', $amppas);
  $passphrase = hash('sha256',$time . $key);

  $url = $ampurl.'/server/json.server.php?action=handshake&auth='.$passphrase.'&timestamp='.$time.'&version=350001&user='.$ampusr;

  //Options
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
