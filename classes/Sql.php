<?php

/**
* 
*/
class Sql extends PDO{

	private $conn;
	
	public function __construct(){

		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", 
			"root", "");
	}

	private function setParams($statment, $parameters = array()){

		foreach ($parameters as $key => $value) {

			$this->setParam($statment, $key, $value);
		}

	}

	private function setParam($statment, $key, $value){

		$statment->bindParam($key, $value);
	}

	//recebe a consulta e retorna o resultado
	public function query($consulta, $params = array()){

		$stmt = $this->conn->prepare($consulta);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt;
		
	}

	//recebe a consulta e um parâmetro
	public function select($consulta, $params = array()):array{

		$stmt = $this->query($consulta, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>