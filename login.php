<?php
session_start();
include("php/conexao.php");
if(empty($_SESSION["email"])){
echo'<!DOCTYPE html>';
echo'<html>';
echo'<head>';
echo'<meta charset="UTF-8" />';
echo'	<title>Área Restrita | Sistema de reservas</title>';
echo'	<link href="estilos/login-estilo.css"  rel="stylesheet"/>';
echo'	<link href="estilos/padrao_estilo.css" rel="stylesheet" />';
echo'	<script src="javascript/menu_login.js"></script>';
echo'	<script src="javascript/jquery.min.js"></script>';
echo'	<link href="https://fonts.googleapis.com/css?family=BioRhyme" rel="stylesheet">';
echo'	<link rel="icon" href="img/icone.png" />';
echo'	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">';
echo'	<meta name="robots" content="noindex, nofollow">';
echo'<script>
$(window).load(function(){
$("body").css("display","block");
});
</script>';
echo '<script>
function valida_telefone(e){
var tecla=(window.event)?event.keyCode:e.which;
if((tecla>47 && tecla<58)) return true;
else{
if (tecla==8 || tecla==0) return true;
else  return false;
}
}
</script>';
echo '</head>
<body onload="carrega()">
<section id="fundo">
<header id="header">
<figure>
<figcaption>
<nav id="navegacao">
    <a href="#"><img src="img/logo.png" id="logo" alt="Sistema de reservas" title="Sistema de reservas"></a>
</nav>

</figcaption>
</figure>
</header>
<content>
<section class="login">
<form action="php/login_usuario.php" method="post">
<ul>
<h1>Acesso Restrito</h1>
<li><span class="icone"><img src="img/icone_usuario.png"></span><input type="email" name="email" class="img_email" id="email" placeholder="E-mail" required></li>
<li><span class="icone"><img src="img/icone_cadeado.png"></span><input type="password" name="senha" class="img_senha" id="senha" placeholder="Senha" required></li>
<li><input class="botao" type="submit" name="logar" value="Logar"/></li>
</ul>
</form>
</section>
</content>
<footer>
<img src="img/logo.png" alt="Sistema de reservas" title="Sistema de reservas">
<p>© Sistema de reservas | Todos os direitos reservados.</p>
</footer>
</section>
</body>
</html>';
}else{
echo '<meta http-equiv="refresh" content="0, url=index">';
}
?>