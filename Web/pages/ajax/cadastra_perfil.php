<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$nome			= $_POST['nome'];
$ativo 			= $_POST['ativo'];

if($db->conecta()){

	$resultado = $db->insere_perfil($nome,$ativo);
	
	echo "$resultado";
}

$db->desconecta();
?>