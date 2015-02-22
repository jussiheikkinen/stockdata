
<?php
include ('user.php');

Class Kayttaja{
	private $nimi;
	private $snimi; //sukunimi
	private $nick;
	private $salasana;

function __construct() {
$this->nimi = 'Harri';
$this->snimi = 'Häviäjä';
$this->nick = 'tuulipuku';
$this->salasana = 'salasana';
}
	
function __destruct() {
$this->nimi = NULL;
$this->snimi = NULL;
$this->nick = NULL;
$this->salasana = NULL;  
}

public function uusiKayttaja(){
	if (isset($_POST['name']))
		$this->nimi = $_POST['name'];
	
	if (isset($_POST['lastname']))
		$this->snimi = $_POST['lastname'];

	if (isset($_POST['nick']))
		$this->nick = $_POST['nick'];

	if (isset($_POST['password']))
		$this->salasana = $_POST['password'];

	
	//tallenna tiedot mySQL
}
?>
