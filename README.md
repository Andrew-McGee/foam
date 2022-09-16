# foam = Fomantic & Ampache

foam is a web player frontend for Ampache using the Fomantic UI CSS framework. It is mostly PHP, JS, CSS and HTML and designed to be simple and portable.

The micro player is js and uses the howler audio library. The Ampache json API calls are made via PHP.

## Core Features

- Browse by recently played, newest added, most frequent, favourited and random album views.
- Browse by artists, albums or tracks with filters.
- Browse, create and add to playlists. Edit, rename and delete playlists.
- Play or shuffle albums.
- Add individual songs or albums to current play queue.
- View current queue via pulldown list. Jump ahead or back in queue via clickable list.
- Drag and drop reorder of play queue. Save play queue to permanent playlist.
- Top of screen micro player with transport controls, mini art thumbnail and volume, mute controls.
- Favourite or unfavourite individual tracks or albums.
- Download links for individual tracks.
- Smart search bar for album, artist and song search.
- Persistent pages - can use back and forwards browser buttons.
- Can playback all formats from your Ampache collection in FLAC, WAV or MP3.
- Four built in colour schemes or add your own web colours in editable config.
- Series Match finds multi volume album sets.
- SupaMIX function creates huge randomised playlists from boxsets or collections of albums.
- Easily create artist playlists from multiple albums and compilations.

## Future Roadmap (after full stable release)

Trello: https://trello.com/b/AgzQmuvO/foam

**Kiosk Mode (current mode):**
- Streaming and smart radio.
- Smart playlists and musicbrainz integration.
- Dedicated mobile devices layout.

**Advanced Mode:**
- Dual player with track mixing capabilities (vol, crossfade, pitch etc).
- Advanced playlists (create set lists with advanced tagging and filters).
- Waveform and bpm analysis and tagging.
- Volume normalization.
- Auto mixing/crossfading and AI track selection.

![Overview](/img/screenshot_pre-release_wip3_sml.png)

## Installation
Download the latest release and simply drop everything into your public html directory of your PHP enabled web server and away you go. No building should be necessary as it is designed to be self contained.

You need an [Ampache](https://github.com/ampache/ampache) server somewhere.

Some options (mainly theming) can be found in config/foam.conf.php which sets a few php variables.

Ampache authentication is stored in browser cookies. If "Remember me" is NOT selected cookies will expire after the current browser session.
This is advisable on a public or borrowed computer - always close your browser when finished to destroy all session cookies.

If "Remember me" is selected cookies will live for 1 year. Use the logout option in settings to remove cookies and force login.

Note: If you change Ampache credentials so your current cookies no longer validate you will be asked to re-login.
Note: You should NOT consider foam as highly secure. It is still in development.

## Development Status - Early Beta
Status: 100% operational on desktop. Formatting improvements and bug fixing now underway in Phase 2.

#### Phase 1 (*Complete*):
Finished the core functionality including all major features for first stable release.

#### Phase 2 (*Current*):
Adjust styling to polish fonts, palette, element position, theme options and bug fixing.

#### Phase 3 (*Started*):
Code optimisation, clean up, minimisation, speed, etc.

#### _Not Yet Working_
- Mobile device friendly view

#### _Known Issues_
- Need a timeout if Ampache host unreachable in order to sign in again
- Sometimes the track timer glitches after seeking with the slider

## Testing
Testing on Chrome (Windows and Linux) during initial development.
- Testing library with all FLAC playback
- Ampache: dev (testing 5.2)
- Apache: 2.4.41
- PHP: 7.4.3

## Acknowledgements & Dependencies
- Inspired by the subsonic player [subplayer](https://github.com/peguerosdc/subplayer) - a really nice looking web player for subsonic.
- Using [Fomantic UI](https://github.com/fomantic/Fomantic-UI) components (v2.8.8).
- Using [howler.js](https://github.com/goldfire/howler.js) (v2.2.3) audio library for media playback (In HTML mode for better FLAC playback).
- Fomantic (Semantic) UI is still dependent on jquery (pulled from CDN - no need to include it).
- Of course you need a backend [Ampache](https://github.com/ampache/ampache) server.
- And a PHP enabled webserver (PHP version 7.4+ recommended).

## License

Licensed under the GNU General Public License v3.0.
