<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/BancoDeDados.php');

class Auth{

	private $loginStatus = false;
	private $lgErrorMsg = '';
	function __construct($login, $senha){

		$bd = new BancoDeDados();

		$pass = $senha;

		$fields = array('nome','id');
		$table = 'user';
		$where = "where email = '$login' and senha = '$pass'";
		$result = $bd->select($fields,$table,$where);

		if(!$result){
			$this->loginStatus = false;
			$this->lgErrorMsg = 'Erro na conexão com banco de dados';
		}else{

			if(mysqli_num_rows($result) >= 1){

				$r = mysqli_fetch_array($result);

				$_SESSION['nome']  = $r['nome'];
				$_SESSION['uid']    = $r['id'];
				$this->loginStatus = true;

			}else{
				$this->loginStatus = false;
				$this->lgErrorMsg = 'Email ou senha inválidos';
			}
		}
	}

	public function loginOk(){
		return $this->loginStatus;
	}
	public function errorMsg(){
		return $this->lgErrorMsg;
	}
}
