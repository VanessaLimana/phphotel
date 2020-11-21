<?php
echo '<meta charset="UTF-8" />';
include("conexao.php");

$nome = $_POST["nome"];
$cpf = $_POST["cpf"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];
$status = "Ativo";
if(isset($_POST["genero"])){
$gener = $_POST["genero"];
switch ($gener) {
case 'masculino':
	$genero = 'Masculino';
	break;
case 'feminino':
	$genero = 'Feminino';
	break;
default:
	echo '';
	break;
}
}

$erros = 0;
if((empty($nome))&& $erros ==0){
echo "<script>alert('Informe o Nome do Cliente.'); history.back();</script>";
$erros++;
}if((empty($genero))&& $erros ==0){
echo "<script>alert('Selecione o Gênero.'); history.back();</script>";
$erros++;
}if((empty($cpf))&& $erros ==0){
echo "<script>alert('Informe o CPF.'); history.back();</script>";
$erros++;
}if((empty($telefone))&& $erros ==0){
echo "<script>alert('Selecione o Telefone.'); history.back();</script>";
$erros++;
}if((empty($email))&& $erros ==0){
echo "<script>alert('Informe o E-mail.'); history.back();</script>";
$erros++;
}


if($erros == 0){
$con = new conecta();
$cadastro = $con->pdo->prepare("insert into clientes 
	(nomecliente, email, cpf, sexo, telefone, status) values 
	('$nome', '$email', '$cpf', '$genero', '$telefone', '$status')");
$cadastro->execute();

echo "<script>alert('Cadastrado efetuado com sucesso!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";

}else{
echo "<script>alert('Erro! Contate o administrador!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";
}

?>