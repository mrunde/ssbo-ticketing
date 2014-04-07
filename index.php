<?php
	session_start();
	
	// Test login to set codes to used
	if (isset($_POST['user']) && $_POST['user'] == "user" && isset($_POST['pass']) && $_POST['pass'] == "pass") {
		$_SESSION['logged_in'] = TRUE;
	}
	
	// Logout
	if (isset($_POST['logout'])) {
		$_SESSION['logged_in'] = FALSE;
	}
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8" />

		<title>SSBO Ticketing</title>
		<meta name="description" content="SSBO Ticketing System" />
		<meta name="author" content="Marius Runde" />
		
		<!-- Stylesheet -->
		<link rel="stylesheet" href="style.css" />
		
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
		
		<div id="demo">
			<ul>
				<li>
					<a href="?code=1911332118324935400">Unused code</a>
				</li>
				<li>
					<a href="?code=9751755374018103000">Used code</a>
				</li>
				<li>
					<a href="?code=12345">Wrong code</a>
				</li>
			</ul>
		</div>
		
		<div id="main">
			<div id="ticket">
				<!-- Ticket will be placed here, if the code is valid. -->
			</div>
			<div id="qrcode">
				<!-- QRCode will be placed here, if the code is valid. -->
			</div>
			<div id="numeric_code">
				<!-- Numeric code will be placed here, if the code is valid. -->
			</div>
			<div id="error">
				<!-- Error messages will be displayed here, if the code is wrong. -->
			</div>
			
			
		</div>
		
		<?php
			// Control the code
			if (isset($_GET['code'])) {
				$code = $_GET['code'];
				
				// Open a connection to the MySQL server and select the database
				if (! @include_once('db_info.php')) { // @ - to suppress warnings 
  					echo '<h1>500 Internal Server Error!</h1><br/>
  					<b>Error message:</b> db_info.php does not exist!';
  				} else {
					$connection = mysql_connect($db_host, $db_username, $db_password) or die('Keine Verbindung möglich. Benutzername oder Passwort sind falsch');
					mysql_select_db($db_database) or die('Die Datenbank existiert nicht.');
			
					// Select the row with the correct user_id
					$query = "SELECT * FROM tickets WHERE code = '" . $code . "' LIMIT 1";
					$result = mysql_query($query);
			
					while ($row = mysql_fetch_object($result)) {
						$used = $row -> used;
					}
					
					if (isset($used) && $used == FALSE) {
						if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
							// Update the code from unused to used
							$query_update = "UPDATE tickets SET used = true WHERE code = '" . $code . "'";
							mysql_query($query_update);
							
							// Code is correct
							echo '
				<script type="text/javascript">
					document.getElementById("qrcode").innerHTML = "<img src=\"img/ok.png\" /><br/>";
				</script>
						';
						} else {
							// Code is correct
							echo '
					<script type="text/javascript">
						// Create the QRCode
						document.getElementById("ticket").innerHTML = "<img src=\"img/ticket.png\" />";
						new QRCode(document.getElementById("qrcode"), {
							text: getParam("code"),
							// text: document.URL,
							width: 256,
							height: 256,
							colorDark : "#0000ff",
							colorLight : "#ffffff",
							correctLevel : QRCode.CorrectLevel.L
						})
						document.getElementById("numeric_code").innerHTML = getParam("code");
					</script>
							';
						}
						
					} elseif (isset($used) && $used == TRUE) {
						// Code has been used before
						echo '
				<script type="text/javascript">
					document.getElementById("error").innerHTML = "<img src=\"img/not_ok.png\" /><br/>" +
						"<h3>Dieser Code wurde bereits verwendet!</h3>";
				</script>
						';
					} else {
						// Code is wrong	
						echo '
				<script type="text/javascript">
					document.getElementById("error").innerHTML = "<img src=\"img/fake.png\" /><br/>" +
						"<h3>Dein Code konnte nicht in der Datenbank gefunden werden.<br/>" +
						"Bitte überprüfe deine Eingaben.<br/>" +
						"Wenn du glaubst, dass hier ein Fehler vorliegt, melde dich bitte beim Veranstalter.</h3>";
				</script>
						';
						
					}
			
					// Close connection to MySQL server
					mysql_close($connection);
  				}
			} else {
				echo '<h1>404 Not Found</h1><br/>
				<b>Error message:</b> No validation code found!';
			}
			
		?>

		<footer>
			<p>
				<?php
					if (isset($_SESSION['logged_in'])) {
						if ($_SESSION['logged_in'] == TRUE) {
							echo '<form name="logout_form" href="index.php" method="post">
								<input name="logout" type="text" value="TRUE" hidden />
								<button type="submit">Logout</button>
							</form>';
						} else {
							echo 'Du bist nicht angemeldet. Klicke <a href="control.php">hier</a>, um dich anzumelden.<br/>';
						}
					}
				?>
				&copy; Copyright 2014 by Marius Runde
			</p>
		</footer>
	</body>
</html>
