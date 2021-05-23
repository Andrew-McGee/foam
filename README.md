# foam = Fomantic & Ampache

foam is a web player frontend for Ampache using the Fomantic UI CSS framework. It is mostly PHP, JS, CSS and HTML and designed to be simple and portable.

The micro player is js and uses the howler audio library. The Ampache json API calls are made via PHP.

## Core Features

- Browse by recently played, newest added, most frequent, favourited and random album views.
- Browse by artists or tracks with filters.
- Browse, create and add to playlists.
- Play or shuffle albums.
- Add individual songs or albums to current play queue.
- View current queue via pulldown list. Jump ahead or back in queue via clickable list.
- Top of screen micro player with transport controls, mini art thumbnail and volume, mute controls.
- Favourite or unfavourite individual tracks or albums.
- Download links for individual tracks.
- Smart search bar for album, artist and song search.

## Future Roadmap Features (after full stable release)

- Advanced dual pipeline player with mixing capabilities.
- Mix crates, advanced tagging and filters.
- Waveform and bpm analysis.
- Volume normalisation.
- Auto mixing/crossfading.
- Streaming and radio.

![Overview](/img/screenshot_pre-release_wip2_sml.png)

## Installation
Simply drop everything into your public html directory of your PHP enabled web server and away you go. No building should be necessary as it is designed to be self contained.

You need an [Ampache](https://github.com/ampache/ampache) server somewhere.

Some limited options can be found in config/foam.conf.php which sets a few php variables.

Ampache authentication is stored in browser cookies. If "Remember me" is NOT selected cookies will expire after the current browser session.
This is advisable on a public or borrowed computer - always close your browser when finished to destroy all session cookies.

If "Remember me" is selected cookies will live for 1 year. Use the logout option in settings to remove cookies and force login.

Note: If you change Ampache credentials so your current cookies no longer validate you will be asked to re-login.
Note: You should NOT consider foam as highly secure. It is still in development.

## To Do
Status: 90% operational with some minor functions missing. Formatting improvements are yet to be completed and will happen in Phase 2.
You can see a video of all current working features here:
https://www.youtube.com/watch?v=VK_6-VN4e8o

#### Phase 1 (*Current*):
Finishing the core functionality to get a working stable release.

#### Phase 2 (*Started*):
Adjust styling to polish fonts, palette, element position, theme options etc.

#### Phase 3 (*Next*):
Code optimisation, minimisation, speed, minify etc.

#### _Working_
- Recent, newest, frequent, favourites and random albums views.
- Single album view with track listing after clicking on an album
- All albums view with pagination navigation
- Play track in album view by clicking track title or track number
- DL link in track listing
- pause/play toggle, Previous/Next skip buttons in microplayer
- mute/unmute volume button in microplayer
- volume slider
- links to artist from track listing (or anywhere artist name appears)
- Artist all tracks view
- Artists all albums view
- Playback timer and slider position update during playback.
- Album play and shuffle buttons and functions
- Album view and artist track views now create a queue when played.
- iFrame to separate micro player from content browsing
- Queue pulldown from micro player with clickable tracks
- Add a track to queue from hidden vertical ellipsis menu per song
- Add track to next queue position as Play Next option from menu
- Playlists view and playlist tracks view when you click a playlist
- Playlists can be played, shuffled or tracks added to the queue like albums
- Pagination on recent, frequent and newest album views for next/prev navigation
- All artists view and all tracks view
- Popup song menus for Play next, Add to queue, go to album, go to artist
- Album and Playlist menu to add all songs to end of queue
- Filters now work on albums view, artists view and tracks view
- Series match to find other albums in multi disc or multi volume sets
- Smart search from top bar with results page
- Adding or removing favourites (blue star) from tracks and albums
- Playlist create, add & remove tracks from new or existing playlists
- Rename and delete playlists from playlist tracks view
- Clear queue
- Browser authentication for Ampache with cookies
- Save current queue to a playlist
- Genre information in artists view
- Better logic for first/last page and pagination controls

#### _Not Yet Working_
- Track seeking via slider
- Queue manipulation (re-order, remove track)
- Play next for whole album
- Mobile device friendly view

## Contributions
Once I have a working release then contributions and suggestions always welcome.

## Testing
Testing on Chrome (Windows and Linux) during initial development.
- Ampache: dev (testing 5.0)
- Apache: 2.4.41
- PHP: 7.4.3

## Acknowledgements & Dependencies
- Inspired by the subsonic player [subplayer](https://github.com/peguerosdc/subplayer) - a really nice looking web player for subsonic.
- Using [Fomantic UI](https://github.com/fomantic/Fomantic-UI) components (v2.8.7 included).
- Using [howler.js](https://github.com/goldfire/howler.js) audio library for media playback (In HTML mode for better FLAC playback).
- Fomantic (Semantic) UI is still dependent on jquery (pulled from CDN - no need to include it).
- Of course you need a backend [Ampache](https://github.com/ampache/ampache) server.
- And a PHP enabled webserver (PHP version 7.4+ recommended).

## License

Licensed under the GNU General Public License v3.0.
