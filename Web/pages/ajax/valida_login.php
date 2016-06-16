<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$login = $_POST['usuario'];
$senha = $_POST['senha'];

// Conecta ao banco
if($db->conecta()){
	$retorno = $db->valida_login($login,$senha);
	echo $retorno;
}

$db->desconecta();
unset($db);
?>