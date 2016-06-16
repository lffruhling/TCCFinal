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
    1 => 'NOME',
    2 => 'GRUPO',
    3 => 'ATIVO',
    4 => 'ACAO',
);

if(!$ret){
    die('Erro na seleção do database');
}

$query =" SELECT                                                        ".
        "     prod.ID_PROD, gp.DESC_GRUP, prod.NOME_PROD, prod.ATIVO    ".
        " FROM                                                          ".
        "     tb_produtos prod                                          ".
        " LEFT JOIN                                                     ".
        "     tb_grupo_produto gp ON gp.ID_GRUP = prod.ID_GRUP          ".
        " WHERE                                                         ".
        "     (prod.DELETADO = 0                                        ".
        "         OR prod.DELETADO IS NULL)                             ";

$result = mysqli_query($conn,$query);
$totalData = mysqli_num_rows($result);
$totalFiltered = $totalData;

$query =    " SELECT                                                        ".
            "     prod.ID_PROD, gp.DESC_GRUP, prod.NOME_PROD, prod.ATIVO    ".
            " FROM                                                          ".
            "     tb_produtos prod                                          ".
            " LEFT JOIN                                                     ".
            "     tb_grupo_produto gp ON gp.ID_GRUP = prod.ID_GRUP          ".
            " WHERE                                                         ".
            "     (prod.DELETADO = 0                                        ".
            "         OR prod.DELETADO IS NULL)                             ";

if( !empty($requestData['search']['value']) ) {

    $query.=" AND (prod.ID_PROD LIKE '%".$requestData['search']['value']."%' ";
    $query.=" OR gp.DESC_GRUP LIKE '%".$requestData['search']['value']."%' ";
    $query.=" OR prod.NOME_PROD LIKE '%".$requestData['search']['value']."%' )";
}

$result = mysqli_query($conn,$query) or die ("Erro na query: $query\n");
$totalFiltered = mysqli_num_rows($result);
$query.= " ORDER BY ". isset($columns[$requestData['order'][0]['column']])." ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']." ";

$result = mysqli_query($conn,$query) or die ("Erro na query: $query\n");


while ($retorno=mysqli_fetch_array ( $result )){
    $id		= $retorno['ID_PROD'];
    $grupo   = utf8_encode($retorno['DESC_GRUP']);
    $nome   = utf8_encode($retorno['NOME_PROD']);
    $ativo  = $retorno['ATIVO'];
    if ($ativo=='0'){
        $ativo='Inativo';
    }else{
        $ativo='Ativo';
    }

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

    $nestedData=array();

    $nestedData[] = $id;
    $nestedData[] = $nome;
    $nestedData[] = $grupo;
    $nestedData[] = $ativo;
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


