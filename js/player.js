/*!
 * Player code for foam
 * Copyright Andrew McGee 2021
 */

const setVol = 1.0;
const muted = false;

this.setVol = 0.5;

//Define some player functions

// Function called to begin playing the sound
function playnew(track) {

  var self = this;
  // If trk01 is defined something might be playing so just stop everything
  if (typeof trk01 !== 'undefined') {
    trk01.stop();
  }

  // First we need to load in our track to howler
  this.trk01 = new Howl({
    src: [track],
    html5: true,
    loop: false,
    volume: [this.setVol]
  });

  // Play the sound
  trk01.play();

  // Show the pause button.
  document.getElementById("playBtn").className = "bordered pause icon";

  // Update the length of track in the UI once it starts playing
  trk01.on('play', function(){
    document.getElementById("length").textContent = sec2mins(Math.round(trk01.duration()));
  // Start upating the progress slider and playtime of the track.
  requestAnimationFrame(progress);
  });

  // Set up a trigger for end of song to change button to play & update doc title
  trk01.on('end', function(){
    document.getElementById("playBtn").className = "bordered play icon";
    document.title = "foam";
    });
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

  if (this.muted) {
    // if muted then unmute the sound & show volume button
    trk01.mute(false);
    document.getElementById("volBtn").className = "bordered volume up icon";
    this.muted = false;
  } else {
    // if unmuted then mute the sound & show mute button
    trk01.mute(true);
    document.getElementById("volBtn").className = "bordered volume mute icon";
    this.muted = true;
  }
}

// Change volume as set by slider value
function changeVol(newVol) {

  // If trk01 is not yet defined don't try calling howler
  if (typeof trk01 !== 'undefined') {
    trk01.volume(newVol);
  }
  this.setVol = newVol;
}

// Update progress slider and play time - recursive function called within requestAnimationFrame
function progress() {
  var self = this;
  var seek = trk01.seek() || 0;
  document.getElementById("timer").textContent = sec2mins(Math.round(seek)); // Updates playtime
  $('.ui.track.slider').slider('set value', ((seek / trk01.duration()) * 100) || 0); // Update slider postion
  // If the track is still playing, continue updating by calling function again.
  if (trk01.playing()) {
    requestAnimationFrame(progress);
  }
}


// Convert seconds to minutes & seconds for better display
function sec2mins(secs) {
  var minutes = Math.floor(secs / 60) || 0;
  var seconds = (secs - minutes * 60) || 0;
  return minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
}



// We need to set some listener events for our player control buttons.
playBtn.addEventListener('click', function() {
  playToggle();
});

volBtn.addEventListener('click', function() {
  mute();
});

$('.ui.vol.slider')
  .slider({
    min: 0,
    max: 1,
    start: 0.5,
    step: 0.1,
    smooth: true,
    onChange: function() {
      changeVol($(this).slider('get value'));
    }
  })
;


$('.ui.track.slider')
  .slider({
    min: 0,
    max: 100,
    start: 0,
    step: 1
//    onChange: function() {
//      seek($(this).slider('get value'));
//    }
  })
;
