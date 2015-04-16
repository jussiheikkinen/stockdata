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
require_once ("/var/www/db-init.php");
// Lisää tarkistukset kenttiin kun kerkiät
if (isset($_POST['submit'])){
$nimi = $_POST['enimi'];
$snimi = $_POST['snimi'];
$tunnus = $_POST['tunnus'];
$hash = crypt($_POST['salasana']);

// let the salt be automatically generated näköjään $6$ eli SHA-512 salt 18 merkkiä pitkä = turvallinen
// https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
$stmt = $db->prepare("INSERT INTO Kayttaja (KayttajaNimi, KayttajaSukunimi, KayttajaTunnus, KayttajaSalasana) VALUES( ?, ?, ?, ?)");
$stmt->execute(array($nimi, $snimi, $tunnus, $hash));

//Tehdään salkku
$stmt = $db->prepare("SELECT KayttajaId FROM Kayttaja WHERE KayttajaTunnus =?");
$stmt->execute(array($tunnus));
$kayttajaid =  $stmt->fetch(PDO::FETCH_OBJ);

//lisätään oikea id salkulle
$stmt = $db->prepare("INSERT INTO Salkku (SalkkuNimi, SalkkuKayttaja) VALUES (?, ?)");
$stmt->execute(array('oletus', $kayttajaid->KayttajaId));

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
