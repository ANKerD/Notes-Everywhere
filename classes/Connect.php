<?php

// Classe que realiza consultas no banco de dados
class Connect{

	private $conn;

	function __construct(){

		$DBHOST = 'localhost';
		$DBUSER = 'root';
		$DBPASS = '';
		$DB = 'taskenem2';


		try {

			$this->conn = new PDO("mysql:host=". $DBHOST .";dbname=" . $DB, $DBUSER, $DBPASS, array(PDO::ATTR_PERSISTENT => true));

		} catch (PDOException $e) {


			$this->conn = null;
			exit();
			fail();
		}

	}

	public function query($sql){
		$conss = $this->conn->prepare($sql);   //após a entrega, também retornar o número de linhas aft.

		if(isset($conss)){

			$conss->execute();
			return $conss->fetchAll();
		}else{

			return array();
		}
	}
	public function lastId(){
		//TODO
		// return 1;
		return $this->conn->lastInsertId();
	}

	public function error(){
		//TODO
		return false;
	}

}

/***********************************/

/*
$p = new Connect();

$data = $p->query("select * FROM Userr");

foreach ($data as $key) {
	echo $key['nome'];
	echo "</br>";
}

*/
