<?php
session_start();

if (!isset($_SESSION['app1_islogged']) || $_SESSION['app1_islogged'] !== true) {
header('Location:' . dirname($_SERVER['PHP_SELF']) . '/' . 'kirjaudu.php');
exit;}

require_once 'Salkku.class.php';
require_once 'Osake.class.php';
?>

<html>
<head>
<title>User</title>
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
<article id="kayttaja">
<form action='<?php echo $_SERVER['PHP_SELF']?>' method='get'>
<button type="submit" name="logout" >logout</button>
<button type="submit" name="uusi" >uusi</button>
<button type="submit" name='deleteUser'>Remove user</button>
</form>

<strong>
Käyttäjä:<?php echo ' '.$_SESSION['userName']?><br><br>
<strong>

<?php
//LOGOUT
if (isset($_GET['logout'])){include 'logout.php';}
//REMOVE USER
if(isset($_GET['deleteUser'])){
require_once ('User.class.php');
$kayttaja = new kayttaja;
$kayttaja->deleteUser($_SESSION['userName']);
}
?>
<p>poo</p>
</article>

<article id='salkut'>
<?php
$oletusSalkku = new Salkku();
$oletusSalkku->tulostaSalkku($_SESSION['userName']);

//UUDEN OSAKKEEN LiSÄYS
include ('newstock.php');
lisaaOsake($oletusSalkku->salkkuID);
?>
</article>

<article id='salkut'>
<div id="donutchart" style="max-width: 55%; float:left;"></div>
<div style="width: 40%; float:right;">
<?php $taulu = ($oletusSalkku->laskeArvo($_SESSION['userName']));
echo 'Portfolio value: ' . array_sum($taulu) . '$';?>
</div>
</article>

<article id='kayttaja'>
<?php //data pie charttiin
  $taulu = array();
  $taulu = $oletusSalkku->chart();
//Lisätään taulun alkuun google chartin vaatimat määrittelyt multidimensional array niin array(array())
 array_unshift($taulu, array('Stock', 'Value'));
//PHP hakee numerot string muodossa, mutta piirakka haluaa numerista dataa, joten JSON_NUMERIC_CHECK kääntää ne
  print_r ($piirakka = json_encode($taulu, JSON_NUMERIC_CHECK));
?>
  <!--https://developers.google.com/chart/interactive/docs/gallery/piechart  -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
      <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
          var obj = JSON.parse('<?php echo $piirakka; ?>'); //Tyyppimuunnos JSON to js array
          console.info(obj);
          var data = google.visualization.arrayToDataTable(obj);
          var options = {
            pieHole: 0.35,
          };
          var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
          chart.draw(data, options);
        }
</script>
</article>
<!--
<article id='salkut'>
<?php
/* // Toisen salkun lisäys joka ei toimi toivotulla tavalla(ei saa lisäys valikkoa includetettua)
if (isset($_GET['uusi'])){
echo <<<UUSI
  <div>
  <form action="" method="get" style="text-align:left;">
  Portfolio name: <input type="text" name="salkkuID"><br><br>
  <button type='submit' name='ready'>add</button>
  </form>
  </div>
UUSI;
}
if (isset($_GET['ready'])){
$salkku = new Salkku;
$salkku->uusiSalkku($_GET['salkkuID']);
$salkku->tulostaSalkku($_SESSION['userName']);
include ('newstock.php');
//lisaaOsake($salkku->salkkuID);
}*/
?>
</article>
-->
</content>
</body>
</html>
