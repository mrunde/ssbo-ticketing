<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="iso-8859-1" />

		<title>SSBO Ticketing - Ticket bestellen</title>
		<meta name="description" content="SSBO Ticketing System Ticket bestellen" />
		<meta name="author" content="Marius Runde" />

		<!-- Stylesheet -->
		<link rel="stylesheet" href="style.css" />

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.png" />
	</head>

	<body>
		<header>
			<h1>SSBO Ticketing - Ticket bestellen</h1>
		</header>

		<div id="result"></div>
		<?php
		if (isset($_POST['email'])) {

			// Open a connection to the MySQL server and select the database
			if (!@include_once ('db_info.php')) {// @ - to suppress warnings
				echo '<h1>500 Internal Server Error!</h1><br/>
					<b>Error message:</b> db_info.php does not exist!';
			} else {
				$connection = mysql_connect($db_host, $db_username, $db_password) or die('Keine Verbindung möglich. Benutzername oder Passwort sind falsch');
				mysql_select_db($db_database) or die('Die Datenbank existiert nicht.');

				// Create the code for this order
				$date = date('Y-m-d_H:i:s');
				$code = $date . "_" . substr($_POST['firstname'], 0, 1) . substr($_POST['lastname'], 0, 2) . "_" . rand(100, 999);

				// Insert a new order
				$query_insert = "INSERT INTO tickets (code, firstname, lastname, street, housenumber, postalcode, town, email, date) VALUES ('" . htmlentities($code, ENT_COMPAT, "iso-8859-1") . "', '" . htmlentities($_POST['firstname'], ENT_COMPAT, "iso-8859-1") . "', '" . htmlentities($_POST['lastname'], ENT_COMPAT, "iso-8859-1") . "', '" . htmlentities($_POST['street'], ENT_COMPAT, "iso-8859-1") . "', '" . htmlentities($_POST['housenumber'], ENT_COMPAT, "iso-8859-1") . "', " . htmlentities($_POST['postalcode'], ENT_COMPAT, "iso-8859-1") . ", '" . htmlentities($_POST['town'], ENT_COMPAT, "iso-8859-1") . "', '" . htmlentities($_POST['email'], ENT_COMPAT, "iso-8859-1") . "', '" . htmlentities($date, ENT_COMPAT, "iso-8859-1") . "')";
				$result_insert = mysql_query($query_insert);

				echo '<script type="text/javascript">
						document.getElementById("result").innerHTML = "<p>Deine Buchung wurde erfolgreich abgeschlossen.<br/>" +
						"Bitte &uuml;berweise den Betrag von XY&euro; an das folgende Konto. Verwende dabei auf jeden Fall den angebenen Verwendungszweck, damit wir die Bestellung dir zuordnen k&ouml;nnen!<br/>" +
						"<br/>" +
						"<table>" +
							"<tr>" +
								"<td>" +
									"Kontoinhaber:" +
								"</td>" +
								"<td>" +
									"Max Mustermann" +
								"</td>" +
							"</tr>" +
							"<tr>" +
								"<td>" +
									"Kontonummer:" +
								"</td>" +
								"<td>" +
									"123456789" +
								"</td>" +
							"</tr>" +
							"<tr>" +
								"<td>" +
									"Bankleitzahl:" +
								"</td>" +
								"<td>" +
									"011235813" +
								"</td>" +
							"</tr>" +
							"<tr>" +
								"<td>" +
									"Verwendungszweck:" +
								"</td>" +
								"<td>" +
									"' . $code . '" +
								"</td>" +
							"</tr>" +
						"</table>" +
						"</p><hr/>";
					</script>';

				// Close connection to MySQL server
				mysql_close($connection);
			}
		}
		?>
		<br/>
		Hier kannst du ein Ticket f&uuml;r das SSBO-Festival bestellen. Bitte gebe dazu im folgenden Formular alle Angaben an und &uuml;berweise danach das Geld f&uuml;r das Ticket an uns. Wir schicken dir das Ticket dann in digitaler Form sobald wie m&ouml;glich zu.
		<br/>
		<br/>
		<form name="order_form" action="#" method="post">
			<table>
				<tr>
					<td> Vorname: </td>
					<td>
					<input name="firstname" type="text" value="" placeholder="Vorname eingeben..." required autofocus />
					</td>
				</tr>
				<tr>
					<td> Nachname: </td>
					<td>
					<input name="lastname" type="text" value="" placeholder="Nachname eingeben..." required />
					</td>
				</tr>
				<tr>
					<td> Stra&szlig;e: </td>
					<td>
					<input name="street" type="text" value="" placeholder="Stra&szlig;e eingeben..." required />
					</td>
				</tr>
				<tr>
					<td> Hausnummer: </td>
					<td>
					<input name="housenumber" type="text" value="" placeholder="Hausnummer eingeben..." maxlength="5" required />
					</td>
				</tr>
				<tr>
					<td> Postleitzahl: </td>
					<td>
					<input name="postalcode" type="text" pattern="[0-9]{5}" title="Fünfstellige Postleitzahl" value="" placeholder="Postleitzahl eingeben..." maxlength="5" required />
					</td>
				</tr>
				<tr>
					<td> Stadt: </td>
					<td>
					<input name="town" type="text" value="" placeholder="Stadt eingeben..." required />
					</td>
				</tr>
				<tr>
					<td> E-Mail: </td>
					<td>
					<input name="email" type="email" value="" placeholder="E-Mail-Adresse eingeben..." required />
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
					<button type="submit">
						Ticket erstellen
					</button></td>
				</tr>
			</table>
		</form>

		<footer>
			<p>
				&copy; Copyright 2014 by Marius Runde
			</p>
		</footer>
	</body>
</html>