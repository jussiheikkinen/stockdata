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
require ("/var/www/db-init.php");
//echo '<h2></h2>';
echo '<table id="omasalkku"><tr><th>Nick</th><th>Stock</th><th>Amount</th><th>Avg price</th><th>Value</th><th>Currency</th><th>Market</th><th>Timestamp</th></tr>';

    $stmt = $db->prepare('SELECT * FROM Nakyma WHERE KayttajaTunnus = ?');
    $stmt->execute(array($_SESSION['userName']));
    while ($nakyma = $stmt->fetch(PDO::FETCH_OBJ)){

echo <<<VIEW
     <tr>
     <td>$nakyma->KayttajaTunnus</td><td>$nakyma->OsakeNimi</td><td>$nakyma->TapahtumaLkm</td><td>$nakyma->TapahtumaHinta</td><td>$nakyma->Arvo</td>
     <td>$nakyma->TiedotValuutta</td><td>$nakyma->TiedotMarkkina</td><td>$nakyma->TapahtumaAika</td>
     </tr>
VIEW;
}

echo "</table>";

?>
</pre>
</article>

</content>
</body>

</html>
