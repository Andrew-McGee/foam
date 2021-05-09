<?php
// Config file for foam web player. Just a standard php include that will pull in variables

// Set the length of time a foam session cookie is remembered - default: 1 year

$sessionTime = 365 * 24 * 3600; // Seconds in 1 year
// $sessionTime = 28 * 24 * 3600;  // Seconds in 4 weeks
// $sessionTime = 7 * 24 * 3600;   // Seconds in 1 week
// $sessionTime = 24 * 3600;       // Seconds in 1 day
// $sessionTime = 3600;            // Seconds in 1 hour

//Themes - some basic pre-set colour schemes
$theme = array();

// #01 Original
$theme[1][colrfgd1] = '#2a2c41'; // Space Cadet
$theme[1][colrbgd1] = '#556177'; // Manatee
$theme[1][colrfnt1] = '#A5A5A5'; // Main grey text
$theme[1][colrfnt2] = '#F5F5F5'; // WhiteSmoke - highlight text and headings
$theme[1][colrfnt3] = '#556177'; // Manatee - Now playing text
$theme[1][colrhilt] = '#0E6EB8'; // Blue highlight

// #02 New
$theme[2][colrfgd1] = '#2a2c41'; // Space Cadet
$theme[2][colrbgd1] = '#556177'; // Manatee
$theme[2][colrfnt1] = '#A5A5A5'; // Main grey text
$theme[2][colrfnt2] = '#F5F5F5'; // WhiteSmoke - highlight text and headings
$theme[2][colrfnt3] = '#556177'; // Manatee - Now playing text
$theme[2][colrhilt] = '#0E6EB8'; // Blue highlight

?>
