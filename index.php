<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8" />

		<title>SSBO Ticketing</title>
		<meta name="description" content="SSBO Ticketing System" />
		<meta name="author" content="Marius Runde" />

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.png" />
		
		<!-- jQuery -->
		<script src="lib/jquery-2.1.0.min.js"></script>
		
		<!-- qrcode -->
		<script src="lib/qrcode.min.js"></script>
		
		<!-- custom method to read out the URL parameters -->
		<script src="js/getParameters.js"></script>
	</head>

	<body>
		<header>
			<h1>SSBO Ticketing</h1>
		</header>

		<div id="qrcode">
			<!-- QRCode will be placed here, if the code is valid. If not a message will be prompted to the user. -->
		</div>
		
		<?php
			// Control the code
			$code = $_GET['code'];
	
			// Open a connection to the MySQL server and select the database
			require_once 'db_info.php';
			$connection = mysql_connect($db_host, $db_username, $db_password) or die('Keine Verbindung möglich. Benutzername oder Passwort sind falsch');
			mysql_select_db($db_database) or die('Die Datenbank existiert nicht.');
	
			// Select the row with the correct user_id
			$query = "SELECT * FROM tickets WHERE code = '" . $code . "' LIMIT 1";
			$result = mysql_query($query);
	
			while ($row = mysql_fetch_object($result)) {
				$used = $row -> used;
			}
			
			if (isset($used) && $used == FALSE) {
				// Code is correct
				echo '
		<script type="text/javascript">
			// Create the QRCode
			new QRCode(document.getElementById("qrcode"), getParam("code"));
		</script>
				';
			} elseif (isset($used) && $used == TRUE) {
				// Code has been used before
				echo '
		<script type="text/javascript">
			document.getElementById("qrcode").innerHTML = "Dieser Code wurde bereits verwendet!";
		</script>
				';
			} else {
				// Code is wrong	
				echo '
		<script type="text/javascript">
			document.getElementById("qrcode").innerHTML = "Dein Code konnte nicht in der Datenbank gefunden werden. Bitte überprüfe deine Eingaben. Wenn du glaubst, dass hier ein Fehler vorliegt, melde dich bitte beim Veranstalter.";
		</script>
				';
				
			}
	
			// Close connection to MySQL server
			mysql_close($connection);
		?>

		<footer>
			<p>
				&copy; Copyright 2014 by Marius Runde
			</p>
		</footer>
	</body>
</html>
