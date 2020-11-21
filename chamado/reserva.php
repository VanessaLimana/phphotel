<?php
session_start();
include("../php/conexao.php");
if(!empty($_SESSION["email"])){
$email = $_SESSION["email"];
$itens_por_pagina =10;
$cone = new conecta();
if(empty($_GET["pagina"]))
    $pagina =0;
else
    $pagina = intval($_GET["pagina"]);
$sql = $cone->pdo->prepare("SELECT * FROM clientes WHERE status = 'Ativo' LIMIT $pagina, $itens_por_pagina");
$sql->execute();
$cliente=$sql->fetch(PDO::FETCH_ASSOC);
$sql_contador = $cone->pdo->prepare("SELECT * FROM clientes WHERE status = 'Ativo'");
$sql_contador->execute();
$linhas =$sql_contador->rowCount();
$num_total = $linhas;

$num_paginas = ceil($num_total / $itens_por_pagina);

$consulta = $cone->pdo->prepare("SELECT * FROM funcionarios WHERE email = :email");
$consulta->bindValue(":email", $email);
$consulta->execute();
$administrador=$consulta->fetch(PDO::FETCH_ASSOC);
echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Cadastro de Reserva | Sistema de reservas</title>
	<link href="../estilos/Reserva-estilo.css" rel="stylesheet"/>
	<link href="../estilos/padrao_estilo.css" rel="stylesheet" />
	<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
	<script src="../javascript/menu.js"></script>
	<script src="../javascript/jquery.min.js"></script>
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
</head>
<body>
<section id="fundo">
<header id="header">
<figure>
<figcaption>
<nav id="navegacao">
    <a href="../index"><img src="../img/logo.png" id="logo" alt="Sistema de reservas" title="Sistema de reservas"></a>
<ul>
	<a href="cadastro/sobre" title="Sobre"><li><br> Informações </li></a>';
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
	<a href="cadastro/sobre" title="Sobre"><li><br> Informações </li></a>';
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
<section class="todo">
<section id="sobre">
	<h2>Selecione o Cliente</h2>
<table>
<tr>
<form action="Reserva.php" method="post">
<td class="titulo_tabela" class="titulo_tabela">Pesquisar Cliente</td>
<td colspan="5"><span class="img_pesquisa"><img src="../img/pesquisa.png"></span><input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o Nome do Cliente" title="Digite o Nome do Cliente"/></td>
</form>
</tr>';
$atlet = $cone->pdo->prepare("SELECT * FROM clientes where status = 'Ativo'");
$atlet->execute();
$sem_cliente = $atlet->fetch(PDO::FETCH_ASSOC);
if(empty($sem_cliente)){
echo '<tr><th>Cliente</th><th>E-mail</th><th>CPF</th><th>Gênero</th><th>Telefone</th><th colspan="2"></th></tr>';
echo '<tr>';
echo '<td class="espaco" colspan="5">Não possui Clientes cadastrados</td>';
echo '</tr></table><a href="clientes_inativos" class="desativado">Clientes Inativos</a>';
}else{
if(!empty($_POST["pesquisa"])){
$busca = $_POST["pesquisa"];
$consulta_cliente = $cone->pdo->prepare("SELECT * FROM clientes WHERE nomecliente LIKE '%$busca%' AND status = 'Ativo' order by nomecliente");
$consulta_cliente->execute();
$vazio = $consulta_cliente->fetch(PDO::FETCH_ASSOC);
if(!empty($vazio)){
$consulta = $cone->pdo->prepare("SELECT * FROM clientes WHERE nomecliente LIKE '%$busca%' AND status = 'Ativo' order by nomecliente");
$consulta->execute();
echo '<tr><th>Cliente</th><th>E-mail</th><th>CPF</th><th>Gênero</th><th>Telefone</th><th colspan="2"></th></tr>';
while($lista = $consulta->fetch(PDO::FETCH_ASSOC)){

$id = $lista["id"];
$name = $lista["nomecliente"];
echo'<form action="php/desativa_cliente.php" method="post"><tr>

<td><a href="abertura.php?id='.$id.'">'.$lista["nomecliente"].'</a></td>
<td>'.$lista["email"].'</td>
<td>'.$lista["cpf"].'</td>
<td>'.$lista["sexo"].'</td>
<td>'.$lista["telefone"].'</td>';
echo '
<td class="esquecido"><input type="text" name="mic" value="'.$lista['id'].'"></td>
</tr></form>';
}
echo '</table><a href="clientes_inativos" class="desativado">Clientes Inativos</a>';
if(empty($_GET["pagina"]))
    $pagina =0;
else
    $pagina = intval($_GET["pagina"]);
$sql1 = $cone->pdo->prepare("SELECT * FROM clientes WHERE nomecliente LIKE '%$busca%' AND status = 'Ativo' limit $pagina, $itens_por_pagina");
$sql1->execute();
$clinte1=$sql1->fetch(PDO::FETCH_ASSOC);
$contador = $cone->pdo->prepare("SELECT * FROM clientes WHERE nomecliente LIKE '%$busca%' AND status = 'Ativo' limit $pagina, $itens_por_pagina");
$contador->execute();
$linhas =$contador->rowCount();
$total = $linhas;

$num_pag = ceil($total / $itens_por_pagina);

echo '<ul class="pagination">
<li>
<a href="reserva.php?pagina=0" aria-label="Previous">
<span aria-hidden="true">&laquo;</span>
</a>
</li>';
for($i=0;$i<$num_pag;$i++){
$estilo = "";
if($pagina == $i)
$estilo = 'class="active"';
echo'<li '.$estilo.'><a href="reserva.php?pagina='.$i.'">'.($i+1).'</a></li>';
}
echo '<li>
<a href="reserva.php?pagina='.($num_pag-1).'" aria-label="Next">
<span aria-hidden="true">&raquo;</span>
</a>
</li>
</ul>';
}elseif(empty($vazio)){
echo '<tr><th>Cliente</th><th>E-mail</th><th>CPF</th><th>Gênero</th><th>Telefone</th></tr>';
echo '<tr>';
echo '<td class="espaco" colspan="5">Cliente não encontrado!</td>';
echo '</tr></table>';
}
}else{
$consulta_cliente = $cone->pdo->prepare("SELECT * FROM clientes where status = 'Ativo' order by nomecliente limit $pagina, $itens_por_pagina");
$consulta_cliente->execute();
echo '<tr><th>Cliente</th><th>E-mail</th><th>CPF</th><th>Gênero</th><th>Telefone</th></tr>';
while($lista = $consulta_cliente->fetch(PDO::FETCH_ASSOC)){

$id = $lista["id"];
$name = $lista["nomecliente"];
echo'<form action="php/desativa_cliente.php" method="post"><tr>

<td><a href="abertura.php?id='.$id.'">'.$lista["nomecliente"].'</a></td>
<td>'.$lista["email"].'</td>
<td>'.$lista["cpf"].'</td>
<td>'.$lista["sexo"].'</td>
<td>'.$lista["telefone"].'</td>';
echo '
<td class="esquecido"><input type="text" name="mic" value="'.$lista['id'].'"></td>
</tr></form>';
}
echo '</table>
<ul class="pagination">
<li>
<a href="reserva.php?pagina=0" aria-label="Previous">
<span aria-hidden="true">&laquo;</span>
</a>
</li>';
for($i=0;$i<$num_paginas;$i++){
$estilo = "";
if($pagina == $i)
$estilo = 'class="active"';
echo'<li '.$estilo.'><a href="reserva.php?pagina='.$i.'">'.($i+1).'</a></li>';
}
echo '<li>
<a href="reserva.php?pagina='.($num_paginas-1).'" aria-label="Next">
<span aria-hidden="true">&raquo;</span>
</a>
</li>
</ul>';
}
}
echo '
</section>
</section>
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