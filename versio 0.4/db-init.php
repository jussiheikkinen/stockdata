<?php
// db-init.php
$db = new PDO('mysql:host=192.168.10.53;dbname=omaDB;charset=utf8',
              'jussi', 'kalamies');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>
