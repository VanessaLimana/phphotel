<?php
include_once 'conexao.php';
$conn = new conecta();
$email = $_POST['email'];
$senha = $_POST['senha'];
if(empty($email)){
  echo "<script>alert('Preencha todos os campos para se logar.'); history.back();</script>";
}elseif(empty($senha)){
  echo "<script>alert('Preencha todos os campos para se logar.'); history.back();</script>";
}else{
$email = preg_replace("/{^{:alnum:}_.-}/","",$email);
$senha = addslashes($senha);

$resultado = $conn->login($email, $senha);
if($resultado){
session_start();
  $_SESSION['email'] = $email;
  $_SESSION['senha'] = $senha;
echo "<meta http-equiv='refresh' content='0, url=../index'>";
}else{
echo "<script>alert('E-mail e/ou senha incorreto!');history.back();</script>";
}
}
?>