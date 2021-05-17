<?php header("Content-type: text/css; charset: UTF-8");
/*
  Name: settheme.php 2021
  Description: Simple layout for Fomantic UI Ampache web player - foam
*/
include 'foam.conf.php';

  // Let's check the cookie is set
  if (isset($_COOKIE["theme"])) {
    $pref = $_COOKIE["theme"];
  } else {
    $pref = 1;
  }
  if ($pref - 1 > count($theme)) $pref = 1;

/** Set up root varaibles for theme colours **/

echo 	"	:root {";
echo	"		--colrfgd1: " . $theme[$pref]['colrfgd1'] . "; \r\n";
echo 	"		--colrbgd1: " . $theme[$pref]['colrbgd1'] . "; \r\n";
echo	"		--colrfnt1: " . $theme[$pref]['colrfnt1'] . "; \r\n";
echo	"		--colrfnt2: " . $theme[$pref]['colrfnt2'] . "; \r\n";
echo	"		--colrfnt3: " . $theme[$pref]['colrfnt3'] . "; \r\n";
echo 	"		--colrhilt: " . $theme[$pref]['colrhilt'] . "; \r\n";
echo 	"	}";

?>
