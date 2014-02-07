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
		<div>
			<header>
				<h1>SSBO Ticketing</h1>
			</header>

			<div id="qrcode">
				<!-- QRCode will be placed here -->
			</div>
			<script type="text/javascript">
				// Create the QRCode
				new QRCode(document.getElementById("qrcode"), getParam("code"));
			</script>

			<footer>
				<p>
					&copy; Copyright 2014 by Marius Runde
				</p>
			</footer>
		</div>
	</body>
</html>
