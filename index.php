<html>
<head>
<title>Preverjanje</title>
</head>
<body>
<?
include('simple_html_dom.php');
// Povezava do spletne strani
$html = file_get_html('http://www.geocaching.com/seek/nearest.aspx?country_id=181&as=1&ex=0&cFilter=9a79e6ce-3344-409c-bbe9-496530baf758&children=n');

// Poiščemo del strani
foreach($html->find('td.Merge') as $article) {
    @$item['title'] = $article->find('span', 0)->plaintext;
    @$articles[] = $item[title];
}
$nov =$articles[1];
echo"Prebrano iz strani: ";
print_r ($nov);
$file = fopen("podatki.txt", "r") or exit("Unable to open file!");
$pod = fgets($file);
echo"<br>Prebrano iz baze: $pod<br>Primerjava ukazov...<br>";
  fclose($file);
  if ($pod != $nov)
  {
	echo"Ukaza se razlikujeta. Potrebno je poslati mail in posodobiti bazo.<br>";
	$myFile = "podatki.txt";
	unlink($myFile);
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, $nov);
	fclose($fh);
	$user = "luka@bubi.si";
	$headers1  = "MIME-Version: 1.0\r\n";
	$headers1 .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers1 .=  "X-Priority: 1 (Higuest)\n"; 
	$headers1 .=  'From: GeoHoste Posodobitev<geo@hoste.si>' . "\r\n";
	$headers1 .= "Reply-To: gasperstrnisa@gmail.com\r\n";
	$message="Nova posodobitev statusa se je zgodila. Naslov je: $nov.";
	$subject1="Nova posodobitev strani!";
	mail($user, $subject1, $message, $headers1);
	echo"Sporocilo poslano.<br>";
  }
  else{
	  echo "Ni novih posodobitev.<br>";
  }
  echo"KONEC";
?>
</body>
</html>
