/*!
 * Code to control draggable items from the queue
 * Copyright Andrew McGee 2021 - foam web player
 */


let grabbedSong; // The grabbed song we are dragging
let spacer; // A spacer to drop the song onto
let dragging = false; // Flag to track dragging

// Initialise mouse co-ords
let x = 0;
let y = 0;

function swap(nodeA, nodeB) {
    const parentA = nodeA.parentNode;
    const siblingA = nodeA.nextSibling === nodeB ? nodeA : nodeA.nextSibling;

    // Move nodeA to before the nodeB
    nodeB.parentNode.insertBefore(nodeA, nodeB);

    // Move nodeB to before the sibling of nodeA
    parentA.insertBefore(nodeB, siblingA);
};

// Check if nodeA is above nodeB
function isAbove(nodeA, nodeB) {
    // Get the bounding rectangle of both nodes
    const rectA = nodeA.getBoundingClientRect();
    const rectB = nodeB.getBoundingClientRect();

    return (rectA.top + rectA.height / 2 < rectB.top + rectB.height / 2);
};

function mouseDownHandler(e) {
    grabbedSong = e.target.parentNode.parentNode;

    // Calculate the mouse position
    const rect = grabbedSong.getBoundingClientRect();
    //x = e.pageX - rect.left;
    y = e.pageY - (rect.top - 45);
    x = e.pageX;
    //y = e.pageY;

    // Create listeners for moving and releasing the mouse
    document.addEventListener('mousemove', mouseMoveHandler);
    document.addEventListener('mouseup', mouseUpHandler);
};

function mouseMoveHandler(e) {

    const draggingRect = grabbedSong.getBoundingClientRect();

    if (!dragging) {
        // Update our flag
        dragging = true;

        // Make the spacer the height of the song
        // So the next item won't move up
        spacer = document.createElement('div');
        spacer.classList.add('placeholder');
        grabbedSong.parentNode.insertBefore(
            spacer, grabbedSong.nextSibling);
        // Set the placeholder's height
        spacer.style.height = `${draggingRect.height}px`;
    }

    // Set position for grabbedSong
    grabbedSong.style.position = 'absolute';
    grabbedSong.style.top = `${e.pageY - y}px`;
    grabbedSong.style.left = `${e.pageX - x}px`;

    // The current order:
    // prevEle
    // grabbedSong
    // spacer
    // nextEle
    const prevEle = grabbedSong.previousElementSibling;
    const nextEle = spacer.nextElementSibling;

    // The dragging song is above the previous item
    // User drags song up the list
    if (prevEle && isAbove(grabbedSong, prevEle)) {
        // The current order    -> The new order
        // prevEle              -> spacer
        // grabbedSong          -> grabbedSong
        // spacer               -> prevEle
        swap(spacer, grabbedSong);
        swap(spacer, prevEle);
        return;
    }

    // The dragging song is below the next item
    // User drags song down the list
    if (nextEle && isAbove(nextEle, grabbedSong)) {
        // The current order    -> The new order
        // grabbedSong          -> nextEle
        // spacer               -> spacer
        // nextEle              -> grabbedSong
        swap(nextEle, spacer);
        swap(nextEle, grabbedSong);
    }
};

function mouseUpHandler() {
    // Get the id of the moved song and the id just above it
    var itemfrom = (grabbedSong.id.substr(5));
    var exists = grabbedSong.previousElementSibling.id;
    if (exists) {
      var itemto = (grabbedSong.previousElementSibling.id.substr(5));
    } else {
      var itemto = -1;
    }
    // Call function to re-write the queue in it's new order
    reorderQueue(itemfrom, itemto);

		// Cleanup the spacer
	  //spacer && spacer.parentNode.removeChild(spacer);

    // Clean up the position styles
    grabbedSong.style.removeProperty('top');
    grabbedSong.style.removeProperty('left');
    grabbedSong.style.removeProperty('position');

    x = null;
    y = null;
    grabbedSong = null;
    // Reset our flag
    dragging = false;

    // Clean up the mouse listeners
    document.removeEventListener('mousemove', mouseMoveHandler);
    document.removeEventListener('mouseup', mouseUpHandler);
};
