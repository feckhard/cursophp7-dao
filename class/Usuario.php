<?php

echo "<br/>"."Classe SQL"."<br/>";

class Usuario
{
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function getIdusuario()
	{
		return $this->idusuario;
	}

	public function setIdusuario($value)
	{
		$this->idusuario = $value;
	}

	public function getDeslogin()
	{
		return $this->deslogin;
	}

	public function setDeslogin($value)
	{
		$this->deslogin = $value;
	}
	public function getDessenha()
	{
		return $this->dessenha;
	}

	public function setDessenha($value)
	{
		$this->dessenha = $value;
	}
	public function getDtcadastro()
	{
		return $this->dtcadastro;
	}

	public function setDtcadastro($value)
	{
		$this->dtcadastro = $value;
	}

	public function loadById($id)
	{

		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario= :ID",array(":ID"=>$id));
		if (count($results)>0)
		{
			$row = $results[0];
			$this->setData($row);
		}			
	}

	public function __toString()
	{
		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
		));
	}

	public static function getList()
	{
		$sql = new Sql();
		return $sql->select("select * from tb_usuarios order by deslogin;");
	}

	public static function search($login)
	{
		$sql = new Sql();
		return $sql->select("select * from tb_usuarios where deslogin like :SEARCH order by deslogin",array(':SEARCH'=>"%".$login."%"));
	}	

	public function login($login,$pwd)
	{
		$sql = new Sql();
		$results = $sql->select("
								SELECT * FROM tb_usuarios 
								WHERE deslogin= :LOGIN 
								and dessenha = :PASSWORD
								"
								,array(":LOGIN"=>$login
										,":PASSWORD"=>$pwd
					));
		if (count($results)>0)
		{
			$row = $results[0];
			$this->setData($row);
		}				
		else {
			throw new Exception("Login e/ou senha inválidos!");
		}
	}	

	public function setData($data)
	{
		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));		
	}

	public function insert()
	{
		$sql = new Sql();
		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
					':LOGIN'=>$this->getDeslogin()
					,':PASSWORD'=>$this->getDessenha()
		));
		if (count($results)>0)
		{
			echo "Inseriu ".count($results)." registros";
			$this->setData($results[0]);
		}
		else {
			echo "Não inseriu ".count($results)." registros";
		}				

	}	

	public function update($login,$password)
	{
		
		$this->setDeslogin($login);
		$this->setDessenha($password);

		echo $this->getDeslogin()."<br>";
		echo $this->getDessenha()."<br>";
		echo $this->getIdusuario()."<br>";

		$sql = new Sql();
		$results = $sql->select("
								UPDATE tb_usuarios 
								SET deslogin = :LOGIN, dessenha = :PASSWORD
								WHERE idusuario = :ID
								"
								,	array(':LOGIN'=>$this->getDeslogin()
										,':PASSWORD'=>$this->getDessenha()
										,':ID'=>$this->getIdusuario()
										)
								);

		if (count($results)>0)
		{
			echo "Inseriu ".count($results)." registros";
			$this->setData($results[0]);
		}
		else {
			echo "Não inseriu ".count($results)." registros";
		}				

	}	


}

?>