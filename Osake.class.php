<?php

Class Osake extends Salkku{
	private $osakeID;
	private $ostopaiva;
	private $ostohinta;
	private $maara;

	private $pe;
	private $volume;
	private $ylin;
	private $alin;

function __construct() {
	$this->osakeID = '';
	$this->ostopaiva = 0;
	$this->ostohinta = 0;
	$this->maara = 0;
	$this->pe = 0;
	$this->volume = 0;
	$this->ylin = 0;
	$this->alin = 0;
}

function __destruct() {
	$this->osakeID = NULL;
	$this->ostopaiva = NULL;
	$this->ostohinta = NULL;
	$this->maara = NULL;
	$this->pe = NULL;
	$this->volume = NULL;
	$this->ylin = NULL;
	$this->alin = NULL;
}

public function uusiOsake(){
echo <<<TULOSTA
lälläslää

TULOSTA;
}
}
?>
