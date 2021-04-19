<?php
//
// Handshake API function for inital authentication to Ampache API
//
function handshakeAPI(){
  $call = 'hshake';
  $auth = 'new';

  $result = c_init($auth, $call);

  return $result;
}

//
// Stats API call for recent, newest, frequent, random etc
//
function statsAPI($auth, $filter, $offset){

  $call = '?action=stats&type=album&limit=24&filter=' . $filter . '&offset=' . $offset;
  //$call = '?action=stats&type=album&offset=25&limit=24&filter=' . $filter;

  $result = c_init($auth, $call);

  return $result;
}

//
// Albums API call to return albums listing
//
function albumsAPI($auth, $filt, $offset){

  $filt = urlencode($filt);
  $call = '?action=albums&limit=24&filter=' . $filt . '&offset=' . $offset;

  $result = c_init($auth, $call);

  return $result;
}

//
// Album API call to return details on specific album UID
//
function albumAPI($auth, $uid){

  $call = '?action=album&filter=' . $uid;

  $result = c_init($auth, $call);

  return $result;
}

//
// Albumsongs API call to return tracks on specific album UID
//
function albumsongsAPI($auth, $uid){

  $call = '?action=album_songs&filter=' . $uid;

  $result = c_init($auth, $call);

  return $result;
}

//
// Artists API call to return artists listing
//
function artistsAPI($auth, $filt, $offset){

  $filt = urlencode($filt);
  $call = '?action=artists&limit=20&filter=' . $filt . '&offset=' . $offset;

  $result = c_init($auth, $call);

  return $result;
}

//
// Artist API call to return info on specific artist UID
//
function artistAPI($auth, $uid){

  $call = '?action=artist&filter=' . $uid;

  $result = c_init($auth, $call);

  return $result;
}

//
// Artistsongs API call to return tracks of specific artist UID
//
function artistsongsAPI($auth, $uid){

  $call = '?action=artist_songs&filter=' . $uid;

  $result = c_init($auth, $call);

  return $result;
}

//
// Artistalbums API call to return albums of specific artist UID
//
function artistalbumsAPI($auth, $uid){

  $call = '?action=artist_albums&filter=' . $uid;

  $result = c_init($auth, $call);

  return $result;
}

//
// Songs API call to return all tracks listing
//
function songsAPI($auth, $filt, $offset){

  $filt = urlencode($filt);
  $call = '?action=songs&limit=20&filter=' . $filt . '&offset=' . $offset;

  $result = c_init($auth, $call);

  return $result;
}

//
// Playlists API call to return list of playlists
//
function playlistsAPI($auth){

  $call = '?action=playlists&limit=24&hide_search=1';

  $result = c_init($auth, $call);

  return $result;
}

//
// Playlist API call to return single playlist info
//
function playlistAPI($auth, $uid){

  $call = '?action=playlist&filter=' . $uid;

  $result = c_init($auth, $call);

  return $result;
}

//
// Playlistsongs API call to return tracks of specific playlist UID
//
function playlistsongsAPI($auth, $uid){

  $call = '?action=playlist_songs&filter=' . $uid;

  $result = c_init($auth, $call);

  return $result;
}

//
// Smart search uses advanced search API call to return artists, albums and tracks that match
//
function smartAPI($auth, $search, $type){

  $search = urlencode($search);
  $call = '?action=advanced_search&type=' . $type . '&limit=6&rule_1=title&rule_1_operator=0&rule_1_input=' . $search;

  $result = c_init($auth, $call);

  return $result;
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

//
// Sneaking a little time conversion function in here to convert seconds into hours, minutes, seconds.
//
function sec2mins($seconds){
  $result['hours'] = floor($seconds / 3600);
  $result['minutes'] = floor(($seconds / 60) % 60);
  $result['seconds'] = $seconds % 60;

  return $result;;
}

//
// Doing some string manipulation to create a cut down album title for series match filter search.
//
function smatch($album){
  $strings = array("(disc", "[disc", "(cd", "[cd", "vol");

  foreach ($strings as $str) {
    $pos = stripos($album, $str);
    if ($pos !== false) {
      $album = substr($album, 0, $pos + 1);
    }
  }
  return $album;
}
?>
