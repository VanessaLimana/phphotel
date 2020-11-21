<?php
	session_start();
	include("php/conexao.php");
	if(!empty($_SESSION["email"])) {
		$email = $_SESSION['email'];
		$cone = new conecta();
		$consulta = $cone->pdo->prepare("SELECT * FROM funcionarios WHERE email = :email");
		$consulta->bindValue(":email", $email);
		$consulta->execute();
		$administrador=$consulta->fetch(PDO::FETCH_ASSOC);

		$id_reserva = $_POST["id_reserva"];

		$consulta_reserva = $cone->pdo->prepare(
			"
				SELECT
					reservas.*,
					DATE_FORMAT(reservas.dia, '%d/%m/%Y') as dia_entrada,
					DATE_FORMAT(reservas.diasaida, '%d/%m/%Y') as dia_saida,
					DATE_FORMAT(reservas.horarioinicial, '%H:%i') as hora_entrada,
					DATE_FORMAT(reservas.horariofinal, '%H:%i') as hora_saida,
					clientes.id as id_cliente,
					clientes.nomecliente,
					tipoquartos.id as id_quarto,
					tipoquartos.precoquarto as valor_diaria,
					DATEDIFF(DATE(NOW()),dia) as diarias,
					DATEDIFF(DATE(NOW()),dia) * tipoquartos.precoquarto as valor_total
				FROM
					reservas INNER JOIN clientes ON clientes.id = reservas.clientechave
				INNER JOIN tipoquartos ON tipoquartos.id = reservas.tipoquartochave
				WHERE
					reservas.id = $id_reserva
			"
		);
		$consulta_reserva->bindValue(":id", $id_reserva);
		$consulta_reserva->execute();
		$dados_reserva=$consulta_reserva->fetch(PDO::FETCH_ASSOC);

		$clientechave = $dados_reserva["clientechave"];

		$consulta_cliente = $cone->pdo->prepare("select * from clientes where id = :id");
		$consulta_cliente->bindValue(":id",$clientechave);
		$consulta_cliente->execute();
		$dados_cliente = $consulta_cliente->fetch(PDO::FETCH_ASSOC);

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
					$(function() {
						var nav = $("#navegacao");
						$(window).scroll(function () {
							if($(this).scrollTop() > 0) {
								nav.addClass("menu-fixo");
							} else {
								nav.removeClass("menu-fixo");
							}
						});
					});
				</script>

				<style>
					section.todo {
						overflow: hidden;
					}
				
					h1 {
						text-align: center;
						font-size: 3em;
					}

					table {
						margin: 0 auto;
					}

					fieldset {
						padding: 10px;
						border: 1px solid #666;
					}

					fieldset legend {
						padding: 5px;
					}
					
					#botao_consumo {
						background-color: #FFF;
						color: #333;
						transition: 0.2s;
						padding: 5px 10px;
						border: 1px solid #666;
						border-radius: 3px;
					}
					
					#botao_consumo:hover {
						cursor: pointer;
						background-color: #666;
						color: #FFF;
					}
					
					#botao_consumo:disabled {
						background-color: #E1E1E1;
					}
					
					#botao_consumo:disabled:hover {
						background-color: #E1E1E1;
						cursor: default;
						color: #333;
					}
					
					#tabela_consumo {
						border-collapse: collapse;
						margin-top: 15px;
					}
					
					#tabela_consumo thead,
					#tabela_consumo tfoot {
						background-color: #333;
						color: #FFF;
					}
					
					#tabela_consumo thead th {
						text-align: left;
					}
					
					#tabela_consumo thead th,
					#tabela_consumo tfoot td {
						border-color: #333;
						padding: 2px 5px
					}
					
					#tabela_consumo tbody tr td,
					#tabela_consumo tfoot tr td {
						padding: 2px 5px;
					}
					
					#valorTotalReserva span {
						color: #006431;
						font-size: 2em;
					}
				</style>
			</head>
			<body onload="carrega()">
				<section id="fundo">
					<header id="header">
						<figure>
							<figcaption>
								<nav id="navegacao">
									<a href="index"><img src="img/logo.png" id="logo" alt="Sistema de reservas" title="Sistema de reservas"></a>
									<ul>';
									if($administrador["tiririca"]== "admin") {
										echo '<a href="cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de <br>Funcionário</li></a>';
									} else {
										echo '<a href="chamado/reserva" title="Cadastro de Reserva"><li>Cadastro de <br>Reserva</li></a>';
									}
									echo '<a href="cadastro/quarto" title="Cadastro de Quarto"><li>Cadastro de <br>Quarto</li></a>
									</ul>
									</div>
										<a href="#" onclick=\'carrega_menu("menu_mobile")\'><img src="img/menu-icone.png" id="icone-menu" alt="Menu"></a>
									<ul id="menu_mobile">
										<a href="cadastro/pagseguro" title="Check Out"><li>Check <br>Out</li></a>';
									if($administrador["tiririca"]== "admin"){
										echo '<a href="cadastro/funcionario" title="Cadastro de Funcionário"><li>Cadastro de Funcionário</li></a>';
									}else{
										echo '<a href="chamado/atendimento" title="Abertura de Chamado"><li>Abertura de Chamado</li></a>';
									}
									echo '<a href="cadastro/quarto" title="Cadastro de Quarto"><li>Cadastro de <br>Quarto</li></a>
									</ul>';
									if(empty(!$_SESSION["email"])) {
										$nome = explode(" ",$administrador["nome"]);
										print('<p class="login">Bem Vindo '.$nome[0].'</p><br>');
										print('<a href="logout" class="sair">Sair</a>');
									}
								echo '</nav>
							</figcaption>
						</figure>
					</header>
					<section id="slide">
						<img src="img/imagem_fundo.jpg" class="imagem_fundo" title="Sistema de reservas" alt="Sistema de reservas">
						<img src="img/imagem_fundo-2.jpg" class="imagem_fundo2">
						<img src="img/imagem_fundo-3.jpg" class="imagem_fundo3">
					</section>
					<section class="todo">
						<section>
							<h1>Check-Out</h1>
							<table width="800px" cellspacing="4" cellspadding="3" align="center">
								<tr>
									<td width="200px">
										Id reserva
									</td>
									<td>
										<strong>'.$dados_reserva['id'].'</strong>
									</td>
								</tr>
								<tr>
									<td>
										Reserva N&deg;
									</td>
									<td>
										<strong>'.$dados_reserva['numreserva'].'</strong>
									</td>
								</tr>
								<tr>
									<td>
										Previsão de saída
									</td>
									<td>
										<strong>'.$dados_reserva['dia_saida'].' '.$dados_reserva['hora_saida'].'</strong>
									</td>
								</tr>
								<tr>
									<td>
										Entrada / Saída
									</td>
									<td>
										<strong>'.$dados_reserva['dia_entrada'].' '.$dados_reserva['hora_entrada'].' até '.date('d/m/Y H:i').'</strong>
									</td>
								</tr>
								<tr>
									<td>
										Diárias
									</td>
									<td>
										<strong>'.$dados_reserva['diarias'].'</strong>
									</td>
								</tr>
								<tr>
									<td>
										Valor diária
									</td>
									<td>
										<strong>R$ '.number_format($dados_reserva['valor_diaria'], 2, ',', '.').'</strong>
									</td>
								</tr>
								<tr>
									<td>
										Valor total diárias
									</td>
									<td>
										<strong>R$ '.number_format($dados_reserva['valor_total'], 2, ',', '.').'</strong>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<fieldset>
											<legend>Consumo</legend>
											<table width="100%" cellspacing="2">
												<tr>
													<td>
														Importar consumo
													</td>
													<td>
														<button id="botao_consumo" onclick="carrega_consumo('.$dados_reserva['id'].')">Carregar arquivo</button>
													</td>
												</tr>
											</table>
											<table id="tabela_consumo" border="1" border-style="solid" cellspacing="0" width="100%" cellspadding="2">
												<thead>
													<tr>
														<th width="50%">
															Produto
														</th>
														<th width="15%">
															Valor
														</th>
														<th width="15%">
															Quantidade
														</th>
														<th width="20%" align="center">
															Total
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td align="center" colspan="4">
															Nenhum produto!
														</td>
													</tr>
												</tbody>
												<tfoot>
													<tr>
														<td align="right" colspan="3">
															Valor total
														</td>
														<td>
															R$ 00,00
														</td>
													</tr>
												</tfoot>
											</table>
										</fieldset>
										<div id="valorTotalReserva">
											Valor total da reserva: <span>R$ '.number_format($dados_reserva['valor_total'], 2, ',', '.').'</span>
										</div>
									</td>
								</tr>
							</table>
						</section>
						<hr>
						<form name="checkout" method="post" action="pagseguro/checkout.php" target="_blank">
							<input type="hidden" name="valorProduto" id="valorProduto" value="'.(floatval($dados_reserva["valor_total"])).'">
							<input type="hidden" name="nomeProduto" value="Reserva Nº '.$dados_reserva['numreserva'].'">
							<input type="hidden" name="nomeCliente" value="'.$dados_cliente["nomecliente"].'">
							<input type="hidden" name="emailCliente" value="'.$dados_cliente["email"].'">
							<input type="hidden" name="telefoneCliente" value="'.$dados_cliente["telefone"].'">
							<input type="hidden" name="enderecoCliente" value="">
							<input type="hidden" name="numeroEnderecoCliente" value="">
							<input type="hidden" name="bairroCliente" value="">
							<input type="hidden" name="cidadeCliente" value="">
							<input type="hidden" name="estadoCliente" value="">
							<input type="hidden" name="cepCliente" value="">
							<input type="hidden" name="idReserva" value="'.$dados_reserva["id"].'">
							<button id="botao_pagamento" type="submit" style="margin: 20px auto;display: block;padding: 10px;background:#f4f4f4;border: 1px solid;font-size: 15px;">FAZER PAGAMENTO</button>
						</form>
					<footer>
						<img src="img/logo.png" alt="Sistema de reservas" title="Sistema de reservas">
						<p>© Sistema de reservas | Todos os direitos reservados.</p>
					</footer>
				</section>
				<script>
					$(document).ready(function() {
						$.ajaxSetup({ cache: false });
					});
				
					function carrega_consumo(id) {
						$.getJSON("../consumohotel/json/consumo_"+id+".json", function(data) {
							$("#botao_consumo").attr("disabled", true);
						
							var produtos = data.dados;
							var linhas_produtos = "";
							var total_produtos = 0;
							var valor_total_reserva = 0;
							
							if(Array.isArray(produtos)) {
								for(i = 0; i < produtos.produto.length; i++) {
									linhas_produtos += "<tr>";
										linhas_produtos += "<td>"+produtos.produto[i]+"</td>";
										linhas_produtos += "<td>"+parseFloat(produtos.valor[i]).toLocaleString("pt-BR", {style: "currency", currency: "BRL"})+"</td>";
										linhas_produtos += "<td>"+produtos.quantidade[i]+"</td>";
										linhas_produtos += "<td>"+(produtos.valor[i]*produtos.quantidade[i]).toLocaleString("pt-BR", {style: "currency", currency: "BRL"})+"</td>";
									linhas_produtos += "</tr>";

									total_produtos = total_produtos + produtos.valor[i]*produtos.quantidade[i];
								}
							} else {
								linhas_produtos += "<tr>";
									linhas_produtos += "<td>"+produtos.produto+"</td>";
									linhas_produtos += "<td>"+parseFloat(produtos.valor).toLocaleString("pt-BR", {style: "currency", currency: "BRL"})+"</td>";
									linhas_produtos += "<td>"+produtos.quantidade+"</td>";
									linhas_produtos += "<td>"+(produtos.valor*produtos.quantidade).toLocaleString("pt-BR", {style: "currency", currency: "BRL"})+"</td>";
								linhas_produtos += "</tr>";

								total_produtos = total_produtos + produtos.valor*produtos.quantidade;
							}

							$("#tabela_consumo tbody").html("");
							$("#tabela_consumo tbody").append(linhas_produtos);
							$("#tabela_consumo tfoot tr td:last-child").html(total_produtos.toLocaleString("pt-BR", {style: "currency", currency: "BRL"}));
							var valor_total_reserva = parseFloat($("#valorProduto").val()) + total_produtos;
							$("#valorProduto").val(valor_total_reserva);
							$("#valorTotalReserva > span").html(valor_total_reserva.toLocaleString("pt-BR", {style: "currency", currency: "BRL"}));
						}).fail(function() {
							alert("Arquivo não encontrado!");
						});
					}
				</script>
			</body>
		</html>';
	}else{
		echo '<meta http-equiv="refresh" content="0, url=login.php">';
	}
/*
	function carrega_consumo(id) {
		$.getJSON("../consumohotel/json/consumo_"+id+".json", function(data) {
			var dados = data.dados;
			var linhas_produtos = "";

			console.log(dados.length);
			for(i = 0; i < dados.length; i++) {
				linhas_produtos += "<tr>";
					linhas_produtos += "<td>"+dados.+"</td>";
				linhas_produtos += "</tr>";
			}
		});
	}
*/
?>