<?php

/**
* 
*/
class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;
	
	public function __construct($login = "", $senha = "")	{

		$this->setDeslogin($login);
		$this->setDessenha($senha);
		
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

			$this->setDados($resultado[0]);//no inicio do vetor
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

			$this->setData($resultado[0]);//no inicio do vetor
			
		} else {
			throw new Exception("Login e/ou senha inválidos");			
		}
	}

	public function setDados($dados){

		$this->setIdusuario($dados['idusuario']);
		$this->setDeslogin($dados['deslogin']);
		$this->setDessenha($dados['dessenha']);
		$this->setDtcadastro(new DateTime($dados['dtcadastro']));

	}

	public function insert(){

		$sql  = new Sql();
		//chama uma procedure no banco que insere e retorna o id
		$resultado = $sql->select("CALL sp_usuarios_insert(:LOGIN, :SENHA)", array(
			':LOGIN'=>$this->getDeslogin(),
			':SENHA'=>$this->getDessenha()
			));

		if (count($resultado)>0) {

			$this->setDados($resultado[0]);//no inicio do vetor
		}
	}

	public function update($login, $senha){

		$this->setDeslogin($login);
		$this->setDessenha($senha);

		$sql = new Sql();

		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, 
			dessenha = :SENHA WHERE idusuario = :ID", array(
				':LOGIN'=>$this->getDeslogin(),
				'SENHA'=>$this->getDessenha(),
				':ID'=>$this->getIdusuario()
				));
	}

	public function delete(){

		$sql = new Sql();

		$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array( ':ID'=>$this->getIdusuario()
			));

			$this->setIdusuario(6);
			$this->setDeslogin("");
			$this->setDessenha("");
			$this->setDtcadastro(new DateTime());
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