<?php
session_start();
// Se não estiver logado é encaminhado para a pagina de login
if (!isset($_SESSION['uid']) && !isset($_SESSION['nome'])) {
	header('Location: login.php');
}

 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="assets/bootstrap-3.3.6-dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/home.css">
		<script type="text/javascript" src="assets/react/react-15.2.1.js"></script>
		<script type="text/javascript" src="assets/react/react-dom-15.2.1.js"></script>
		<script type="text/javascript" src="assets/react/babel-browser.min.js"></script>

		<title>Notes Everywhere</title>
	</head>
	<body>
		<div class="row-fluid" id="app-container"></div>
		<script type='text/babel' src='js/app-notes-evrwhr.js'></script>

		<script type="text/javascript" src='assets/jquery.min.js'></script>
		<script type="text/javascript" src='assets/bootstrap-3.3.6-dist/js/bootstrap.min.js'></script>
	</body>
</html>
