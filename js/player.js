/*!
 * Player code for foam
 * Copyright Andrew McGee 2021
 */

const setVol = 1.0;
const muted = false;
const pointer = 0;
var list = [];
var queue = [];

var upClass = 'toggle-up';
var downClass = 'toggle-down';

this.setVol = 0.5;

//Define some player functions

// Function called to begin playing the sound
function playnew(pointer) {

  var self = this;
  this.pointer = pointer; // save the parm in our permanent pointer
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

  // Update the album art, title and artist in the microplayer
  document.getElementById("playrThumb").src = this.queue[pointer][3];
  document.getElementById("playrTitle").textContent = this.queue[pointer][0];
  document.getElementById("playrArtist").textContent= this.queue[pointer][1];

  // Update the document title with the song and artist
  document.title = this.queue[pointer][0] + ' - ' + this.queue[pointer][1];

  // Update the length of track in the UI once it starts playing
  trk01.on('play', function(){
    document.getElementById("length").textContent = sec2mins(Math.round(trk01.duration()));
  // Start upating the progress slider and playtime of the track.
    requestAnimationFrame(progress);
  });

  // Call the queueDropdown function to write our queue to the dropdown menu with the new active track
  queueDropdown();

  // Set up a trigger for end of song to do a bunch of stuff
  trk01.on('end', function(){
    pointer++;
    // Need to check if there is another song in the queue - if yes load it - if no end
    if (pointer == queue.length) {
      // We're at the end so lets tidy up
      document.getElementById("playBtn").className = "bordered play icon"; // change button back to play
      document.title = "foam"; // update doc title back to default
      pointer = 0; // reset our position in the queue
    } else {
      // We're not finished the queue yet so lets keep going
      playnew(pointer);  // Call the playnew function again with our updated pointer
    }
  });
}

// Play or pause the sound
function playToggle() {

  // First check if Howler is already set up with a defined trk
  if (typeof trk01 !== 'undefined') {
    if (trk01.playing()) {
      trk01.pause(); // Pause the sound & show play button
      document.getElementById("playBtn").className = "bordered play icon";
    } else {
      trk01.play();  // Play the sound & show pause button
      document.getElementById("playBtn").className = "bordered pause icon";
    }
  } else {
    // Ok Howler is not set up but do we have a queue yet? If yes then playnew from position 0
    if (typeof this.queue[0] !== 'undefined') playnew('0');
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
// Or user clicked Play buttons
// @param = number of which song in the playlist should be played (pointer)
function newQueue(pointer) {
  queue = []; // Empty the current queue array
  this.pointer = pointer; // save the parm in our permanent pointer
  this.queue = [];  //Empty existing queue so we don't get old entries hanging over
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

// Build a shuffled queue if user clicked shuffle button
function shuffle(pointer) {
  queue = []; // Empty the current queue array
  this.pointer = pointer; // save the parm in our permanent pointer
  this.queue = [];  //Empty existing queue so we don't get old entries hanging over
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

  // Now we do some randomising to the queue array
  var currentIndex = this.queue.length, temporaryValue, randomIndex;
  // While there remain elements to shuffle...
  while (0 !== currentIndex) {
    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;
    // And swap it with the current element.
    temporaryValue = queue[currentIndex];
    queue[currentIndex] = queue[randomIndex];
    queue[randomIndex] = temporaryValue;
  }
  // Last call the playnew function to kick it off
  playnew(pointer); // Pass the pointer so he knows what track in the queue to play
}

// Add a single track to the end of teh existing queue
function addT2Q(pointer) {
  var newtrk = this.queue.length; // Determine the next entry at end of the queue array

  // Now lets copy the list entry into our new queue entry
  this.queue[newtrk] = [];
  this.queue[newtrk][0] = this.list[pointer][0]; // Track title
  this.queue[newtrk][1] = this.list[pointer][1]; // Artist name
  this.queue[newtrk][2] = this.list[pointer][2]; // duration
  this.queue[newtrk][3] = this.list[pointer][3]; // art link
  this.queue[newtrk][4] = this.list[pointer][4]; // song link

  // Call the queueDropdown function to re-write our queue to the dropdown menu with the new track
  queueDropdown();
}

// Insert a track into existing queue in the next playable position
function playNext(pointer) {
  var newtrk = this.pointer + 1; // Determine the next entry after the one currently playing

  this.queue.splice(newtrk, 0, this.list[pointer]);

  // Call the queueDropdown function to re-write our queue to the dropdown menu with the new track
  queueDropdown();
}

// Skip next function
function next() {
  if (this.pointer == this.queue.length - 1) {
    // We're at the end so lets stop playback
    trk01.stop();
    // Do some tidy up
    document.getElementById("playBtn").className = "bordered play icon"; // change button back to play
    document.title = "foam"; // update doc title back to default
    this.pointer = 0; // reset our position in the queue
  } else {
    this.pointer++;
    playnew(this.pointer);
  }
}

// Skip prev function
function prev() {
  // Check if we've been playing for 5 seconds if so just rewind this song
  if (trk01.seek() >= 5) {
    playnew(this.pointer); // Just start playback again with current pointer
  } else {
    if (this.pointer !== 0) this.pointer--; // Decrement the pointer to the previous song if it's not at the start
    playnew(this.pointer);
  }
}

// Convert seconds to minutes & seconds for better display
function sec2mins(secs) {
  var minutes = Math.floor(secs / 60) || 0;
  var seconds = (secs - minutes * 60) || 0;
  return minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
}

// Function to update the active menu item on side menu (called from iframe)
function activeMenu(activeitem) {
  for (var i = 1; i <= 9; i++) {
    if (activeitem == i) {
      document.getElementById("item"+i).className = "active item";
    } else {
      document.getElementById("item"+i).className = "item";
    }
  }
}

// Function to dynamically build the queue dropdown list
function queueDropdown() {
  var items = '';
  for (var i = 0, l1 = this.queue.length; i < l1; i++) {
    if (this.pointer == i) {
      items = items + '<div class="item"><div class="ui small space header"><i class="tiny play space icon"></i>' + this.queue[i][0] +
      ' - ' + this.queue[i][1]  + '</div></div>';
    } else {
      items = items + '<div class="item" onclick="playnew(' + i + ')">' + this.queue[i][0] + ' - ' + this.queue[i][1]  + '</div>';
    }
  }
  document.getElementById("queueMenu").innerHTML = items;
}

// We need to set some listener events for our player control buttons.
playBtn.addEventListener('click', function() {
  playToggle();
});

volBtn.addEventListener('click', function() {
  mute();
});

frwdBtn.addEventListener('click', function() {
  next();
});

backBtn.addEventListener('click', function() {
  prev();
});

queueBtn.addEventListener('click', function() {
  var icon = document.getElementById('queueBtn');

  if (~icon.className.indexOf(downClass)) {
    icon.className = icon.className.replace(downClass, upClass);
  } else {
    icon.className = icon.className.replace(upClass, downClass);
  }
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
