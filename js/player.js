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
  //pauseBtn.style.display = 'block';
  //playBtn.style.display = 'none';
  document.getElementById("playBtn").className = "bordered pause icon";

  document.getElementById("status_msg").textContent="Now Playing: " + track;
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

// Pause playing the sound
function pause() {

  // Pause the sound
  trk01.pause();

  // Show the play button.
  //playBtn.style.display = 'block';
  //pauseBtn.style.display = 'none';
  document.getElementById("playBtn").className = "bordered play icon";
}

// mute playing the sound
function mute() {

  // mute the sound
  trk01.mute(true);

  // Show the mute button.
  //muteBtn.style.display = 'block';
  //volBtn.style.display = 'none';
  document.getElementById("volBtn").className = "bordered volume mute icon";

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
  playToggle();
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
