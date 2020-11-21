<?php
session_start();
include("php/conexao.php");
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
	<title>Home | Sistema de reservas</title>
	<link href="estilos/index-estilo.css"  rel="stylesheet"/>
	<link href="estilos/padrao_estilo.css" rel="stylesheet" />
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
    <a href="index"><img src="img/logo.png" id="logo" alt="Sistema de Hotel" title="Sistema de reservas"></a>
<ul>

	<a href="cadastro/sobre" title="Sobre"><li><br> Informações </li></a>';
if($administrador["tiririca"]== "admin"){
	echo'<a href="cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de <br>Funcionário</li></a>'; 	
}else{
	echo'<a href="chamado/Reserva" title="Cadastro de reserva"><li>Cadastro de <br>Reserva</li></a>';
}
    echo'<a href="cadastro/quarto" title="Cadastro de Quartos"><li>Cadastro de <br>Quartos</li></a>

</ul>
</div>
    <a href="#" onclick=\'carrega_menu("menu_mobile")\'><img src="img/menu-icone.png" id="icone-menu" alt="Menu"></a>
<ul id="menu_mobile">
	<a href="cadastro/sobre" title="Sobre"><li><br> Informações </li></a>';
if($administrador["tiririca"]== "admin"){
	echo'<a href="cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de Funcionário</li></a>';
}else{
	echo'<a href="chamado/Reserva" title="Cadastro de Reserva"><li>Reserva de Reserva</li></a>';
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
<section id="conteudo">
	<h1>Bem Vindo '.$nome[0].'!</h1>
	<p>Sistema de Controle de Reservas</p>
<ul>
	<a href="clientes"><li>Clientes</li></a>';
	
	if($administrador["tiririca"]== "admin"){
		echo'<a href="funcionarios"><li>Funcionários</li></a>';
	} else {
		echo'<a href="reservas"><li>Reservas</li></a>';
	}
    echo'<a href="quartos"><li>Quartos</li></a>

</ul>
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