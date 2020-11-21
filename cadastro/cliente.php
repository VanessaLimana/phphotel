<?php
session_start();
include("../php/conexao.php");
if(!empty($_SESSION["email"])){
$email = $_SESSION["email"];
$cone = new conecta();
$consulta = $cone->pdo->prepare("SELECT * FROM funcionarios WHERE email = :email");
$consulta->bindValue(":email", $email);
$consulta->execute();
$administrador=$consulta->fetch(PDO::FETCH_ASSOC);
echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Cadastro de Cliente | Sistema de reservas</title>
	<link href="../estilos/cliente-estilo.css" rel="stylesheet"/>
	<link href="../estilos/padrao_estilo.css" rel="stylesheet" />
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
	<a href="cliente" title="Cadastro de Cliente"><li>Cadastro de <br>Cliente</li></a>';
if($administrador["tiririca"]== "admin"){
	echo'<a href="funcionario" title="Cadastro de Funcionário"><li>Cadastro de <br>Funcionário</li></a>';
}else{
	echo'<a href="../chamado/Reserva" title="Cadastro de Reserva"><li>Cadastro de <br>Reserva</li></a>';
}
echo'<a href="quarto" title="Cadastro de Quartos"><li>Cadastro de <br>Quartos</li></a>
</ul>
</div>
    <a href="#" onclick=\'carrega_menu("menu_mobile")\'><img src="../img/menu-icone.png" id="icone-menu" alt="Menu"></a>
<ul id="menu_mobile">
	<a href="cliente" title="Cadastro de Cliente"><li>Cadastro de Cliente</li></a>';
if($administrador["tiririca"]== "admin"){
	echo'<a href="funcionario" title="Cadastro de Funcionário"><li>Cadastro de Funcionário</li></a>';
}else{
	echo'<a href="../chamado/Reserva" title="Cadastro de Reserva"><li>Cadastro de Reserva</li></a>';
}
echo '<a href="quarto" title="Cadastro de Quartos"><li>Cadastro de Quartos</li></a>
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
<li><h2>Cadastro Cliente</h2></li>
<form action="../php/cadastro_cliente.php" method="post">
<li><input type="text" name="nome" class="padrao" placeholder="Nome" title="Nome" required></li>
<li><input type="email" name="email" class="padrao" placeholder="E-mail" title="E-mail" required></li>
<li><input type="text" name="cpf" class="padrao" placeholder="CPF" title="CPF" required></li>
<li><input type="text" name="telefone" class="padrao" placeholder="Telefone" title="Telefone" required onkeypress="return valida_telefone(event);"></li>
<li>
<select name="genero" id="genero">
 <option value="">Gênero</option>
 <option value="feminino">Feminino</option>
 <option value="masculino">Masculino</option>
</select>
</li>

<li><input id="botao" type="submit" name="enviar" value="Cadastrar"/></li>
</form>
<li id="voltar"><a href="../index">Voltar</a></li>
<li id="importar"><a href="../index">importar clientes?</a></li>

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