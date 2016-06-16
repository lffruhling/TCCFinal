<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$id         = $_POST['id'];
$nome		= $_POST['nome'];
$id_grupo 	= $_POST['id_grupo'];
$marca 		= $_POST['marca'];
$modelo 	= $_POST['modelo'];
$desc 		= $_POST['desc'];
$quant 		= $_POST['quant'];
$valorcomp 	= $_POST['valorcomp'];
$valorvend 	= $_POST['valorvend'];
$ativo 		= $_POST['ativo'];

if($db->conecta()){

    $resultado = $db->edita_produto($nome,$id_grupo,$marca,$modelo,$desc,$quant,$valorcomp,$valorvend,$ativo,$id);

    echo "$resultado";
}

$db->desconecta();
?>

