<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$idg			= $_POST['idg'];
$grupo_produto	= $_POST['grupo_produto'];
$produto 		= $_POST['produto'];
$quant 			= $_POST['quantidade'];

if($db->conecta()){

    $resultado = $db->adiciona_produto($idg,$grupo_produto,$produto,$quant);

    echo "$resultado";
}

$db->desconecta();
?>