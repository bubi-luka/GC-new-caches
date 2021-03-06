<?php

/**
	This part is used to find script settings. It looks for a valid configuration file.
	If there is none it aborts with error. If there is one it is read and than it 
	sets the variables that are uset through the script.
**/

// Define variables
$geocaching_url = "";
$users = "";
$from_email = "";
$reply_email = "";
$admin_email = "";
$backups = "";
$debug_mode = "";
$email_mode = "";
$send_every_email = "";
$log_every_run = "";
$script_status = "";

// Look for config.php file, send error if there is none.
if ( !file_exists("config.php") ) {
	exit("Error! Please save yor configuration settings into config.php file!");
}
// if the file exists read it and find all the variables
else {
	$settings = fopen("config.php", "r") or exit("The configuration file can not be read!");
	while ( !feof($settings) ) {
		$line = trim(fgets($settings));
		if ( strstr($line, "geocaching-url: ") ) {
			if ( !strstr($line, "#") ) {
				$geocaching_url = str_replace("geocaching-url: ", "", $line);
			}
		}
		if ( strstr($line, "users: ") ) {
			if ( !strstr($line, "#") ) {
				$users = str_replace("users: ", "", $line);
			}
		}
		if ( strstr($line, "from-email: ") ) {
			if ( !strstr($line, "#") ) {
				$from_email = str_replace("from-email: ", "", $line);
			}
		}
		if ( strstr($line, "reply-email: ") ) {
			if ( !strstr($line, "#") ) {
				$reply_email = str_replace("reply-email: ", "", $line);
			}
		}
		if ( strstr($line, "backups: ") ) {
			if ( !strstr($line, "#") ) {
				$backups = str_replace("backups: ", "", $line);
			}
		}
		if ( strstr($line, "debug-mode: ") ) {
			if ( !strstr($line, "#") ) {
				$debug_mode = str_replace("debug-mode: ", "", $line);
			}
		}
		if ( strstr($line, "email-mode: ") ) {
			if ( !strstr($line, "#") ) {
				$email_mode = str_replace("email-mode: ", "", $line);
			}
		}
		if ( strstr($line, "send-every-email: ") ) {
			if ( !strstr($line, "#") ) {
				$send_every_email = str_replace("send-every-email: ", "", $line);
			}
		}
		if ( strstr($line, "log-every-run: ") ) {
			if ( !strstr($line, "#") ) {
				$log_every_run = str_replace("log-every-run: ", "", $line);
			}
		}
		if ( strstr($line, "admin-email: ") ) {
			if ( !strstr($line, "#") ) {
				$admin_email = str_replace("admin-email: ", "", $line);
			}
		}
	}
}

// strip ";" character
$geocaching_url = str_replace(";", "", $geocaching_url);
$users = str_replace(";", "", $users);
$from_email = str_replace(";", "", $from_email);
$reply_email = str_replace(";", "", $reply_email);
$backups = str_replace(";", "", $backups);
$debug_mode = str_replace(";", "", $debug_mode);
$email_mode = str_replace(";", "", $email_mode);
$send_every_email = str_replace(";", "", $send_every_email);
$log_every_run = str_replace(";", "", $log_every_run);
$admin_email = str_replace(";", "", $admin_email);

// When method GET is used it overrides manual settings
if ( isset($_GET['dm']) ) {
	$debug_mode = $_GET['dm'];
}
if ( isset($_GET['email']) ) {
	$email_mode = $_GET['email'];
}
?>

<?php if ( $debug_mode == "1" ) : ?>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Preverjanje</title>
	</head>
<body>
<?php endif; ?>

<?php
// Check if variables contains any data
if ( $debug_mode == "1" ) {
	echo "<h2>Checking variables</h2>\n";
}
if ( $geocaching_url == "" ) {
	exit("<p>geocaching_url contains no valid data!</p>\n");
}
else if ( $users == "" ) {
	exit("<p>users contains no valid data!</p>\n");
}
else if ( $from_email == "" ) {
	exit("<p>from_email contains no valid data!</p>\n");
}
else if ( $reply_email == "" ) {
	exit("<p>reply_email contains no valid data!</p>\n");
}
else if ( $backups == "" ) {
	exit("<p>backups contains no valid data!</p>\n");
}
else if ( $debug_mode == "" ) {
	exit("<p>debug_mode contains no valid data!</p>\n");
}
else if ( $email_mode == "" ) {
	exit("<p>email_mode contains no valid data!</p>\n");
}
else if ( $send_every_email == "" ) {
	exit("<p>send_every_email contains no valid data!</p>\n");
}
else if ( $log_every_run == "" ) {
	exit("<p>log_every_run contains no valid data!</p>\n");
}
else if ( $admin_email == "" ) {
	exit("<p>admin_email contains no valid data!</p>\n");
}
else {
	if ( $debug_mode == "1" ) {
		echo "<p>Everything is set as it should be.</p>\n";
	}
}
?>

<?php
if ( $debug_mode == "1" ) {
	echo "<h1>GC script run in debug mode</h1>\n";
	echo "<h2>Read variables</h2>\n";
	echo "<ul>\n";
	echo "<li>geocaching_url: " . $geocaching_url . "</li>\n";
	echo "<li>users: " . $users . "</li>\n";
	echo "<li>from_email: " . $from_email . "</li>\n";
	echo "<li>reply_email: " . $reply_email . "</li>\n";
	echo "<li>backups: " . $backups . "</li>\n";
	echo "<li>debug_mode: " . $debug_mode . "</li>\n";
	echo "<li>email_mode: " . $email_mode . "</li>\n";
	echo "<li>send_every_email: " . $send_every_email . "</li>\n";
	echo "<li>log_every_run: " . $log_every_run . "</li>\n";
	echo "<li>admin-email: " . $admin_email . "</li>\n";
	echo "</ul>";
}
?>

<?php
// If log for this day is not found, we send the last log to the administrator
$today = getdate();
if ( !file_exists($today['year'] . "-" . $today['mon'] . "-" . $today['mday'] . ".log") ) {
	$yesterday = date("Y-n-j", time() - (60*60*24) ) . ".log";
	if ( $debug_mode == "1" ) {
		echo "<h2>Sending yesterday's log file to the administrator</h2>";
	}
	$user = $admin_email;
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "From: " . $from_email . "\r\n";
	$headers .= "Reply-To: " . $reply_email . "\r\n";
	$message = "Prilagam včerajšnjo log datoteko:<br />\r\n";
	$message .= "<ol>\r\n";
	$yesterday_log = fopen($yesterday, "r") or exit ("<p>The yesterday's log can not be opened!</p>\n");
	while ( !feof($yesterday_log) ) {
		$message .= "<li>" . fgets($yesterday_log) . "</li>\r\n"; // each line contains one cache
	}
	fclose($yesterday_log);
	$message .= "</ol>\r\n";
	$subject = "GC Script: Log from yesterday!";
	mail($user, $subject, $message, $headers);
	if ( $debug_mode == "1" ) {
		echo "The log was send!<p>\n";
	}
}
?>

<?php
// We use third party script to extract interesting information from GC homepage
include('simple_html_dom.php');

// WE open the database and read it's content (caches data)
$datoteka = fopen("base", "r") or exit ("<p>The database can not be opened!</p>\n");
while ( !feof($datoteka) ) {
	$vrstice[] = trim(fgets($datoteka)); // each line contains one cache
}
fclose($datoteka);

$baza_st_zapisov = strval(count($vrstice));
if ( $debug_mode == "1" ) {
	echo "<h2>Read Database</h2>\n";
	echo "<p>Database contains {$baza_st_zapisov} entries.</p>\n";
}

// Link to the web page
$html = file_get_html($geocaching_url);

// We look for titles on the web page
$i = 0;
foreach($html->find('tr.Data') as $article) {

  if ( $article->find('span.small', 0)->plaintext != "" ) {
    $naslovi[] = trim($article->find('td.Merge span', 0)->plaintext); // we search for cache's data
    $url[] = "http://www.geocaching.com" . trim($article->find('a.lnk', 0)->href);
    list($owner[], $cache_id[], $country[]) = split(' \| ', preg_replace('/(?:\s\s+|\n|\t)/', ' ', trim($article->find('span.small', 1)->plaintext)));
    $date[] = trim($article->find('span.small', 1)->plaintext);
    // if the cache does not exist in the database, we add it to the list of new caches
    if ( !in_array($cache_id[$i], $vrstice) ) {
			  $novosti[] = $i;
    }
    $i++;
	 }
	
}

$stran_st_zapisov = strval(count($naslovi));
$stran_st_novih_zapisov = strval(count($novosti));
if ( $debug_mode == "1" ) {
	echo"<h2>Read The Site: </h2>";
	echo "<p>The site contains {$stran_st_zapisov} entries.</p>\n";
	echo "<p>The site contains {$stran_st_novih_zapisov} new entries.</p>\n";
}

// We set the starting and final point of the loop, that will write all new caches to the page
$i = 0;
$i_max = count($novosti); 

// In case of new caches we create database backup and write new data in the database
if ( $i_max >> 0 ) {
	// We set the script status to 1 => new caches were found
	$script_status = "1";
	
	// We start the loop that will write all new caches to the web page.
	if ( $debug_mode == "1" ) {
		echo "<h2>New caches</h2>\n";
		echo "<table>\n";
		for ( $i; $i <= $i_max - 1; $i++ ) {
			$zaporedna = $novosti[$i];
			$this_owner = substr($owner[$zaporedna], -strlen($owner[$zaporedna]) + 3);
			echo "<tr>\n";
			echo "<td>" . ($i + 1) . "</td>\n";
			echo "<td>" . "<a href=\"$url[$zaporedna]\">$cache_id[$zaporedna]</a>" . "</td>\n";
			echo "<td>" . "<a href=\"$url[$zaporedna]\">$naslovi[$zaporedna]</a>" . "</td>\n";
			echo "<td>" . $this_owner . "</td>\n";
			echo "<td>" . $date[$zaporedna] . "</td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
	}

	// We create database backup
	if ( $debug_mode == "1" ) {
		echo "<h2>Creating new database</h2>\n";
		echo "<p>Since the database is outdated, we will create fresh one.</p>\n";
	}
	$ime_kopije = "base-".$today['year']."-".$today['mon']."-".$today['mday']."-".$today['hours']."-".$today['minutes']."-".$today['seconds'].".bck";
	if ( $backups == "1" ) {
		$varnostna_kopija = fopen($ime_kopije, 'w') or die("<p>Can not create backup copy of a database!</p>\n");
		for ( $i = 0; $i <= $$baza_st_zapisov; $i++ ) {
			fwrite($varnostna_kopija, $vrstice[$i]."\n");
		}
		fclose($varnostna_kopija);
		if ( $debug_mode == "1" ) {
			echo "<p>Backup copy of a database was created!</p>\n";
		}
	}
	
	// We delete the old database to create fresh one
	unlink("base");
	if ( $debug_mode == "1" ) {
		echo "<p>Database was deleted!</p>\n";
	}
	
	// We create fresh database
	$nova_baza = fopen("base", 'w') or die("<p>Can not create new database</p>\n");
	for ( $i = 0; $i <= $stran_st_zapisov; $i++ ) {
		fwrite($nova_baza, $cache_id[$i]."\n");
	}
	fclose($nova_baza);
	if ( $debug_mode == "1" ) {
		echo "<p>New, fresh database was created!</p>\n";
	}
	
	// We send email notices for new caches to the users on the list
	if ( $email_mode == "1" ) {
		$user = $users;
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
		$headers .= "From: " . $from_email . "\r\n";
		$headers .= "Reply-To: " . $reply_email . "\r\n";
		$message = "Nova posodobitev statusa se je zgodila. Naslovi so:<br />\r\n";
		$message .= "<table>\r\n";
		for ( $i = 0; $i <= $i_max - 1; $i++ ) {
			$zaporedna = $novosti[$i];
			$this_owner = substr($owner[$zaporedna], -strlen($owner[$zaporedna]) + 3);
			$message .= "<tr>\r\n";
			$message .= "<td>" . ($i + 1) . "</td>\r\n";
			$message .= "<td>" . "<a href=\"$url[$zaporedna]\">$cache_id[$zaporedna]</a>" . "</td>\r\n";
			$message .= "<td>" . "<a href=\"$url[$zaporedna]\">$naslovi[$zaporedna]</a>" . "</td>\r\n";
			$message .= "<td>" . $this_owner . "</td>\r\n";
			$message .= "<td>" . $date[$zaporedna] . "</td>\r\n";
			$message .= "</tr>\r\n";
		}
		$message .= "</table>\r\nUspešen lov.<br />\r\n";
		$message .= "<p><small>Če imate kakšne predloge ali pa težave pri uporabi programa, ";
		$message .= "mi to prosim sporočite kar prek <a href=\"https://github.com/bubi-luka/GC-new-caches/issues/new\">";
		$message .= "GitHub spletne strani</a> (morda se boste morali brezplačno prijaviti). Hvala!</small></p>\r\n";
		$subject = "Na GC strani so objavljeni novi zakladi!";
		mail($user, $subject, $message, $headers);
		if ( $debug_mode == "1" ) {
			echo "<p>The message for new caches was send!<p>\n";
		}
	}
}
else {
	// We set the script status to 0 => no new caches were found
	$script_status = "0";
	
	// We send notices for no new caches to the users on the list
	if ( $send_every_email == "1" ) {
		$user = $users;
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
		$headers .= "From: " . $from_email . "\r\n";
		$headers .= "Reply-To: " . $reply_email . "\r\n";
		$message = "Žal boste danes kar doma.<br />\r\n";
		$subject = "GC skripta ni našla nobenih posodobitev!";
		mail($user, $subject, $message, $headers);
		if ( $debug_mode == "1" ) {
			echo "The message for no updates was send!<p>\n";
		}
	}
}

// we log current date and time with the resulting status of the script into log file
if ( $log_every_run == "1" ) {

	$ime_loga = $today['year'] . "-" . $today['mon'] . "-" . $today['mday'] . ".log";
	
	$logiranje = fopen($ime_loga, 'a') or die("<p>Can not create log file!</p>\n");
	fwrite($logiranje, $today['mday'] . "." . $today['mon'] . "." .$today['year'] . "\t" . $today['hours'] . ":" . $today['minutes'] . ":" . $today['seconds'] . "\t" . $script_status . "\n");
	fclose($logiranje);
	
	if ( $debug_mode == "1" ) {
		echo "<p>The log entry was created with status " . $script_status . "!</p>\n";
	}
}

if ( $debug_mode == "1" ) {
	echo "<h2>Finish</h2>\n";
	echo "<p>The script finished successfully!</p>\n";
}
?>
<?php if ( $debug_mode == "1" ) : ?>
</body>
</html>
<?php endif; ?>
