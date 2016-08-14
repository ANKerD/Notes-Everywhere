<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Connect.php');

// classe usada para realizar o login e informar possiveis error durante o processo
class Auth{

	private $loginStatus = false;
	private $lgErrorMsg = '';
	function __construct($login, $senha){

		$bd = new Connect();

		$pass = $senha;

		$sql = "select nome, id from user where email = '$login' and senha = '$pass'";
		$result = $bd->query($sql);


		if(sizeof($result) == 0){
			$this->loginStatus = false;
			$this->lgErrorMsg = 'Email ou senha inválidos';
		}else{

			$r = $result[0];

			$_SESSION['nome']  = $r['nome'];
			$_SESSION['uid']   = $r['id'];
			$this->loginStatus = true;
		}
	}

	public function loginOk(){
		return $this->loginStatus;
	}
	public function errorMsg(){
		return $this->lgErrorMsg;
	}
}
