<?php
//Poistetaan istuntomuuttuja
if (isset($_SESSION['app1_islogged'])) {
    unset($_SESSION['app1_islogged']);
}
header('Location:' . dirname($_SERVER['PHP_SELF']) . '/' . 'index.php');

?>
