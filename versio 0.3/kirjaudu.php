<?php
session_start();
require_once ("/home/H4214/php-dbconfig/db-init.php");

if(isset($_POST['submit'])) {
$stmt = $db->prepare("SELECT * FROM kayttaja WHERE kayttajaID=? AND salasana=?");
$stmt->execute(array($_POST["userName"], $_POST["password"]));
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['kayttajaID'] == $_POST["userName"] && $row['salasana'] == $_POST['password']){

//lisää tiedot kirjautumisesta sessio muuttujiin
		$_SESSION['app1_islogged'] = true;
		$_SESSION['userName'] = $_POST['userName'];
		header('Location:' . dirname($_SERVER['PHP_SELF']) . '/' . 'user.php');
		exit;
	}
  else{echo 'Wrong input';}}}
?>
<html style='background-image: url("./Kuvat/tausta1.jpg"); background-repeat: no-repeat; position:fixed; top:0; left:0; min-width:100%; min-height:100%;'>
<head>
<title>User Login</title>
<link rel="stylesheet" href="tyylit.css">
</head>

<body style='background-color: transparent; padding-top:15%; padding-bottom:15%; '>
<form method="post" action="" id='login'>
  <input type="text" name="userName" placeholder="username">
  <br><br>
  <input type="password" name="password" placeholder="password"><br><br>
  <button type="submit" name="submit" style='width:15em;'>Sign In</button><br><br>
  Not a member?<a href='newUser.php'>Join</a>
</form>

</body>
</html>
