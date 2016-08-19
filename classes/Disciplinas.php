<?php
require_once('Connect.php');
$params = $_REQUEST;

// controla o acesso as anotaçãoes e permite a adição de outras
class Disciplina{

	private $bd;

	function __construct(){
		$this->bd = new Connect();
		session_start();
	}

	public function getAllContent(){
		$resp = array();

		$sql = "select * from disciplina";
		$discs = $this->bd->query($sql);

		$data = array();

		foreach ($discs as $r) {
			 $d = array('name'=>$r['nome'],
							'id'=>$r['id'],
							'key'=>$r['id'],
							'notes'=>array());

			$sql = 'select * from tarefa where dono = "'.$_SESSION['uid'].'" and disciplina = "'.$r['id'].'"';
			$notes = $this->bd->query($sql);

			foreach ($notes as $n) {

				$d['notes'][] = array('title'=>$n['nome'],
												'id'=>$n['id'],
												'key'=>$r['id'],
												'hora'=>$n['horario'],
												'content'=>$n['anotacao']);
			}
			$data[] = $d;
		}

		/***************************************************************************************************/

		echo json_encode($data);
	}
	public function addNote($note){
		$note = json_decode($note);

		$sql = "insert into tarefa(dono,nome,disciplina,horario,anotacao) value('".$_SESSION['uid']."','".$note->title."','".$note->disc."','".$note->hora."','".$note->content."')";
		$result = $this->bd->query($sql);

		$lastId = $this->bd->lastId();
		$response = array(
			'id'=>$lastId,
			'key'=>$lastId,
			'content'=>$note->content,
			'hora'=>$note->hora,
			'title'=>$note->title
		);

		echo json_encode($response);
	}

}

$action = isset($params['action'])? $params['action'] : '';

$inst = new Disciplina();

if ($action == 'ajaxGetContent') {
	$inst->getAllContent();
}elseif ($action == 'addNote') {
	$inst->addNote($params['note']);
}
?>
