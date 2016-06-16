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
    0 => 'CODIGO',
    1 => 'GRUPO',
    2 => 'PRODUTO',
    3 => 'QUANTIDADE',
    4 => 'VALOR',
    5 =>  ' ',
);

if(!$ret){
    die('Erro na seleção do database');
}

$idg= $_REQUEST['idg'];
//$idg= '7fffffff';

$query = " SELECT ID_PROD_US, gp.DESC_GRUP, prod.NOME_PROD, QUANTIDADE_PROD_US,            ".
         "  prod.VALOR_VENDA_PROD*QUANTIDADE_PROD_US VALOR FROM tb_produtos_usados prod_us ".
         " LEFT JOIN tb_grupo_produto gp on                                                ".
         " prod_us.ID_GRUP = gp.ID_GRUP                                                    ".
         " LEFT JOIN tb_produtos prod on                                                   ".
         " prod_us.ID_PROD = prod.ID_PROD                                                  ".
         " WHERE ID_JS='$idg' AND (prod_us.DELETADO = 0 OR prod_us.DELETADO IS NULL)       ";
$result = mysqli_query($conn,$query);
$totalData = mysqli_num_rows($result);
$totalFiltered = $totalData;

$query =    " SELECT ID_PROD_US, gp.DESC_GRUP, prod.NOME_PROD, QUANTIDADE_PROD_US,            ".
            "  prod.VALOR_VENDA_PROD*QUANTIDADE_PROD_US VALOR FROM tb_produtos_usados prod_us ".
            " LEFT JOIN tb_grupo_produto gp on                                                ".
            " prod_us.ID_GRUP = gp.ID_GRUP                                                    ".
            " LEFT JOIN tb_produtos prod on                                                   ".
            " prod_us.ID_PROD = prod.ID_PROD                                                  ".
            " WHERE ID_JS='$idg' AND (prod_us.DELETADO = 0 OR prod_us.DELETADO IS NULL)       ";

if( !empty($requestData['search']['value']) ) {
    $query.=" AND (ID_PROD_US LIKE '%".$requestData['search']['value']."%' ";
    $query.=" OR gp.DESC_GRUP LIKE '%".$requestData['search']['value']."%'";
    $query.=" OR prod.NOME_PROD LIKE '%".$requestData['search']['value']."%'";
    $query.=" OR QUANTIDADE_PROD_US LIKE '%".$requestData['search']['value']."%' )";
}

$result = mysqli_query($conn,$query) or die ("Erro na query: $query\n");
$totalFiltered = mysqli_num_rows($result);
$query.= " ORDER BY ". isset($columns[$requestData['order'][0]['column']])." ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']." ";

$result = mysqli_query($conn,$query) or die ("Erro na query: $query\n");


while ($retorno=mysqli_fetch_array ( $result )){
    $id		 = $retorno['ID_PROD_US'];
    $grupo   = utf8_encode($retorno['DESC_GRUP']);
    $produto = utf8_encode($retorno['NOME_PROD']);
    $quantidade  = $retorno['QUANTIDADE_PROD_US'];
    $valor = $retorno['VALOR'];
    $branco = ' ';

    $acao = "<div class='hidden-sm hidden-xs action-buttons'>
		<a class='red' onclick='apagar($id);'>
			<i class='ace-icon fa fa-trash-o bigger-130'></i>
		</a>
	</div>

	<div class='hidden-md hidden-lg'>
		<div class='inline pos-rel'>
			<button class='btn btn-minier btn-yellow dropdown-toggle' data-toggle='dropdown' data-position='auto'>
				<i class='ace-icon fa fa-caret-down icon-only bigger-120'></i>
			</button>

			<ul class='dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close'>
				<li>
					<a onclick='apagar($id);' class='tooltip-error' data-rel='tooltip' title='Delete'>
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
    $nestedData[] = $grupo;
    $nestedData[] = $produto;
    $nestedData[] = $quantidade;
    $nestedData[] = $valor;
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