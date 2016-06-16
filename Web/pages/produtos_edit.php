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
}elseif ($id = $_REQUEST['id'] == null OR $id = $_REQUEST['id'] == 0){
    header("Location: produtos_list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Produtos</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>
<body>
<?php
include "utils/utils.php";
include "classes/mysql.php";

$id = $_REQUEST['id'];

$db = new MySQL();
$db->conecta() or die("Erro de conexão ao banco");

$nome       = $db->_e_nome_prod($id);
$grupo     = $db->_e_grupo_prod($id);
foreach($grupo as $key => $value){
    if(strpos($value,"*")){
        $id_grup = $key;
        break;
    }
}

$marca = $db->_e_marca_prod($id);
$modelo = $db->_e_modelo_prod($id);
$valor_comp = $db->_e_valor_compra_prod($id);
$valor_vend = $db->_e_valor_venda_prod($id);
$quantidade = $db->_e_quantidade_prod($id);
$desc = $db->_e_desc_prod($id);
$ativo = $db->_e_ativo_prod($id);

$total_abertas = $db->total_abertas();
$total_orcadas = $db->total_orcadas();
$total_concluidas = $db->total_concluidas();
?>
<div>
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

            <li>
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

            <li class="active">
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
            Produtos
        </div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="menu.php">Home</a><i
                class="fa fa-angle-right"></i></li>
        <li class="active"><a href="produtos_list.php">Produtos</a><i class="fa fa-angle-right"></i></li></li>
        <li class="active">Edição de Produtos</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<!--END TITLE & BREADCRUMB PAGE-->
<!--BEGIN CONTENT-->
<div class="page-content">
    <div id="tab-general">
        <div class="row mbl">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">Novo Produto</div>
                            <div class="panel-body pan">
                                <form action="#">
                                    <div class="form-body pal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="inputname" class="control-label">Nome *</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="inputname" type="text" placeholder="" class="form-control" required="" value="<?php echo $nome ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">Grupo do Produto *
                                                    <br>
                                                    <select class="form-control" id="inputgrupo" >
                                                        <?php
                                                        foreach($grupo as $key => $value){
                                                            if(strpos($value,"*")){
                                                                //str_replace("*","",$value);
                                                                echo "<option value='$key' selected>$value</option>\n";
                                                            }
                                                            else{
                                                                echo "<option value='$key'>$value</option>\n";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputmarca" class="control-label">Marca</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="inputmarca" type="text" placeholder="" class="form-control"value="<?php echo $marca ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputmodelo" class="control-label">Modelo</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="inputmodelo" type="text" placeholder="" class="form-control" value="<?php echo $modelo ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="inputcompra" class="control-label">Valor de Compra</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="inputcompra" type="number" placeholder="" class="form-control" value="<?php echo $valor_comp ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="inputvenda" class="control-label">Valor de Venda</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="inputvenda" type="number" placeholder="" class="form-control" value="<?php echo $valor_vend ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="inputquant" class="control-label">Quantidade</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="inputquant" type="number" placeholder="" class="form-control" value="<?php echo $quantidade ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="inputdesc" class="control-label">Descrição</label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <textarea  id="inputdesc" type="text" placeholder="" class="form-control"><?php echo $desc ?> </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mbn">
                                            <div class="checkbox">
                                                <label>
                                                    <input id="inputativo" tabindex="5" type="checkbox" <?php echo $ativo ?>/>&nbsp; Ativo
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions text-right pal">
                                        <button type="button" class="btn btn-primary" onclick="cancelar();">
                                            Cancelar</button>
                                        <button type="button" class="btn btn-primary" onclick="editar_produto();">
                                            Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
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
    function cancelar(){
        if(confirm("Deseja cancelar?")==true){
            open("produtos_list.php","_self");
        }
    }
    function editar_produto(){
        var nome 		= $('#inputname').val();
        var id_grupo	= $('#inputgrupo').val();
        var marca       = $('#inputmarca').val();
        var modelo      = $('#inputmodelo').val();
        var desc        = $('#inputdesc').val();
        var quant       = $('#inputquant').val();
        var valorcomp   = $('#inputcompra').val();
        var valorvend   = $('#inputvenda').val();

        if(nome==''){
            alert("Preencha o campo Nome");
            return;
        }
        if ( $('#inputativo').is(":checked")){
            var ativo		= '1';
        }else{
            var ativo		= '0';
        }

        var dadosajax = {
            'id':<?php echo $id?>,
            'nome': nome,
            'id_grupo': id_grupo,
            'marca': marca,
            'modelo': modelo,
            'desc': desc,
            'quant': quant,
            'valorcomp': valorcomp,
            'valorvend': valorvend,
            'ativo': ativo
        };
        pageurl = './ajax/edita_produto.php';
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
                    alert('Produtos editado com sucesso');
                    open("produtos_new.php","_self");
                    //$('#dynamictable').DataTable().ajax.reload(null,false).draw();

                } else if(result==0){
                    alert('Erro ao editar Produtos');
                }
            }
        });
    }
</script>
</body>
</html>
