<?php
include("functions.php");

function nouda($osake){     //nyt toimii php_self kautta jos haluaa toimivan tästä filusta niin  poista kommentit
//if (isset($_GET['osake'])){
//$a = haeData( $_GET['osake'], $e);
$a = haeData ($osake, $e);
if ($a != -1) {

$taulu = array();
foreach ($a as $k){
$taulu[] = $k;
}
return $taulu;

} else{
	echo "No stock data is available. The detail of the error is: $e";}
}
?>
