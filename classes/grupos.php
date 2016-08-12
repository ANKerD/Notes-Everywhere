<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/classes/BancoDeDados.php');

class Grupos{
	private $BD;
	function __construct(){
		$this->BD = new BancoDeDados();
	}

	public function novo($nome,$categorias,$privacidade){
		$table = 'grupo(nome,admin,privacidade)';
		$values = array($nome,$_SESSION['uid'],$privacidade);

		$this->BD->insert($table,$values);

		$gpId = $this->BD->getLastId();
		$cats = explode(' ',$categorias);
		echo sizeof($cats);
		for ($i=0; $i < sizeof($cats); $i++) {
			$fields = array('id');
			$table = 'categoria';
			$where = "nome like '$cats[$i]'";

			$cat = $this->BD->select($fields,$table,$where);
			$catId = 0;
			if (mysqli_num_rows($cat) <= 0) {
				$this->BD->insert('categoria(nome)',array($cats[$i]));
				$catId = $this->BD->getLastId();
			}else {
				$line = mysqli_fetch_array($cat);
				$catId = $line['id'];
			}

			$table = 'grupoCategoria(categoria,grupo)';
			$values = array($catId,$gpId);

			$this->BD->insert($table,$values);
		}
	}
}

$action = isset($_GET['action'])? $_GET['action'] : die('some action required');
session_start();
var_dump($_SESSION['uid']);
$GP = new Grupos();

if ($action == 'salvar') {

	if (isset($_POST['nome']) && isset($_POST['assunto']) &&
		isset($_POST['privacidade']) && isset($_SESSION['uid'])) {
		$nome = $_POST['nome'];
		$ass  = $_POST['assunto'];
		$prv  = $_POST['privacidade'];

		$GP->novo($nome,$ass,$prv);
	}
}
