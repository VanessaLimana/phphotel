<?php
echo '<meta charset="UTF-8" />';
include("conexao.php");

$nome = $_POST["nome"];
$endereco = $_POST["endereco"];
$cpf = $_POST["cpf"];
$telefone = $_POST["telefone"];
$cargo = $_POST["cargo"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$r_senha = $_POST["r_senha"];

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
echo "<script>alert('Informe o Nome do Funcionário.'); history.back();</script>";
$erros++;
}if((empty($endereco))&& $erros ==0){
echo "<script>alert('Informe o Endereço.'); history.back();</script>";
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
}if((empty($cargo))&& $erros ==0){
echo "<script>alert('Informe o Cargo.'); history.back();</script>";
$erros++;
}if((empty($email))&& $erros ==0){
echo "<script>alert('Informe o E-mail.'); history.back();</script>";
$erros++;
}if((empty($senha))&& $erros ==0){
echo "<script>alert('Informe a Senha.'); history.back();</script>";
$erros++;
}elseif($senha != $r_senha){
echo "<script>alert('As senhas precisam ser iguais!'); history.back();</script>";
$erros++;
}


if($erros == 0){
$con = new conecta();
$cadastro_funcionario = $con->pdo->prepare("insert into funcionarios 
	(nome, endereco, cpf, telefone, sexo, cargo, email, senha) values 
	('$nome', '$endereco', '$cpf', '$telefone', '$genero', '$cargo', '$email'('$senha'))");
$cadastro_funcionario->execute();

echo "<script>alert('Cadastrado efetuado com sucesso!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";

}else{
echo "<script>alert('Erro! Contate o administrador!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";
}

?>