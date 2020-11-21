<?php
header("access-control-allow-origin: https://pagseguro.uol.com.br");
header("Content-Type: text/html; charset=UTF-8",true);
date_default_timezone_set('America/Sao_Paulo');


function mask($val, $mask)
{
    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++)
    {
        if($mask[$i] == '#')
        {
            if(isset($val[$k]))
                $maskared .= $val[$k++];
        }
        else
        {
            if(isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

require_once("PagSeguro.class.php");
$PagSeguro = new PagSeguro();

$valorProduto = floatval($_POST["valorProduto"]);
$valorProduto = number_format($valorProduto,2);
$nomeProduto = $_POST["nomeProduto"];
$nomeCliente = $_POST["nomeCliente"];
$emailCliente = $_POST["emailCliente"];
$telefoneCliente = $_POST["telefoneCliente"];
$enderecoCliente = $_POST["enderecoCliente"];
$numeroEnderecoCliente = $_POST["numeroEnderecoCliente"];
$bairroCliente = $_POST["bairroCliente"];
$cidadeCliente = $_POST["cidadeCliente"];
$estadoCliente = $_POST["estadoCliente"];
$cepCliente = $_POST["cepCliente"];
$idReserva = $_POST["idReserva"];

$connect = mysqli_connect("localhost", "root", "", "hotel");

mysqli_query($connect, "UPDATE reservas SET status = 'F', diasaida = '".date('Y-m-d')."', horariofinal = '".date('H:i')."' WHERE id = '$idReserva'");

mysqli_query($connect);

//EFETUAR PAGAMENTO	
$venda = array("codigo"=>"1",
			   "valor"=>$valorProduto,
			   "descricao"=>$nomeProduto, //nome do produto
			   "nome"=>$nomeCliente, //nome do cliente
			   "email"=>$emailCliente, //email do cliente
			   "telefone"=>$telefoneCliente, //telefone do cliente formato (XX) XXXX-XXXX
			   "rua"=>$enderecoCliente, //endereco do cliente, sem numero
			   "numero"=>$numeroEnderecoCliente, //
			   "bairro"=>$bairroCliente,
			   "cidade"=>$cidadeCliente,
			   "estado"=>$estadoCliente, //2 LETRAS MAIÚSCULAS
			   "cep"=>$cepCliente, //formatado XX.XXX-XXX
			   "codigo_pagseguro"=>"");
			   
$PagSeguro->executeCheckout($venda,"http://localhost/pedido/".$_GET['codigo']);

//----------------------------------------------------------------------------


//RECEBER RETORNO
if( isset($_GET['transaction_id']) ){
	$pagamento = $PagSeguro->getStatusByReference($_GET['codigo']);
	
	$pagamento->codigo_pagseguro = $_GET['transaction_id'];
	if($pagamento->status==3 || $pagamento->status==4){
	    var_dump($pagamento->status);
		//ATUALIZAR DADOS DA VENDA, COMO DATA DO PAGAMENTO E STATUS DO PAGAMENTO
		
	}else{
	    echo "<br>else";
	    var_dump($pagamento);
		//ATUALIZAR NA BASE DE DADOS
	}
}

?>