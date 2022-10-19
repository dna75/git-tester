<!DOCTYPE html>
<html lang="nl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>

	<?php
	// check wheter the username is abc and password is 123
	if ($_POST['username'] == 'abc' && $_POST['password'] == '123') {
		echo '<p>Welkom</p>';
	} else {
		echo '<p>Verkeerde gebruikersnaam of wachtwoord</p>';
	}
	?>



</body>

</html>