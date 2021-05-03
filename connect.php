<?php
// Verify login info for Ampache API and set cookies.
// If remember me was selected make cookie permanent otherwise limit lifespan with time().

if(!empty($_POST["remember"])) {
	setcookie ("host",$_POST["host"],time()+ 3600);
	setcookie ("name",$_POST["username"],time()+ 3600);
	setcookie ("pass",$_POST["password"],time()+ 3600);
	echo "Cookies Set Successfully";
} else {
	setcookie ("host",$_POST["host"],0;
	setcookie ("name",$_POST["username"],0;
	setcookie ("pass",$_POST["password"],0;
	echo "Cookies expire at end of session";
}

?>
