<?php
include "../classes/mysql.php";
header('Content-type: text/json');

$db = new MySQL();

$grupo_produto = $_POST['id_grupo_prod'];

if($db->conecta()){

    $resultado = $db->_n_produto($grupo_produto);

    echo json_encode($resultado);
}

$db->desconecta();



?>