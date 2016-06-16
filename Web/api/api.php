<?php
# Definindo pacotes de retorno em padrão JSON...
header('Content-Type: application/json;charset=utf-8');
 
# Carregando o framework Slim...
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
 
# Iniciando o objeto de manipulação da API SlimFramework
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

function authenticate(){

  $app = \Slim\Slim::getInstance();
  $user = $app->request->headers->get('HTTP_USER');
  $pass = $app->request->headers->get('HTTP_PASS');  //recebo a senha jᠦormatada em md5

	    $erro = 0;
	
		try{
		   
		   if(($user != "MG") or ($pass != 'MG')){
		     //se retornar e99 houve falha ao autenticar
		     echo json_encode('e99');		
		     $erro = 1; 
		   } 
		}catch(Exception $e){
		   //se retornar e100 houve algum erro
		   echo json_encode('e100');		
		   $erro = 1;		
		}
		
		if($erro == 1)
		  $app->stop();
}
 
# Função de teste de funcionamento da API...
$app->get('/', function () {
    echo "Bem-vindo a API do Sistema de Clientes";
});
 
# Função para obter dados da tabela 'cliente'...
//$app->get('/clientes','authenticate',function(){

$app->get('/clientes',function(){ 
    # Variável que irá ser o retorno (pacote JSON)...
    $retorno = array();
 
    # Abrir conexão com banco de dados...
    $conexao = new MySQLi("localhost","u389380248_root","06111992","u389380248_mg");
 
    # Validar se houve conexão...
    if(!$conexao){ echo "Não foi possível se conectar ao banco de dados"; exit;}
 
    # Selecionar todos os cadastros da tabela 'cliente'...
    $registros = $conexao->query("SELECT * FROM tb_cliente");
 
    # Transformando resultset em array, caso ache registros...
    if($registros->num_rows>0){
        while($cliente = $registros->fetch_array(MYSQL_BOTH)) {
                $registro = array(
                        'id'   => $cliente["ID_CLI"],
                        'nome'     => utf8_encode($cliente["NOME_CLI"]),
                        'fone' => $cliente["FONE1_CLI"],
                        'email'    => $cliente["EMAIL_CLI"],
                    );
            $retorno[] = $registro;
        }
         
	    # Encerrar conexão...
	    $conexao->close();
	 
	    # Retornando o pacote (JSON)...
	    $retorno = json_encode(array('clientes'=>$retorno));
	    //$retorno = json_encode($retorno);
	    echo $retorno;
 
	}
});
 
$app->get('/usuarios',function(){ 
    # Variável que irá ser o retorno (pacote JSON)...
    $retorno = array();
 
    # Abrir conexão com banco de dados...
    $conexao = new MySQLi("localhost","u389380248_root","06111992","u389380248_mg");
 	//$conexao = new MySQLi("localhost","root","","mg");
    # Validar se houve conexão...
    if(!$conexao){ echo "Não foi possível se conectar ao banco de dados"; exit;}
 
    # Selecionar todos os cadastros da tabela 'cliente'...
    $registros = $conexao->query("SELECT ID_COLAB, NOME_COLAB, EMAIL_COLAB, USUARIO_COLAB, SENHA_COLAB FROM tb_colaboradores WHERE ATIVO = 1 AND (DELETADO = 0 OR NULL) AND ID_PERFIL IN (1,3)");
 
    # Transformando resultset em array, caso ache registros...
    if($registros->num_rows>0){
        while($resultado = $registros->fetch_array(MYSQL_BOTH)) {
                $registro = array(
                        'id_web'   		=> $resultado["ID_COLAB"],
                        'nome'     	=> utf8_encode($resultado["NOME_COLAB"]),
                        'email' 	=> utf8_encode($resultado["EMAIL_COLAB"]),
                        'usuario'	=> utf8_encode($resultado["USUARIO_COLAB"]),
                        'senha'    	=> utf8_encode(base64_decode($resultado["SENHA_COLAB"])),
                    );
            $retorno[] = $registro;
        }
         
	    # Encerrar conexão...
	    $conexao->close();
	 
	    # Retornando o pacote (JSON)...
	    $retorno = json_encode(array('usuarios'=>$retorno));
	    //$retorno = json_encode($retorno);
	    echo $retorno;
 
	}
});

$app->get('/servicos',function(){ 
    # Abrir conexão com banco de dados...
    $conexao = new MySQLi("localhost","u389380248_root","06111992","u389380248_mg");
 	//$conexao = new MySQLi("localhost","root","","mg");
    # Validar se houve conexão...
    if(!$conexao){ echo "Não foi possível se conectar ao banco de dados"; exit;}
 
    # Selecionar todos os cadastros da tabela 'cliente'...
    $registros = $conexao->query("	SELECT 																".
								 "  	OS.ID_OS, 														".
								 "  	cli.NOME_CLI, 													".
								 "  	tposerv.DESC_TPOSERV, 											".
								 "  	colab.NOME_COLAB, 												".
								 "  	OS.OBS_OS, 														".
								 "  	OS.ORCAMENTO, 													".
								 "  	OS.FOTO, 														".
								 "  	CASE 															".
								 "      	WHEN OS.UPDATEDAT IS NULL THEN OS.CREATEDAT 				".
								 "	        ELSE OS.UPDATEDAT 											".
								 "	    END data_criacao 												".
								 "	FROM 																".
								 "	    tb_os OS 														".
								 "	        LEFT JOIN 													".
								 "	    tb_tpo_servico tposerv ON tposerv.ID_TPOSERV = OS.ID_TPOSERV 	".
								 "	        LEFT JOIN 													".
								 "	    tb_colaboradores colab ON colab.ID_COLAB = OS.ID_COLAB 			".
								 "	        LEFT JOIN 													".
								 "	    tb_cliente cli ON cli.ID_CLI = OS.ID_CLI 						".
								 "	WHERE 																".
								 "	    OS.ID_STATUS IN (1 , 2) AND OS.ATIVO = 1 						".
								 "	        AND (OS.DELETADO = 0 OR OS.DELETADO IS NULL)				");
 
    # Transformando resultset em array, caso ache registros...
    if($registros->num_rows>0){
        echo '{'."\n".
            '   "servicos": ['."\n";
        $item2 = 0;
        foreach($registros as $r) {
            $item2 ++;
            echo '  {'."\n";
            echo '      "id_web": "'.$r["ID_OS"].'",'."\n";
            echo '      "nome": "'.$r["NOME_CLI"].'",'."\n";
            echo '      "serv": "'.$r["DESC_TPOSERV"].'",'."\n";
            echo '      "colab": "'.$r["NOME_COLAB"].'",'."\n";
            echo '      "obs": "'.$r["OBS_OS"].'",'."\n";
            echo '      "orc": "'.$r["ORCAMENTO"].'",'."\n";
            echo '      "fot": "'.$r["FOTO"].'",'."\n";
            echo '      "data": "'.$r["data_criacao"].'",'."\n";
            $id_os = $r["ID_OS"];
            $produtos = $conexao->query("	SELECT 															".
                                        "	    prodUs.ID_PROD_US, 											".
                                        "	    prod.NOME_PROD, 											".
                                        "	    gprod.DESC_GRUP, 											".
                                        "	    prodUs.QUANTIDADE_PROD_US QUANT 							".
                                        "	FROM 															".
                                        "	    tb_produtos_usados prodUs 									".
                                        "	        LEFT JOIN 												".
                                        "	    tb_produtos prod ON prod.ID_PROD = prodUs.ID_PROD 			".
                                        "	        LEFT JOIN 												".
                                        "	    tb_grupo_produto gprod ON gprod.ID_GRUP = prodUs.ID_GRUP 	".
                                        "	WHERE 															".
                                        "	    prodUs.ATIVO = 1 											".
                                        "	        AND (prodUs.DELETADO = 0 								".
                                        "	        OR prodUs.DELETADO IS NULL) 							".
                                        "	        AND prodUs.ID_OS = $id_os								");

            if ($produtos -> num_rows>0){
                echo '      "produtos":['."\n";
            }else{
                echo '      "produtos":[';
            }


            $total = $produtos -> num_rows;

            $item = 0;

            foreach($produtos as $p){
                    $item ++;
                    echo '          {'."\n";
                    echo '              "id_pro": "'.$p["ID_PROD_US"].'",'."\n";
                    echo '              "nome": "'.$p["NOME_PROD"].'",'."\n";
                    echo '              "desc": "'.$p["DESC_GRUP"].'",'."\n";
                    echo '              "quant": "'.$p["QUANT"].'"'."\n";
                    if ($total == $item){
                        echo '          }'."\n";
                    }else{
                        echo '          },'."\n";
                    }

            }
            echo  "     ]"."\n";
            if ($registros -> num_rows == $item2){
                echo  "  }"."\n";
            }else{
                echo  "  },"."\n";
            }

            usleep(5000);
        }
        echo  "]"."\n";
        echo "}"."\n";

	    # Encerrar conexão...
	    $conexao->close();
	 
	}
});

$app->get('/servicos/id', function() use($app){
//$app->get('/teste', function(){
    $request = \Slim\Slim::getInstance()->request();
    $requisicao = json_decode($request->getBody());
//
    //$status = "naogravou";

    $OS = $_GET{'id_us'};

    //se n㯠existir o caminho cria

    //se existir a pasta
    $conexao = new MySQLi("localhost","u389380248_root","06111992","u389380248_mg");
    //$conexao = new MySQLi("localhost","root","","mg");
    # Validar se houve conexão...
    if(!$conexao){ echo "Não foi possível se conectar ao banco de dados"; exit;}

    # Selecionar todos os cadastros da tabela 'cliente'...
    $registros = $conexao->query("	SELECT 																".
                                "  	OS.ID_OS, 														    ".
                                "  	cli.NOME_CLI, 													    ".
                                "  	tposerv.DESC_TPOSERV, 											    ".
                                "  	colab.NOME_COLAB, 												    ".
                                "  	OS.ID_COLAB, 													    ".
                                "  	OS.OBS_OS, 														    ".
                                "  	OS.ORCAMENTO, 													    ".
                                "  	OS.FOTO, 														    ".
                                "  	CASE 															    ".
                                "      	WHEN OS.UPDATEDAT IS NULL THEN OS.CREATEDAT 				    ".
                                "	        ELSE OS.UPDATEDAT 											".
                                "	    END data_criacao,                                               ".
                                "   cli.rua_cli,                                                        ".
                                "   cli.nro_cli     												    ".
                                "	FROM 																".
                                "	    tb_os OS 														".
                                "	        LEFT JOIN 													".
                                "	    tb_tpo_servico tposerv ON tposerv.ID_TPOSERV = OS.ID_TPOSERV 	".
                                "	        LEFT JOIN 													".
                                "	    tb_colaboradores colab ON colab.ID_COLAB = OS.ID_COLAB 			".
                                "	        LEFT JOIN 													".
                                "	    tb_cliente cli ON cli.ID_CLI = OS.ID_CLI 						".
                                "	WHERE 																".
                                "	    OS.ID_STATUS IN (1 , 2) AND OS.ATIVO = 1 						".
                                "	        AND (OS.DELETADO = 0 OR OS.DELETADO IS NULL)                ".
                                "			AND OS.ID_COLAB = ". $OS                                    );

    # Transformando resultset em array, caso ache registros...
    if($registros->num_rows>0){
        echo '{'."\n".
            '   "servicos": ['."\n";
        $item2 = 0;
        foreach($registros as $r) {
            $item2 ++;
            echo '  {'."\n";
            echo '      "id_web": "'.$r["ID_OS"].'",'."\n";
            echo '      "nome": "'.$r["NOME_CLI"].'",'."\n";
            echo '      "serv": "'.$r["DESC_TPOSERV"].'",'."\n";
            echo '      "colab": "'.$r["NOME_COLAB"].'",'."\n";
            echo '      "id_colab": "'.$r["ID_COLAB"].'",'."\n";
            echo '      "obs": "'.$r["OBS_OS"].'",'."\n";
            echo '      "orc": "'.$r["ORCAMENTO"].'",'."\n";
            echo '      "fot": "'.$r["FOTO"].'",'."\n";
            echo '      "data": "'.$r["data_criacao"].'",'."\n";
            echo '      "end": "'.$r["rua_cli"].'",'."\n";
            echo '      "nro": "'.$r["nro_cli"].'",'."\n";
            $id_os = $r["ID_OS"];
            $produtos = $conexao->query("	SELECT 															".
                                        "	    prodUs.ID_PROD_US, 											".
                                        "	    prodUs.ID_OS, 											    ".
                                        "	    prod.NOME_PROD, 											".
                                        "	    gprod.DESC_GRUP, 											".
                                        "	    prodUs.QUANTIDADE_PROD_US QUANT 							".
                                        "	FROM 															".
                                        "	    tb_produtos_usados prodUs 									".
                                        "	        LEFT JOIN 												".
                                        "	    tb_produtos prod ON prod.ID_PROD = prodUs.ID_PROD 			".
                                        "	        LEFT JOIN 												".
                                        "	    tb_grupo_produto gprod ON gprod.ID_GRUP = prodUs.ID_GRUP 	".
                                        "	WHERE 															".
                                        "	    prodUs.ATIVO = 1 											".
                                        "	        AND (prodUs.DELETADO = 0 								".
                                        "	        OR prodUs.DELETADO IS NULL) 							".
                                        "	        AND prodUs.ID_OS = $id_os								");

            if ($produtos -> num_rows>0){
                echo '      "produtos":['."\n";
            }else{
                echo '      "produtos":[';
            }


            $total = $produtos -> num_rows;

            $item = 0;

            foreach($produtos as $p){
                $item ++;
                echo '          {'."\n";
                echo '              "id_pro": "'.$p["ID_PROD_US"].'",'."\n";
                echo '              "id_os": "'.$p["ID_OS"].'",'."\n";
                echo '              "nome": "'.$p["NOME_PROD"].'",'."\n";
                echo '              "desc": "'.$p["DESC_GRUP"].'",'."\n";
                echo '              "quant": "'.$p["QUANT"].'"'."\n";
                if ($total == $item){
                    echo '          }'."\n";
                }else{
                    echo '          },'."\n";
                }

            }
            echo  "     ]"."\n";
            if ($registros -> num_rows == $item2){
                echo  "  }"."\n";
            }else{
                echo  "  },"."\n";
            }

            usleep(5000);
        }
        echo  "]"."\n";
        echo "}"."\n";

        # Encerrar conexão...
        $conexao->close();

    }
});

$app->post('/device/registration', function() use($app){

    $request = \Slim\Slim::getInstance()->request();
    $requisicao = json_decode($request->getBody());
    $device_id = $requisicao->{'device_id'};
    $id_tec = $requisicao->{'id_tec'};

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=u389380248_mg', 'u389380248_root', '06111992');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('UPDATE tb_colaboradores SET ID_DEVICE_COLAB = :device_id WHERE ID_COLAB = :id_tec');
        $stmt->execute(array(
            ':id_tec' => $id_tec,
            ':device_id' => $device_id
        ));

        $status = array('status' => 'success');
    } catch(PDOException $e) {
        $status = array('status' => $e->getMessage());
    }

    echo json_encode($status);

});

$app->post('/os/exec', function() use($app){
    $request = \Slim\Slim::getInstance()->request();
    $requisicao = json_decode($request->getBody());
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=u389380248_mg', 'u389380248_root', '06111992');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach ($requisicao as $objeto) {
            $id_os = $objeto->{'id_web_os'};
            $ass_mob = $objeto->{'ass_mob'};
            $obs_mob = $objeto->{'obs_mob'};
            $cliAus_mob = $objeto->{'cliAus_mob'};
            $foto1_mob = $objeto->{'foto1_mob'};
            $foto2_mob = $objeto->{'foto2_mob'};
            $foto3_mob = $objeto->{'foto3_mob'};

            /* Altera o status da OS para concluida*/
            $stmt = $pdo->prepare(  ' UPDATE tb_os SET ID_STATUS = 4, ASS_MOB = :ass_mob,   '.
                ' FOTO_MOB_1 = :foto1_mob, FOTO_MOB_2 = :foto2_mob,     '.
                ' FOTO_MOB_3 = :foto3_mob, OBS_MOB = :obs_mob,          '.
                ' CLIAUS_MOB = :cliAus_mob WHERE ID_OS = :id_os         ');
            $stmt->execute(array(
                ':id_os' => $id_os,
                ':ass_mob' => $ass_mob,
                ':obs_mob' => $obs_mob,
                ':cliAus_mob' => $cliAus_mob,
                ':foto1_mob' => $foto1_mob,
                ':foto2_mob' => $foto2_mob,
                ':foto3_mob' => $foto3_mob,

            ));
        }
        $status = array('status' => 'success');
    } catch(PDOException $e) {
        $status = array('status' => $e->getMessage());
    }

    echo json_encode($status);

});

$app->post('/os/orc', function() use($app){
    $request = \Slim\Slim::getInstance()->request();
    $requisicao = json_decode($request->getBody());
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=u389380248_mg', 'u389380248_root', '06111992');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach ($requisicao as $objeto){
            $id = $objeto->{'id_os'};
            $ass =$objeto->{'ass_mob'};
            $produtos =$objeto->{'produtos_mob'};

            /* Altera o status da OS para concluida*/
            if(!empty($produtos)){
                $stmt = $pdo->prepare(  ' UPDATE tb_os SET ID_STATUS = 3, ASS_MOB = :ass_mob WHERE ID_OS = :id_os');
                $stmt->execute(array(
                    ':id_os' => $id,
                    ':ass_mob' => $ass,
                ));

                foreach ($produtos as $objeto){
                    $nome =$objeto->{'nome_prod_mob'};
                    $quantidade =$objeto->{'quant_prod_mob'};
                    /* Cadastra produtos orçados e atrela a OS concluida*/
                    $stmt = $pdo->prepare(  ' insert into tb_produtos_orcados (ID_OS, NOME_PROD, QUANT_PROD) VALUES (:id_os,:nome,:quantidade)');
                    $stmt->execute(array(
                        ':id_os' => $id,
                        ':nome' => $nome,
                        ':quantidade' => $quantidade,
                    ));
                }
                $status = array('status' => 'success');
            }else{
                $status = array('status' =>'orçamento sem produtos!' );
            }
        }



    } catch(PDOException $e) {
        $status = array('status' => $e->getMessage());
    }

    echo json_encode($status);

});

$app->post('/os/finaliza/exec', function() use($app){

    $request = \Slim\Slim::getInstance()->request();
    $requisicao = json_decode($request->getBody());
    $id_os = $requisicao->{'id_os'};

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=u389380248_mg', 'u389380248_root', '06111992');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('UPDATE tb_os SET id_status = 4 WHERE id_os = :id_os');
        $stmt->execute(array(
            ':id_os' => $id_os,
        ));

        $status = array('status' => 'success');
    } catch(PDOException $e) {
        $status = array('status' => $e->getMessage());
    }

    echo json_encode($status);

});
$app->post('/os/finaliza/orc', function() use($app){

    $request = \Slim\Slim::getInstance()->request();
    $requisicao = json_decode($request->getBody());
    $id_os = $requisicao->{'id_os'};

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=u389380248_mg', 'u389380248_root', '06111992');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('UPDATE tb_os SET id_status = 3 WHERE id_os = :id_os');
        $stmt->execute(array(
            ':id_os' => $id_os,
        ));

        $status = array('status' => 'success');
    } catch(PDOException $e) {
        $status = array('status' => $e->getMessage());
    }

    echo json_encode($status);

});


# Executar a API (deixá-la acessível)...
$app->run();
?>