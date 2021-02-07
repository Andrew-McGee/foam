# foam = Fomantic & Ampache

foam is a web player frontend for Ampache using the Fomantic UI CSS framework. It is mostly PHP, CSS and HTML and designed to be simple and portable.

The player is made with js and uses the howler audio library.

## Features

- TBA - but expect all the normal album, artist, song, playlist searching.

![Overview](/img/screenshot_pre-release_wip_sml.png)

## Installation
Simply drop everything into your public html directory of your PHP enabled web server and away you go. No building should be necessary as it is designed to be self contained.

You need an [Ampache](https://github.com/ampache/ampache) server somewhere.

Some limited options can be found in config/foam.conf.php which sets a few php variables.

## TODO
- Early days - still building the base functionality to get to a working release stage.

## Contributions
Once I have a working release then contributions and suggestions always welcome.

## Acknowledgements & Dependencies
- Inspired by the subsonic player [subplayer](https://github.com/peguerosdc/subplayer) - a really nice looking web player for subsonic.
- Using [Fomantic UI](https://github.com/fomantic/Fomantic-UI) components.
- Using [howler.js](https://github.com/goldfire/howler.js) audio library for media playback.
- Fomantic (Semantic) UI is still dependent on jquery.
- Of course you need a backend [Ampache](https://github.com/ampache/ampache) server.
- And a PHP enabled webserver.

## License

Licensed under the GNU General Public License v3.0.
