<html>
	<head>

<?php

/* Requires the functions that do the IP tracking and formatting of OS and Browser data. */

	Require 'functions.php';

/* Starts a session for the currently connecting user. */

	session_start(); 
		if( isset( $_SESSION['counter'] ) ) { 
			$_SESSION['counter'] += 1; 
		}else { 
			$_SESSION['counter'] = 1; 
        }

/* Queries the connecting host for IP, OS & Browser version */

	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$user_os = getOS(); 
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$user_browser = getBrowser();
	$user_ip = $_SERVER['REMOTE_ADDR'];
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$datetime = date("F j, Y, g:i a");
	$referrer = $_SERVER['HTTP_REFERER'];
	
	/* Only for use within domain environments */
	# $username = $_SERVER['REMOTE_USER'];

/* GeoIPLocation Tracking Data */

	$country = ip_info($user_ip, "Country"); 
	$countryCode = ip_info($user_ip, "Country Code"); 
	$state = ip_info($user_ip, "State"); 
	$city = ip_info($user_ip, "City"); 
	$address = ip_info($user_ip, "Address"); 

/* Formats the data into readable and easily understandable text */
	$udata = "\n" . '------User Data Collection------' . "\n"  . 'Date & time of Users Visit: ' . $datetime . "\n" . 'Visiting from: ' . $referrer . "\n" . 'Operating System: ' . $user_os . "\n" . 'Browser: ' . $user_browser['name'] . "\n" . 'Browser Version: ' . $user_browser['version'] . "\n" . 'Browser Platform: ' . $user_browser['platform'] . "\n" . $user_browser['userAgent'] . "\n" . "\n" . 'Users IP Address: ' . $user_ip . "\n" . 'Users Hostname: ' . $hostname . "\n" . "\n" . '--User Trace --' . "\n" . 'Country: ' . $country  . "\n" . 'Province or State: ' .  $state  . "\n" . 'City: ' . $city . "\n" . 'Full location: ' . $address . "\n" . "\n" . 'They have visited ' . $_SESSION['counter'] . ' times' . "\n" . "\n";

/* Adds the visitors data to the text file */
	file_put_contents("users.txt", $udata , FILE_APPEND);
	session_unset();
	session_destroy();
?>
<!-- Modify whatever is below here to suit your needs -->

	<title> </title>


<!-- Would recommend not removing this part as you should cover yourself for legal purposes -->
	<p><sub> This site uses cookies and tracks data to enhance users experience.</sub> 
