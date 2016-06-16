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
<html lang="en">
<head>
    <title>Grupo de Produtos</title>
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
    <!-- Data tables-->
    <link type="text/css" rel="stylesheet" href="media/css/dataTables.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="media/css/dataTables.foundation.min.css">
    <link type="text/css" rel="stylesheet" href="media/css/dataTables.jqueryui.min.css">
    <link type="text/css" rel="stylesheet" href="media/css/jquery.dataTables.min.css">
    <link type="text/css" rel="stylesheet" href="media/css/jquery.dataTables_themeroller.css">
    <script type="text/javascript" src="media/js/jquery.js"></script>
    <script type="text/javascript" src="media/js/jquery.dataTables.min.js"></script>
</head>
<?php
include "utils/utils.php";
include "classes/mysql.php";

$db = new MySQL();
$db->conecta() or die("Erro de conexão ao banco");

$total_abertas = $db->total_abertas();
$total_orcadas = $db->total_orcadas();
$total_concluidas = $db->total_concluidas();
?>
<body>
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

                <li class="active">
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
                    Grupo de Produtos
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="abre_iframe();">
                        Novo Grupo</button>
                </div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right">
                <li><i class="fa fa-home"></i>&nbsp;<a href="menu.php">Home</a>&nbsp;<i
                        class="fa fa-angle-right"></i>&nbsp;</li>
                <li class="hidden"><a href="#">Grupo de Produtos</a>&nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
                <li class="active">Grupo de Produtos</li>
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
                        <div class="col-md-12">
                            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-green">
                        <div class="panel-heading">Grupos Cadastrados</div>
                        <div class="panel-body">
                            <table id="dynamictable" class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        //
        // Tabela
        //
        $(document).ready(function() {
            $('#dynamictable').dataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "table/grupo_prod_table.php",
                    "type": "POST"
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
    <script type="text/javascript">
        function deletar(id){
            if(confirm("Deseja realmente apagar o registro "+id+" ?")==false){
                return;
            }

            //dados a enviar, vai buscar os valores dos campos que queremos enviar para a BD
            var dadosajax = {
                'id' : id
            };
            pageurl = 'ajax/deleta_grupo.php';
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
                        $('#dynamictable').DataTable().ajax.reload(null,false).draw();
                        alert('Registro deletado com sucesso');
                    } else if(result=='0'){
                        alert('Erro ao deletar registro');
                    }
                }
            });
        }

        function editar(id){
            if(confirm("Deseja realmente editar o registro "+id+" ?")==false){
                return;
            }
            open("grupo_prod_edit.php?id="+id,"_self");

        }

        function abre_iframe(){
            open("grupo_prod_new.php","_self");
        }
    </script>
</body>
</html>

