<?php
Class Salkku{
	public $salkkuID;
	private $tuotto;
	private $osakkeet = array(); //array

function __construct() {
$this->salkkuID = 'Portfolio';
$this->tuotto = 0;
$this->osakkeet = array(1,2,3);
}

function __destruct() {
$this->salkkuID = NULL;
$this->tuotto = NULL;
$this->osakkeet = NULL;
}

public function uusiSalkku($id){
$this->salkkuID = $id;
}

public function tallennaSalkku(){
//tähän tallennustietokantaan mySQL

}

public function tulostaSalkku($kayttaja){
require ("/var/www/db-init.php");
$stmt = $db->prepare('SELECT * FROM salkku where kayttajaID = ? AND salkkuID = ? ');
$stmt->execute(array($kayttaja, $this->salkkuID));

echo '<h3>' .  $this->salkkuID .'<h3>';
echo '<table id="omasalkku"><tr><th>stock</th><th>average</th><th>amount</th><th>value</th><th>winning</th></tr>';
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
echo <<<SALKKU
<tr><td>{$row['osake']}</td><td>{$row['keskihinta']}</td><td>{$row['maara']}</td><td>{$row['arvo']}</td><td>{$row['tuotto']}</td></tr>
SALKKU;
}
echo <<<NAPPI
</table>
<div id='uusi'> </div>
NAPPI;
}
//<button type='submit' name='uusiOsake'>add</button>
///MIKÄ VITTU TÄSSÄ MÄTTÄÄÄ?????? joopa joo eli require ONCE == ONCE
public function chart(){
require ("/var/www/db-init.php");
$stmt = $db->prepare("SELECT * FROM salkku WHERE salkkuID = :id");
$stmt->bindValue(':id', $this->salkkuID);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
$this->osakkeet[] = array($row['osake'], $row['arvo']);
}
return $this->osakkeet;
}
}
?>
