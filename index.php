<?php

$r=$_GET['r'];
$g=$_GET['g'];
$b=$_GET['b'];
$colorpicker=$_GET['colorpicker'];

$output = shell_exec("pigpiod");
$output = shell_exec("pigs p 17 0");
$output = shell_exec("pigs p 22 0");
$output = shell_exec("pigs p 24 0");

if($r != "" AND $g != "" AND $b != "")
{
	$output = shell_exec("pigpiod");
	$output = shell_exec("pigs p 17 $r");
	$output = shell_exec("pigs p 22 $g");
	$output = shell_exec("pigs p 24 $b");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Colorpicker</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<body>

<p>
<a href="led.php?r=255&g=255&b=255">LED's anschalten</a>
<a href="led.php?r=0&g=0&b=0">LED's ausschalten</a>
</p>

<p>
<script>
function show(id) {
    if(document.getElementById) {
        var mydiv = document.getElementById(id);
        mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
    }
}
</script>
<a href="" onclick="javascript:show('divText'); return false">
Colorpicker einblenden</a>

<?php

if($colorpicker == "active") {
echo("
<div style='display: block' id='divText'>
");
}
else {
echo("
<div style='display: none' id='divText'>
");
}
?>
<canvas width="730" height="730" id="canvas_picker"></canvas>
<script type="text/javascript">
	var canvas = document.getElementById('canvas_picker').getContext('2d');

	// create an image object and get it’s source
	var img = new Image();
	img.src = 'image.jpg';

	// copy the image to the canvas
	$(img).load(function(){
	  canvas.drawImage(img,0,0);
	});

	// http://www.javascripter.net/faq/rgbtohex.htm
	function rgbToHex(R,G,B) {return toHex(R)+toHex(G)+toHex(B)}
	function toHex(n) {
	  n = parseInt(n,10);
	  if (isNaN(n)) return "00";
	  n = Math.max(0,Math.min(n,255));
	  return "0123456789ABCDEF".charAt((n-n%16)/16)  + "0123456789ABCDEF".charAt(n%16);
	}
	$('#canvas_picker').click(function(event){
	  // getting user coordinates
	  var x = event.pageX - this.offsetLeft;
	  var y = event.pageY - this.offsetTop;
	  // getting image data and RGB values
	  var img_data = canvas.getImageData(x, y, 1, 1).data;
	  var R = img_data[0];
	  var G = img_data[1];
	  var B = img_data[2];  var rgb = R + ',' + G + ',' + B;
	  // convert RGB to HEX
	  var hex = rgbToHex(R,G,B);
	  window.location.href = "led.php?r=" + R + "&g=" + G + "&b=" + B + "&colorpicker=active";
	  });
</script>
</p>
</div>

<p>
<a href="" onclick="javascript:show('divTexta'); return false">
Farben manuell bestimmen</a>

<div style='display: none' id='divTexta'>

 <form action="led.php" method="get">
Rot:
<?php
echo("
  <input type='range' name='r' min='0' max='255' value='$r'>
Grün:
<input type='range' name='g' min='0' max='255' value='$g'>
Blau:
<input type='range' name='b' min='0' max='255' value='$b'><br>
<input type='submit' value='Farbe setzen'>
");
?>
</form>
</p>
</div>

</body>
</html>

