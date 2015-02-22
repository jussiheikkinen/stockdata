<?php
/**
 * php-syntax-highlighter.php
 *
 * PHP-ohjelma, joka tarjoaa käyttöliittymän tietyssä web-kansiossa sijaitsevien 
 * C++-ohjelmien syntaksin korostamiseen web-sivulla.
 *
 * Käyttää syntaksin korostukseen:
 * http://alexgorbatchev.com/SyntaxHighlighter
 * 
 * @version
 * 0.0.1 (20.9.2013)
 * 
 * @copyright
 * Copyright (C) 2013 Ari Rantala
 *
 * @license
 * Dual licensed under the MIT and GPL licenses.
 *
 *
 */
  
/*********************************************************************************/
/*
 * Alustukset
*/
session_start();
  
$jsurl    = "http://student.labranet.jamk.fi/~ara/syntaxhighlighter/scripts/";
$cssurl = "http://student.labranet.jamk.fi/~ara/syntaxhighlighter/styles/";
$file_extensions = "php";
  
$dir = dirname ($_SERVER['SCRIPT_FILENAME']) . "/";
$fiilu  = (isset($_GET['fiilu'])) ? $_GET['fiilu'] : '';
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
$self   = (isset($_SERVER['PHP_SELF'])) ?
           $_SERVER['PHP_SELF'] : '';
  
if (isset($_GET['csstheme'])) { 
   $_SESSION['csstheme']   = $_GET['csstheme'];
   $csstheme   = $_GET['csstheme'];
}
else if (isset($_SESSION['csstheme'])) { 
   $csstheme   = $_SESSION['csstheme'];
}
else {
   $csstheme   = 'Default';
}
  
/*********************************************************************************/
/*
 * Navigointivalikko
*/
  
  
$headelement = <<<HEADELEMENT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>$fiilu</title>
    <script type="text/javascript" src="{$jsurl}shCore.js"></script>
    <script type="text/javascript" src="{$jsurl}shBrushPhp.js"></script>
    <link type="text/css" rel="stylesheet" href="{$cssurl}shCore{$csstheme}.css"/>
    <script type="text/javascript">SyntaxHighlighter.all();</script>
  
<style type="text/css">
    #menu, #menu ul{ padding:0; margin:0}
    #menu a{display:block; text-decoration: none;}
    #menu li{display:block; float:left;}
    #menu li ul li{float:none;}
    #menu li ul{display:none; position:absolute; z-index:1}
    #menu li:hover ul{display:block;}
  
    #menu{height:10px}
    #menu a{color:#009; padding:3px 6px 3px 6px; text-decoration: none;}
    #menu a:hover{color:#00F; text-decoration: none;}
    #menu li{background-color:#E9E9E9; border:solid 1px #AAF;  margin-left:3px}
    #menu li:hover{background-color:#BBB}
</style>
  
</head>
  
<body style="background: white; font-family: Helvetica">
  
<ul id='menu'>
   <li><a href='#'>Style: $csstheme</a>
     <ul>
         <li><a href='{$self}?action=show&fiilu={$fiilu}&csstheme=Default'>Default</a></li>
         <li><a href='{$self}?action=show&fiilu={$fiilu}&csstheme=Eclipse'>Eclipse</a></li>
         <li><a href='{$self}?action=show&fiilu={$fiilu}&csstheme=Emacs'>Emacs</a></li>
         <li><a href='{$self}?action=show&fiilu={$fiilu}&csstheme=FadeToGrey'>FadeToGrey</a></li>
         <li><a href='{$self}?action=show&fiilu={$fiilu}&csstheme=Django'>Django</a></li>
         <li><a href='{$self}?action=show&fiilu={$fiilu}&csstheme=MDUltra'>MDUltra</a></li>
         <li><a href='{$self}?action=show&fiilu={$fiilu}&csstheme=Midnight'>Midnight</a></li>
         <li><a href='{$self}?action=show&fiilu={$fiilu}&csstheme=RDark'>RDark</a></li>
     </ul>
   </li>   <li><a href='{$self}'>Listaa</a>
   </li>
</ul>
  
<h1>$fiilu</h1>
  
HEADELEMENT;
  
  
/*********************************************************************************/
/*
 * Main
*/
  
$filet = array();
$handle=opendir($dir);
// $file sis. vuorollaan jokaisen tiedoston hakemistosta:
$found  = 0;
while ($file = readdir($handle)) {
  // vain halutut tiedostot kasitellaan:
  if (is_file($dir . $file) AND preg_match("/^.+\.({$file_extensions})$/",$file)) {
      $filet[] = $file; $found  = 1;
  }
}
sort($filet);
  
// jos seurattu linkkia ja kansiossa oleva tiedosto käsillä:
if ($action == "show" AND in_array($fiilu, $filet)) {
   echo $headelement;
   echo "<pre class='brush: php;'>\n";
   $file = htmlspecialchars(file_get_contents($dir . $fiilu, true));
   echo $file;
   echo "\n</pre>\n";
   echo "</html>\n";
  
} else {
  
echo "<ul>";
foreach ($filet as $file)
{
    echo "<li>" .
         "<a href='$self?action=show&fiilu=$file'>" .
         "$file</a>";
}
if (!$found) echo "<li>Tässä kansiossa ei ole tiedostoja päätteillä: $file_extensions!\n";
echo "</ul>";
}
?> 