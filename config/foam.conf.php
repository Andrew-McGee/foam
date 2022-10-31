<?php
  // Config file for foam web player. Just a standard php include that will pull in variables

  // Default login information that will be populated on the login form
  // If left blank then fields will be unpopulated except for placeholder hints
  $defHost = '';  // Eg. http://myhost.com or myampachehost.com or IP equivalent. Can include port number.
  $defUser = '';  // Eg. The Ampache username to default
  $defPass = '';  // Eg. The Ampache password to default use (WARN: this leaves it wide open for anyone to login)

  // Set the length of time a foam session cookie is remembered - default: 1 year
  $sessionTime = 365 * 24 * 3600;    // Seconds in 1 year
  // $sessionTime = 28 * 24 * 3600;  // Seconds in 4 weeks
  // $sessionTime = 7 * 24 * 3600;   // Seconds in 1 week
  // $sessionTime = 24 * 3600;       // Seconds in 1 day
  // $sessionTime = 3600;            // Seconds in 1 hour

  //Themes - some basic pre-set colour schemes
  $theme = array();

  // #01 Classic
  $theme[1]['name'] = 'Classic';     // Name
  $theme[1]['colrfgd1'] = '#2a2c41'; // Space Cadet
  $theme[1]['colrbgd1'] = '#556177'; // Manatee
  $theme[1]['colrfnt1'] = '#A5A5A5'; // Main grey text
  $theme[1]['colrfnt2'] = '#F5F5F5'; // WhiteSmoke - highlight text and headings
  $theme[1]['colrfnt3'] = '#556177'; // Manatee - Now playing text
  $theme[1]['colrhilt'] = '#1990db'; // Blue highlight

  // #02 Dark - Uncomment to use
  $theme[2]['name'] = 'Dark';     // Name
  $theme[2]['colrfgd1'] = '#27293D'; // Foreground
  $theme[2]['colrbgd1'] = '#1E1E2F'; // Background
  $theme[2]['colrfnt1'] = '#A5A5A5'; // Main text
  $theme[2]['colrfnt2'] = '#F5F5F5'; // Bright text
  $theme[2]['colrfnt3'] = '#707070'; // Dark text
  $theme[2]['colrhilt'] = '#0E6EB8'; // Highlight

  // #03 Mint - Uncomment to use
  $theme[3]['name'] = 'Mint';     // Name
  $theme[3]['colrfgd1'] = '#379683'; // Foreground
  $theme[3]['colrbgd1'] = '#4CBDA6'; // Background
  $theme[3]['colrfnt1'] = '#ADEBC5'; // Main text
  $theme[3]['colrfnt2'] = '#EDF5E1'; // Bright text
  $theme[3]['colrfnt3'] = '#05386B'; // Dark text
  $theme[3]['colrhilt'] = '#D1F5BE'; // Highlight

  // #04 Ampache - Uncomment to use
  $theme[4]['name'] = 'ampache-dark';     // Name
  $theme[4]['colrfgd1'] = '#222222'; // Foreground
  $theme[4]['colrbgd1'] = '#1D1D1D'; // Background
  $theme[4]['colrfnt1'] = '#888888'; // Main text
  $theme[4]['colrfnt2'] = '#ffffff'; // Bright text
  $theme[4]['colrfnt3'] = '#555555'; // Dark text
  $theme[4]['colrhilt'] = '#f49600'; // Highlight

  // #05 Ampache - Uncomment to use
  $theme[5]['name'] = 'ampache-light';     // Name
  $theme[5]['colrfgd1'] = '#f8f8f8'; // Foreground
  $theme[5]['colrbgd1'] = '#d8d8d8'; // Background
  $theme[5]['colrfnt1'] = '#000000'; // Main text
  $theme[5]['colrfnt2'] = '#1990db'; // Bright text
  $theme[5]['colrfnt3'] = '#ffffff'; // Dark text
  $theme[5]['colrhilt'] = '#1990db'; // Highlight
?>
