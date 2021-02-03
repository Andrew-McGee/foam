<!-- Side menu for foam - Copyright 2021 Andrew McGee -->

<?php

echo '<div class="ui left compact vertical inverted side menu">';

// Function to build the correct active menu item based on which page was passed.
function active_menu($page, $hshake){
  if ($page == 'recent') {
    echo '<a class="active item" href="index.php"><i class="clock icon"></i>Recent</a>';
  } else {
    echo '<a class="item" href="index.php"><i class="clock icon"></i>Recent</a>';
  }
  if ($page == 'newest') {
    echo '<a class="active item" href="newest_view.php"><i class="meteor icon"></i>Newest</a>';
  } else {
    echo '<a class="item" href="newest_view.php"><i class="meteor icon"></i>Newest</a>';
  }
  if ($page == 'artists') {
    echo '<a class="active item" href="artists_view.php"><i class="user icon"></i>Artists</a>';
  } else {
    echo '<a class="item" href="artists_view.php"><i class="user icon"></i>Artists</a>';
  }
  if ($page == 'albums') {
    echo '<a class="active item" href="albums_view.php"><i class="record vinyl icon"></i>Albums</a>';
  } else {
    echo '<a class="item" href="albums_view.php"><i class="record vinyl icon"></i>Albums</a>';
  }
  if ($page == 'tracks') {
    echo '<a class="active item" href="tracks_view.php"><i class="music icon"></i>Tracks</a>';
  } else {
    echo '<a class="item" href="tracks_view.php"><i class="music icon"></i>Tracks</a>';
  }
  if ($page == 'playlists') {
    echo '<a class="active item" href="playlists_view.php"><i class="stream icon"></i>Playlists</a>';
  } else {
    echo '<a class="item" href="playlists_view.php"><i class="stream icon"></i>Playlists</a>';
  }
  if ($page == 'frequent') {
    echo '<a class="active item" href="frequent_view.php"><i class="chart line icon"></i>Frequent</a>';
  } else {
    echo '<a class="item" href="frequent_view.php"><i class="chart line icon"></i>Frequent</a>';
  }
  if ($page == 'favourites') {
    echo '<a class="active item" href="favourites_view.php"><i class="star icon"></i>Favourites</a>';
  } else {
    echo '<a class="item" href="favourites_view.php"><i class="star icon"></i>Favourites</a>';
  }
  if ($page == 'random') {
    echo '<a class="active item" href="random_view.php"><i class="dice icon"></i>Random</a>';
  } else {
    echo '<a class="item" href="random_view.php"><i class="dice icon"></i>Random</a>';
  }

  echo '</div>';
  // Build the stats section below the menu
  echo '<center><h1 class="ui small dim header">Stats</h1></center>';

  echo '<table class="ui very compact very basic collapsing table"><tbody>';
    echo '<tr><td>Albums:</td><td>' . $hshake[albums] . '</td></tr>';
    echo '<tr><td>Artists:</td><td>' . $hshake[artists] . '</td></tr>';
    echo '<tr><td>Songs:</td><td>' . $hshake[songs] . '</td></tr>';
    echo '<tr><td>Genres:</td><td>' . $hshake[genres] . '</td></tr>';
    echo '<tr><td>Playlists:</td><td>' . $hshake[playlists] . '</td></tr>';
  echo '</tbody></table>';

  return;
}

?>
