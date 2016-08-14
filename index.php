<?php
	session_start();

	// caso o usuário esteja loga é redirecionado para o app
	if (isset($_SESSION['uid']) && isset($_SESSION['nome'])){
		header('location: home.php');
	}else {
		// do contrário vai para página de login
		header('location: login.php');
	}
 ?>
