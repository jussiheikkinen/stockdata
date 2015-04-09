<?php
session_start();

if (!isset($_SESSION['app1_islogged']) || $_SESSION['app1_islogged'] !== true) {
header('Location:' . dirname($_SERVER['PHP_SELF']) . '/' . 'kirjaudu.php');
exit;}
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

echo <<<SALKKU
     <tr><td><a href="feed.php?osake={$osumat[0][0]}&hinta={$osumat[0][1]}">{$osumat[0][0]}</a></td><td>{$osumat[0][1]}</td><td>{$osumat[0][3]}</td><td style=$color>{$osumat[0][5]}</td>
     <td>{$osumat[0][8]}</td><td>{$osumat[0][9]}</td><td>$volume</td><td>$valuutta</td></tr>
SALKKU;
$i++;
}
echo "</table>";
}
?>
</pre>
<article>
<article id="kayttaja" style="float:right; margin-left:10%;">
  <?php
  include (newstock);
  $hinta = (double)$_GET[hinta];

  echo <<<NEW
  <div id="lomakkeet">
  <form method='get' action='' id='lisaysform'>
  Buy
  <table>
  <tr><td>Stock</td><td>$_GET[osake]</td></tr>
  <tr><td>Price</td><td>$hinta</td></tr>
  <tr><td>Amount</td><td><input type="number" name="amount" required></td></tr>
  </table>
  <button type="submit" name='addstock'>Buy</button>
  </form>
NEW;

//$oletusSalkku = new Salkku();
lisaaOsake($oletusSalkku->salkkuID);
  ?>

<article>

</content>
</body>

</html>
