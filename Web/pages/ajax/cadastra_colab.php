<?php
include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

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

//$dt_nasc = substr($dt_nasc,6,4)."-".substr($dt_nasc,3,2)."-".substr($dt_nasc,0,2);
/*$h = fopen("cad_colab.txt","w+");
$out = "nome >> $nome\n\n perfil >> $id_perfil\n\n cpf >> $cpf\n\n data_nas >> $dt_nasc\n\n cep >> $cep\n\n rua >> $rua\n\n nro >> $nro\n\n bairro >> $bairro comp >> $comp\n\n est >> $est\n\n cid >> $cid\n\n fone1 >> $fone\n\n cel >> $cel\n\n email >> $email\n\n usu >> $user\n\n pass >> $pass\n\n";
fwrite($h,$out,strlen($out));
fclose($h);*/

if($db->conecta()){

    $resultado = $db->insere_colab($nome,$id_perfil,$cpf,$dt_nasc,$cep,$rua,$nro,$bairro,$comp,$est,$cid,$fone,$cel,$email,$user,$pass,$ativo);
	
	echo "$resultado";
}

$db->desconecta();
?>