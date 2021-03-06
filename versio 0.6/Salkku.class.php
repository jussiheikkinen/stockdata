<?php
Class Salkku{
	public $salkkuID;
	private $tuotto;
	private $osakkeet = array(); //array

function __construct() {
$this->salkkuID = 'Portfolio';
$this->tuotto = 0;
$this->osakkeet = array();
}

function __destruct() {
$this->salkkuID = NULL;
$this->tuotto = NULL;
$this->osakkeet = NULL;
}

public function uusiSalkku($id){
$this->salkkuID = $id;
}

//Osto arvo
public function laskeArvo($kayttaja){
	$array = array();
	require ("/var/www/db-init.php");
	$stmt = $db->prepare('SELECT (Tapahtuma.TapahtumaLkm * Tapahtuma.TapahtumaHinta) AS Arvo, Osake.OsakeNimi FROM Tapahtuma INNER JOIN Osake ON Tapahtuma.TapahtumaOsake = Osake.OsakeID
	INNER JOIN Tiedot ON Osake.OsakeTiedot = Tiedot.TiedotId
	INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku
	INNER JOIN Kayttaja On KayttajaId = SalkkuKayttaja WHERE KayttajaNimi = ?;');
	$stmt->execute(array($kayttaja));
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$array[] = $row['Arvo'];
	}
	return $array;
}
/*
public function poistaOsake(){
	require ("/var/www/db-init.php");
	$stmt = $db->prepare('DELETE FROM Kayttaja WHERE kayttajaNimi = :id');
	$stmt->bindValue(':id', $v);
	$stmt->execute();
}
*/
public function tulostaSalkku($kayttaja){
require ("/var/www/db-init.php");
include ('functions.php');

$stmt = $db->prepare('SELECT Tapahtuma.TapahtumaAika,Tapahtuma.TapahtumaLkm,Tapahtuma.TapahtumaHinta,Osake.OsakeNimi,Tiedot.TiedotValuutta
FROM Tapahtuma INNER JOIN Osake ON Tapahtuma.TapahtumaOsake = Osake.OsakeID
INNER JOIN Tiedot ON Osake.OsakeTiedot = Tiedot.TiedotId
INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku
INNER JOIN Kayttaja On KayttajaId = SalkkuKayttaja WHERE KayttajaNimi = ?;
');
$stmt->execute(array($kayttaja)); //oli vielä $this->salkkuID
echo '<h3>' .  $this->salkkuID .'<h3>';
echo '<table id="omasalkku"><tr><th>stock</th><th>average</th><th>amount</th><th>value</th><th>winning</th><th>BuyValue</th><th>Profit</th></tr>';
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$tuotto = haeHinta($row['OsakeNimi']);
$hinta = ($row['TapahtumaLkm'] * $row['TapahtumaHinta']);
//$tuotto = (($hinta[0] - $row['TapahtumaHinta']) * $row['TapahtumaLkm']);

echo <<<SALKKU
<tr><td>{$row['TapahtumaAika']}</td><td>{$row['TapahtumaLkm']}</td><td>{$row['TapahtumaHinta']}</td><td>{$row['OsakeNimi']}</td><td>{$row['TiedotValuutta']}</td><td>$hinta</td><td>$tuotto[0]</td></tr>
SALKKU;
}
echo <<<NAPPI
</table>
<div id='uusi'> </div>
NAPPI;
}
//<button type='submit' name='uusiOsake'>add</button>

public function chart(){
$kayttaja = $_SESSION['userName'];
require ("/var/www/db-init.php");
$stmt = $db->prepare('SELECT (Tapahtuma.TapahtumaLkm * Tapahtuma.TapahtumaHinta) AS Arvo, Osake.OsakeNimi FROM Tapahtuma INNER JOIN Osake ON Tapahtuma.TapahtumaOsake = Osake.OsakeID
INNER JOIN Tiedot ON Osake.OsakeTiedot = Tiedot.TiedotId
INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku
INNER JOIN Kayttaja On KayttajaId = SalkkuKayttaja WHERE KayttajaNimi = ?;');
$stmt->execute(array($kayttaja));
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
$this->osakkeet[] = array($row['OsakeNimi'], $row['Arvo']);
}
return $this->osakkeet;
}
}
?>
