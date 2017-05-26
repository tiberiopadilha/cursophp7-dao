<?php

/**
* 
*/
class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;
	
	function __construct()	{
		
	}

	public function getIdusuario(){
		return $this->idusuario;
	}

	public function setIdusuario($value){
		$this->idusuario = $value;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}

	public function setDeslogin($value){
		$this->deslogin = $value;
	}

	public function getDessenha(){
		return $this->dessenha;
	}

	public function setDessenha($value){
		$this->dessenha = $value;
	}

	public function getDtcadastro(){
		return $this->dtcadastro;
	}

	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}

	//recebe uma consulta através do id do usuario, retornando o usuário 
	public function loadById($id){

		$sql = new Sql();

		$resultado = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));

		if (count($resultado) > 0) {

			$linha = $resultado[0];

			$this->setIdusuario($linha['idusuario']);
			$this->setDeslogin($linha['deslogin']);
			$this->setDessenha($linha['dessenha']);
			$this->setDtcadastro(new DateTime($linha['dtcadastro']));
		}
	}

	//lista todos usuários
	public static function listarUsuarios(){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
	}

	//verifica se existe e lista o usuario que está logando
	public function validaLogin($login, $senha){

		$sql = new Sql();

		$resultado = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :SENHA", array(
			":LOGIN"=>$login, ":SENHA"=>$senha));

		if (count($resultado)>0) {

			$linha = $resultado[0]; //pega a partir do inicio

			$this->setIdusuario($linha['idusuario']);
			$this->setDeslogin($linha['deslogin']);
			$this->setDessenha($linha['dessenha']);
			$this->setDtcadastro(new DateTime($linha['dtcadastro']));
		} else {
			throw new Exception("Login e/ou senha inválidos");
			
		}

	}
	



	public function __toString(){

		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
			));
	}

}

?>