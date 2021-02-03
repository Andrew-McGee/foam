<!-- Side menu for foam - Copyright 2021 Andrew McGee -->

<?php

// Function to build the correct active menu item based on which page was passed.
function active_menu($page){
  if ($page == 'recent') {
    echo '<a class="active item" href="index.php"><i class="clock icon"></i>Recent</a>';
  } else {
    echo '<a class="item" href="index.php"><i class="clock icon"></i>Recent</a>';
  }
  if ($page == 'newest') {
    echo '<a class="active item" href="newest_view.php"><i class="clock icon"></i>Newest</a>';
  } else {
    echo '<a class="item" href="newest_view.php"><i class="clock icon"></i>Newest</a>';
  }
  if ($page == 'artists') {
    echo '<a class="active item" href="artists_view.php"><i class="clock icon"></i>Artists</a>';
  } else {
    echo '<a class="item" href="artists_view.php"><i class="clock icon"></i>Artists</a>';
  }
  if ($page == 'albums') {
    echo '<a class="active item" href="albums_view.php"><i class="clock icon"></i>Albums</a>';
  } else {
    echo '<a class="item" href="albums_view.php"><i class="clock icon"></i>Albums</a>';
  }
  if ($page == 'tracks') {
    echo '<a class="active item" href="tracks_view.php"><i class="clock icon"></i>Tracks</a>';
  } else {
    echo '<a class="item" href="tracks_view.php"><i class="clock icon"></i>Tracks</a>';
  }
  if ($page == 'playlists') {
    echo '<a class="active item" href="playlists_view.php"><i class="clock icon"></i>Playlists</a>';
  } else {
    echo '<a class="item" href="playlists_view.php"><i class="clock icon"></i>Playlists</a>';
  }
  if ($page == 'frequent') {
    echo '<a class="active item" href="frequent_view.php"><i class="clock icon"></i>Frequent</a>';
  } else {
    echo '<a class="item" href="frequent_view.php"><i class="clock icon"></i>Frequent</a>';
  }
  if ($page == 'favourites') {
    echo '<a class="active item" href="favourites_view.php"><i class="clock icon"></i>Favourites</a>';
  } else {
    echo '<a class="item" href="favourites_view.php"><i class="clock icon"></i>Favourites</a>';
  }
  if ($page == 'random') {
    echo '<a class="active item" href="random_view.php"><i class="clock icon"></i>Random</a>';
  } else {
    echo '<a class="item" href="random_view.php"><i class="clock icon"></i>Random</a>';
  }

  // Build the stats section below menu

  echo '<div class="item"><h1 class="ui small dim header">Stats</h1>';
	echo 'Albums: '. $hshake[albums];
	echo '<br>Artists: '. $hshake[artists];
	echo '<br>Tracks: '. $hshake[songs];
	echo '<br>Genres: '. $hshake[genres];
	echo '<br>Playlists: '. $hshake[playlists];
  echo '</div></div>';

  return;
}

?>
