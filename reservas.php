<?php
session_start();
include("php/conexao.php");
if(!empty($_SESSION["email"])){
$email = $_SESSION['email'];
$itens_por_pagina =10;
$cone = new conecta();
$consulta = $cone->pdo->prepare("SELECT * FROM funcionarios WHERE email = :email");
$consulta->bindValue(":email", $email);
$consulta->execute();
$administrador=$consulta->fetch(PDO::FETCH_ASSOC);
if(empty($_GET["pagina"]))
    $pagina =0;
else
    $pagina = intval($_GET["pagina"]);
//$sql = $cone->pdo->prepare("SELECT * FROM reservas where funcionariochave = :id and horariofinal = '' LIMIT $pagina, $itens_por_pagina");
$sql = $cone->pdo->prepare("SELECT * FROM reservas where funcionariochave = :id LIMIT $pagina, $itens_por_pagina");
$sql->bindValue(":id", $administrador['id']);
$sql->execute();
$atendimento=$sql->fetch(PDO::FETCH_ASSOC);



$sql_contador = $cone->pdo->prepare("SELECT * FROM reservas where funcionariochave = :id and horariofinal = ''");
$sql_contador->bindValue(":id", $administrador['id']);
$sql_contador->execute();
$linhas =$sql_contador->rowCount();
$num_total = $linhas;

$num_paginas = ceil($num_total / $itens_por_pagina);

echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>reservas | Sistema de reservas</title>
	<link href="estilos/clientes-estilo.css"  rel="stylesheet"/>
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
	<a href="cadastro/sobre" title="Sobre"><li><br> Informações </li></a>';
if($administrador["tiririca"]== "admin"){
	echo'<a href="cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de <br>Funcionário</li></a>';
}else{
	echo'<a href="chamado/reserva" title="Cadastro de Reserva"><li>Cadastro de <br>Reserva</li></a>';
}
echo'<a href="cadastro/quarto" title="Cadastro de Quarto"><li>Cadastro de <br>Quarto</li></a>
</ul>
</div>
    <a href="#" onclick=\'carrega_menu("menu_mobile")\'><img src="img/menu-icone.png" id="icone-menu" alt="Menu"></a>
<ul id="menu_mobile">
	<a href="cadastro/sobre" title="Sobre"><li><br> Informações </li></a>';
if($administrador["tiririca"]== "admin"){
	echo'<a href="cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de Funcionário</li></a>';
}else{
	echo'<a href="chamado/atendimento" title="Abertura de Chamado"><li>Abertura de Chamado</li></a>';
}
echo '<a href="cadastro/quarto" title="Cadastro de Quarto"><li>Cadastro de <br>Quarto</li></a>
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
	<h2>reservas</h2>
<table>
<tr>
<!--form action="reservas.php" method="post">
<td class="titulo_tabela" class="titulo_tabela">Pesquisar Reserva</td>
<td colspan="6"><span class="img_pesquisa"><img src="img/pesquisa.png"></span><input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o Número do Chamado" title="Digite o Número do Chamado"/></td>
</form-->
</tr>';
//$consult = $cone->pdo->prepare("SELECT * FROM reservas where funcionariochave = :id and horariofinal = ''");
$consult = $cone->pdo->prepare("SELECT * FROM reservas where funcionariochave = :id ");
$consult->bindValue(":id", $administrador['id']);
$consult->execute();
$sem_chamado = $consult->fetch(PDO::FETCH_ASSOC);
if(empty($sem_chamado)){
echo '<tr><th>Reserva</th><th>Cliente</th><th colspan="2"></th></tr>';
echo '<tr>';
echo '<td class="espaco" colspan="6">Não possui reservas</td>';
echo '</tr></table>';
}else{
if(!empty($_POST["pesquisa"])){
    $busca = $_POST["pesquisa"];
    //$consulta_chamado = $cone->pdo->prepare("SELECT * FROM reservas WHERE id LIKE '%$busca%' AND funcionariochave = :id_funcionario and horariofinal = '' limit $pagina, $itens_por_pagina");
    $consulta_chamado = $cone->pdo->prepare("SELECT * FROM reservas WHERE id LIKE '%$busca%' AND funcionariochave = :id_funcionario limit $pagina, $itens_por_pagina");
    $consulta_chamado->bindValue(":id_funcionario", $administrador['id']);
    $consulta_chamado->execute();
    $vazio = $consulta_chamado->fetch(PDO::FETCH_ASSOC);
    if(!empty($vazio)){
    //$consulta = $cone->pdo->prepare("SELECT * FROM reservas WHERE id LIKE '%$busca%' AND funcionariochave = :id_funcionario and horariofinal = '' limit $pagina, $itens_por_pagina");
    $consulta = $cone->pdo->prepare("SELECT * FROM reservas WHERE id LIKE '%$busca%' AND funcionariochave = :id_funcionario limit $pagina, $itens_por_pagina");
    $consulta->bindValue(":id_funcionario", $administrador['id']);
    $consulta->execute();
    echo '<tr>
    <th>Reserva</th>
    <th>Cliente</th>
    <th>Quarto</th>
    <th>Check-in</th>
    <th>Check-out</th>
    <th colspan="2"></th>
    </tr>';
    while($lista = $consulta->fetch(PDO::FETCH_ASSOC)){

    $id = $lista["clientechave"];
    $tipoquarto = $lista["tipoquartochave"];
    echo'<form action="php/fecha_chamado.php" method="post"><tr>';

    $co = $cone->pdo->prepare("SELECT * FROM clientes WHERE id = :id");
    $co->bindValue(":id", $id);
    $co->execute();
    $cliente=$co->fetch(PDO::FETCH_ASSOC);

    $qo = $cone->pdo->prepare("SELECT * FROM tipoquartos WHERE id = :id");
    $qo->bindValue(":id", $tipoquarto);
    $qo->execute();
    $quarto=$qo->fetch(PDO::FETCH_ASSOC);

    echo '<td>'.$lista["id"].'</td>
    <td>'.$cliente["nomecliente"].'</td>
    <td>'.$quarto["nomequarto"].'</td>';
    echo '
    <td class="esquecido"><input type="text" name="mic" value="'.$lista['id'].'"></td>
    <td><input type="image" src="img/fechar.png" class="desativar" title="Fechar"/></td>
    </tr></form>';
    }
    echo '</table>';
    if(empty($_GET["pagina"]))
        $pagina =0;
    else
        $pagina = intval($_GET["pagina"]);
    //$sql1 = $cone->pdo->prepare("SELECT * FROM reservas WHERE id LIKE '%$busca%' AND funcionariochave = :id_funcionario and horariofinal = '' limit $pagina, $itens_por_pagina");
    $sql1 = $cone->pdo->prepare("SELECT * FROM reservas WHERE id LIKE '%$busca%' AND funcionariochave = :id_funcionario limit $pagina, $itens_por_pagina");
    $sql1->bindValue(":id_funcionario", $administrador['id']);
    $sql1->execute();
    $clinte1=$sql1->fetch(PDO::FETCH_ASSOC);
    //$contador = $cone->pdo->prepare( "SELECT * FROM reservas WHERE id LIKE '%$busca%' AND funcionariochave = :id_funcionario and horariofinal = '' LIMIT $pagina, $itens_por_pagina");
    $contador = $cone->pdo->prepare( "SELECT * FROM reservas WHERE id LIKE '%$busca%' AND funcionariochave = :id_funcionario LIMIT $pagina, $itens_por_pagina");
    $contador->bindValue(":id_funcionario", $administrador['id']);
    $contador->execute();
    $linhas =$contador->rowCount();
    $total = $linhas;

    $num_pag = ceil($total / $itens_por_pagina);

    echo '<ul class="pagination">
    <li>
    <a href="reservas.php?pagina=0" aria-label="Previous">
    <span aria-hidden="true">&laquo;</span>
    </a>
    </li>';
    for($i=0;$i<$num_pag;$i++){
    $estilo = "";
    if($pagina == $i)
    $estilo = 'class="active"';
    echo'<li '.$estilo.'><a href="reservas.php?pagina='.$i.'">'.($i+1).'</a></li>';
    }
    echo '<li>
    <a href="reservas.php?pagina='.($num_pag-1).'" aria-label="Next">
    <span aria-hidden="true">&raquo;</span>
    </a>
    </li>
    </ul>';
    }elseif(empty($vazio)){
    echo '<tr><th>Reserva</th><th>Cliente</th><th colspan="2"></th></tr>';
    echo '<tr>';
    echo '<td class="espaco" colspan="6">Reserva não encontrado!</td>';
    echo '</tr></table>';
    }
}else{
//$consulta_cliente = $cone->pdo->prepare("SELECT * FROM reservas where funcionariochave = :id and horariofinal = '' order by id limit $pagina, $itens_por_pagina");
$consulta_cliente = $cone->pdo->prepare("SELECT reservas.*, clientes.nomecliente, tipoquartos.nomequarto, tipoquartos.precoquarto FROM reservas INNER JOIN clientes ON (clientes.id = reservas.clientechave) INNER JOIN tipoquartos ON (tipoquartos.id = reservas.tipoquartochave) where funcionariochave = :id order by reservas.status, reservas.id limit $pagina, $itens_por_pagina");
$consulta_cliente->bindValue(":id", $administrador['id']);
$consulta_cliente->execute();
    echo '<tr>
    <th>Reserva</th>
    <th>Cliente</th>
    <th>Quarto</th>
    <th>Diária</th>
    <th>Check-in</th>
    <th>Check-out</th>
    <th>Status</th>
    <th colspan="2"></th>
    </tr>';
while($lista = $consulta_cliente->fetch(PDO::FETCH_ASSOC)){

$id = $lista["clientechave"];
$tipoquarto = $lista["tipoquartochave"];

echo'<form action="fecha_reserva.php" method="post"><tr>';

echo '<td>'.$lista["id"].'</td>
<td>'.$lista["nomecliente"].'</td>
<td>'.$lista["nomequarto"].'</td>
<td>R$ '.number_format($lista["precoquarto"], 2, ',', '.').'</td>
<td>'.$cone->converteDataPT($lista["dia"]).' '.$lista["horarioinicial"].'</td>
<td>'.($lista["status"]!="F" ? 'previsto p/ ' : NULL).$cone->converteDataPT($lista["diasaida"]).' '.$lista["horariofinal"].'</td>
<td>'.($lista["status"]=="F" ? 'Finalizada' : 'Ativa').'</td>';

echo '
<td class="esquecido"><input type="text" name="id_reserva" value="'.$lista['id'].'"></td>
<td>'.($lista["status"]!="F" ? '<input type="image" src="img/checkout.png" class="desativar" title="Check-out"/>' : NULL).'</td>
</tr></form>';
}
echo '</table>
<ul class="pagination">
<li>
<a href="reservas.php?pagina=0" aria-label="Previous">
<span aria-hidden="true">&laquo;</span>
</a>
</li>';
for($i=0;$i<$num_paginas;$i++){
$estilo = "";
if($pagina == $i)
$estilo = 'class="active"';
echo'<li '.$estilo.'><a href="reservas.php?pagina='.$i.'">'.($i+1).'</a></li>';
}
echo '<li>
<a href="reservas.php?pagina='.($num_paginas-1).'" aria-label="Next">
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