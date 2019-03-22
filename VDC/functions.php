<?php 

/* This here formats the ['HTTP_USER_AGENT'] data into a readable format */

function getOS() { 

	global $user_agent; 

	$os_platform = "Unknown OS Platform"; 

	$os_array = array( 
		'/windows nt 10.0/i' => 'Windows 10', 
		'/windows nt 6.3/i' => 'Windows 8.1', 
		'/windows nt 6.2/i' => 'Windows 8', 
		'/windows nt 6.1/i' => 'Windows 7', 
		'/windows nt 6.0/i' => 'Windows Vista', 
		'/windows nt 5.2/i' => 'Windows Server 2003/XP x64', 
		'/windows nt 5.1/i' => 'Windows XP', 
		'/windows xp/i' => 'Windows XP', 
		'/windows nt 5.0/i' => 'Windows 2000', 
		'/windows me/i' => 'Windows ME', 
		'/win98/i' => 'Windows 98', 
		'/win95/i' => 'Windows 95', 
		'/win16/i' => 'Windows 3.11', 
		'/macintosh|mac os x/i' => 'Mac OS X', 
		'/mac_powerpc/i' => 'Mac OS 9', 
		'/linux/i' => 'Linux', 
		'/ubuntu/i' => 'Ubuntu', 
		'/iphone/i' => 'iPhone', 
		'/ipod/i' => 'iPod', 
		'/ipad/i' => 'iPad', 
		'/android/i' => 'Android', 
		'/blackberry/i' => 'BlackBerry', 
		'/webos/i' => 'Mobile' 
	); 

	foreach ($os_array as $regex => $value) { 
		if (preg_match($regex, $user_agent)) {
			$os_platform = $value; 
		} 
	} 
	return $os_platform; 
	}
	
/* This here filters the ['HTTP_USER_AGENT'] data and grabs the browser type and version into a readable format */
	
function getBrowser() { 
    global $browser;
	$u_agent = $browser;
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version= "";

		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}

	/* Browser types */
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		}elseif(preg_match('/Firefox/i',$u_agent)){
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		}elseif(preg_match('/OPR/i',$u_agent)){
			$bname = 'Opera';
			$ub = "Opera";
		}elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
			$bname = 'Google Chrome';
			$ub = "Chrome";
		}elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
			$bname = 'Apple Safari';
			$ub = "Safari";
		}elseif(preg_match('/Netscape/i',$u_agent)){
			$bname = 'Netscape';
			$ub = "Netscape";
		}elseif(preg_match('/Edge/i',$u_agent)){
			$bname = 'Edge';
			$ub = "Edge";
		}elseif(preg_match('/Trident/i',$u_agent)){
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		}

	/* Browser version */
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	
		if (!preg_match_all($pattern, $u_agent, $matches)) {
    
		}

	$i = count($matches['browser']);
	
		if ($i != 1) {
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}else {
				$version= $matches['version'][1];
			}else {
				$version= $matches['version'][0];
			}
		}
		if ($version==null || $version==""){
			$version="?";
		}
	
	return array(
		'userAgent' => $u_agent,
		'name'      => $bname,
		'version'   => $version,
		'platform'  => $platform,
		'pattern'    => $pattern
	);
}
	

/* This here performs the IPGeolocation process by utilizing the geoplugin.net api */

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    global $user_ip;
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $user_ip;
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}
