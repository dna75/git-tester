<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>TypeScript</title>
</head>

<body>
	<script src="ts.js"></script>
	<h1>Test page DNA - ddd </h1>
	<?php
	// create random number between 1 and 100
	$randomNumber = rand(1, 100);

	echo "<h2>Random number is $randomNumber</h2>";

	// create countdown from time to zero
	$counter = 10;
	while ($counter > 0) {
		echo "<h3>Countdown: $counter</h3>";
		$counter--;
	}
	?>

	<!-- create countdown timer to specific time -->
	<h1 id="countdown"></h1>
	<script>
		// set the date we're counting down to
		var countDownDate = new Date("Dec 5, 2022 15:37:25").getTime();

		// update the count down every 1 second
		var x = setInterval(function() {

			// get today's date and time
			var now = new Date().getTime();

			// find the distance between now and the count down date
			var distance = countDownDate - now;

			// time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// output the result in an element with id="countdown"
			document.getElementById("countdown").innerHTML = days + "d " + hours + "h " +
				minutes + "m " + seconds + "s ";

			// if the count down is over, write some text 
			if (distance < 0) {
				clearInterval(x);
				document.getElementById("countdown").innerHTML = "EXPIRED";
			}
		}, 1000);
	</script>




</body>

</html>