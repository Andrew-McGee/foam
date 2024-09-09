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

var paused = false;
var seeking = false;
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
    volume: [this.setVol],
    onplay: function() {
      // Update the track length indicator - do some math to round to minutes from seconds
      document.getElementById("length").textContent = sec2mins(Math.round(trk01.duration()));
      // Start the spectograph animation
      specto('on');
      // Start upating the progress slider and playtime of the track.
      requestAnimationFrame(progress);
    },
    onseek: function() {
      // Start upating the progress slider and playtime of the track.
      requestAnimationFrame(progress);
    }
  });

  // Play the sound
  trk01.play();

  // Show the pause button.
  document.getElementById("playBtn").className = "bordered pause icon";

  // Update the album art, title and artist in the microplayer
  document.getElementById("playrThumb").src = this.queue[pointer][3];
  document.getElementById("albmLink").href = 'album_view.php?uid='  + this.queue[pointer][5];
  document.getElementById("playrTitle").textContent = this.queue[pointer][0];
  document.getElementById("playrArtist").textContent= this.queue[pointer][1];

  // Update the document title with the song and artist
  document.title = this.queue[pointer][0] + ' - ' + this.queue[pointer][1];

  // Call the queueDropdown function to write our queue to the dropdown menu with the new active track
  queueDropdown();

  // Set up a trigger for end of song to do a bunch of stuff
  trk01.on('end', function(){
    pointer = parent.pointer;
    pointer++; // Increment our pointer to the next song in queue

    // Need to check if there is another song in the queue - if yes load it - if no end
    if (pointer == queue.length) {
      // We're at the end so lets just tidy up
      document.getElementById("playBtn").className = "bordered play icon"; // change button back to play
      document.title = "foam"; // update doc title back to default
      parent.pointer = 0; // reset our position in the queue back to the start
      trk01.unload(); // Unload the track from howler to free up mem
      specto('off');      // Stop the spectograph animation
    } else {
      trk01.unload(); // Unload the track from howler to free up mem
      specto('off');      // Stop the spectograph animation
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
      parent.pause = true;
      trk01.pause(); // Pause the sound & show play button
      document.getElementById("playBtn").className = "bordered play icon";
      specto('off');      // Stop the spectograph animation
    } else {
      if (parent.pause === true) {
        parent.pause = false;
        trk01.play();  // Play the sound & show pause button
        document.getElementById("playBtn").className = "bordered pause icon";
      } else {
        playnew('0');  // We weren't paused so must have stopped - playnew from the top
      }
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
  // Only call howler if trk01 is defined otherwise don't call but just save the vol
  if (typeof trk01 !== 'undefined') {
    trk01.volume(newVol);
  }
  this.setVol = newVol;
}

// Start or stop the spectograph
function specto(state) {
  if (state == 'on') {
    document.getElementById("specto1").className = "spectrograph__bar";
    document.getElementById("specto2").className = "spectrograph__bar";
    document.getElementById("specto3").className = "spectrograph__bar";
    document.getElementById("specto4").className = "spectrograph__bar";
    document.getElementById("specto5").className = "spectrograph__bar";
  } else {
    document.getElementById("specto1").className = "spectrograph__off";
    document.getElementById("specto2").className = "spectrograph__off";
    document.getElementById("specto3").className = "spectrograph__off";
    document.getElementById("specto4").className = "spectrograph__off";
    document.getElementById("specto5").className = "spectrograph__off";
  }
}

// Update progress slider and play time - recursive anim function called within requestAnimationFrame
function progress() {
  var seek = trk01.seek() || 0;
  document.getElementById("timer").textContent = sec2mins(Math.round(seek)); // Updates playtime
  // Only update the slider anim if we are not mouse over it so we can grab the slider thumb
  if (seeking === false) {
    $('.ui.track.slider').slider('set value', ((seek / trk01.duration()) * 100) || 0); // Update ui slider postion
  }
  // If the track is still playing, continue updating anim by calling function again.
  if (trk01.playing()) {
    requestAnimationFrame(progress);
  }
}

// Build a completely new queue if user clicked track from album or tracklist or Play button
function newQueue(pointer) {
  this.pointer = pointer; // save the parm in our permanent pointer
  this.queue = [];  //Empty existing queue so we don't get old entries hanging over
  // loop through outer array and copy the 6 inner list values to queue
  for (var i = 0, l1 = this.list.length; i < l1; i++) {
    this.queue[i] = [];
    this.queue[i][0] = this.list[i][0]; // Track title
    this.queue[i][1] = this.list[i][1]; // Artist name
    this.queue[i][2] = this.list[i][2]; // duration
    this.queue[i][3] = this.list[i][3]; // art link
    this.queue[i][4] = this.list[i][4]; // song link
    this.queue[i][5] = this.list[i][5]; // album id
    this.queue[i][6] = this.list[i][6]; // song id
  }
  // Last call the playnew function to kick it off
  playnew(pointer); // Pass the pointer so he knows what track in the queue to play
}

// Build a shuffled queue if user clicked shuffle button
function shuffle(pointer) {
  this.pointer = pointer; // save the parm in our permanent pointer
  this.queue = [];  //Empty existing queue so we don't get old entries hanging over
  // loop through outer array and copy the 6 inner list values to queue
  for (var i = 0, l1 = this.list.length; i < l1; i++) {
    this.queue[i] = [];
    this.queue[i][0] = this.list[i][0]; // Track title
    this.queue[i][1] = this.list[i][1]; // Artist name
    this.queue[i][2] = this.list[i][2]; // duration
    this.queue[i][3] = this.list[i][3]; // art link
    this.queue[i][4] = this.list[i][4]; // song link
    this.queue[i][5] = this.list[i][5]; // album id
    this.queue[i][6] = this.list[i][6]; // song id
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

// Build a completely new queue and add a single track
function newSingle(pointer) {
  this.pointer = pointer; // save the parm in our permanent pointer
  this.queue = [];  //Empty existing queue so we don't get old entries hanging over
  // Now lets copy the list entry into our new queue entry
  this.queue[0] = [];
  this.queue[0][0] = this.list[pointer][0]; // Track title
  this.queue[0][1] = this.list[pointer][1]; // Artist name
  this.queue[0][2] = this.list[pointer][2]; // duration
  this.queue[0][3] = this.list[pointer][3]; // art link
  this.queue[0][4] = this.list[pointer][4]; // song link
  this.queue[0][5] = this.list[pointer][5]; // album id
  this.queue[0][6] = this.list[pointer][6]; // song id
  // Last call the playnew function to kick it off
  playnew('0'); // There's only one song in the queue so always pass 0 as the pointer
}

// Add a single track to the end of the existing queue
function addT2Q(pointer) {
  var newtrk = this.queue.length; // Determine the next entry at end of the queue array
  // Now lets copy the list entry into our new queue entry
  this.queue[newtrk] = [];
  this.queue[newtrk][0] = this.list[pointer][0]; // Track title
  this.queue[newtrk][1] = this.list[pointer][1]; // Artist name
  this.queue[newtrk][2] = this.list[pointer][2]; // duration
  this.queue[newtrk][3] = this.list[pointer][3]; // art link
  this.queue[newtrk][4] = this.list[pointer][4]; // song link
  this.queue[newtrk][5] = this.list[pointer][5]; // album id
  this.queue[newtrk][6] = this.list[pointer][6]; // song id
  queueDropdown(); // Call queueDropdown() to re-write our dropdown menu with the new track
}

// Add all tracks from an album or playlist to the end of the existing queue
function addAll2Q() {
  var newpos = this.queue.length; // Determine the next entry at end of the queue array
  // loop through outer array and copy the 5 inner list values to queue
  for (var i = 0, l1 = this.list.length; i < l1; i++) {
    this.queue[newpos] = [];
    this.queue[newpos][0] = this.list[i][0]; // Track title
    this.queue[newpos][1] = this.list[i][1]; // Artist name
    this.queue[newpos][2] = this.list[i][2]; // duration
    this.queue[newpos][3] = this.list[i][3]; // art link
    this.queue[newpos][4] = this.list[i][4]; // song link
    this.queue[newpos][5] = this.list[i][5]; // album id
    this.queue[newpos][6] = this.list[i][6]; // song id
    newpos++;
  }
  queueDropdown(); // Call queueDropdown() to re-write our dropdown menu with the new track
}

// Insert a track into existing queue in the next playable position
function playNext(song) {
  var newtrk = this.pointer + 1; // Determine the next entry after the one currently playing
  this.queue.splice(newtrk, 0, this.list[song]); // Use splice() to insert into array
  queueDropdown(); // Call queueDropdown() to re-write our dropdown menu with the new track
}

// Insert all tracks from album or playlist into existing queue in the next playable position
function playAllNext() {
  var newtrk = this.pointer + 1; // Determine the next entry after the one currently playing
  this.queue.splice(newtrk, 0, ...this.list); // Use splice() to insert into array
  queueDropdown(); // Call queueDropdown() to re-write our dropdown menu with the new track
}

// Skip next function
function next() {

  if (parent.pointer == parent.queue.length - 1) {
    // We're at the end so lets stop playback
    trk01.stop();
    // Do some tidy up
    document.getElementById("playBtn").className = "bordered play icon"; // change button back to play
    document.title = "foam"; // update doc title back to default
    parent.pointer = 0; // reset our position in the queue
  } else {
    parent.pointer++;
    playnew(parent.pointer);
  }
}

// Skip prev function
function prev() {
  // Check if we've been playing for 5 seconds if so just rewind this song, if not decrement pointer to previous song
  if (trk01.seek() >= 5) {
    playnew(parent.pointer); // Just start playback again with current pointer
  } else {
    if (parent.pointer !== 0) parent.pointer--; // Decrement the pointer to the previous song if it's not at first song
    playnew(parent.pointer);
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
  var items = '<div class="item"><center><button class="ui tiny basic button" onclick="clearQueue()">CLEAR</button>&nbsp;';
  var items = items + '<button class="ui tiny basic button" onclick="saveQueue()">SAVE</button></center></div>';
  for (var i = 0, l1 = this.queue.length; i < l1; i++) {
    if (this.pointer == i) {
      items = items + '<div class="item" id="qitem' + i + '">';
      items = items + '<div class="ui small space header"><i class="tiny play space icon"></i>' + this.queue[i][0] +
      ' - ' + this.queue[i][1]  + '</div></div>';
    } else {
      items = items + '<div class="item queue-row" id="qitem' + i + '">';
      items = items +     '<span class="draggable"><i class="hidden sort icon" id="sort' + i + '"></i></span>';
      items = items +     '<span onclick="playnew(' + i + ')">' + this.queue[i][0] + ' - ' + this.queue[i][1] + '</span>';
      items = items +     '<span>&nbsp;&nbsp;<i onclick="delTFQueue(' + i + ')" class="hidden trash icon" id="trash' + i + '"></i></span>';
      items = items + '</div>';
    }
  }
  document.getElementById("queueMenu").innerHTML = items;

  // Note: Remaining dragging functions are all in dragger.js
  // Get all the queue elements
  const queueItems = document.getElementById('queueMenu');

  // Build a listener for each of our draggable menu items in the queue
  Array.from(queueItems.querySelectorAll('.draggable')).forEach(function(item) {
    item.addEventListener('mousedown', mouseDownHandler);
  });
}

// Reorder the queue
function reorderQueue(oldPos, newPos) {

  // If we insert a new item into the queue above pointer make sure we shift it correctly
  if ((oldPos > this.pointer) && (newPos <= this.pointer)) this.pointer++;

  // If we remove an item from the queue above pointer make sure we shift it correctly
  if ((oldPos < this.pointer) && (newPos >= this.pointer)) this.pointer--;

  this.queue.splice(newPos, 0, this.queue.splice(oldPos, 1)[0]);

  queueDropdown(); // Call queueDropdown() to re-write our dropdown menu with the new track

}

// Save the queue
function saveQueue() {
	$('.pfromq.ui.modal')
	  .modal({
	     onApprove : function() {
         var songs = "";
	       var nn = document.getElementById('newname').value;
         for (var i = 0, l1 = parent.queue.length; i < l1; i++) {
           songs = songs + "&songs[]=" + parent.queue[i][6];
         }
	       $.get("includes/playlistfromqAPI.php?filter=" + nn + songs);
	     }
	   })
	  .modal('show')
	;
}

// Delete a single track from the queue
function delTFQueue(song) {
  if (this.queue.length == 1) {
    clearQueue();
  } else {
    if (song < this.pointer) this.pointer--; // If we remove a song before the pointer make sure we shift it correctly
    this.queue.splice(song, 1); // Use splice() to remove 1 element from array
    queueDropdown(); // Call queueDropdown() to re-write new queue with track removed
  }
}

// Clear the queue
function clearQueue() {
  this.queue = [];  //Empty existing queue
  items = '<div class="active item">No Music Here!</div>';
  document.getElementById("queueMenu").innerHTML = items;
}
// End of functions - mainline below

// We need to set some listener events for our player control buttons.
playBtn.addEventListener('click', playToggle);

volBtn.addEventListener('click', mute);

frwdBtn.addEventListener('click', next);

backBtn.addEventListener('click', prev);

queueBtn.addEventListener('click', function() {
  var icon = document.getElementById('queueBtn');

  if (~icon.className.indexOf(downClass)) {
    icon.className = icon.className.replace(downClass, upClass);
  } else {
    icon.className = icon.className.replace(upClass, downClass);
  }
});

track1.addEventListener('mouseover', function() {
  // If we mouse over the track slider set a flag to stop updating the slider animation
  seeking = true;
});

track1.addEventListener('mouseout', function() {
  // If we mouse off the track slider set a flag to resume updating the slider animation
  seeking = false;
});

// Some jquery to set up sliders with callbacks
$('.ui.vol.slider')
  .slider({
    min: 0,
    max: 1,
    start: 0.5,
    step: 0.1,
    smooth: true,
    onMove: function(value) {
      changeVol(value);
    }
  })
;

$('.ui.track.slider')
  .slider({
    min: 0,
    max: 100,
    start: 0,
    step: 1,
    onChange: function(value) {
      if (seeking === true) {
        var pos = (value / 100) * trk01.duration();
        trk01.seek(pos);
      }
    }
  })
;
