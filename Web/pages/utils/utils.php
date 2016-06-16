<?php
$title_name = "Gestão de Projetos";

function ip_cliente()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
	  $ip=$_SERVER['REMOTE_ADDR'];
	}
	
	$ip = str_replace(".","",$ip);
	
	return $ip;
}

 function session_test(){
	session_name('userlogin');
//	session_id($_GET['PHPSESSID']);
	session_start();
	if ($_SESSION['autenticado'] != 'SI') { 
	    //se não está logado o envio à página de autenticação 
	    header("location: http://191.252.3.112/dmp_desenv"); //envio ao usuário à página de autenticação 
	} else { 
	    //senão, calculamos o tempo transcorrido 
	    $dataSalva = $_SESSION['ultimoacesso']; 
	    $agora = date('Y-m-d H:i:s'); 
	    $tempo_transcorrido = (strtotime($agora)-strtotime($dataSalva)); 

	    //comparamos o tempo transcorrido 
	     if($tempo_transcorrido >= 1440) { 
	     //se passaram 10 minutos ou mais 
	      session_destroy(); // destruo a sessão 
	      $_SESSION['autenticado']='SO';
	      header("location: http://191.252.3.112/dmp_desenv"); //envio ao usuário à página de autenticação 
	      //senão, atualizo a data da sessão 
	    }else { 
	    $_SESSION['ultimoacesso'] = $agora; 
	 }
	}
 }

 function formata_data($data){
	 $dia = substr($data,0,2);
	 $mes = substr($data,3,2);
	 $ano = substr($data,6,4);
	 
	 $resposta = "$ano-$mes-$dia";
	 
	 return $resposta;
 }
 
 function formata_datahora($data){
	 $dia = substr($data,0,2);
	 $mes = substr($data,3,2);
	 $ano = substr($data,6,4);
	 $hora = substr($data,11,2);
	 $minuto = substr($data,14,2);
	 $segundo = substr($data,17,2);
	 
	 $resposta = "$ano-$mes-$dia $hora:$minuto:$segundo";
	 
	 return $resposta;
 }

 function encryptIt( $q ) {
    $cryptKey  = 'qMB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function decryptIt( $q ) {
    $cryptKey  = 'qMB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}

function getVoucher(){
	// Monta yymmddhhiisslll e converte para hexadecimal
	$micro = explode(".",(float)microtime(true)/1000);
	$mili = substr($micro[1],0,3);
	$modelo = date("ymdHis");
	$modelo = $modelo.$mili;
	$voucher = dechex($modelo);	
	
	return $voucher;
}

function my_number_format($number, $dec_point, $thousands_sep) 
{ 
	$tmp = explode('.', $number); 
	$out = number_format($tmp[0], 0, $dec_point, $thousands_sep); 
	if (isset($tmp[1])) $out .= $dec_point.$tmp[1]; 

	return $out; 
}

function format_datetime($date){
	$date = substr($date,6,4)."-".substr($date,3,2)."-".substr($date,0,2)." ".substr($date,11,5).":00";
	return $date;
} 

function retira_acentos($texto){
	//return preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $texto ) ); 
	$com_acento_minuscula = array("á","à","ã","â","é","ê","í","ó","õ","ô","ú","û","ç");
	$com_acento_maiuscula = array("Á","À","Ã","Â","É","Ê","Í","Ó","Õ","Ô","Ú","Û","Ç");
	$sem_acento_minuscula = array("a","a","a","a","e","e","i","o","o","o","u","u","c");
	$sem_acento_maiuscula = array("A","A","A","A","E","E","I","O","O","O","U","U","C");
	
	$texto = str_replace($com_acento_minuscula,$sem_acento_minuscula,$texto);
	$texto = str_replace($com_acento_maiuscula,$sem_acento_maiuscula,$texto);
	
	return $texto;
}

function ajusta_espacos($str){
	return preg_replace("/[ ]{2,}/",' ',$str);
}

function active_menu(){
}

function busca_cep($cep){  
    $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');  
    if(!$resultado){  
        $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";  
    }  
    parse_str($resultado, $retorno);   
    return $retorno;  
}

function cep_online($cep,&$ret){
	return;
}

function mask($val, $mask)
{
	$maskared = '';
	$k = 0;
	
	for($i = 0; $i<=strlen($mask)-1; $i++)
	{
		if($mask[$i] == '#')
		{
			if(isset($val[$k])) $maskared .= $val[$k++];
		}
		else
		{
			if(isset($mask[$i])) $maskared .= $mask[$i];
		}
	}
	
	return $maskared;
}

?>