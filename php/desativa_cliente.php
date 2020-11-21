<?php
echo '<meta charset="UTF-8" />';
include("conexao.php");

$id = $_POST['mic'];
$status = 'Inativo';
$con = new conecta();
$inativa = $con->pdo->prepare("UPDATE clientes SET status = :status WHERE id = :id");
$inativa->execute(array(":status" => $status, ":id" => $id));
if($inativa->rowCount()>0){
	echo "<script>alert('Cliente Desativado!');</script>";
}else{
	echo "<script>alert('Ocorreu um erro!');</script>";
}

echo "<meta http-equiv='refresh' content='0, url=../clientes.php'>";
?>