<html style='background-image: url("./Kuvat/tausta1.jpg"); background-repeat: no-repeat; position:fixed; top:0; left:0; min-width:100%; min-height:100%;'>
<head>
<title>User Login</title>
<link rel="stylesheet" href="tyylit.css">
</head>

<body style='background-color: transparent; padding-top:15%; padding-bottom:15%; '>

<form method="post" action="" id='login'>
  <input type='text' name='enimi' placeholder='Name'>
  <br><br>
  <input type='text' name='snimi' placeholder='Lastname'>
  <br><br>
  <input type='text' name='tunnus' placeholder='Username'>
  <br><br>
  <input type='password' name='salasana' placeholder='Password'>
  <br><br>
  <button type="submit" name="submit" style='width:15em;'>register</button><br><br>

<?php
require_once ("/home/H4214/php-dbconfig/db-init.php");
// Lisää tarkistukset kenttiin kun kerkiät
if (isset($_POST['submit'])){
$nimi = $_POST['enimi'];
$snimi = $_POST['snimi'];
$tunnus = $_POST['tunnus'];
$pass = $_POST['salasana'];

$stmt = $db->prepare("INSERT INTO kayttaja (kayttajaID, salasana, enimi, snimi) VALUES( ?, PASSWORD(?), ?, ?)");
$stmt->execute(array($tunnus, $pass, $nimi, $snimi));
//tarkistetaan onnistuiko lisääminen
if ($affected_rows = $stmt->rowCount()){
   echo 'Registering succeed';
} else {
exit('<p>Something went wrong</p>');
}
// uudelleenohjaa 2 sekunnin kuluttua kkirjautumissivulle jos rekisteröinti onnistui
echo '<META HTTP-EQUIV="Refresh" Content="2; URL=kirjaudu.php">';
}
?>
</form>
</body>
</html>
