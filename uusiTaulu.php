<?php
//unohda vielä tämä feature
require_once 'Taulu.class.php';
	$uusi = new Taulu();
	$uusi->uusi_canvas();
	$uusi->uusi_form();
	$uusi->hae('YHOO');
?>
<!---
<content>
	<article>
	<div id="myDiv"><h2>Lisää tästä uusi taulu</h2></div>
	<button type="button" onclick="loadXMLDoc()">Uusi</button>
	</article>
	<aside>
	<?php
	//$uusi->tulosta_tiedot();
	?>
	</aside>
</content>
--->
<script>
function loadXMLDoc()
{
var xmlhttp;

xmlhttp=new XMLHttpRequest();

xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","uusiTaulu.php",true);
xmlhttp.send();
}
</script>
