<?php
echo <<<NEW
<form method='get' action='' id='lisaysform'>
<table>
<tr><td>Stock name</td><td><input type="text" name="stock" required></tr></td>
<tr><td>Avg/pcs</td><td><input type="number" name="avg" required></tr></td>
<tr><td>Amount(pcs)</td><td><input type="number" name="amount" required></tr></td>
</table>
<button type="submit" name='addstock'>add</button>
</form>
NEW;
//<tr><td>Value</td><td><input type="text" name="value"></tr></td>
//<tr><td>Profit</td><td><input type="text" name="profit"></tr></td>
//Osakkeen lisääminen salkkuun
function lisaaOsake($salkku){
if(isset($_GET['addstock'])){
  require ("/var/www/db-init.php");
  include ('functions.php');

  $a = $salkku;
  $b =  $_SESSION['userName'];
  $tunnus = strtoupper($_GET['stock']); //Osakkeet aina isoilla kirjaimilla
  $ostohinta = $_GET['avg'];
  $lkm = $_GET['amount'];
  //$hinta = haeHinta($c);
  //$g = (($hinta[0] - $d) * $e);//tuotto
  //$f = ($d * $e + $g);//osakkeen nimellisarvo
  //Tähän haku function.php ja sieltä b2 arvo osakkeelle ja laskut + tallennus $g
  $stmt = $db->prepare("SELECT SalkkuId FROM Salkku INNER JOIN Kayttaja ON KayttajaId = SalkkuKayttaja WHERE KayttajaNimi =?");
  $stmt->execute(array($b));
  $salkkuid = $stmt->fetch(PDO::FETCH_OBJ);

  $stmt = $db->prepare("SELECT TiedotId FROM Tiedot WHERE TiedotId =?");
  $stmt->execute(array(1));
  $tiedotid =  $stmt->fetch(PDO::FETCH_OBJ);

  $stmt = $db->prepare("INSERT INTO Osake (OsakeNimi, OsakeTiedot) VALUES (?, ?)");
  $stmt->execute(array($tunnus, $tiedotid->TiedotId));

  $stmt = $db->prepare("SELECT OsakeId FROM Osake WHERE OsakeNimi =?");
  $stmt->execute(array($tunnus));
  $osakeid =  $stmt->fetch(PDO::FETCH_OBJ);

  $stmt = $db->prepare("INSERT INTO Tapahtuma (TapahtumaLkm, TapahtumaHinta, TapahtumaSalkku, TapahtumaOsake) VALUES( :f1,:f2,:f3,:f4)");
  $stmt->execute(array(':f1' => $lkm, ':f2' => $ostohinta, ':f3' => $salkkuid->SalkkuId, ':f4' => $osakeid->OsakeId));

  if ($affected_rows = $stmt->rowCount()){
     echo '<META HTTP-EQUIV="Refresh" Content="0; URL=user.php">';
  } else {
  exit();
  }}}

?>
