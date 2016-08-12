<!DOCTYPE html>
<html>
	<head>
		<script>
			function tratar(d){
				d = String(d);
				if (d.length < 2) {
					// console.log('true');
					return tratar('0'+d);
				}else {
					// console.log('fal');
					return d;
				}
			}
			setInterval(function(){
				var d = new Date();
				var x = d.getFullYear() + '-' + (tratar(d.getUTCMonth() + 1))+'-'+tratar(d.getUTCDate()) + ' > ' +
						tratar(d.getHours())+':'+ tratar(d.getMinutes())+':'+tratar(d.getSeconds());
				document.getElementById('a').innerHTML = x;
			}, 1000);
		</script>
	</head>
	<body>
		<span id="a"></span>
	</body>
</html>

<?php
// date_default_timezone_set('America/Recife');
// echo date('Y-m-d > H:i:s');
?>
