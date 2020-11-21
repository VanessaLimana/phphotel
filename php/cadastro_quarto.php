<?php
echo '<meta charset="UTF-8" />';
include("conexao.php");

$nomequarto = $_POST["nomequarto"];
$numeroquarto = $_POST["numeroquarto"];
$precoquarto= $_POST["precoquarto"];
$status = "Ativo";


$erros = 0;
if((empty($nomequarto))&& $erros ==0){
echo "<script>alert('Informe o Nome do quarto.'); history.back();</script>";
$erros++;
if((empty($numeroquarto))&& $erros ==0){
echo "<script>alert('Informe o numero do quarto.'); history.back();</script>";
$erros++;
}if((empty($precoquarto))&& $erros ==0){
echo "<script>alert('Informe o Preço.'); history.back();</script>";
$erros++;
}

if($erros == 0){
$con = new conecta();
$cadastro = $con->pdo->prepare("insert into tipoquartos 
	(nomequarto, precoquarto, status) values 
	('$nomequarto', '$precoquarto', '$status')");
$cadastro->execute();

echo "<script>alert('Cadastrado efetuado com sucesso!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";

}else{
echo "<script>alert('Erro! Contate o administrador!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";
}

?>