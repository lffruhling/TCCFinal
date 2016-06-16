<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$id			    = $_POST['id'];
$nome			= $_POST['nome'];
$ativo 			= $_POST['ativo'];

if($db->conecta()){

    $resultado = $db->edita_tipo_serv($nome,$ativo,$id);

    echo "$resultado";
}

$db->desconecta();
?>