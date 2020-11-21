<?php
session_start();
include("php/conexao.php");
if(!empty($_SESSION["email"])){
$email = $_SESSION['email'];
$itens_por_pagina =10;
$cone = new conecta();
if(empty($_GET["pagina"]))
    $pagina =0;
else
    $pagina = intval($_GET["pagina"]);
$sql = $cone->pdo->prepare("SELECT * FROM funcionarios LIMIT $pagina, $itens_por_pagina");
$sql->execute();
$funcionario=$sql->fetch(PDO::FETCH_ASSOC);
$sql_contador = $cone->pdo->prepare("SELECT * FROM funcionarios");
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
	<title>Funcionários | Sistema de reservas</title>
	<link href="estilos/funcionarios-estilo.css" rel="stylesheet"/>
	<link href="estilos/padrao_estilo.css" rel="stylesheet" />
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<script src="javascript/menu.js"></script>
	<script src="javascript/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=BioRhyme" rel="stylesheet">
	<link rel="icon" href="img/icone.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="robots" content="noindex, nofollow">
<script>
$(window).load(function(){
$("body").css("display","block");
});
</script>
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
</head>
<body onload="carrega()">
<section id="fundo">
<header id="header">
<figure>
<figcaption>
<nav id="navegacao">
    <a href="index"><img src="img/logo.png" id="logo" alt="Sistema de reservas" title="Sistema de reservas"></a>
<ul>
	<a href="cadastro/pagseguro" title="Pagamento"><li> <br>Pagamento</li></a>';
if($administrador["tiririca"]== "admin"){
	echo'<a href="cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de <br>Funcionário</li></a>';
}else{
	echo'<a href="chamado/Reserva" title="Cadastro de Reserva"><li>Cadastro de <br>Reserva</li></a>';
}
echo'<a href="cadastro/quarto" title="Cadastro de Quartos"><li>Cadastro de <br>Quartos</li></a>
</ul>
</div>
    <a href="#" onclick=\'carrega_menu("menu_mobile")\'><img src="img/menu-icone.png" id="icone-menu" alt="Menu"></a>
<ul id="menu_mobile">
	<a href="cadastro/pagseguro" title="Pagamento"><li> <br>Pagamento</li></a>';
	
if($administrador["tiririca"]== "admin"){
	echo'<a href="cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de Funcionário</li></a>';
}else{
	echo'<a href="chamado/Reserva" title="Cadastro de Reserva"><li>Cadastro de Reserva</li></a>';
}
echo '<a href="cadastro/quarto" title="Cadastro de Quartos"><li>Cadastro de Quartos</li></a>
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
<img src="img/imagem_fundo.jpg" class="imagem_fundo" title="Sistema de reservas" alt="Sistema de reservas">
<img src="img/imagem_fundo-2.jpg" class="imagem_fundo2">
<img src="img/imagem_fundo-3.jpg" class="imagem_fundo3">
</section>
<section class="todo">
<section id="sobre">
	<h2>Funcionários</h2>
<table>
<tr>
<form action="funcionarios.php" method="post">
<td class="titulo_tabela" class="titulo_tabela">Pesquisar Funcionário</td>
<td colspan="6"><span class="img_pesquisa"><img src="img/pesquisa.png"></span><input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o Nome do Funcionário" title="Digite o Nome do Funcionário"/></td>
</form>
</tr>';
$atlet = $cone->pdo->prepare("SELECT * FROM funcionarios");
$atlet->execute();
$sem_funcionario = $atlet->fetch(PDO::FETCH_ASSOC);
if(empty($sem_funcionario)){
echo '<tr><th>Funcionário</th><th>E-mail</th><th>Endereço</th><th>Gênero</th><th>Cargo</th><th>Telefone</th></tr>';
echo '<tr>';
echo '<td class="espaco" colspan="6">Não possui Funcionários cadastrados</td>';
echo '</tr></table>';
}else{
if(!empty($_POST["pesquisa"])){
$busca = $_POST["pesquisa"];
$consulta_funcionario = $cone->pdo->prepare("SELECT * FROM funcionarios WHERE nome LIKE '%$busca%' order by nome");
$consulta_funcionario->execute();
$vazio = $consulta_funcionario->fetch(PDO::FETCH_ASSOC);
if(!empty($vazio)){
$consulta = $cone->pdo->prepare("SELECT * FROM funcionarios WHERE nome LIKE '%$busca%' order by nome");
$consulta->execute();
echo '<tr><th>Funcionário</th><th>E-mail</th><th>Endereço</th><th>Gênero</th><th>Cargo</th><th>Telefone</th></tr>';
while($lista = $consulta->fetch(PDO::FETCH_ASSOC)){

$id = $lista["id"];
$name = $lista["nome"];
echo'<tr>

<td>'.$lista["nome"].'</td>
<td>'.$lista["email"].'</td>
<td>'.$lista["endereco"].'</td>
<td>'.$lista["sexo"].'</td>
<td>'.$lista["cargo"].'</td>
<td>'.$lista["telefone"].'</td>';
echo '
<td class="esquecido"><input type="text" name="mic" value="'.$lista['id'].'"></td>
</tr>';
}
echo '</table>';
if(empty($_GET["pagina"]))
    $pagina =0;
else
    $pagina = intval($_GET["pagina"]);
$sql1 = $cone->pdo->prepare("SELECT * FROM funcionarios WHERE nome LIKE '%$busca%' limit $pagina, $itens_por_pagina");
$sql1->execute();
$funcionario1=$sql1->fetch(PDO::FETCH_ASSOC);
$contador = $cone->pdo->prepare("SELECT * FROM funcionarios WHERE nome LIKE '%$busca%' limit $pagina, $itens_por_pagina");
$contador->execute();
$linhas =$contador->rowCount();
$total = $linhas;

$num_pag = ceil($total / $itens_por_pagina);

echo '<ul class="pagination">
<li>
<a href="funcionarios.php?pagina=0" aria-label="Previous">
<span aria-hidden="true">&laquo;</span>
</a>
</li>';
for($i=0;$i<$num_pag;$i++){
$estilo = "";
if($pagina == $i)
$estilo = 'class="active"';
echo'<li '.$estilo.'><a href="funcionarios.php?pagina='.$i.'">'.($i+1).'</a></li>';
}
echo '<li>
<a href="funcionarios.php?pagina='.($num_pag-1).'" aria-label="Next">
<span aria-hidden="true">&raquo;</span>
</a>
</li>
</ul>';
}elseif(empty($vazio)){
echo '<tr><th>Funcionário</th><th>E-mail</th><th>Endereço</th><th>Gênero</th><th>Cargo</th><th>Telefone</th></tr>';
echo '<tr>';
echo '<td class="espaco" colspan="6">Funcionário não encontrado!</td>';
echo '</tr></table>';
}
}else{
$consulta_funcionario = $cone->pdo->prepare("SELECT * FROM funcionarios order by nome limit $pagina, $itens_por_pagina");
$consulta_funcionario->execute();
echo '<tr><th>Funcionário</th><th>E-mail</th><th>Endereço</th><th>Gênero</th><th>Cargo</th><th>Telefone</th></tr>';
while($lista = $consulta_funcionario->fetch(PDO::FETCH_ASSOC)){

$id = $lista["id"];
$name = $lista["nome"];
echo'<tr>

<td>'.$lista["nome"].'</td>
<td>'.$lista["email"].'</td>
<td>'.$lista["endereco"].'</td>
<td>'.$lista["sexo"].'</td>
<td>'.$lista["cargo"].'</td>
<td>'.$lista["telefone"].'</td>';
echo '
<td class="esquecido"><input type="text" name="mic" value="'.$lista['id'].'"></td>
</tr></form>';
}
echo '</table>
<ul class="pagination">
<li>
<a href="funcionarios.php?pagina=0" aria-label="Previous">
<span aria-hidden="true">&laquo;</span>
</a>
</li>';
for($i=0;$i<$num_paginas;$i++){
$estilo = "";
if($pagina == $i)
$estilo = 'class="active"';
echo'<li '.$estilo.'><a href="funcionarios.php?pagina='.$i.'">'.($i+1).'</a></li>';
}
echo '<li>
<a href="funcionarios.php?pagina='.($num_paginas-1).'" aria-label="Next">
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
<img src="img/logo.png" alt="Sistema de reservas" title="Sistema de reservas">
<p>© Sistema de reservas | Todos os direitos reservados.</p>
</footer>
</section>
</body>
</html>';
}else{
echo '<meta http-equiv="refresh" content="0, url=login.php">';
}
?>