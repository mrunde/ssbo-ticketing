<?php
	session_start();
	
	// Test login
	if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE) {
		echo 'Bitte melde dich erst an, um diese Seite zu nutzen!';
		return;
	}
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8" />

		<title>SSBO Ticketing - Neues Ticket</title>
		<meta name="description" content="SSBO Ticketing System Neues Ticket" />
		<meta name="author" content="Marius Runde" />
		
		<!-- Stylesheet -->
		<link rel="stylesheet" href="style.css" />
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.png" />
	</head>

	<body>
		<header>
			<h1>SSBO Ticketing - Neues Ticket</h1>
		</header>
		
		<div id="result"></div>
		<?php
			if (isset($_POST['ordercode'])) {
				$code = $_POST['ordercode'];
						
				// Open a connection to the MySQL server and select the database
				if (! @include_once('db_info.php')) { // @ - to suppress warnings 
					echo '<h1>500 Internal Server Error!</h1><br/>
					<b>Error message:</b> db_info.php does not exist!';
				} else {
					$connection = mysql_connect($db_host, $db_username, $db_password) or die('Keine Verbindung möglich. Benutzername oder Passwort sind falsch');
					mysql_select_db($db_database) or die('Die Datenbank existiert nicht.');
			
					// Select the row with the correct code
					$query = "SELECT code FROM tickets";
					$result = mysql_query($query);
					
					$checked = false;
					while ($row = mysql_fetch_object($result)) {
						$temp_code = $row -> code;
						if ($code == md5($temp_code)) {
							$checked = true;
							break;
						}
					}
					
					// Create a new ticket if the code is correct by updating the code from used to unused
					if ($checked == TRUE) {
						if ($row -> used == TRUE) {
							$query_update = "UPDATE tickets SET used = false WHERE code = '" . $temp_code . "'";
							mysql_query($query_update);
							
							echo '<script type="text/javascript">
								document.getElementById("result").innerHTML = "<h3>Das Ticket wurde erfolgreich erstellt.</h3>" +
								"Bitte schicke ' . $row -> firstname . ' eine <a href=\"mailto:' . $row -> email . '\" alt=\"E-Mail an ' . $row -> firstname . ' schicken.\">E-Mail</a> mit der Ticketnummer.<br/>" +
								"<br/>" +
								"Ticketnummer:     <b>' . $temp_code . '</b><hr/>";
							</script>';
						} else {
							echo '<script type="text/javascript">
								document.getElementById("result").innerHTML = "<p class=\"error\">Offenbar wurde dieses Ticket schon vorher einmal erstellt. Bitte &uuml;berpr&uuml;fe noch einmal alle Angaben und setze dich ggf. mit dem Administrator der Website in Kontakt.</p><hr/>";
							</script>';
						}
					} else {
						echo '<script type="text/javascript">
							document.getElementById("result").innerHTML = "<p class=\"error\">Der Bestellungscode konnte leider nicht gefunden werden. Bitte überprüfe noch einmal alle Angaben und setze dich ggf. mit dem Administrator der Website in Kontakt.</p><hr/>";
						</script>';
					}
					
					// Close connection to MySQL server
					mysql_close($connection);
				}
			}
		?>
		<br/>
		Um ein neues Ticket zu erstellen, trage bitte den Bestellungscode des K&auml;ufers ein.<br/>
		Dies ist nicht der Code, welcher f&uuml;r das Ticket verwendet wird, sondern nur f&uuml;r die Bestellung verwendet wird.<br/>
		Der Bestellungscode sollte als Verwendungszweck bei der Überweisung angegeben werden.<br/>
		<br/>
		<form name="new_form" action="#" method="post">
			<input name="ordercode" type="text" value="" placeholder="Code eingeben..." size="20" autofocus /><br/>
			<button type="submit">Ticket erstellen</button>
		</form>
		
		<footer>
			<p>
				&copy; Copyright 2014 by Marius Runde
			</p>
		</footer>
	</body>
</html>