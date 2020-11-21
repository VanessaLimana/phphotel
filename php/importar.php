<?php  
$connect = mysqli_connect("localhost", "root", "", "hotel");
if(isset($_POST["submit"]))
{
 if($_FILES['file']['name'])
 {
  $filename = explode(".", $_FILES['file']['name']);
  if($filename[1] == 'csv')
  {
   $handle = fopen($_FILES['file']['tmp_name'], "r");

	  mysqli_query($connect, "DELETE FROM clientes");
   $contador=0;
   while(($data = fgetcsv($handle,0,";"))!==false)
   {

    if($contador>0 && $contador<=50) { //nao pegar a primeira linha (header) e limite de 50

     //0 = nome; 1 = email; 2 = cpf; 3 = sexo; 4 = telefone; 5 = status; 6 = rg; 7 = endereco; 8 = pais; 9 = cidade; 10 = estado
     $item1 = mysqli_real_escape_string($connect, $data[0]);
     $item2 = mysqli_real_escape_string($connect, $data[1]);
     $item3 = mysqli_real_escape_string($connect, $data[2]);
     $item4 = mysqli_real_escape_string($connect, $data[3]);
     $item5 = mysqli_real_escape_string($connect, $data[4]);
     $item6 = mysqli_real_escape_string($connect, $data[5]);
	 

     $queryConsulta = "select id from clientes where cpf='$item3' limit 0,1"; //verificar se existe cliente com cpf no banco
     $consulta = mysqli_query($connect,$queryConsulta);
     if(mysqli_affected_rows($connect)>0){
      $cliente = mysqli_fetch_array($consulta);
      $cliente_id = intval($cliente[0]);
      if($cliente_id>0) {
       $query = "update clientes set nomecliente='$item1',email='$item2',sexo='$item4',telefone='$item5',status='$item6' where id='$cliente_id'";
      }
     }
     else {
        $query = "INSERT into clientes (nomecliente,email,cpf,sexo,telefone,status ) values ('$item1','$item2','$item3','$item4','$item5','$item6')";
     }

     mysqli_query($connect, $query);
    }
    $contador++;
   }
   fclose($handle);
   echo "<script>alert('IMPORTAÇÃO EFETUADA COM SUCESSO!');</script>";
  }
 }
}

   echo "<meta http-equiv='refresh' content='0, url=../clientes.php'>";
?>  