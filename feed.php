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

<pre>

<?php

$homepage = file_get_contents("https://www.nordnet.fi/mux/web/marknaden/kurslista/aktier.html?marknad=Finland&lista=1_1&large=on&mid=on&small=on&sektor=0&subtyp=price&sortera=aktie&sorteringsordning=stigande");

   //if (preg_match_all('/underline.>[A-Za-z\s<\/>0-9,="%]+EUR/',$homepage , $matches)){
   if (preg_match_all('/[A-Z]+[A-Za-z\s<\/>0-9,="%]+EUR/',$homepage , $matches)){

        	$i = 0;
   	$j = count($matches, COUNT_RECURSIVE) -1 ;
   	while ($i < $j){

   	preg_match_all('/[A-Z]+[A-Za-z\s]+|[0-9,%]+/', $matches[0][$i], $osumat);

   	$i++;
   }

   print_r ($matches);

   }

?>

</pre>
}

}
?>

  </pre>

<article>

</content>
</body>

</html>
