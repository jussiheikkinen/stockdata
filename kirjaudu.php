<?php
session_start();
//mysql kirjautumistiedot
require_once ("/var/www/db-init.php");
if(isset($_POST['submit'])) {
$username = $_POST["userName"];
$password = $_POST["password"];
$message = '';
// varmistetaan että mysql injektio ei ole mahdollista
$stmt = $db->prepare("SELECT KayttajaSalasana FROM Kayttaja WHERE kayttajaTunnus = :username");
$stmt->bindValue(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);
//jos käyttäjää luodessa kryptattu salasana on sama kuin keskenään kryptattu hash ja syötetty salasana, niin salasana on oikein
if ($user->KayttajaSalasana == crypt($password, $user->KayttajaSalasana)) {
  //Jos oikein tallennetaan kirjautuminen sessiomuuttujiin ja ohjataan käyttäjä sivulle
  $_SESSION['app1_islogged'] = true;
  $_SESSION['userName'] = $_POST['userName'];
  header('Location:' . dirname($_SERVER['PHP_SELF']) . '/' . 'user.php');
  exit;
} else{ $message = 'Wrong input';
}
}
?>

<html style='background-image: url("./Kuvat/tausta1.jpg"); background-repeat: no-repeat; position:fixed; top:0; left:0; min-width:100%; min-height:100%;'>
<head>
<title>User Login</title>
<link rel="stylesheet" href="tyylit.css">
</head>

<body style='background-color: transparent; padding-top:15%; padding-bottom:15%; '>
<form method="post" action="" id='login'>
  <p><?php echo $message?></p>
  <input type="text" name="userName" placeholder="username" autofocus>
  <br><br>
  <input type="password" name="password" placeholder="password"><br><br>
  <button type="submit" name="submit" style='width:15em;'>Sign In</button><br><br>
  Not a member?<a href='newUser.php'>Join</a>
</form>


</body>
</html>
