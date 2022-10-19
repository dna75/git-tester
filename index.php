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
</body>

</html>