<?php
	session_start();
	unset($_SESSION['tipo']);
	unset($_SESSION['chave']);
	unset($_SESSION['nome']);

	session_destroy();

	header('Location: login.php');


?>
