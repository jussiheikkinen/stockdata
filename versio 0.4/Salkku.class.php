<?php
Class Salkku{
	private $salkkuID;
	private $tuotto;
	private $osakket = array(); //array

function __construct() {
$this->salkkuID = 'Salkku';
$this->tuotto = 0;
$this->osakket = array(1,2,3);
}

function __destruct() {
$this->salkkuID = NULL;
$this->tuotto = NULL;
}

public function uusiSalkku($id){
$this->salkkuID = $id;
}

public function tallennaSalkku(){
//tähän tallennustietokantaan mySQL

}

public function tulostaSalkku(){
require_once ("db-init.php");
$stmt = $db->query('SELECT * FROM salkku');
echo '<table><tr><th>stock</th><th>average</th><th>amount</th><th>value</th><th>winning</th></tr>';
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
echo <<<SALKKU
<tr><td>{$row['osake']}</td><td>{$row['keskihinta']}</td><td>{$row['maara']}</td><td>{$row['arvo']}</td><td>{$row['tuotto']}</td></tr>
SALKKU;
}
echo <<<NAPPI
</table>
<button type='submit' name='add'>add</button>
NAPPI;
}
}
?>
