<?php
	session_start();

	require_once '/classes/auth.php';

	if (isset($_POST['user']) && isset($_POST['pass'])) {
		$login = new Auth($_POST['user'],$_POST['pass']);
		if (!$login->loginOk()) {
			echo "deucerto";
			echo $login->errorMsg();
		}
	}

	if (isset($_SESSION['uid']) && isset($_SESSION['nome'])) {
		header('Location: /home.php');
	}
?>
<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Sign-Up/Login Form</title>
	<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="/assets/login/css/normalize.css">
	<link rel="stylesheet" href="/assets/login/css/style.css">

</head>
<body>
	<div class="form">
		<ul class="tab-group">
			<li class="tab"><a href="#signup">Registrar</a></li>
			<li class="tab active"><a href="#login">Entrar</a></li>
		</ul>
		<div class="tab-content">
			<div id="login">
				<h1>Bem-Vindo!</h1>
				<form action="/login.php" method="post">
					<div class="field-wrap">
						<label>
							Email<span class="req">*</span>
						</label>
						<input type="email" name="user" required/>
					</div>
					<div class="field-wrap">
						<label>
							Senha<span class="req">*</span>
						</label>
						<input type="password" name="pass" required/>
					</div>
					<p class="forgot"><a href="#">Esqueci minha senha</a></p>
					<button class="button button-block"/>Entrar!</button>
				</form>
			</div>
			<div id="signup">
				<h1>Crie sua conta</h1>
				<form action="/" method="post">
					<div class="top-row">
						<div class="field-wrap">
							<label>
								Primeiro Nome<span class="req">*</span>
							</label>
							<input type="text" required/>
						</div>
						<div class="field-wrap">
							<label>
								Último Nome<span class="req">*</span>
							</label>
							<input type="text" required/>
						</div>
					</div>
					<div class="field-wrap">
						<label>
							Endereço de Email<span class="req">*</span>
						</label>
						<input type="email" required/>
					</div>
					<div class="field-wrap">
						<label>
							Senha<span class="req">*</span>
						</label>
						<input type="password"required autocomplete="off"/>
					</div>
					<div class="field-wrap">
						<label>
							Confirme sua senha<span class="req">*</span>
						</label>
						<input type="password"required autocomplete="off"/>
					</div>
					<button type="submit" class="button button-block"/>Cadastrar</button>
				</form>
			</div>
		</div><!-- tab-content -->
	</div> <!-- /form -->
	<script src='/assets/jquery.min.js'></script>
	<script src='/assets/login/js/index.js'></script>
	<script src='/js/submit-register-form.js'></script>
</body>
</html>
