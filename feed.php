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

$homepage = file_get_contents("https://www.nordnet.fi/mux/web/marknaden/kurslista/aktier.html");

   //if (preg_match_all('/underline.>[A-Za-z\s<\/>0-9,="%]+EUR/',$homepage , $matches)){
if (preg_match_all('/[A-Z]+[A-Za-z\s<\/>0-9,="%]+EUR/',$homepage , $matches)){

     	$i = 0;
	$j = count($matches, COUNT_RECURSIVE) -1 ;
	while ($i < $j){

	$data = preg_match_all('/[A-Z]+[A-Za-z\s]+|[0-9,%]+/', $matches[0][$i], $osumat);

	$i++;
print_r ($osumat);
}

print_r ($matches);

}

/*	$i = 0;
	$j = count($matches, COUNT_RECURSIVE) -1 ;
	while ($i < $j){
	$data = explode("</td>", $matches[0][$i]);// näyttää tältä <td  >37,13</td>
						// näyttää tältä <td  >37,13
	$taulu[] = implode("<td >",$data); 	// näyttää tältä <td  >37,13<td >
	$taulu1[] = explode("<td >",$taulu[$i]);	// pitäsi näyttää tältä 7,13, mutta näytää tältä <td  >37,13
	$i++;	}   [A-Z]|([a-z]){4,30}\w+|[0-9,%]
			/<td.class[a-z&0-9=\?.\/"\s<>]+[A-Za-z\s<\/>0-9,="%]+EUR<\/td>/
     */
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
