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
<script>

</script>
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
</form>

<?php
if (isset($_GET['logout'])){
include 'logout.php';
}

echo '<strong>';
echo 'Käyttäjä:<br><br>';
echo 'Salkut:<br><br>';
echo '<strong>';
echo '<button type="button" onclick="muutaTietoja()">Muuta tietoja</button> ';
?>
</article>

<article id='salkut'>
<?php
if (isset($_GET['uusi'])){
echo <<<UUSI
  <div>
  <form action="" method="get" style="text-align:left;">
  Portfolio name: <input type="text" name="salkkuID"><br><br>
  <button type='input' name='ready'>add</button>
  </form>
  </div>
UUSI;
}

$oletusSalkku = new Salkku();
$oletusSalkku->tulostaSalkku();

if(isset($_GET['ready'])){
$salkku = new Salkku;
$salkku->uusiSalkku($_GET['salkkuID']);
$salkku->tulostaSalkku();
}

?>
<aside >

</aside>

</article>

</content>

</body>

</html>
