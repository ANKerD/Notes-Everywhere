<?php

require_once('Connect.php');

// Registra novos usuários e informa pro formulário se o email já está sendo usado
class Register{

	private $bd;
	function __construct(){
		$this->bd = new Connect();
	}

	public function add($email,$nome,$senha){
		$sql = "insert into user(nome,email,senha) value('$nome','$email','$senha');";
		$result = $this->bd->query($sql);
		header('location: ../login.php');
	}

	public function checkEmail($email){
		$sql = "select * from user where email = '$email'";
		$result = $this->bd->query($sql);
		if (sizeof($result) == 0) {
			echo "1";
		}else {
			echo "0";
		}
	}
}

if (isset($_POST['action'])) {
	$obj = new Register();
	$act = $_POST['action'];
	if ($act == 'checkEmail') {
		$obj->checkEmail($_POST['email']);
	}elseif ($act == 'register') {
		$obj->add($_POST['email'],$_POST['nome'],$_POST['pass']);
	}
}
?>
