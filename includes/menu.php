<!-- Side menu for foam - Copyright 2021 Andrew McGee -->

<?php

// Function to build the correct active menu item based on which page was passed.
function active_menu($hshake){
  echo '<div class="ui left compact vertical inverted side menu">';

  echo '<a class="item" id="item1" href="recent_view.php?ofst=0" target="iframe_main"><i class="clock icon"></i>Recent</a>';
  echo '<a class="item" id="item2" href="newest_view.php" target="iframe_main"><i class="meteor icon"></i>Newest</a>';
  echo '<a class="item" id="item3" href="artists_view.php" target="iframe_main"><i class="user icon"></i>Artists</a>';
  echo '<a class="item" id="item4" href="albums_view.php" target="iframe_main"><i class="record vinyl icon"></i>Albums</a>';
  echo '<a class="item" id="item5" href="tracks_view.php" target="iframe_main"><i class="music icon"></i>Tracks</a>';
  echo '<a class="item" id="item6" href="playlists_view.php" target="iframe_main"><i class="stream icon"></i>Playlists</a>';
  echo '<a class="item" id="item7" href="frequent_view.php" target="iframe_main"><i class="chart line icon"></i>Frequent</a>';
  echo '<a class="item" id="item8" href="favourites_view.php" target="iframe_main"><i class="star icon"></i>Favourites</a>';
  echo '<a class="item" id="item9" href="random_view.php" target="iframe_main"><i class="dice icon"></i>Random</a>';

  echo '</div>';
  // Build the stats section below the menu
  echo '<br><h1 class="ui small dim header">Stats</h1>';

  echo '<table class="ui very compact very basic collapsing table"><tbody>';
    echo '<tr><td>Albums:</td><td>' . $hshake['albums'] . '</td></tr>';
    echo '<tr><td>Artists:</td><td>' . $hshake['artists'] . '</td></tr>';
    echo '<tr><td>Songs:</td><td>' . $hshake['songs'] . '</td></tr>';
    echo '<tr><td>Genres:</td><td>' . $hshake['genres'] . '</td></tr>';
    echo '<tr><td>Playlists:</td><td>' . $hshake['playlists'] . '</td></tr>';
  echo '</tbody></table>';

  return;
}

?>
