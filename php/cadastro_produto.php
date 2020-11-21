<?php
echo '<meta charset="UTF-8" />';
include("conexao.php");

$nomeproduto = $_POST["nomeproduto"];
$precoproduto= $_POST["precoproduto"];
$status = "Ativo";


$erros = 0;
if((empty($nomeproduto))&& $erros ==0){
echo "<script>alert('Informe o Nome do produto.'); history.back();</script>";
$erros++;
}if((empty($precoproduto))&& $erros ==0){
echo "<script>alert('Informe o Preço.'); history.back();</script>";
$erros++;
}

if($erros == 0){
$con = new conecta();
$cadastro = $con->pdo->prepare("insert into tipoprodutos 
	(nomeproduto, precoproduto, status) values 
	('$nomeproduto', '$precoproduto', '$status')");
$cadastro->execute();

echo "<script>alert('Cadastrado efetuado com sucesso!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";

}else{
echo "<script>alert('Erro! Contate o administrador!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";
}

?>