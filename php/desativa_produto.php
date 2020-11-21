<?php
echo '<meta charset="UTF-8" />';
include("conexao.php");

$id = $_POST['mic'];
$status = 'Inativo';
$con = new conecta();
$inativa = $con->pdo->prepare("UPDATE tipoprodutos SET status = :status WHERE id = :id");
$inativa->execute(array(":status" => $status, ":id" => $id));
if($inativa->rowCount()>0){
	echo "<script>alert('Produto Desativado!');</script>";
}else{
	echo "<script>alert('Ocorreu um erro!');</script>";
}

echo "<meta http-equiv='refresh' content='0, url=../produtos.php'>";
?>