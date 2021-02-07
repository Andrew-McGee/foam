/*!
 * Player code for foam
 * Copyright Andrew McGee 2021
 */

//Define some player functions

// Begin playing the sound
function play() {

  // Play the sound
  trk01.play();

  // Show the pause button.
  pauseBtn.style.display = 'block';
  playBtn.style.display = 'none';

}

// Pause playing the sound
function pause() {

  // Pause the sound
  trk01.pause();

  // Show the play button.
  playBtn.style.display = 'block';
  pauseBtn.style.display = 'none';

}

// First we need to load in our track to howler
// First set the beats
var trk01 = new Howl({
  src: ['./tmp1.flac'],
  loop: false
});

// We need to set some listener events for our player control buttons.
playBtn.addEventListener('click', function() {
  play();
});
pauseBtn.addEventListener('click', function() {
  pause();
});
