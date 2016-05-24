<?php

/* LEDControl by blog.mattionline.de */

$r=$_GET['r'];
$g=$_GET['g'];
$b=$_GET['b'];
$colorpicker=$_GET['colorpicker'];
$manually=$_GET['manually'];

/* after every raspberry pi reboot you must execute pigpiod manually */
$execute = shell_exec("pigpiod");
$execute = shell_exec("pigs p 17 0");
$execute = shell_exec("pigs p 22 0");
$execute = shell_exec("pigs p 24 0");

if($r != "" AND $g != "" AND $b != "")
{
	$execute = shell_exec("pigpiod");
	$execute = shell_exec("pigs p 17 $r");
	$execute = shell_exec("pigs p 22 $g");
	$execute = shell_exec("pigs p 24 $b");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>LEDControl by blog.mattionline.de</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script>
	function show(id) {
		if(document.getElementById) {
			var mydiv = document.getElementById(id);
			mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
		}
	}
	</script>
	<style>
		body {
			width:50%;
			padding-top:5%;
			margin:auto;
		}
	</style>
</head>
<body>

LEDControl by <a href="https://blog.mattionline.de/">https://blog.mattionline.de/</a><br><br><br>
<p>
<a href="index.php?r=255&g=255&b=255">Turn on LED's</a>
<a href="index.php?r=0&g=0&b=0">Turn off LED's</a>
</p>

<p>
<a href="" onclick="javascript:show('divcolorpicker'); return false">Display colorpicker</a>

<?php

if($colorpicker == "active") {
	echo("
		<div style='display: block' id='divcolorpicker'>
	");
}
else {
	echo("
		<div style='display: none' id='divcolorpicker'>
	");
}

?>

	<canvas width="730" height="730" id="canvas_picker"></canvas>

	<script type="text/javascript">
        var canvas = document.getElementById('canvas_picker').getContext('2d');

        // create an image object and get it’s source
        var img = new Image();
        img.src = 'colorwheel.jpg';

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
        window.location.href = "index.php?r=" + R + "&g=" + G + "&b=" + B + "&colorpicker=active";
        });
        </script>

	</div>
</p>

<p>
<a href="" onclick="javascript:show('divmanually'); return false">Set colors manually</a>

<?php

if($manually == "active") {
        echo("
                <div style='display: block' id='divmanually'>
        ");
}
else {
        echo("
                <div style='display: none' id='divmanually'>
        ");
}

?>

	<form action="index.php" method="get">

	<?php
	echo("
		Red: <input type='range' name='r' min='0' max='255' value='$r'>
		Green: <input type='range' name='g' min='0' max='255' value='$g'>
		Blue: <input type='range' name='b' min='0' max='255' value='$b'><br>
		<input type='hidden' name='manually' value='active'>
		<input type='submit' value='Farbe setzen'>
	");
	?>
	</form>
</div>
</p>

</body>
</html>

