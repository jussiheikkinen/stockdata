<?php
echo <<<NEW
<form method='get' action='' id='lisaysform'>
<table>
<tr><td>Stock name</td><td><input type="text" name="stock" required></tr></td>
<tr><td>Avg/pcs</td><td><input type="number" name="avg" required></tr></td>
<tr><td>Amount(pcs)</td><td><input type="number" name="amount" required></tr></td>
</table>
<button type="submit" name='addstock'>Buy</button>
</form>
<form method='get' action='' id='myyntiform'>
<table>
<tr><td>Stock name</td><td><input type="text" name="stock1" required></tr></td>
<tr><td>Amount(pcs)</td><td><input type="number" name="amount1" required></tr></td>
</table>
<button type="submit" name='sellstock'>Sell</button>
</form>
NEW;

//Osakkeen lisääminen salkkuun
function lisaaOsake($salkku){
//if(isset($_GET['addstock'])){
  require ("/var/www/db-init.php");

  $a = $salkku;
  $b =  $_SESSION['userName'];
  $tunnus = strtoupper($_GET['stock']); //Osakkeet aina isoilla kirjaimilla
  $ostohinta = $_GET['avg'];
  $lkm = $_GET['amount'];

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
  }}

  function myyOsake($val){
    require ("/var/www/db-init.php");
    $stmt = $db->prepare("SELECT Tapahtuma.TapahtumaLkm,Tapahtuma.TapahtumaHinta,Osake.OsakeNimi
    FROM Tapahtuma INNER JOIN Osake ON Tapahtuma.TapahtumaOsake = Osake.OsakeId
    INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku INNER JOIN Kayttaja ON KayttajaId = SalkkuKayttaja
    WHERE KayttajaNimi = ? AND OsakeNimi = ?");
    $stmt->execute(array($_SESSION['userName'] ,$val));
    $osake = $stmt->fetch(PDO::FETCH_OBJ);

    $lkm = ($osake->TapahtumaLkm - $_GET['amount1'];

    $stmt = $db->prepare("INSERT INTO Tapahtuma (TapahtumaLkm) VALUES( :f1");
    $stmt->execute(array(':f1' => $lkm));

    /*if ($lkm <= 0){
    $stmt = $db->prepare("DELETE FROM Tapahtuma INNER JOIN Osake ON Tapahtuma.TapahtumaOsake = Osake.OsakeId
    INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku INNER JOIN Kayttaja ON KayttajaId = SalkkuKayttaja
    WHERE KayttajaNimi = ? AND OsakeNimi = ?");
  }*/

    }

?>
