<?php


class BancoDeDados{

	private $conn;
function __construct(){
		$host = 'localhost';
		$user = 'root';
		$pass = '';
		$name = 'taskenem2';
		$this->conn = mysqli_connect($host,$user,$pass,$name);
	}

	private function log($text , $file = 'log.txt'){

		$l = fopen($file,'a+');
		$time = date('Y-m-d>MM:hh:ss');

		date_default_timezone_set('America/Recife');
		$t = date('Y-m-d > H:i:s');

		$msg = "$t --> $text\n";
		fwrite($l,$msg);
		fclose($l);
	}

	private function query($sql){
		$r = mysqli_query($this->conn,$sql);
		$this->log($sql);

		return $r;
	}

	private function prepareData(array $data){
		$d = "'".$data[0]."'";
		for ($i=1; $i < sizeof($data); $i++) {
			$d .= ",'".$data[$i]."'";
		}
		return $d;
	}

	private function prepareFields(array $data){
		$d = $data[0];
		for ($i=1; $i < sizeof($data); $i++) {
			$d .= ",".$data[$i];
		}
		return $d;
	}

	public function insert($table,array $values){

		$values = $this->prepareData($values);
		$sql = 'insert into '.$table.' values('.$values.')';
		$this->query($sql);
	}

	public function select(array $fields,$table,$where){
		$f = $this->prepareFields($fields);

		$sql = 'select '.$f.' from '.$table.' '.$where;
		$ret = $this->query($sql);
		return $ret;
	}

	public function update($table,$where){
		//TODO
	}

	public function delete($table,$where){
		//TODO
	}

	public function getLastId(){
		return mysqli_insert_id($this->conn);
	}

	public function insertText($t){
		$this->query($t);
	}
}

?>
