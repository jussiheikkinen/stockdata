<html>
<head>
<!--<meta http-equiv="refresh" content="15" >-->
<title>Stocksdata</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="icon.ico">
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="tyylit.css">
</head>

<body>

<header>
<?php include ('header.php'); ?>
</header>

<h1 style="margin-left:7%; height: 1vh; line-height: 2vh; font-size: 4vh;">NASDAQ / NYSE </h1>
<content>
	<article>
		<canvas id="myCanvas" width="600" height="300">
		</canvas>

		<form id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method= "get">
		From:
		<input type="date" name="from">
		To:
		<input type="date" name="to">
		<select name='väli'>
		<option value="d">Daily</option>
		<option value="w">Weekly</option>
		<option value="m">Monthly</option>
		</select>
		<input type="text" name="osake" placeholder="Id" style='width:15%;'>
		<button type="submit" name="haku">search</button>
		</form>

		<?php
		include ('historia.php');
		// Hakee histoalliset pörssitiedot
		if (isset($_GET['haku'])){
			$nimi = $_GET['osake'];
			$from =  explode('-', $_GET['from']);
			$to = explode('-', $_GET['to']);
			$interval = $_GET['väli'];
			$hClose = haeHistoria( $nimi, $from[1], $from[2], $from[0], $to[1], $to[2], $to[0], $interval);
			  $history = json_encode($hClose);
				//echo $history;

		//Hakee tiedot yrityksestä
		require_once 'Taulu.class.php';
		$taulu = new Taulu();
		$taulu->hae($_GET['osake']);
		}
		?>
		<strong>Syötä esim AMD, TWTR, GOOG, AAPL, NOK, </strong>
	</article>

	<aside>
	<?php
	if (isset($_GET['haku']))
	$taulu->tulosta_tiedot();
	?>
	</aside>
</content>

<script>
<!-- Piirrä koordinaatti   -->
 function writeMessage(canvas, message) {
        var context = canvas.getContext('2d');
        context.clearRect(0, 0, canvas.width, 30);
        context.font = '10pt Calibri';
        context.fillStyle = 'black';
        context.fillText(message, 10, 25);
      }
      function getMousePos(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
		x: (evt.clientX-rect.left)/(rect.right-rect.left)*canvas.width,
		y: (evt.clientY-rect.top)/(rect.bottom-rect.top)*canvas.height
        };
      }
      var canvas = document.getElementById('myCanvas');
      var context = canvas.getContext('2d');

      canvas.addEventListener('mousemove', function(evt) {
        var mousePos = getMousePos(canvas, evt);
        var message = '(x,y) ' + mousePos.x + ' , ' + mousePos.y ;
        writeMessage(canvas, message);
      }, false);

		//Event listener for mouse over element
			canvas.addEventListener('mouseover', function(evt) {
				   var y = this.context.height;
						console.log(y);
			});

    elemLeft = canvas.offsetLeft,
    elemTop = canvas.offsetTop,
    context = canvas.getContext('2d'),
    elements = [];

// Add event listener for `click` events.
canvas.addEventListener('click', function(event) {
    var x = event.pageX - elemLeft,
        y = event.pageY - elemTop;
    console.log(x, y);
    elements.forEach(function(element) {
        if (y > element.top && y < element.top + element.height && x > element.left && x < element.left + element.width) {
					console.log(element.height);
        }
    });

}, false);

//elementtien määrä on sama kuin taulukon alkioiden määrä, luodaan loopissa yhtä monta elementtiä ja pushataan ne canvakselle
var vasen = 1;
var j = 1;//taulukon indeksi loopissa
var array = JSON.parse( '<?php echo $history;?>' ); // Convert JSON String to JavaScript Object
for ( i = 1; i < array.length; i++) {

//Jos päiviä yli 85 niin ohuemmat palkit
	if ( array.length < 90){
		leveys = 3;
	}else if ( array.length < 155 ){
		leveys = 2;
	}else {
		leveys = 1;
	}

elements.push({// Add element.
    width: leveys,
    height: array[j],
    top: 300 - array[j],
    left: vasen
});

// Render elements.
elements.forEach(function(element) {
    context.fillStyle = '#05EFFF';
    context.fillRect(element.left, element.top, element.width, element.height);
});

//Jos päiviä yli 85 niin ohuemmat palkit
if ( array.length < 90){
			vasen = vasen + 5;
		}else if ( array.length < 155 ){
			vasen = vasen + 3;
		}else {
			vasen = vasen + 1;
		}

j++;
}

</script>

</body>

</html>
