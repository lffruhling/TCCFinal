<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

$id         = $_POST['id'];
$idg		= $_POST['idg'];
$id_cli		= $_POST['id_cli'];
$id_tp_serv = $_POST['id_tp_serv'];
$id_tec 	= $_POST['id_tec'];
$orcamento 	= $_POST['orcamento'];
$obs 		= $_POST['obs'];
$foto       = $_POST['foto'];
$email      = $_POST['email'];
$ativo 		= $_POST['ativo'];

if($db->conecta()){

    $resultado = $db-> edita_os($id_cli,$id_tp_serv,$id_tec,$orcamento,$obs,$foto,$email,$ativo,$id);

    echo $resultado;
}

$db->desconecta();
?>

