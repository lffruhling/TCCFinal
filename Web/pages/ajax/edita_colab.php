<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$id			    = $_POST['id'];
$nome			= $_POST['nome'];
$id_perfil      = $_POST['id_perfil'];
$cpf			= $_POST['cpf'];
$dt_nasc    	= $_POST['dt_nasc'];
$cep			= $_POST['cep'];
$rua			= $_POST['rua'];
$nro			= $_POST['nro'];
$bairro			= $_POST['bairro'];
$comp			= $_POST['comp'];
$est			= $_POST['est'];
$cid			= $_POST['cid'];
$fone			= $_POST['fone'];
$cel			= $_POST['cel'];
$email			= $_POST['email'];
$user			= $_POST['user'];
$pass			= $_POST['pass'];
$ativo 			= $_POST['ativo'];


if($db->conecta()){

    $resultado = $db->edita_colab($nome,$id_perfil,$cpf,$dt_nasc,$cep,$rua,$nro,$bairro,$comp,$est,$cid,$fone,$cel,$email,$user,$pass,$ativo, $id);

    echo "$resultado";
}

$db->desconecta();
?>