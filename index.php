<?php
require_once("config.php");

//$felipe = new Usuario();

//$felipe->loadById(1);

//echo $felipe;

// carrega uma lista de usuários
$lista = Usuario::getList();
$lista = Usuario::search("ckh");
echo json_encode($lista);

// carrega um usuário usando o login e a senha
$usuario = new Usuario();
$usuario->login("eckhard","12334");
echo $usuario;


?>