<?php
echo <<<NEW
<form method='get' action='' id='lisaysform'>
<table>
<tr><td>Stock name</td><td><input type="text" name="stock"></tr></td>
<tr><td>Avg/pcs</td><td><input type="text" name="avg"></tr></td>
<tr><td>Amount(pcs)</td><td><input type="text" name="amount"></tr></td>
<tr><td>Value</td><td><input type="text" name="value"></tr></td>
<tr><td>Profit</td><td><input type="text" name="profit"></tr></td>
</table>
<button type="submit" name='addstock'>add</button>
</form>
NEW;

//Osakkeen lisääminen salkkuun
function lisaaOsake($salkku){
if(isset($_GET['addstock'])){
  require ("/var/www/db-init.php");
  $a = $salkku;
  $b =  $_SESSION['userName'];
  $c = strtoupper($_GET['stock']); //Osakkeet aina isoilla kirjaimilla
  $d = $_GET['avg'];
  $e = $_GET['amount'];
  $f = $_GET['value'];
  $g = $_GET['profit'];

  $stmt = $db->prepare("INSERT INTO salkku (salkkuID, kayttajaID, osake, keskihinta, maara, arvo, tuotto) VALUES( :f1,:f2,:f3,:f4,:f5,:f6,:f7)");
  $stmt->execute(array(':f1' => $a, ':f2' => $b, ':f3' => $c, ':f4' => $d, ':f5' => $e, ':f6' => $f, ':f7' => $g));

  if ($affected_rows = $stmt->rowCount()){
     echo 'Adding succeed';
     echo '<META HTTP-EQUIV="Refresh" Content="0; URL=user.php">';
  } else {
  exit();
  }}}

?>
