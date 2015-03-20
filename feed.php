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
<article id = "kayttajat">

  <?php

  $homepage = file_get_contents("https://www.nordnet.fi/mux/web/marknaden/kurslista/aktier.html");

     if (preg_match_all('/class=.underline.>[A-Za-z\s<\/>0-9,="%]+EUR/',$homepage , $matches)){
       echo "loytyi";
       print_r ($matches);
     }
  ?>

<article>

</content>
</body>

</html>
