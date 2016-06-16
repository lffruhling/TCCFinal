<?php

// Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)
if (!empty($_POST) AND (empty($_POST['usuario']) OR empty($_POST['senha']))) {
    header("Location: index.php"); exit;
}

$usuario = $_POST['usuario'];
$senha = base64_encode($_POST['senha']);


$pdo = new PDO('mysql:host=localhost;dbname=u389380248_mg', 'u389380248_root', '06111992');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$result = $pdo->prepare( " SELECT ID_COLAB, NOME_COLAB, ID_PERFIL  FROM tb_colaboradores WHERE (USUARIO_COLAB = ?) AND (SENHA_COLAB = ?) AND (ATIVO = 1) LIMIT 1");
$result->bindParam(1,$usuario);
$result->bindParam(2,$senha);

if($result->execute()){
    $row = $result->fetch(PDO::FETCH_BOTH);
    $id_colab = $row[0];
    $nome_colab = utf8_encode($row[1]);
    $perfil_id_colab = $row[2];
}

// Validação do usuário/senha digitados
if ($result->rowCount() != 1) {
    // Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado
    echo 0;
    //echo $sql;

    exit;
} else {
    // Salva os dados encontados na variável $resultado
    //$resultado = mysql_fetch_assoc($query);

    // Se a sessão não existir, inicia uma
    if (!isset($_SESSION)) session_start();
    // Salva os dados encontrados na sessão
    $_SESSION['UsuarioID'] = $id_colab;
    $_SESSION['UsuarioNome'] = $nome_colab;
    $_SESSION['UsuarioNivel'] = $perfil_id_colab;

    // Redireciona o visitante
    //header("Location: index2.php");
    //exit;
    echo 1;
}
