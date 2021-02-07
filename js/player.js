/*!
 * Player code for foam
 * Copyright Andrew McGee 2021
 */

const setVol = 10.0;
const muted = false;

//Define some player functions

// Begin playing the sound
function playnew(track) {

  // If trk01 is defined something might be playing so just stop everything
  if (typeof trk01 !== 'undefined') {
    trk01.stop();
  }

  // First we need to load in our track to howler
  this.trk01 = new Howl({
    src: [track],
    html5: true,
    loop: false,
    volume: [setVol]
  });

  // Play the sound
  trk01.play();

  // Show the pause button.
  document.getElementById("playBtn").className = "bordered pause icon";
}

// Play or pause the sound
function playToggle() {

  if (trk01.playing()) {
    trk01.pause(); // Pause the sound & show play button
    document.getElementById("playBtn").className = "bordered play icon";
  } else {
    trk01.play();  // Play the sound & show pause button
    document.getElementById("playBtn").className = "bordered pause icon";
  }
}

// mute or unmute the sound
function mute() {

  if (muted()) {
    // if muted then unmute the sound & show volume button
    trk01.mute(false);
    document.getElementById("volBtn").className = "bordered volume up icon";
  } else {
    // if unmuted then mute the sound & show mute button
    trk01.mute(true);
    document.getElementById("volBtn").className = "bordered volume mute icon";
  }
}

// We need to set some listener events for our player control buttons.
playBtn.addEventListener('click', function() {
  playToggle();
});

volBtn.addEventListener('click', function() {
  mute();
});
