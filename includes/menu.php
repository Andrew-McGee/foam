<!-- Side menu for foam - Copyright 2021 Andrew McGee -->

<?php

// Function to build the correct active menu item based on which page was passed.
function active_menu($hshake){

  include 'config/foam.conf.php';

  echo '<div class="ui left compact vertical inverted side menu">';

  echo '  <a class="item" id="item1" href="recent_view.php" target="iframe_main"><i class="clock icon"></i>Recent</a>';
  echo '  <a class="item" id="item2" href="newest_view.php" target="iframe_main"><i class="meteor icon"></i>Newest</a>';
  echo '  <a class="item" id="item3" href="artists_view.php" target="iframe_main"><i class="user icon"></i>Artists</a>';
  echo '  <a class="item" id="item4" href="albums_view.php" target="iframe_main"><i class="record vinyl icon"></i>Albums</a>';
  echo '  <a class="item" id="item5" href="tracks_view.php" target="iframe_main"><i class="music icon"></i>Tracks</a>';
  echo '  <a class="item" id="item6" href="playlists_view.php" target="iframe_main"><i class="stream icon"></i>Playlists</a>';
  echo '  <a class="item" id="item7" href="frequent_view.php" target="iframe_main"><i class="chart line icon"></i>Frequent</a>';
  echo '  <a class="item" id="item8" href="favourites_view.php" target="iframe_main"><i class="star icon"></i>Favourites</a>';
  echo '  <a class="item" id="item9" href="random_view.php" target="iframe_main"><i class="dice icon"></i>Random</a>';
  echo '  <div class="item" id="item10">' . "\r\n";
  echo '    <div class="ui inline dropdown">Settings &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="cog icon"></i>' . "\r\n";
  echo '  	  <div class="menu" id="settingsMenu">' . "\r\n";

 // Loop to generate each theme menu item
  $cnt = count($theme);
  for ($i = 1; $i <= $cnt; $i++){
    echo '  	    <div class="item" id="theme' . $i . '">' . $theme[$i]['name'] . '</div>' . "\r\n";
    // Add a listener for clicking this theme menu item
    echo '<script>theme' . $i . '.addEventListener("click", function() {';
    echo '  document.body.style.setProperty("--colrfgd1", "' . $theme[$i]['colrfgd1'] . '");';
    echo '  document.body.style.setProperty("--colrbgd1", "' . $theme[$i]['colrbgd1'] . '");';
    echo '  document.body.style.setProperty("--colrfnt1", "' . $theme[$i]['colrfnt1'] . '");';
    echo '  document.body.style.setProperty("--colrfnt2", "' . $theme[$i]['colrfnt2'] . '");';
    echo '  document.body.style.setProperty("--colrfnt3", "' . $theme[$i]['colrfnt3'] . '");';
    echo '  document.body.style.setProperty("--colrhilt", "' . $theme[$i]['colrhilt'] . '");';
    echo '  window.frames.iframe_main.document.body.style.setProperty("--colrfgd1", "' . $theme[$i]['colrfgd1'] . '");';
    echo '  window.frames.iframe_main.document.body.style.setProperty("--colrbgd1", "' . $theme[$i]['colrbgd1'] . '");';
    echo '  window.frames.iframe_main.document.body.style.setProperty("--colrfnt1", "' . $theme[$i]['colrfnt1'] . '");';
    echo '  window.frames.iframe_main.document.body.style.setProperty("--colrfnt2", "' . $theme[$i]['colrfnt2'] . '");';
    echo '  window.frames.iframe_main.document.body.style.setProperty("--colrfnt3", "' . $theme[$i]['colrfnt3'] . '");';
    echo '  window.frames.iframe_main.document.body.style.setProperty("--colrhilt", "' . $theme[$i]['colrhilt'] . '");';
    echo '	document.cookie = "theme=' . $i . '; max-age=31536000; path=/";';
    echo '});</script>' . "\r\n";
  }

  echo '  	    <div class="item" id="logOut">Log out</div>' . "\r\n";
  echo '      </div>' . "\r\n";
  echo '    </div>' . "\r\n";
  echo '  </div>' . "\r\n";

  echo '</div>' . "\r\n";
  // Build the stats section below the menu
  echo '<br><h1 class="ui small dim header">Stats</h1>';

  echo '<table class="ui very compact very basic collapsing table"><tbody>';
  echo '  <tr><td>Albums:</td><td>' . $hshake['albums'] . '</td></tr>';
  echo '  <tr><td>Artists:</td><td>' . $hshake['artists'] . '</td></tr>';
  echo '  <tr><td>Songs:</td><td>' . $hshake['songs'] . '</td></tr>';
  echo '  <tr><td>Genres:</td><td>' . $hshake['genres'] . '</td></tr>';
  echo '  <tr><td>Playlists:</td><td>' . $hshake['playlists'] . '</td></tr>';
  echo '</tbody></table>' . "\r\n";

  // Add a listener for the logout menu item
  // If logout is clicked set all the cookies to an expiry date in the past so they are deleted
  echo '<script>logOut.addEventListener("click", function() {';
  echo '	document.cookie = "host=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";';
  echo '	document.cookie = "name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";';
  echo '	document.cookie = "pass=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";';
  echo '  location.reload();';
  echo '});</script>' . "\r\n";



  // Add a listener for theme 1 menu item
  echo '<script>theme1.addEventListener("click", function() {';
  echo '  document.body.style.setProperty("--colrfgd1", "#556177");';
  echo '  document.body.style.setProperty("--colrbgd1", "#2a2c41");';
  echo '  window.frames.iframe_main.document.body.style.setProperty("--colrfgd1", "#556177");';
  echo '  window.frames.iframe_main.document.body.style.setProperty("--colrbgd1", "#2a2c41");';
  echo '});</script>' . "\r\n";

  // Add a listener for theme 2 menu item
  echo '<script>theme2.addEventListener("click", function() {';
  echo '  document.body.style.setProperty("--colrfgd1", "#2a2c41");';
  echo '  document.body.style.setProperty("--colrbgd1", "#556177");';
  echo '  window.frames.iframe_main.document.body.style.setProperty("--colrfgd1", "#2a2c41");';
  echo '  window.frames.iframe_main.document.body.style.setProperty("--colrbgd1", "#556177");';
  echo '});</script>' . "\r\n";

  return;
}

?>
