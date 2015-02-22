<?php

	function haeHistoria($nimi, $fm, $fd, $fy, $tm, $td, $ty, $interval){
	
	//$taulu = array($fm, $fd, $fy, $tm, $td, $ty, $interval);	
	$static = '&ignore=.csv';	

	$url = "http://ichart.yahoo.com/table.csv?s=".$nimi.'&a'.'='.$fm.'&b'.'='.$fd.'&c'.'='.$fy.'&d'.'='.$tm.'&e'.'='.$td.'&f'.'='.$ty.'&g'.'='.$interval.$static;	
	//print_r ($url);
	$arr = array();
	$taulu = array();
	$i=0;
	$file = @fopen($url, "r");		
	while(! feof($file))
	{		
		$taulu = (@fgetcsv($file));	
		$arr[] = ($taulu[4]);
	}
	return ($arr);
@fclose($file);
	}	
/*
 Date [1] => Open [2] => High [3] => Low [4] => Close [5] => Volume [6] => Adj Close 
 
Start with the default base URL for historical quotes download.
http://ichart.yahoo.com/table.csv?s=

From Date
In this example I will download the quotes from 15/3/2000 until 31/1/2010.

At first you have to add the number of the month minus 1.
http://ichart.yahoo.com/table.csv?s=GOOG&a=2

Then add the number of the day.
http://ichart.yahoo.com/table.csv?s=GOOG&a=0&b=15

At last add the year.
http://ichart.yahoo.com/table.csv?s=GOOG&a=0&b=1&c=2000

To Date
Adding the "To Date" data is nearly the same.

Month minus 1.	
http://ichart.yahoo.com/table.csv?s=GOOG&a=0&b=1&c=2000&d=0

Day.	
http://ichart.yahoo.com/table.csv?s=GOOG&a=0&b=1&c=2000&d=0&e=31

And the Year.	
http://ichart.yahoo.com/table.csv?s=GOOG&a=0&b=1&c=2000&d=0&e=31&f=2010

Interval
Now you have to add the interval of the trading periods.
http://ichart.yahoo.com/table.csv?s=GOOG&a=0&b=1&c=2000&d=0&e=31&f=2010&g=w

Static part at the end add the following to the URL.
http://ichart.yahoo.com/table.csv?s=GOOG&a=0&b=1&c=2000&d=0&e=31&f=2010&g=w&ignore=.csv
	*/
	?>