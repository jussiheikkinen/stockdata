<?php
function tulostaLomake(){
echo <<<NEW
<div id="lomakkeet">
<form method='get' action='' id='lisaysform'>
<p>Buy</p>
<table>
<tr><td>Stock</td><td><input type="text" onkeyup="showHint(this.value)" name="stock" required></td></tr>
<tr><td>Price</td><td><input type="number" name="price" required></td></tr>
<tr><td>Amount</td><td><input type="number" name="amount" required></td></tr>
</table>
<button type="submit" name='addstock'>Buy</button>
</form>
<div id="ehdotukset"><span id="txtHint"></span></div>
<form method='get' action='' id='myyntiform'>
Sell
<table>
<tr><td>Stock</td><td><input type="text" name="stock1" required></td></tr>
<tr><td>Amount</td><td><input type="number" name="amount1" required></td></tr>
</table>
<button type="submit" name='sellstock'>Sell</button>
</form>
</div>
NEW;
}
//Osakkeen lisääminen salkkuun
function lisaaOsake($salkku){
  require ("/var/www/db-init.php");

  $a = $salkku;
  $b =  $_SESSION['userName'];
  $tunnus = strtoupper($_GET['stock']); //Osakkeet aina isoilla kirjaimilla
  $ostohinta = $_GET['price'];
  $lkm = $_GET['amount'];

  $stmt = $db->prepare("SELECT SalkkuId FROM Salkku INNER JOIN Kayttaja ON KayttajaId = SalkkuKayttaja WHERE KayttajaTunnus =?");
  $stmt->execute(array($b));
  $salkkuid = $stmt->fetch(PDO::FETCH_OBJ);

  $stmt = $db->prepare("SELECT OsakeId FROM Osake WHERE OsakeNimi =?");
  $stmt->execute(array($tunnus));
  $osakeid =  $stmt->fetch(PDO::FETCH_OBJ);

  if ($osakeid->OsakeId > 0){ // jos osake on jo Osake taulussa niin ei lisätä sitä uudestaan
        $stmt = $db->prepare("SELECT Tapahtuma.TapahtumaLkm,Tapahtuma.TapahtumaHinta,Osake.OsakeNimi, Tapahtuma.TapahtumaOsake, Osake.OsakeId
        FROM Tapahtuma INNER JOIN Osake ON Tapahtuma.TapahtumaOsake = Osake.OsakeId
        INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku INNER JOIN Kayttaja ON KayttajaId = SalkkuKayttaja
        WHERE KayttajaTunnus = ? AND OsakeNimi = ?");
        $stmt->execute(array($_SESSION['userName'], $_GET['stock']));
        $osake = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($osake)){ // Osake on jo Osake taulussa (tietokannassa) mutta se ei ole vielä salkussa
            $stmt = $db->prepare("INSERT INTO Tapahtuma (TapahtumaLkm, TapahtumaHinta, TapahtumaSalkku, TapahtumaOsake) VALUES( :f1,:f2,:f3,:f4)");
            $stmt->execute(array(':f1' => $lkm, ':f2' => $ostohinta, ':f3' => $salkkuid->SalkkuId, ':f4' => $osakeid->OsakeId));
        }

        else{ //Osake on jo Osaketaulussa sekä salkussa joten osto yhdistetään salkussa olevaan tapahtumaan

            $value = ($osake->TapahtumaLkm + $_GET['amount']); // lasketaan osakkeiden uusi määrä

            $stmt = $db->prepare("UPDATE Tapahtuma INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku
            INNER JOIN Kayttaja On KayttajaId = SalkkuKayttaja SET Tapahtuma.TapahtumaLkm = ?
            WHERE KayttajaTunnus = ? AND TapahtumaOsake = ?");
            $stmt->execute(array($value, $_SESSION['userName'], $osake->TapahtumaOsake));
        }

  }else{ // indeksi on 0 eli lisätään uusi alkio Osake tauluun
        $stmt = $db->prepare("INSERT INTO Osake (OsakeNimi, OsakeTiedot) VALUES (?, 1)");
        $stmt->execute(array($tunnus));

        $stmt = $db->prepare("SELECT OsakeId FROM Osake WHERE OsakeNimi =?");
        $stmt->execute(array($tunnus));
        $osakeid =  $stmt->fetch(PDO::FETCH_OBJ);

        $stmt = $db->prepare("INSERT INTO Tapahtuma (TapahtumaLkm, TapahtumaHinta, TapahtumaSalkku, TapahtumaOsake) VALUES( :f1,:f2,:f3,:f4)");
        $stmt->execute(array(':f1' => $lkm, ':f2' => $ostohinta, ':f3' => $salkkuid->SalkkuId, ':f4' => $osakeid->OsakeId));
        if ($affected_rows = $stmt->rowCount()){
          echo '<META HTTP-EQUIV="Refresh" Content="0; URL=user.php">';
        }else {
        echo 'Something went wrong in newstock line 80' ;
}}
}

  function myyOsake(){
    require ("/var/www/db-init.php");

    $stmt = $db->prepare("SELECT Tapahtuma.TapahtumaLkm,Tapahtuma.TapahtumaHinta,Osake.OsakeNimi, Tapahtuma.TapahtumaOsake
    FROM Tapahtuma INNER JOIN Osake ON Tapahtuma.TapahtumaOsake = Osake.OsakeId
    INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku INNER JOIN Kayttaja ON KayttajaId = SalkkuKayttaja
    WHERE KayttajaTunnus = ? AND OsakeNimi = ?");
    $stmt->execute(array($_SESSION['userName'], $_GET['stock1']));
    $osake = $stmt->fetch(PDO::FETCH_OBJ);

    if (!empty($osake)){

    $lkm = ($osake->TapahtumaLkm - $_GET['amount1']);
    //$newprice = ($osake->TapahtumaHinta + ]); //uuden ostohiinnan lasku mutta ei jaksa toteuttaa

    if ($lkm <= 0){
      $stmt = $db->prepare("DELETE Tapahtuma.* FROM Tapahtuma INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku
        INNER JOIN Kayttaja On KayttajaId = SalkkuKayttaja WHERE KayttajaTunnus = ? AND TapahtumaOsake = ?");
        $stmt->execute(array($_SESSION['userName'], $osake->TapahtumaOsake));
      }else{
          $stmt = $db->prepare("UPDATE Tapahtuma INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku
          INNER JOIN Kayttaja On KayttajaId = SalkkuKayttaja SET Tapahtuma.TapahtumaLkm = ?
          WHERE KayttajaTunnus = ? AND TapahtumaOsake = ?");
          $stmt->execute(array($lkm, $_SESSION['userName'], $osake->TapahtumaOsake));
}
}
if ($affected_rows = $stmt->rowCount()){
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=user.php">';
    }else {
    echo 'Check details';
}
}
?>
