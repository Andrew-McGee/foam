/*!
 * Player code for foam
 * Copyright Andrew McGee 2021
 */

const setVol = 1.0;
const muted = false;
var list = [];
var queue = [];

this.setVol = 0.5;

//Define some player functions

// Function called to begin playing the sound
function playnew(pointer) {

  var self = this;
  // If trk01 is defined something might be playing so just stop everything
  if (typeof trk01 !== 'undefined') {
    trk01.stop();
  }

  // We gotta get the track from the playlist based on our pointer
  track = this.queue[pointer][4];

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

  // Set up a trigger for end of song to do a bunch of stuff
  trk01.on('end', function(){
    // Need to check if there is another song in the queue - if yes load it - if no end
    document.getElementById("playBtn").className = "bordered play icon"; // change button back to play
    document.title = "foam"; // update doc title
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
  $('.ui.track.slider').slider('set value', ((seek / trk01.duration()) * 100) || 0); // Update ui slider postion
  // If the track is still playing, continue updating by calling function again.
  if (trk01.playing()) {
    requestAnimationFrame(progress);
  }
}

// Build a completely new queue if user clicked a new track from album or tracklist view
// Or user clicked Play or Shuffle buttons
// @param = number of which song in the playlist should be played (pointer)
function newQueue(pointer) {
  queue = []; // Empty the current queue array
  // Now lets copy the contents of the list array into our new queue array
  // loop through outer array and copy the 5 inner values
  for (var i = 0, l1 = this.list.length; i < l1; i++) {
    this.queue[i] = [];
    this.queue[i][0] = this.list[i][0]; // Track title
    this.queue[i][1] = this.list[i][1]; // Artist name
    this.queue[i][2] = this.list[i][2]; // duration
    this.queue[i][3] = this.list[i][3]; // art link
    this.queue[i][4] = this.list[i][4]; // song link
  }
  // Last call the playnew function to kick it off
  playnew(pointer); // Pass the pointer so he knows what track in the queue to play
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
