<?php
	session_start();

	require_once '/classes/auth.php';

	$ok = true;
	$error = "";

	// Se houver uma requisição om essas variáveis tenta fazer login
	if (isset($_POST['user']) && isset($_POST['pass'])) {
		$login = new Auth($_POST['user'],$_POST['pass']);
		if ($login->loginOk()) {
			header('Location: home.php');
		}else {
			$ok = false;
			// mensagem de erro quando o login não da certo
			$msg = $login->errorMsg();
		}
	}

	if (isset($_SESSION['uid']) && isset($_SESSION['nome'])) {
		// se o usuário ja estiver logado seráredirecionado para o app
		header('location: home.php');
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

	<link rel="stylesheet" href="/css/form.css">

	<script type="text/javascript" src="/assets/jquery.min.js"></script>
	<script type="text/javascript" src="/js/submit-register-form.js"></script>
</head>
<body>
	<div class="form">
		<ul class="tab-group">
			<li class="tab"><a href="#signup">Registrar</a></li>
			<li class="tab active"><a href="#login">Entrar</a></li>
		</ul>
		<div class="tab-content">
			<div id="login">
				<?php

				if (!$ok) {
				?>
					<h1><?=$msg?></h1>
				<?php

				}else {?>

					<h1>Bem-Vindo!</h1>
				<?php

				}
				 ?>
				<form action="login.php" method="post">
					<div class="field-wrap">
						<label>
							Email<span class="req">*</span>
						</label>
						<input type="email" name="user" required autocomplete="off"/>
					</div>
					<div class="field-wrap">
						<label>
							Senha<span class="req">*</span>
						</label>
						<input type="password" name="pass" required autocomplete="off"/>
					</div>
					<!-- <p class="forgot"><a href="#">Esqueci minha senha</a></p> -->
					<button class="button button-block"/>Entrar!</button>
				</form>
			</div>
			<div id="signup">
				<h1>Crie sua conta</h1>
				<form action="classes/register.php" id="form" method="post">
					<div class="field-wrap">
						<label>
							Nome<span class="req">*</span>
						</label>
						<input name="nome" type="text" required/>
					</div>
					<div class="field-wrap">
						<label>
							Endereço de Email<span class="req">*</span>
						</label>
						<input id="email" name="email" type="email" required/>
					</div>
					<p class="forgot invisible" id="email-used"><a href="#">O email ja está em uso. Escolha outro</a></p>
					<div class="field-wrap">
						<label>
							Senha<span class="req">*</span>
						</label>
						<input id="pass" name="pass" type="password" required autocomplete="off"/>
					</div>
					<div class="field-wrap">
						<label>
							Confirme sua senha<span class="req">*</span>
						</label>
						<input id="repeat" type="password"required autocomplete="off"/>
					</div>
					<p class="forgot invisible" id="pass-error"><a href="#">As senha informadas são diferentes. Por favor corrija o erro.</a></p>
					<button id="register" type="submit" class="button button-block"/>Cadastrar</button>
					<input type="hidden" name="action" value="register"/>
				</form>
			</div>
		</div><!-- tab-content -->
	</div> <!-- /form -->
	<script src='/assets/jquery.min.js'></script>
	<script src='/assets/login/js/index.js'></script>
	<script src='/js/submit-register-form.js'></script>
</body>
</html>
