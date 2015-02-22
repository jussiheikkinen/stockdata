<html style='background-image: url("./Kuvat/tausta1.jpg"); background-repeat: no-repeat; position:fixed; top:0; left:0; min-width:100%; min-height:100%;'>
<head>
<title>User Login</title>
<link rel="stylesheet" href="tyylit.css">
</head>

<body style='background-color: transparent; padding-top:15%; padding-bottom:15%; '>

<form method="post" action="" id='login'>
  <input type='text' name='enimi' placeholder='Name' required autofocus>
  <br><br>
  <input type='text' name='snimi' placeholder='Lastname' required>
  <br><br>
  <input type='text' name='tunnus' placeholder='Username' required>
  <br><br>
  <input type='password' name='salasana' placeholder='Password' required>
  <br><br>
  <button type="submit" name="submit" style='width:15em;'>register</button><br><br>

<?php
require_once ("db-init.php");
// Lisää tarkistukset kenttiin kun kerkiät
if (isset($_POST['submit'])){
$nimi = $_POST['enimi'];
$snimi = $_POST['snimi'];
$tunnus = $_POST['tunnus'];
$pass = crypt($_POST['salasana']);
// let the salt be automatically generated näköjään $6$ eli SHA-512
// https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
$stmt = $db->prepare("INSERT INTO kayttaja (kayttajaID, hash, enimi, snimi) VALUES( ?, ?, ?, ?)");
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
