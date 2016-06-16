<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="styles/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="styles/animate.css">
    <link type="text/css" rel="stylesheet" href="styles/all.css">
    <link type="text/css" rel="stylesheet" href="styles/main.css">
    <link type="text/css" rel="stylesheet" href="styles/style-responsive.css">
</head>
<body style="background: url('images/bg/bg.png') center center fixed;">
    <div class="page-form">
        <div class="panel panel-blue">
            <div class="panel-body pan">
                <form action="#" class="form-horizontal">
                <div class="form-body pal">
                    <div class="col-md-12 text-center">
                        <h1 style="margin-top: -90px; font-size: 48px;">
                            Meu Gerente</h1>
                        <br />
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <img src="images/avatar/profile-pic.png" class="img-responsive" style="margin-top: -35px;" />
                        </div>
                        <div class="col-md-9 text-center">
                            <h1>
                                Controle de Acesso</h1>
                            <br />
                            <p>
                                Informe usuário e senha para acessar o sistema</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-md-3 control-label">
                            Usuário:</label>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <i class="fa fa-user"></i>
                                <input id="usuario" type="text" placeholder="" class="form-control" /></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="senha" class="col-md-3 control-label">
                            Senha:</label>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <i class="fa fa-lock"></i>
                                <input id="senha" type="text" placeholder="" class="form-control" /></div>
                        </div>
                    </div>
                    <div class="form-group mbn">
                        <div class="col-lg-12" align="right">
                            <div class="form-group mbn">
                                <div class="col-lg-3">
                                    &nbsp;
                                </div>
                                <div class="col-lg-9">
                                   
                                    <button type="button" class="width-35 pull-right btn btn-sm btn-primary" onclick="validar_login();">
                                       <i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Entrar</span>
															</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <p>
                <a href="#">Esqueceu sua Senha?</a> 
            </p>
        </div>
    </div>
    <script language="JavaScript" type="text/javascript" src="./js/jquery-1.2.6.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="./js/jquery-ui-personalized-1.5.2.packed.js"></script>
	<script language="JavaScript" type="text/javascript" src="./js/sprinkle.js"></script>
	<script language="JavaScript" type="text/javascript" src="./js/glide.js"></script>
    <script type="text/javascript">
    	function validar_login()
	{
		//var campo = document.getElementById('inputName');
		//alert(campo.value);
		
		var dadosajax = {
			'usuario' : $("#usuario").val(),
			'senha' : $("#senha").val(),
		};
		pageurl = './ajax/valida_login.php';
		$.ajax({
			//url da pagina
			url: pageurl,
			//parametros a passar
			data: dadosajax,
			//tipo: POST ou GET
			type: 'POST',
			//cache
			cache: false,
			//se ocorrer um erro na chamada ajax, retorna este alerta
			//possiveis erros: pagina nao existe, erro de codigo na pagina, falha de comunicacao/internet, etc etc etc
			error: function(){
				alert("Erro na chamada AJAX");
			},
			//retorna o resultado da pagina para onde enviamos os dados
			success: function(result)
			{ 
				//se foi inserido com sucesso
				if($.trim(result) == '1')
				{
					//alert("Login ok!");
					document.getElementById('usuario').value='';
					document.getElementById('senha').value='';
					window.open("index.html","_self");
				}
				//se foi um erro
				else
				{
					alert("Usuário ou senha inválida");
					alert(result);
				}
	 
			}
		});
	}
    </script>
</body>
</html>
