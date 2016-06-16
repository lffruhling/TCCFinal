<?php
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

$nivel_necessario = 1;

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] > $nivel_necessario)) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: index.php"); exit;
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordens de Serviços</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <style>
        body{font: 14px "Open Sans", serif; background-color: #488C6C; float: left; height: 100%; position: relative; width: 100%; background-color: #e3e3e4;}
        *{margin: 0; padding: 0; box-sizing: border-box;}
        :focus{outline: none;}
        a{text-decoration: none;}
        li{list-style: none;}
        h1{font-size: 24px; font-weight: 600; margin: 20px 0 10px; text-align: center;}
        .container{margin: 20px 60px; max-width: 600px;}

        /*= wizard css =*/
        .payment-wizard{float: left; width: 100%;}
        .payment-wizard li.active{position: relative; z-index: 1;}
        .wizard-heading{float: left; width: 100%; padding: 10px 15px; background-color: #488C6C; margin-bottom: 1px; box-sizing: border-box; font-size: 18px; color: #fff; text-transform: uppercase; transition: 0.3s;}
        .wizard-content{display: none; float: left; width: 100%; background-color: #fff; box-shadow: 0 8px 8px #65A688; padding: 15px; box-sizing: border-box;}
        li:first-child .wizard-content{display: block;}
        .wizard-content p{margin-bottom: 15px; font-size: 15px; line-height: 26px; color: #4c4c4c;}
        .btn-green{color: #fff; float: right; border: 0; padding: 7px 10px; min-width: 92px; z-index: 1; cursor: pointer; font-size: 14px; text-transform: uppercase; background-color: #447294; border-radius: 3px; border-bottom: 3px solid #3881C9; position: relative; transition: 0.3s;}
        .btn-green:before{content: ""; width: 100%; height: 0; border-radius: 3px; z-index: -1; position: absolute; left: 0; bottom: 0; background-color: #65A688; transition: 0.3s;}
        .btn-green:hover:before{height: 100%;}
        .wizard-heading span{float: right; background-image: url(wizard-icons.png); background-repeat: no-repeat;}
        .icon-user{width: 20px; height: 18px; background-position: 0 -40px; margin-top: 4px;}
        .icon-location{width: 15px; height: 20px; background-position: -22px -42px; margin-top: 4px;}
        .icon-summary{width: 20px; height: 20px; background-position: -39px -42px; margin-top: 4px;}
        .icon-mode{width: 20px; height: 16px; background-position: -61px -34px; margin-top: 6px;}
        .active .wizard-heading{background-color: #488C6C; color: #fff; margin-bottom: 0;}
        .active .icon-user{background-position: 0 0;}
        .active .icon-location{background-position: -22px 0;}
        .active .icon-summary{background-position: -39px 0;}
        .active .icon-mode{background-position: -61px 0;}
        .completed .wizard-heading{color: #fff; position: relative; padding: 10px 15px 10px 36px; cursor: pointer; transition: 0.3s;}
        .completed .wizard-heading:before{content: "✓"; color: #fff; text-align: center; font-size: 15px; font-weight: bold; position: absolute; left: -7px; top: 8px; width: 32px; padding: 4px 0; background-color: #447294; z-index: 99;}
        .completed .wizard-heading:after{content: ""; position: absolute; top: 38px; left: -7px; border-left: 7px solid transparent; border-top: 5px solid #001e34;}
        .completed .icon-user{background-position: 0 -20px;}
        .completed .icon-location{background-position: -22px -21px;}
        .completed .icon-summary{background-position: -39px -21px;}
        .completed .icon-mode{background-position: -61px -17px;}
        /*= wizard end =*/
    </style>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="images/icons/favicon.ico">
    <link rel="apple-touch-icon" href="images/icons/favicon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/icons/favicon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/icons/favicon-114x114.png">
    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="styles/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="styles/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="styles/animate.css">
    <link type="text/css" rel="stylesheet" href="styles/all.css">
    <link type="text/css" rel="stylesheet" href="styles/main.css">
    <link type="text/css" rel="stylesheet" href="styles/style-responsive.css">
    <link type="text/css" rel="stylesheet" href="styles/zabuto_calendar.min.css">
    <link type="text/css" rel="stylesheet" href="styles/pace.css">
    <!-- Data tables-->
    <link type="text/css" rel="stylesheet" href="media/css/dataTables.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="media/css/dataTables.foundation.min.css">
    <link type="text/css" rel="stylesheet" href="media/css/dataTables.jqueryui.min.css">
    <link type="text/css" rel="stylesheet" href="media/css/jquery.dataTables.min.css">
    <link type="text/css" rel="stylesheet" href="media/css/jquery.dataTables_themeroller.css">
</head>
<body>
<?php
include "utils/utils.php";
include "classes/mysql.php";

$idg = getVoucher();

$db = new MySQL();
$db->conecta() or die("Erro de conexão ao banco");

$cliente = $db->_n_cliente_os();
$tipo_serviço = $db->_n_tipo_serv_os();
$tecnico = $db->_n_tecnico_os();
$grupo_prod = $db->_n_grupo_produto_os();

$total_abertas = $db->total_abertas();
$total_orcadas = $db->total_orcadas();
$total_concluidas = $db->total_concluidas();

?>
<!--INICIO MENU TOPO-->
<div id="header-topbar-option-demo" class="page-header-topbar">
    <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3" class="navbar navbar-default navbar-static-top">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <a id="logo" href="menu.php" class="navbar-brand"><span class="fa fa-rocket"></span><span class="logo-text">Meu Gerente</span><span style="display: none" class="logo-text-icon">µ</span></a></div>
        <div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
            <ul class="nav navbar navbar-top-links navbar-right mbn">
                <li class="dropdown"><a data-hover="dropdown" href="os_list.php" class="dropdown-toggle"><i class="fa fa-bell fa-fw"></i><span class="badge badge-green"><?php echo "Abertas ".$total_abertas ?></span>&nbsp;</a>

                </li>
                <li class="dropdown"><a data-hover="dropdown" href="os_list.php" class="dropdown-toggle"><i class="fa fa-envelope fa-fw"></i><span class="badge badge-orange"><?php echo "Orcadas ".$total_orcadas ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>

                </li>
                <li class="dropdown"><a data-hover="dropdown" href="os_list.php" class="dropdown-toggle"><i class="fa fa-tasks fa-fw"></i><span class="badge badge-yellow"><?php echo "Concluídas ".$total_concluidas ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </li>
                <li class="dropdown topbar-user"><a data-hover="dropdown" href="#" class="dropdown-toggle"><img src="images/avatar/businessman.png" alt="" class="img-responsive img-circle"/>&nbsp;<span class="hidden-xs"><?php echo $_SESSION['UsuarioNome']; ?></span>&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-user pull-right">
                        <li><a href="altera_senha.php"><i class="fa fa-lock"></i>Alterar Senha</a></li>
                        <li><a href="logout.php"><i class="fa fa-key"></i>Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
</div>
<!--END TOPBAR-->
<div id="wrapper">
<!--BEGIN SIDEBAR MENU-->
<nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
     data-position="right" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse menu-scroll">
        <ul id="side-menu" class="nav">

            <div class="clearfix"></div>
            <li>
                <a href="menu.php">
                    <i class="fa fa-bar-chart-o fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i>
                    <span class="menu-title">Painel de Controle</span>
                </a>
            </li>

            <li>
                <a href="clientes_list.php">
                    <i class="fa fa-users fa-fw">
                        <div class="icon-bg bg-pink"></div>
                    </i>
                    <span class="menu-title">Clientes</span>
                </a>
            </li>

            <li>
                <a href="colaboradores_list.php">
                    <i class="fa fa-user-md fa-fw">
                        <div class="icon-bg bg-green"></div>
                    </i>
                    <span class="menu-title">Colaboradores</span>
                </a>
            </li>

            <li>
                <a href="grupo_prod_list.php">
                    <i class="fa fa-list fa-fw">
                        <div class="icon-bg bg-red"></div>
                    </i>
                    <span class="menu-title">Grupo de Produtos</span>
                </a>
            </li>

            <li  class="active">
                <a href="os_list.php">
                    <i class="fa fa-file-text fa-fw">
                        <div class="icon-bg bg-grey"></div>
                    </i>
                    <span class="menu-title">Ordens de Serviços</span>
                </a>
            </li>

            <li>
                <a href="perfil_list.php">
                    <i class="fa fa-user fa-fw">
                        <div class="icon-bg bg-violet"></div>
                    </i>
                    <span class="menu-title">Perfil</span>
                </a>
            </li>

            <li>
                <a href="produtos_list.php">
                    <i class="fa fa-shopping-cart fa-fw">
                        <div class="icon-bg bg-blue"></div>
                    </i>
                    <span class="menu-title">Produtos</span>
                </a>
            </li>

            <li>
                <a href="tipo_serv_list.php">
                    <i class="fa fa-cog fa-fw">
                        <div class="icon-bg bg-yellow"></div>
                    </i>
                    <span class="menu-title">Tipos de Serviços</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">
                Ordens de Serviços
            </div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="menu.php">Home</a><i
                    class="fa fa-angle-right"></i></li>
            <a href="os_list.php">Ordens de Serviço</a>&nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Cadastro Ordem de Serviço</li>
        </ol>
        <div class="clearfix">
        </div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <!--BEGIN CONTENT-->
    <div class="container">
    <ul class="payment-wizard">
        <li class="active">
            <div class="wizard-heading">
                1. Ordem de Serviço
                <span class="icon-user"></span>
            </div>
            <div class="wizard-content">
                <div class="form-group">Cliente *
                    <br>
                    <select class="form-control" id="inputcli" >
                        <?php
                        foreach($cliente as $key => $value){
                            echo "<option value='$key'>$value</option>\n";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">Tipo de Serviço *
                    <br>
                    <select class="form-control" id="input_tp_serv" >
                        <?php
                        foreach($tipo_serviço as $key => $value){
                            echo "<option value='$key'>$value</option>\n";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">Técnico *
                    <br>
                    <select class="form-control" id="inputtec" >
                        <?php
                        foreach($tecnico as $key => $value){
                            echo "<option value='$key'>$value</option>\n";
                        }
                        ?>
                    </select>
                </div>
                <label for="inputobs" class="control-label">Observações </label>
                <div class="input-icon right">
                    <i class="fa fa-user"></i>
                    <textarea id="inputobs" type="text" placeholder="" class="form-control" required=""></textarea>
                </div>
                </br>
                <div class="checkbox">
                    <label>
                        <input id="inputorcamento" tabindex="5" type="checkbox" checked/>&nbsp; Orçar Ordem de Serviço
                    </label>
                </div>
                </br>
                <div class="checkbox">
                    <label>
                        <input id="inputfoto" tabindex="5" type="checkbox" checked/>&nbsp; Fotografar Peças
                    </label>
                </div>
                </br>
                <div class="checkbox">
                    <label>
                        <input id="inputemail" tabindex="5" type="checkbox" checked/>&nbsp; Receber E-mail
                    </label>
                </div>
                </br>
                <div class="checkbox">
                    <label>
                        <input id="inputativo" tabindex="5" type="checkbox" checked/>&nbsp; Ativo
                    </label>
                </div>
                <button class="btn-green done" type="button">Próximo</button>
            </div>
        </li>
        <li>
            <div class="wizard-heading">
                2. Produtos
                <span class="icon-mode"></span>
            </div>
            <div class="wizard-content">
                <div class="form-group">Grupo de Produtos *
                    <br>
                    <select class="form-control" id="input_grupo_prod" onchange="sel_produto();">
                        <?php
                        foreach($grupo_prod as $key => $value){
                            echo "<option value='$key'>$value</option>\n";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">Produto *
                    <br>
                    <select class="form-control" id="inputproduto"></select>
                </div>
                <div class="form-group">
                    <label for="inputquant" class="control-label">Quantidade *</label>
                    <input id="inputquant" type="number" placeholder="" class="form-control" required=""/>
                </div>
                <div class="form-actions text-right pal">
                    <button type="button" class="btn btn-primary" onclick="adiciona_produto();">Adiconar Produto</button>
                </div>
                <button class="btn-green" type="submit" onclick="cadastrar_os()">Salvar</button>
            </div>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <form>
                <div class="panel panel-green">
                    <div class="panel-heading">Produtos Utilizados</div>
                    <div class="panel-body">
                        <table id="dynamictable" class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Grupo do Produto</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
</div>

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
    $(window).load(function(){
        $(".done").click(function(){
            var id_cli 		= $('#inputcli').val();
            var id_tp_serv	= $('#input_tp_serv').val();
            var id_tec      = $('#inputtec').val();
            if(id_cli==0){
                alert("Campo 'Cliente' precisa ser preenchido");
                return;
            }

            if(id_tp_serv==0){
                alert("Campo 'Tipo de Serviço' precisa ser preenchido");
                return;
            }

            if(id_tec==0){
                alert("Campo 'Técnico' precisa ser preenchido");
                return;
            }
            var this_li_ind = $(this).parent().parent("li").index();
            if($('.payment-wizard li').hasClass("jump-here")){
                $(this).parent().parent("li").removeClass("active").addClass("completed");
                $(this).parent(".wizard-content").slideUp();
                $('.payment-wizard li.jump-here').removeClass("jump-here");
            }else{
                $(this).parent().parent("li").removeClass("active").addClass("completed");
                $(this).parent(".wizard-content").slideUp();
                $(this).parent().parent("li").next("li:not('.completed')").addClass('active').children('.wizard-content').slideDown();
            }

        });

        $('.payment-wizard li .wizard-heading').click(function(){
            if($(this).parent().hasClass('completed')){
                var this_li_ind = $(this).parent("li").index();
                var li_ind = $('.payment-wizard li.active').index();
                if(this_li_ind < li_ind){
                    $('.payment-wizard li.active').addClass("jump-here");
                }
                $(this).parent().addClass('active').removeClass('completed');
                $(this).siblings('.wizard-content').slideDown();
            }
        });
    })
</script>
<script>        (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-145464-12', 'auto');
    ga('send', 'pageview');


</script>
<script type="text/javascript">

    function cadastrar_os(){
        var id_cli 		= $('#inputcli').val();
        var id_tp_serv	= $('#input_tp_serv').val();
        var id_tec      = $('#inputtec').val();
        var obs		    = $('#inputobs').val();

        if ( $('#inputorcamento').is(":checked")){
            var orcamento = '1';
        }else{
            var orcamento = '0';
        }

        if ( $('#inputfoto').is(":checked")){
            var foto = '1';
        }else{
            var foto = '0';
        }

        if ( $('#inputemail').is(":checked")){
            var email = '1';
        }else{
            var email = '0';
        }

        if ( $('#inputativo').is(":checked")){
            var ativo = '1';
        }else{
            var ativo = '0';
        }

        if(id_cli==0){
            alert("Campo 'Cliente' precisa ser preenchido");
            return;
        }

        if(id_tp_serv==0){
            alert("Campo 'Tipo de Serviço' precisa ser preenchido");
            return;
        }

        if(id_tec==0){
            alert("Campo 'Técnico' precisa ser preenchido");
            return;
        }

        var dadosajax = {
            'idg' : <?php echo "'$idg'" ?>,
            'id_cli': id_cli,
            'id_tp_serv': id_tp_serv,
            'id_tec': id_tec,
            'obs': obs,
            'foto': foto,
            'email': email,
            'orcamento': orcamento,
            'ativo': ativo
        };
        pageurl = './ajax/cadastra_os.php';
        //para consultar mais opcoes possiveis numa chamada ajax
        //http://api.jquery.com/jQuery.ajax/
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
                if(result==1){
                    alert('Ordem de Serviço adicionada com sucesso');

                    //$('#inputperfil').val(0);
                    $('#inputativo').val('');

                    open("os_new.php","_self");
                    $('#dynamictable').DataTable().ajax.reload(null,false).draw();

                } else if(result==0){
                    alert('Erro ao adicionar Ordem de Serviço');
                }
            }
        });
    }

    function adiciona_produto(){
        //dados a enviar, vai buscar os valores dos campos que queremos enviar para a BD
        var grupo_produo = $('#input_grupo_prod').val();
        var produto = $('#inputproduto').val();
        var quantidade = $('#inputquant').val();

        if(grupo_produo==0){
            alert("Campo 'Grupo de Produto' precisa ser preenchido");
            return;
        }
        if(produto==0){
            alert("Campo 'Produto' precisa ser preenchido");
            return;
        }
        if(quantidade==''){
            alert("Campo 'Quantidade' precisa ser preenchido");
            return;
        }

        var dadosajax = {
            'idg' : <?php echo "'$idg'" ?>,
            'grupo_produto' : grupo_produo,
            'produto': produto,
            'quantidade': quantidade
        };

        pageurl = 'ajax/adiciona_produto.php';
        //para consultar mais opcoes possiveis numa chamada ajax
        //http://api.jquery.com/jQuery.ajax/
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
                if(result=='1'){
                    $('#input_grupo_prod').val('');
                    $('#inputproduto').val('');
                    $('#inputquant').val('');

                    alert("Produto adicionado com sucesso");

                    //open("form_projeto.php","_self");
                    $('#dynamictable').DataTable().ajax.reload(null,false).draw();

                } else if(result=='0'){
                    alert('Erro ao adicionar Produto');
                } else {alert(result);}
            }
        });
    }

    function sel_produto(){
        //dados a enviar, vai buscar os valores dos campos que queremos enviar para a BD
        var id_grupo_prod = $('#input_grupo_prod').val();
        var dadosajax = {
            'id_grupo_prod' : id_grupo_prod,
        };
        $('#inputproduto').attr('disabled', 'disabled');
        pageurl = './ajax/sel_produto.php';
        //para consultar mais opcoes possiveis numa chamada ajax
        //http://api.jquery.com/jQuery.ajax/
        $.ajax({
            //url da pagina
            url: pageurl,
            //parametros a passar
            data: dadosajax,
            //tipo: POST ou GET
            type: 'POST',
            //cache
            cache: false,
            // tipo de dados
            dataType: 'json',
            //se ocorrer um erro na chamada ajax, retorna este alerta
            //possiveis erros: pagina nao existe, erro de codigo na pagina, falha de comunicacao/internet, etc etc etc
            error: function(){
                alert("Erro na chamada AJAX");
            },
            //retorna o resultado da pagina para onde enviamos os dados
            success: function(json)
            {
                var options = "";
                $.each(json,function(key,value){
                    options += '<option value="'+key+'">'+value+'</option>';
                });
                $('#inputproduto').html(options);
                $('#inputproduto').removeAttr('disabled');
            }
        });
    }
</script>
<script src="script/jquery-1.10.2.min.js"></script>
<script src="script/jquery-migrate-1.2.1.min.js"></script>
<script src="script/jquery-ui.js"></script>
<script src="script/bootstrap.min.js"></script>
<script src="script/bootstrap-hover-dropdown.js"></script>
<script src="script/html5shiv.js"></script>
<script src="script/respond.min.js"></script>
<script src="script/jquery.metisMenu.js"></script>
<script src="script/jquery.slimscroll.js"></script>
<script src="script/jquery.cookie.js"></script>
<script src="script/icheck.min.js"></script>
<script src="script/custom.min.js"></script>
<script src="script/jquery.news-ticker.js"></script>
<script src="script/jquery.menu.js"></script>
<script src="script/pace.min.js"></script>
<script src="script/holder.js"></script>
<script src="script/responsive-tabs.js"></script>
<script src="script/jquery.flot.js"></script>
<script src="script/jquery.flot.categories.js"></script>
<script src="script/jquery.flot.pie.js"></script>
<script src="script/jquery.flot.tooltip.js"></script>
<script src="script/jquery.flot.resize.js"></script>
<script src="script/jquery.flot.fillbetween.js"></script>
<script src="script/jquery.flot.stack.js"></script>
<script src="script/jquery.flot.spline.js"></script>
<script src="script/zabuto_calendar.min.js"></script>
<script src="script/index.js"></script>
<!--LOADING SCRIPTS FOR CHARTS-->
<script src="script/highcharts.js"></script>
<script src="script/data.js"></script>
<script src="script/drilldown.js"></script>
<script src="script/exporting.js"></script>
<script src="script/highcharts-more.js"></script>
<script src="script/charts-highchart-pie.js"></script>
<script src="script/charts-highchart-more.js"></script>
<!--CORE JAVASCRIPT-->
<script language="JavaScript" type="text/javascript" src="./js/jquery-1.2.6.min.js"></script>
<script language="JavaScript" type="text/javascript" src="./js/jquery-ui-personalized-1.5.2.packed.js"></script>
<script language="JavaScript" type="text/javascript" src="./js/sprinkle.js"></script>
<script language="JavaScript" type="text/javascript" src="./js/glide.js"></script>
<script src="script/main.js"></script>
<script type="text/javascript" src="media/js/jquery.js"></script>
<script type="text/javascript" src="media/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    //
    // Tabela
    //
    $(document).ready(function() {
        $('#dynamictable').dataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "table/os_produto_table.php?idg=<?php echo $idg ?>",
                "type": "POST"
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
            }
        });
    });
</script>
</body>
</html>