<?php

require_once("config.php");

//carrega um usuário
//$user = new Usuario();
//$user->loadById(1);
//echo $user;

//carrega uma lista de usuários
//não é necessario instanciar o objeto pois o método getList() é estático
//$lista = Usuario::listarUsuarios();
//echo json_encode($lista);

//verifica se o usuario existe e loga no sistema
$usuario = new Usuario();
$usuario->validaLogin("Tiberio","123456");
echo $usuario
?>