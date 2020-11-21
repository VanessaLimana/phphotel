<?php
session_start();
include("../php/conexao.php");
if(!empty($_SESSION["email"])){
$email = $_SESSION["email"];
$cone = new conecta();
if(empty($_GET["id"])){
echo '<meta http-equiv="refresh" content="0, url=login.php">';
}
$id = $_GET["id"];

$consulta = $cone->pdo->prepare("SELECT * FROM funcionarios WHERE email = :email");
$consulta->bindValue(":email", $email);
$consulta->execute();
$administrador=$consulta->fetch(PDO::FETCH_ASSOC);
echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Cadastro de Reserva | Sistema de reservas</title>
	<link href="../estilos/abertura-estilo.css" rel="stylesheet"/>
	<link href="../estilos/padrao_estilo.css" rel="stylesheet" />
	<script src="../javascript/menu.js"></script>
	<script src="../javascript/jquery.min.js"></script>
	
	<script type="text/javascript" src="../javascript/moment.min.js"></script>
    <script type="text/javascript" src="../javascript/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="../estilos/daterangepicker.css" />
	
	<link href="https://fonts.googleapis.com/css?family=BioRhyme" rel="stylesheet">
	<link rel="icon" href="../img/icone.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="robots" content="noindex, nofollow">
<script>
$(function(){
var nav = $("#navegacao");
$(window).scroll(function () {
if ($(this).scrollTop() > 0) {
nav.addClass("menu-fixo");
} else {
nav.removeClass("menu-fixo");
}
});
});
</script>
<script>
function valida_telefone(e){
var tecla=(window.event)?event.keyCode:e.which;
if((tecla>47 && tecla<58) || (tecla > 39 && tecla <42) || tecla ==45) return true;
else{
if (tecla==8 || tecla==0) return true;
else  return false;
}
}
</script>

<script type="text/javascript">
$(function() {
  $("#periodo").daterangepicker({
  autoUpdateInput: false,
  startDate: moment().startOf(\'hour\').add(1,\'day\'),
  endDate: moment().startOf(\'hour\').add(2,\'day\'),
    locale: {
          format: \'DD/MM/YYYY\',
          applyLabel: "Aplicar",
        cancelLabel: "Cancelar",
        fromLabel: "De",
        toLabel: "até",
        daysOfWeek: [
            "Dom",
            "Seg",
            "Ter",
            "Qua",
            "Qui",
            "Sex",
            "Sab"
        ],
        monthNames: [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ],
    }
  }, function(start, end, label) {
    $("#dia").val(start.format("YYYY-MM-DD"));
    $("#diasaida").val(end.format("YYYY-MM-DD"));
  });
  
  $(\'input[name="periodo"]\').on(\'apply.daterangepicker\', function(ev, picker) {
      $(this).val(picker.startDate.format(\'DD/MM/YYYY\') + \' - \' + picker.endDate.format(\'DD/MM/YYYY\'));
  });

  $(\'input[name="periodo"]\').on(\'cancel.daterangepicker\', function(ev, picker) {
      $(this).val(\'\');
  });
  
});
</script>

</head>
<body>
<section id="fundo">
<header id="header">
<figure>
<figcaption>
<nav id="navegacao">
    <a href="../index"><img src="../img/logo.png" id="logo" alt="Sistema de reservas" title="Sistema de reservas"></a>
<ul>
	<a href="cadastro/pagseguro" title="Pagamento"><li> <br>Pagamento</li></a>';
if($administrador["tiririca"]== "admin"){
	echo'<a href="../cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de <br>Funcionário</li></a>';
}else{
	echo'<a href="Reserva" title="Cadastro de Reserva"><li>Cadastro de <br>Reserva</li></a>';
}
echo'<a href="../cadastro/quarto" title="Cadastro de Quartos"><li>Cadastro de <br>Quartos</li></a>
</ul>
</div>
    <a href="#" onclick=\'carrega_menu("menu_mobile")\'><img src="../img/menu-icone.png" id="icone-menu" alt="Menu"></a>
<ul id="menu_mobile">
	<a href="cadastro/pagseguro" title="Pagamento"><li> <br>Pagamento</li></a>';
if($administrador["tiririca"]== "admin"){
	echo'<a href="../cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de Funcionário</li></a>';
}else{
	echo'<a href="Reserva" title="Cadastro de Reserva"><li>Cadastro de Reserva</li></a>';
}
echo '<a href="../cadastro/quarto" title="Cadastro de Quartos"><li>Cadastro de Quartos</li></a>
</ul>';
if(empty(!$_SESSION["email"])){
$nome = explode(" ",$administrador["nome"]);
print('<p class="login">Bem Vindo '.$nome[0].'</p><br>');
print('<a href="logout" class="sair">Sair</a>');
}
echo'
</nav>
</figcaption>
</figure>
</header>
<section id="slide">
<img src="../img/imagem_fundo.jpg" class="imagem_fundo">
<img src="../img/imagem_fundo-2.jpg" class="imagem_fundo2">
<img src="../img/imagem_fundo-3.jpg" class="imagem_fundo3">
</section>
<section class="formulario">
<ul>
<li><h2>Cadastro de Reserva</h2></li>
<form action="../php/registra_Reserva.php" method="post">';
$cliente = $cone->pdo->prepare("SELECT * FROM clientes WHERE id = :id");
$cliente->bindValue(":id", $id);
$cliente->execute();
$dados=$cliente->fetch(PDO::FETCH_ASSOC);

echo '<li><input type="text" name="nome" class="padrao" title="Nome" value="'.$dados["nomecliente"].'" disabled></li>
<li>
<select name="quarto" class="quarto">';
$quarto = $cone->pdo->prepare("SELECT * FROM tipoquartos WHERE tipoquartos.status = 'Ativo' order by nomequarto");
$quarto->execute();
echo'<option value="">Selecione o quarto</option>';
while($lista_quarto = $quarto->fetch(PDO::FETCH_ASSOC)){
echo'<option value="'.$lista_quarto['id'].'">'.$lista_quarto['nomequarto'].'</option>';
}
echo'</select>
</li>
<li><input type="text" name="id_cliente" class="escondido" value="'.$dados["id"].'"></li>
<li><input type="text" name="id_quarto" class="escondido" value="'.$dados["id"].'"></li>

<li><input type="text" name="periodo" placeholder="Informe o período" value="" id="periodo" class="padrao" title="Período" required></li>
<input type="hidden" name="dia" value="" class="padrao" title="dia" id="dia">
<li><input type="text" name="horarioinicial" class="padrao" title="Horário inicial" placeholder="Horário previsto de chegada" required></li>

<input type="hidden" name="diasaida" value="" id="diasaida" class="padrao" title="diasaida">

<li><input type="text" name="id_funcionario" class="escondido" value="'.$administrador["id"].'"></li>
<li><input type="text" name="horariofinal" class="padrao" title="Horário final" placeholder="Horário previsto de saída" required></li>
<li><input type="text" name="numreserva" class="padrao" title="Número da reserva" placeholder="Número da reserva" required></li>
<li><textarea name="obs" id="obs" placeholder="Observação" title="Observação"></textarea></li>
<li><input id="botao" type="submit" name="enviar" value="Registrar"/></li>
</form>
<li id="voltar"><a href="../index">Voltar</a></li>
</ul>
</section>
</content>
<footer>
<img src="../img/logo.png" alt="Sistema de reservas" title="Sistema de reservas">
<p>© Sistema de reservas | Todos os direitos reservados.</p>
</footer>
</section>
</body>
</html>';
}else{
echo '<meta http-equiv="refresh" content="0, url=../login.php">';
}
?>