<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/BancoDeDados.php');
$params = $_REQUEST;
class Disciplina{

	private $bd;

	function __construct(){
		$this->bd = new BancoDeDados();
		session_start();
	}

	public function ajaxGetDisciplinas(){
		if (!isset($_SESSION['uid'])) {
			echo "[]";
		}else {
			$fields = array('nome','id');
			$table = 'Disciplina';
			$where = "";
			$result = $this->bd->select($fields,$table,$where);

			$data = array();

			while (($r = mysqli_fetch_assoc($result)) != null) {
				array_push($data,$r);
			}

			echo json_encode($data);
		}
	}
}

$action = isset($params['action'])? $params['action'] : '';

$inst = new Disciplina();

if ($action == 'ajaxgetall') {
	$inst->ajaxGetDisciplinas();
}elseif (true) {
	# code...
}
?>
