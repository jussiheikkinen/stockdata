<?php
//Tällä voi luoda uuden taulun joka sisältää kuvaajan ja tiedot
include ('noutaja.php');

Class Taulu{
	private $yritysid;//
	private $osto;// 5
	private $myynti; // 4
	private $vaihto; // 79
	private $ylin ; //25
	private $alin; //24
	private $range ;//52wk 81	
	private $taulu1;

function __construct() {
}
	
function __destruct() {
	$this->yritysid = NULL;
	$this->osto = NULL;
	$this->myynti = NULL; 
	$this->vaihto = NULL;
	$this->ylin = NULL; 
	$this->alin = NULL; 
	$this->range = NULL;
	$this->taulu1 = NULL;
 }
	

public function hae($osake){
$this->taulu1 = nouda($osake);
$this->alusta($this->taulu1);
}

public function alusta($taulu){
$this->taulu = $taulu;
$this->yritysid = $taulu[58];//
$this->osto = $taulu[5];// 5
$this->myynti = $taulu[4]; // 4
$this->vaihto = $taulu[78]; // 79
$this->ylin = $taulu[25]; //25
$this->alin = $taulu[24]; //24
$this->range = $taulu[81];//52wk 81
//print_r ($taulu);
}

public function tulosta_tiedot(){
	echo "<div id='tiedot'>";
	echo "<strong>"."Yritys: ". $this->yritysid . "</strong>";
	echo "<p>" . "Osto: " . $this->osto . "<p>";
	echo "<p>" . "Myynti: " . $this->myynti . "<p>";
	echo "<p>" . "Vaihto: " . $this->vaihto . "<p>";
	echo "<p>" . "Päivän ylin: " . $this->ylin . "<p>";
	echo "<p>" . "päivän alin: " . $this->alin . "<p>";
	echo "<p>" . "Valihtelu väli: " . $this->range . "<p>";	
	echo "</div>";
}

public function uusi_canvas(){
	echo "<canvas id='myCanvas' width='600' height='300'>";
	echo "</canvas>";
}

public function uusi_form(){
	/*action='<?php echo $_SERVER['PHP_SELF']; ?>'*/
	echo "<form id='myForm' method= 'get'>";
	echo "<input type='text' name='osake'>";
	echo "<input type='submit' name='id' value='Search'>";
	echo "</form>";
}

}

?>