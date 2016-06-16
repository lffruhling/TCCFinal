<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$old_senha	= $_POST['old_senha'];
$new_senha  = $_POST['new_senha'];
$usuário 	= $_POST['usuário'];


if($db->conecta()){

    $resultado = $db->altera_senha($usuário,$old_senha,$new_senha);

    echo "$resultado";
}

$db->desconecta();
?>