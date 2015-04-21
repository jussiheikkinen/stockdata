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

if ($affected_rows = $stmt->rowCount()){
		echo '<META HTTP-EQUIV="Refresh" Content="1; URL=kirjaudu.php">';
		}else {
			echo 'Something went wrong';
}
}

public function updateUser($value){
	require ("/var/www/db-init.php");
	$hash = crypt($value);
	$stmt = $db->prepare('UPDATE Kayttaja SET KayttajaSalasana = ? WHERE KayttajaTunnus = ?');
	$stmt->execute(array($hash ,$_SESSION['userName']));

	if ($affected_rows = $stmt->rowCount()){
			echo 'Succes'.'<META HTTP-EQUIV="Refresh" Content="0; URL=user.php">';
			}else {
			echo 'Something went wrong';
}
}
}

?>
