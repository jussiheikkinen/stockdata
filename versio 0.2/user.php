<html style="width:100%;" >
<head>
<!--<meta http-equiv="refresh" content="15" >-->
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

<content >
<article style='padding:5%;'>
<?php 
echo '<strong>';
echo 'Käyttäjä:<br><br>';
echo 'Nimi ' . 'Sukunimi<br><br>';
echo 'Salkut:<br><br>';
echo '<strong>';
echo '<button type="button" onclick="loadXMLDoc()">Muuta tietoja</button> ';
echo '<button type="button" onclick="loadXMLDoc()">Muuta salasana</button> ';
echo '<button type="button" onclick="loadXMLDoc()">Uusi salkku</button> ';
?>
</article>

<article style='padding:5%;'>
<?php 
echo '<strong>Salkku 1<strong><br>';
echo '
<table style="width:90%">
  <tr>
    <th>Osake</th>
    <th>osto</th>
	<th>määrä</th>
	<th>tuotto</th>
  </tr>
  <tr>
    <td>January</td>
	<td>January</td>
	<td>January</td>
    <td>$100</td>
  </tr>
  <tr>
    <td>February</td>
    <td>$50</td>
	<td>February</td>
	<td>February</td>
  </tr>
  <tr>
    <td>February</td>
    <td>$50</td>
	<td>February</td>
	<td>February</td>
  </tr>
  <tr>
    <td>February</td>
    <td>$50</td>
	<td>February</td>
	<td>February</td>
  </tr>
</table>
';

echo '<button type="button" onclick="loadXMLDoc()">Käy kauppaa</button> ';
echo '<button type="button" onclick="loadXMLDoc()">Poista salkku</button> ';

?>
<aside>
<?php

?>
</aside>

</article>

</content>

</body>

</html>