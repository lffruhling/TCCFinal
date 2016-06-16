<?php
include "../classes/mysql.php";

ini_set( 'display_errors', true );
error_reporting( E_ALL );

$conn = mysqli_connect($dbhost,$dbuser,$dbpass);
if(!$conn){
    die('Erro na conexão');
}


$ret = mysqli_select_db($conn,$dbtable);
$requestData= $_REQUEST;

$columns = array(
    0 => 'ID',
    1 => 'CLI',
    2 => 'SERV',
    3 => 'TEC',
    4 => 'STATUS',
    5 => 'VALOR',
    6 => 'PAGA',
    7 => 'ACAO',
);

if(!$ret){
    die('Erro na seleção do database');
}

$query =    "SELECT                                         ".
            "    OS.ID_OS,                                  ".
            "    OS.ID_STATUS,                              ".
            "    cli.NOME_CLI,                              ".
            "    tpo_serv.DESC_TPOSERV,                     ".
            "    tec.NOME_COLAB,                            ".
            "    sts.DESC_STATUS,                           ".
            "    CASE                                       ".
            "		WHEN OS.VALOR_FINAL IS NULL THEN 0      ".
            "	END VALOR_FINAL,                            ".
            "    OS.PAGA                                    ".
            " FROM                                          ".
            "    tb_os OS                                   ".
            "        LEFT JOIN tb_cliente cli               ".
            "    ON OS.ID_CLI = cli.ID_cli                  ".
            "        LEFT JOIN tb_tpo_servico tpo_serv      ".
            "    ON OS.ID_TPOSERV = tpo_serv.ID_TPOSERV     ".
            "		LEFT JOIN tb_colaboradores tec          ".
            "	ON OS.ID_COLAB = tec.ID_COLAB               ".
            "    LEFT JOIN tb_status_os sts                 ".
            "	ON OS.ID_STATUS = sts.ID_STATUS             ".
            " WHERE (OS.DELETADO = 0 OR OS.DELETADO IS NULL)";

$result = mysqli_query($conn,$query);
$totalData = mysqli_num_rows($result);
$totalFiltered = $totalData;

$query =    "SELECT                                         ".
    "    OS.ID_OS,                                  ".
    "    OS.ID_STATUS,                              ".
    "    cli.NOME_CLI,                              ".
    "    tpo_serv.DESC_TPOSERV,                     ".
    "    tec.NOME_COLAB,                            ".
    "    sts.DESC_STATUS,                           ".
    "    CASE                                       ".
    "		WHEN OS.VALOR_FINAL IS NULL THEN 0      ".
    "	END VALOR_FINAL,                            ".
    "    OS.PAGA                                    ".
    " FROM                                          ".
    "    tb_os OS                                   ".
    "        LEFT JOIN tb_cliente cli               ".
    "    ON OS.ID_CLI = cli.ID_cli                  ".
    "        LEFT JOIN tb_tpo_servico tpo_serv      ".
    "    ON OS.ID_TPOSERV = tpo_serv.ID_TPOSERV     ".
    "		LEFT JOIN tb_colaboradores tec          ".
    "	ON OS.ID_COLAB = tec.ID_COLAB               ".
    "    LEFT JOIN tb_status_os sts                 ".
    "	ON OS.ID_STATUS = sts.ID_STATUS             ".
    " WHERE (OS.DELETADO = 0 OR OS.DELETADO IS NULL)";

if( !empty($requestData['search']['value']) ) {
    $query.=" AND (OS.ID_OS LIKE '%".$requestData['search']['value']."%' ";
    $query.=" OR cli.NOME_CLI LIKE '%".$requestData['search']['value']."%'";
    $query.=" OR tpo_serv.DESC_TPOSERV LIKE '%".$requestData['search']['value']."%'";
    $query.=" OR tec.NOME_COLAB LIKE '%".$requestData['search']['value']."%' )";
}

$result = mysqli_query($conn,$query) or die ("Erro na query: $query\n");
$totalFiltered = mysqli_num_rows($result);
$query.= " ORDER BY ". isset($columns[$requestData['order'][0]['column']])." ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']." ";

$result = mysqli_query($conn,$query) or die ("Erro na query: $query\n");


while ($retorno=mysqli_fetch_array ( $result )){
    $id		    = $retorno['ID_OS'];
    $id_status	= $retorno['ID_STATUS'];
    $nome       = utf8_encode($retorno['NOME_CLI']);
    $servico	= utf8_encode($retorno['DESC_TPOSERV']);
    $tec	    = utf8_encode($retorno['NOME_COLAB']);
    $status	    = utf8_encode($retorno['DESC_STATUS']);
    $valor      = $retorno['VALOR_FINAL'];
    $paga       = $retorno['PAGA'];
    if ($paga=='0'){
        $paga='Em Aberto';
    }else{
        $paga='Paga';
    }

    if ($id_status == '1' || $id_status == '2'){
    $acao = "<div class='hidden-sm hidden-xs action-buttons'>
		<!--<a class='blue' onclick='abre_frame_visualizar($id);'>
			<i class='ace-icon fa fa-search-plus bigger-130'></i>
		</a>-->

		<a class='green' onclick='editar($id);'>
			<i class='ace-icon fa fa-pencil bigger-130'></i>
		</a>

		<a class='red' onclick='deletar($id);'>
			<i class='ace-icon fa fa-trash-o bigger-130'></i>
		</a>
	</div>

	<div class='hidden-md hidden-lg'>
		<div class='inline pos-rel'>
			<button class='btn btn-minier btn-yellow dropdown-toggle' data-toggle='dropdown' data-position='auto'>
				<i class='ace-icon fa fa-caret-down icon-only bigger-120'></i>
			</button>

			<ul class='dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close'>
				<!--<li>
					<a onclick='abre_frame_visualizar($id);' class='tooltip-info' data-rel='tooltip' title='View'>
						<span class='blue'>
							<i class='ace-icon fa fa-search-plus bigger-120'></i>
						</span>
					</a>
				</li>-->

				<li>
					<a onclick='editar($id);' class='tooltip-success' data-rel='tooltip' title='Edit'>
						<span class='green'>
							<i class='ace-icon fa fa-pencil-square-o bigger-120'></i>
						</span>
					</a>
				</li>

				<li>
					<a onclick='deletar($id);' class='tooltip-error' data-rel='tooltip' title='Delete'>
						<span class='red'>
							<i class='ace-icon fa fa-trash-o bigger-120'></i>
						</span>
					</a>
				</li>
			</ul>
		</div>
	</div>";
    }else{
        $acao='';
    }

    $nestedData=array();

    $nestedData[] = $id;
    $nestedData[] = $nome;
    $nestedData[] = $servico;
    $nestedData[] = $tec;
    $nestedData[] = $status;
    $nestedData[] = $valor;
    $nestedData[] = $paga;
    $nestedData[] = $acao;
    $data[] = $nestedData;

}
if ($totalFiltered != 0) {
    $dados = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),  // numero total de dados da consulta
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data //Dados para da consulta Sql
    );
}else{
    $dados = array(
        "draw" => 1,
        "recordsTotal" => "0",  // numero total de dados da consulta
        "recordsFiltered" => "0",
        "data" => [] //Dados para da consulta Sql
    );
}
mysqli_close($conn);

echo json_encode($dados);

?>