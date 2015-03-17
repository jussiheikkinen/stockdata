<?php
/*
Description: Getting Stock Data from Yahoo! Finance
//http://www.canbike.ca/information-technology/2013/08/10/yahoo-finance-url-download-to-a-csv-file.html
* This function gets a symbol or an array of symbol as a parameter.
* And it returns an array of the corresponding stock data.
* If an error occurs, the detail of the error is saved in $error_message variable
* which is passed by reference from the parent function
*/
include_once("data.php");

function haeData($symbol, &$error_message) {

	global $yahoo_finance_tags;
	$error_message = NULL; // Default value

	$f = ""; // The f parameter in Yahoo! Finance URL
	foreach($yahoo_finance_tags as $key => $value) // data.php sisältää $yahoo_finance_tags($key => $value)
		$f = $f . $key;// eli hakee kaiken datan...muuta data tiedostoa tai tätä että hakee vain halutut arvot.
						//tähän voisi muutta vain että f = ne tagit mitä haluaa

	if ( strlen($symbol) < 1 || $symbol == NULL ) { // if the symbol is invalid
	$error_message = "The given symbol is invalid.";
	return -1; // ERROR
	}

	$url = "http://finance.yahoo.com/d/quotes.csv?s=" . $symbol . "&f=" . $f;
	//print_r ($url);
	$fp = @fopen($url, "r");
	if ( $fp == FALSE ) { // If the URL can't be opened
		$error_message = "Cannot get data from Yahoo! Finance. The following URL is not accessible, $url";
		return -1; // ERROR
	}

	$array = @fgetcsv($fp , 4096 , ', ');
	$arr = array();
	$i = 0;
	foreach($yahoo_finance_tags as $key => $value) {
		$arr[$key] = $array[$i];
		$i = $i + 1;
	}
		@fclose($fp);
		return $arr;
	}


function haeHinta($symbol){
$key = 'a';//a0 = ask l1=last price
$static = '&e=.csv';
$url = "http://finance.yahoo.com/d/quotes.csv?s=" . $symbol . "&f=" . $key . $static;
$fp = @fopen($url, "r");

if ( $fp == FALSE ) { // If the URL can't be opened
	return -1; // ERROR
}

$array = @fgetcsv($fp , 1000);
@fclose($fp);
return $array;
}

?>
