<?php
echo '<meta charset="UTF-8" />';
include("conexao.php");

$id = $_POST['mic'];
$con = new conecta();
$data = date('H:i:s');
$fecha = $con->pdo->prepare("UPDATE reservas SET horariofinal = :data WHERE id = :id");
$fecha->execute(array(":data" => $data, ":id" => $id));
if($fecha->rowCount()>0){
	echo "<script>alert('Chamado Fechado!');</script>";
}else{
	echo "<script>alert('Ocorreu um erro!');</script>";
}

echo "<meta http-equiv='refresh' content='0, url=../reservas.php'>";
?>