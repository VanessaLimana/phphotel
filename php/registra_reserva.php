<?php
echo '<meta charset="UTF-8" />';
include("conexao.php");
function formatarData($data){
$rData = implode("-", array_reverse(explode("/", trim($data))));
return $rData;
}

$id_quarto = $_POST["quarto"];
$id_cliente = $_POST["id_cliente"];
$id_funcionario = $_POST["id_funcionario"];
$horarioinicial = $_POST["horarioinicial"];
$horariofinal = $_POST["horariofinal"];
$dia = ($_POST["dia"]);
$diasaida = ($_POST["diasaida"]);
$obs = $_POST["obs"];
$numreserva = $_POST["numreserva"];
$periodo = $_POST["periodo"];
$erros = 0;


$periodo_arr = explode(' - ', $periodo);
$dia_arr = explode('/', $periodo_arr[0]);
$diasaida_arr = explode('/', $periodo_arr[1]);

$dia = implode('-', array_reverse($dia_arr));
$diasaida = implode('-', array_reverse($diasaida_arr));

if((empty($id_quarto))&& $erros ==0){
echo "<script>alert('Informe o Quartos.'); history.back();</script>";
$erros++;
}if((empty($horarioinicial))&& $erros ==0){
echo "<script>alert('Informe a Hora.'); history.back();</script>";
$erros++;
}if((empty($dia))&& $erros ==0){
echo "<script>alert('Informe a Data.'); history.back();</script>";
$erros++;
}if((empty($obs))&& $erros ==0){
$obs = "Sem observações.";
}

if($erros == 0){
$con = new conecta();
$cadastro = $con->pdo->prepare("insert into reservas (clientechave, tipoquartochave, dia, obs, diasaida, funcionariochave,horarioinicial, horariofinal,numreserva) values ('$id_cliente', '$id_quarto', '$dia', '$obs', '$diasaida', '$id_funcionario','$horarioinicial','$horariofinal','$numreserva')");
$cadastro->execute();

echo "<script>alert('Reserva efetuada com sucesso!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";

}else{
echo "<script>alert('Erro! Contate o administrador!');</script>";
echo "<meta http-equiv='refresh' content='0, url=../index'>";
}

?>