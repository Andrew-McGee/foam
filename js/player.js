/*!
 * Player code for foam
 * Copyright Andrew McGee 2021
 */

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
    loop: false
  });

  // Play the sound
  trk01.play();

  // Show the pause button.
  pauseBtn.style.display = 'block';
  playBtn.style.display = 'none';

  document.getElementById("status_msg").textContent="Now Playing: " + track;
}

// Resume playing the sound
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

// mute playing the sound
function mute() {

  // mute the sound
  trk01.mute(true);

  // Show the mute button.
  muteBtn.style.display = 'block';
  volBtn.style.display = 'none';

}

// unmute playing the sound
function unmute() {

  // Unmute the sound
  trk01.mute(false);

  // Show the vol button.
  muteBtn.style.display = 'none';
  volBtn.style.display = 'block';

}


// We need to set some listener events for our player control buttons.
playBtn.addEventListener('click', function() {
  play();
});

pauseBtn.addEventListener('click', function() {
  pause();
});

volBtn.addEventListener('click', function() {
  mute();
});

muteBtn.addEventListener('click', function() {
  unmute();
});
