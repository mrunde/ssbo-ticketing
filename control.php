<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8" />

		<title>SSBO Ticketing - Login</title>
		<meta name="description" content="SSBO Ticketing System Login" />
		<meta name="author" content="Marius Runde" />

		<!-- Stylesheet -->
		<link rel="stylesheet" href="style.css" />

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.png" />
	</head>

	<body>
		<header>
			<h1>SSBO Ticketing - Login</h1>
		</header>

		<form name="control_form" action="index.php" method="post">
			<input name="user" type="text" value="" placeholder="Nutzername eingeben..." autofocus />
			<br/>
			<input name="pass" type="password" value="" placeholder="Passwort eingeben..." />
			<br/>
			<button type="submit">
				Anmelden
			</button>
		</form>

		<footer>
			<p>
				&copy; Copyright 2014 by Marius Runde
			</p>
		</footer>
	</body>
</html>
