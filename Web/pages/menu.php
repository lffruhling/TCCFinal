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
    <title>Menu</title>
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
    <link type="text/css" rel="stylesheet" href="styles/jquery.news-ticker.css">
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
        <!--FIM MENU TOPO-->
        <div id="wrapper">
            <!--INICIO MENU LATERAL-->
            <nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
                data-position="right" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
                    
                    <div class="clearfix"></div>
                    <li class="active">
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
            <!--FIM MENU LATERAL-->
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--INICIO TITULO PÁGINA-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left">
                        <div class="page-title">
                            Painel de Controle</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="menu.php">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="hidden"><a href="#">Painel de Controle</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Painel de Controle</li>
                    </ol>
                    <div class="clearfix">
                    </div>
                </div>
                <!--END TITULO PÁGINA-->
                <!--INICIO CONTENT-->
                <div class="page-content">
                    <div id="tab-general">
                        <div id="sum_box" class="row mbl">
                            <div class="col-sm-6 col-md-3">
                                <div class="panel profit db mbm">
                                    <div class="panel-body">
                                        <p class="icon">
                                            <i class="icon fa fa-shopping-cart"></i>
                                        </p>
                                        <h4 class="value">
                                            <span data-counter="" data-start="10" data-end="50" data-step="1" data-duration="0">
                                            </span><span>$</span></h4>
                                        <p class="description">
                                            Profit description</p>
                                        <div class="progress progress-sm mbn">
                                            <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 80%;" class="progress-bar progress-bar-success">
                                                <span class="sr-only">80% Complete (success)</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="panel income db mbm">
                                    <div class="panel-body">
                                        <p class="icon">
                                            <i class="icon fa fa-money"></i>
                                        </p>
                                        <h4 class="value">
                                            <span>215</span><span>$</span></h4>
                                        <p class="description">
                                            Income detail</p>
                                        <div class="progress progress-sm mbn">
                                            <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 60%;" class="progress-bar progress-bar-info">
                                                <span class="sr-only">60% Complete (success)</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="panel task db mbm">
                                    <div class="panel-body">
                                        <p class="icon">
                                            <i class="icon fa fa-signal"></i>
                                        </p>
                                        <h4 class="value">
                                            <span>215</span></h4>
                                        <p class="description">
                                            Task completed</p>
                                        <div class="progress progress-sm mbn">
                                            <div role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 50%;" class="progress-bar progress-bar-danger">
                                                <span class="sr-only">50% Complete (success)</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="panel visit db mbm">
                                    <div class="panel-body">
                                        <p class="icon">
                                            <i class="icon fa fa-group"></i>
                                        </p>
                                        <h4 class="value">
                                            <span>128</span></h4>
                                        <p class="description">
                                            Visitor description</p>
                                        <div class="progress progress-sm mbn">
                                            <div role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 70%;" class="progress-bar progress-bar-warning">
                                                <span class="sr-only">70% Complete (success)</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mbl">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h4 class="mbs">
                                                    Network Performance</h4>
                                                <p class="help-block">
                                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem...</p>
                                                <div id="area-chart-spline" style="width: 100%; height: 300px">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h4 class="mbm">
                                                    Server Status</h4>
                                                <span class="task-item">CPU Usage (25 - 32 cpus)<small class="pull-right text-muted">40%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 40%;" class="progress-bar progress-bar-orange">
                                                        <span class="sr-only">40% Complete (success)</span></div>
                                                </div>
                                                </span><span>Memory Usage (2.5GB)<small class="pull-right text-muted">60%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 60%;" class="progress-bar progress-bar-blue">
                                                        <span class="sr-only">60% Complete (success)</span></div>
                                                </div>
                                                </span><span>Disk Usage (C:\ 120GB , D:\ 430GB)<small class="pull-right text-muted">55%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 55%;" class="progress-bar progress-bar-green">
                                                        <span class="sr-only">55% Complete (success)</span></div>
                                                </div>
                                                </span><span>Domain (2/5)<small class="pull-right text-muted">66%</small><div class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 66%;" class="progress-bar progress-bar-yellow">
                                                        <span class="sr-only">66% Complete (success)</span></div>
                                                </div>
                                                </span><span>Database (90/100)<small class="pull-right text-muted">90%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 90%;" class="progress-bar progress-bar-pink">
                                                        <span class="sr-only">90% Complete (success)</span></div>
                                                </div>
                                                </span><span>Email Account (25/50)<small class="pull-right text-muted">50%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 50%;" class="progress-bar progress-bar-violet">
                                                        <span class="sr-only">50% Complete (success)</span></div>
                                                </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <!--FIM CONTENT-->
                <!--BEGIN FOOTER-->
                <div id="footer">
                    <div class="copyright">
                        <a href="http://themifycloud.com">2016 © Leonardo Frühling | Sistema Meu Gerente</a></div>
                </div>
                <!--END FOOTER-->
            </div>
            <!--END PAGE WRAPPER-->
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
</body>
</html>
