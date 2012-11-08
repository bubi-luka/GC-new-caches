<html>
	<head>
		<title>Preverjanje</title>
	</head>
<body>
<?
// Za razbiranje spletnih strani uporabimo zunanjo skripto
include('simple_html_dom.php');

// Odpremo bazo naslovov novih zakladov
$datoteka = fopen("base", "r") or exit ("Baze naslovov ni bilo moč odpreti");
while ( !feof($datoteka) ) {
	$vrstice[] = trim(fgets($datoteka)); // vsaka vrstica je svoj naslov
}
fclose($datoteka);

$baza_st_zapisov = strval(count($vrstice));
echo "Baza vsebuje {$baza_st_zapisov} zapisov.<br />";

// Povezava do spletne strani
$html = file_get_html('http://www.geocaching.com/seek/nearest.aspx?country_id=181&as=1&ex=0&cFilter=9a79e6ce-3344-409c-bbe9-496530baf758&children=n');

// Poiščemo naslove
foreach($html->find('td.Merge') as $article) {
	if ( $article->find('span', 0)->plaintext != "" ) {
    $naslovi[] = trim($article->find('span', 0)->plaintext); // poiščemo naslov zaklada
    // v kolikor se naslov ne nahaja v bazi podatkov, ga vključimo v seznam novih zakladov
    if ( !in_array(trim($article->find('span', 0)->plaintext), $vrstice) ) {
			$novosti[] = trim($article->find('span', 0)->plaintext);
		}
	}
}

$stran_st_zapisov = strval(count($naslovi));
echo "Spletna stran vsebuje {$stran_st_zapisov} zapisov.<br />";
$stran_st_novih_zapisov = strval(count($novosti));
echo "Spletna stran vsebuje {$stran_st_novih_zapisov} novih zapisov.<br />";

// Določimo začetni in končni položaj zanke, ki bo izpisala vse naslove najdene na GC strani
$i = 0;
$i_max = count($novosti); 

// Če so novosti prisotne, ustvarimo varnostno kopijo baze in prepišemo nove podatke v obstoječo bazo
if ( $i_max >> 0 ) {
	// Zaženemo zanko, ki izpiše vse nove naslove najdene na GC strani
	echo"Prebrano iz strani: <br />";
	for ( $i; $i <= $i_max - 1; $i++ ) {
		echo "$i: $novosti[$i]<br />\n"; 
	}

	// ustvarimo varnostno kopijo stare baze
	echo "Baza je zastarela. Ustvaril bom njeno varnostno kopijo.<br />";
	$today = getdate();
	$ime_kopije = "base-".$today['year']."-".$today['mon']."-".$today['mday']."-".$today['hours']."-".$today['minutes']."-".$today['seconds'].".bck";
	$varnostna_kopija = fopen($ime_kopije, 'w') or die("Datoteke varnostne kopije ne morem ustvariti");
	for ( $i = 0; $i <= $$baza_st_zapisov; $i++ ) {
		fwrite($varnostna_kopija, $vrstice[$i]."\n");
	}
	fclose($varnostna_kopija);
	echo "Varnostna kopija je bila ustvarjena.<br />";
	
	// izbrišemo obstoječo bazo
	unlink("base");
	echo "Baza podatkov je bila izbrisana.<br />";
	
	// ustvarimo novo bazo
	$nova_baza = fopen("base", 'w') or die("Baze ne morem ustvariti");
	for ( $i = 0; $i <= $stran_st_zapisov; $i++ ) {
		fwrite($nova_baza, $naslovi[$i]."\n");
	}
	fclose($nova_baza);
	echo "Baza je bila ustvarjena.<br />";
	
	// pošljemo mail obvestilo o stanju skripte
	$user = "luka@bubi.si";
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .=  'From: GC skripta<skripta@bubi.si>' . "\r\n";
	$headers .= "Reply-To: skripta@bubi.si\r\n";
	$message = "Nova posodobitev statusa se je zgodila. Naslovi so:<br />\r\n";
	for ( $i = 0; $i <= $i_max - 1; $i++ ) {
		$message .=  "$i: $novosti[$i]<br />\r\n"; 
	}
	$message .= "Uspešen lov.<br />\r\n";
	$subject = "Na GC strani so objavljeni novi zakladi!";
	mail($user, $subject, $message, $headers);
	echo "Sporočilo je poslano.<br />";
}
else {
	// pošljemo mail obvestilo o neobstoječih podatkih
	$user = "luka@bubi.si";
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .=  'From: GC skripta<skripta@bubi.si>' . "\r\n";
	$headers .= "Reply-To: skripta@bubi.si\r\n";
	$message = "Žal boste danes kar doma.<br />\r\n";
	$subject = "GC skripta ni našla nobenih posodobitev!";
	mail($user, $subject, $message, $headers);
	echo "Sporočilo je poslano.<br />";
}

echo "Skripta je uspešno zaključila svoje delo!<br />";
  
?>
</body>
</html>
