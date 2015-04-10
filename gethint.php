<?php

// Array with names
$filename = "osakenimet.txt";
if (!$fp = @fopen($filename, "r")) {echo "fopen virhe!"; exit();}

while (!feof($fp)){
   $a[] = explode( ',',fgets($fp, 20));
}
   fclose ($fp);


// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?>
