<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Produto de teste</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery.js"></script>
<script>

function enviaPagseguro(){
$.post('pagseguro.php','',function(data){
$('#code').val(data);
$('#comprar').submit();
})
}

</script>

</head>

<body>
<div>
<h1>Produto de teste</h1>
<p> 299,00</p>
<button onclick="enviaPagseguro()">Comprar</button>
</div>

<form id="comprar" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">

<input type="hidden" name="code" id="code" value="" />

</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
</body>
</html>

<?php

$data['token'] ='seutoken';
$data['email'] = 'seuemail';
$data['currency'] = 'BRL';
$data['itemId1'] = '1';
$data['itemQuantity1'] = '1';
$data['itemDescription1'] = 'Produto de Teste';
$data['itemAmount1'] = '299.00';

$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';

$data = http_build_query($data);

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$xml= curl_exec($curl);

curl_close($curl);

$xml= simplexml_load_string($xml);
echo $xml -> code;

?>