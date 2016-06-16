<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$nome			= $_POST['nome'];
$cnpj			= $_POST['cnpj'];
$cpf 			= $_POST['cpf'];
$cep 			= $_POST['cep'];
$rua 			= $_POST['rua'];
$nro 			= $_POST['nro'];
$complemento 	= $_POST['complemento'];
$estado 		= $_POST['estado'];
$cidade 		= $_POST['cidade'];
$fone1			= $_POST['fone1'];
$fone2 			= $_POST['fone2'];
$celular 		= $_POST['celular'];
$email 			= $_POST['email'];
$ativo 			= $_POST['ativo'];

/*$cep = preg_replace('/[^0-9]/','',$cep);
$telefone1 = preg_replace('/[^0-9]/','',$telefone1);
$telefone2 = preg_replace('/[^0-9]/','',$telefone2);
$celular1 = preg_replace('/[^0-9]/','',$celular1);
$celular2 = preg_replace('/[^0-9]/','',$celular2);*/


if($db->conecta()){

	$resultado = $db->insere_cliente($nome,$cnpj,$cpf,$cep,$rua,$nro,$complemento,$estado,$cidade,$fone1,$fone2,$celular,$email,$ativo);
	
	echo "$resultado";
}

$db->desconecta();
?>