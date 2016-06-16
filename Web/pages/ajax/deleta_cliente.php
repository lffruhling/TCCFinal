<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$id			    = $_POST['id'];

if($db->conecta()){

    $resultado = $db->deleta_cliente($id);

    echo "$resultado";
}

$db->desconecta();
?>