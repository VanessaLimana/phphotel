<?php
echo '<meta charset="UTF-8" />';
include("conexao.php");

$id = $_POST['mic'];
$status = 'Ativo';
$con = new conecta();
$ativo = $con->pdo->prepare("UPDATE clientes SET status = :status WHERE id = :id");
$ativo->execute(array(":status" => $status, ":id" => $id));
if($ativo->rowCount()>0){
	echo "<script>alert('Cliente Ativado!');</script>";
}else{
	echo "<script>alert('Ocorreu um erro!');</script>";
}

echo "<meta http-equiv='refresh' content='0, url=../clientes.php'>";
?>