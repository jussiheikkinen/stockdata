<?php
session_start();

if (!isset($_SESSION['app1_islogged']) || $_SESSION['app1_islogged'] !== true) {
header('Location:' . dirname($_SERVER['PHP_SELF']) . '/' . 'kirjaudu.php');
exit;}

if (isset($_GET['osake'])){
setcookie("osake", $_GET['osake'], time()+86400);
}
if (isset($_GET['hinta'])){
setcookie("hinta", (double)$_GET['hinta'], time()+86400);
}
?>

<html style="width:100%;" >
<head>
<title>Stocksdata</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="icon.ico">
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="tyylit.css">

</head>

<body>

<header>
<?php include ('header.php'); ?>
</header>
<content>
<article id="feed">
<pre>
<?php
$homepage = file_get_contents("https://www.nordnet.fi/mux/web/marknaden/kurslista/aktier.html?marknad=Finland&lista=1_1&large=on&mid=on&small=on&sektor=0&subtyp=price&sortera=aktie&sorteringsordning=stigande");
echo '<h1>OMX Helsinki</h1><p>Delay 15min</p>';
echo '<table id="omasalkku"><tr><th>Name</th><th>Last</th><th>Change</th><th>%</th><th>Highest</th><th>Lowest</th><th>Volume</th><th>Currency</th></tr>';
   //if (preg_match_all('/underline.>[A-Za-ö\s<\/>0-9,="%]+EUR/',$homepage , $matches)){
   if (preg_match_all('/[A-Z]+[A-ZÅÄÖa-zåöä\s<\/>0-9,.="%-]+EUR/',$homepage , $matches)){

        	$i = 0;
   	$j = count($matches, COUNT_RECURSIVE) -1 ;
   	while ($i < $j){
//eli alkaa isolla + sanoja / numeroita tai numero merkki
//Huom! Bugeja on esim että Bank of åland Plc a ja b
//tulostuvat vai plc a, plac b sekä volyymistä tulostuu vain osa ennen whitespaces
   	preg_match_all('/[A-Z]+[A-ZÅÄÖa-zåöä\s-]+|[0-9,%]+/', $matches[0][$i], $osumat);
   	//print_r ($osumat);
     if (is_numeric($osumat[0][12])){
     $volyme = $osumat[0][10] ." ". $osumat[0][11] ." ". $osumat[0][12];
     $valuutta = $osumat[0][13];
   } else if (is_numeric($osumat[0][11])){
     $volume = $osumat[0][10] ." ". $osumat[0][11];
     $valuutta = $osumat[0][12];
   }else{
     $volume = $osumat[0][10];
     $valuutta = $osumat[0][11];
   }

   if ($osumat[0][2] == Plus){
     $color = '"color:blue;"';
   } else if ($osumat[0][2] == Minus){
     $color = '"color:red;"';
   }else{
     $color = '"color:green;"';
   }

$double = urlencode($osumat[0][1]);

echo <<<SALKKU
     <tr><td><a href="feed.php?osake={$osumat[0][0]}&hinta=$double">{$osumat[0][0]}</a></td><td>{$osumat[0][1]}</td><td>{$osumat[0][3]}</td><td style=$color>{$osumat[0][5]}</td>
     <td>{$osumat[0][8]}</td><td>{$osumat[0][9]}</td><td>$volume</td><td>$valuutta</td></tr>
SALKKU;
$i++;
}
echo "</table>";
}
?>
</pre>
</article>
<article id="kayttaja" style="float:right; width:27%; margin-left:1%; ">
  <?php

  $hinta = (double)urldecode($_GET['hinta']);
  $tunnus = $_GET['osake'];

  echo <<<NEW
  <div id="lomakkeet">
  <form method='get' action='' id='lisaysform'>
  Buy
  <table>
  <tr><td>Stock</td><td>$tunnus</td></tr>
  <tr><td>Price</td><td>$hinta</td></tr>
  <tr><td>Amount</td><td><input type="number" name="amount" required></td></tr>
  </table>
  <button type='submit' name='addstock'>Buy</button>
  </form>
NEW;

if (isset($_GET["addstock"])){
  require_once 'Salkku.class.php';
  require ("/var/www/db-init.php");
  $a = $oletusSalkku->salkkuID;
  $b =  $_SESSION['userName'];
  $lkm = $_GET['amount'];

  $stmt = $db->prepare("SELECT SalkkuId FROM Salkku INNER JOIN Kayttaja ON KayttajaId = SalkkuKayttaja WHERE KayttajaTunnus =?");
  $stmt->execute(array($b));
  $salkkuid = $stmt->fetch(PDO::FETCH_OBJ);

  $stmt = $db->prepare("SELECT OsakeId FROM Osake WHERE OsakeNimi =?");
  $stmt->execute(array($_COOKIE['osake']));
  $osakeid =  $stmt->fetch(PDO::FETCH_OBJ);

  if ($osakeid->OsakeId > 0){ // jos osake on jo Osake taulussa niin ei lisätä sitä uudestaan
        $stmt = $db->prepare("SELECT Tapahtuma.TapahtumaLkm,Tapahtuma.TapahtumaHinta,Osake.OsakeNimi, Tapahtuma.TapahtumaOsake, Osake.OsakeId
        FROM Tapahtuma INNER JOIN Osake ON Tapahtuma.TapahtumaOsake = Osake.OsakeId
        INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku INNER JOIN Kayttaja ON KayttajaId = SalkkuKayttaja
        WHERE KayttajaTunnus = ? AND OsakeNimi = ?");
        $stmt->execute(array($_SESSION['userName'], $_COOKIE['osake']));
        $osake = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($osake)){ // Osake on jo Osake taulussa (tietokannassa) mutta se ei ole vielä salkussa
            $stmt = $db->prepare("INSERT INTO Tapahtuma (TapahtumaLkm, TapahtumaHinta, TapahtumaSalkku, TapahtumaOsake) VALUES( :f1,:f2,:f3,:f4)");
            $stmt->execute(array(':f1' => $lkm, ':f2' => $_COOKIE['hinta'], ':f3' => $salkkuid->SalkkuId, ':f4' => $osakeid->OsakeId));

        }else{ //Osake on jo Osaketaulussa sekä salkussa joten osto yhdistetään salkussa olevaan tapahtumaan

            $value = ($osake->TapahtumaLkm + $_GET['amount']); // lasketaan osakkeiden uusi määrä

            $stmt = $db->prepare("UPDATE Tapahtuma INNER JOIN Salkku ON Salkku.SalkkuId = TapahtumaSalkku
            INNER JOIN Kayttaja On KayttajaId = SalkkuKayttaja SET Tapahtuma.TapahtumaLkm = ?
            WHERE KayttajaTunnus = ? AND TapahtumaOsake = ?");
            $stmt->execute(array($value, $_SESSION['userName'], $osake->TapahtumaOsake));
        }

        }else{ // indeksi on 0 eli lisätään uusi alkio Osake tauluun
          $stmt = $db->prepare("INSERT INTO Osake (OsakeNimi, OsakeTiedot) VALUES (?, 2)");
          $stmt->execute(array($_COOKIE['osake']));

            $stmt = $db->prepare("SELECT OsakeId FROM Osake WHERE OsakeNimi =?");
            $stmt->execute(array($_COOKIE['osake']));
            $osakeid =  $stmt->fetch(PDO::FETCH_OBJ);

            $stmt = $db->prepare("INSERT INTO Tapahtuma (TapahtumaLkm, TapahtumaHinta, TapahtumaSalkku, TapahtumaOsake) VALUES( :f1,:f2,:f3,:f4)");
            $stmt->execute(array(':f1' => $lkm, ':f2' => $_COOKIE['hinta'], ':f3' => $salkkuid->SalkkuId, ':f4' => $osakeid->OsakeId));
            }

        if ($affected_rows = $stmt->rowCount()){
            echo 'Adding to portfolio succeed';
            }else {
            echo 'Something went wrong in newstock line 80' ;
      }

unset($_COOKIE['hinta']);
unset($_COOKIE['osake']);
}
?>
</article>

</content>
</body>

</html>
