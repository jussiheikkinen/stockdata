<?php

Class Kayttaja{
	private $nimi;
	private $snimi;
	private $kayttaja;
	private $salasana;

function __construct() {
$this->nimi = 'Harri';
$this->snimi = 'Häviäjä';
$this->kayttaja = 'tuulipuku';
$this->salasana = 'salasana';
}

function __destruct() {
$this->nimi = NULL;
$this->snimi = NULL;
$this->kayttaja = NULL;
$this->salasana = NULL;
}

public function deleteUser($value){
	require ("/var/www/db-init.php");

	$stmt = $db->prepare('DELETE FROM Kayttaja WHERE KayttajaTunnus = :id');
	$stmt->bindValue(':id', $value);
	$stmt->execute();

	echo '<META HTTP-EQUIV="Refresh" Content="1; URL=kirjaudu.php">';
}

public function updateUser($value){
	require ("/var/www/db-init.php");

	echo '<META HTTP-EQUIV="Refresh" Content="1; URL=kirjaudu.php">';

	//$stmt = $db->prepare('DELETE FROM Kayttaja WHERE KayttajaTunnus = :id');
	//$stmt->bindValue(':id', $value);
	//$stmt->execute();

	//echo '<META HTTP-EQUIV="Refresh" Content="1; URL=kirjaudu.php">';
}

}

?>
