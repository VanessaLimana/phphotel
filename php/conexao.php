<?php
include_once 'config.php';

class conecta extends config{
var $pdo;
function __construct(){	
	$this->pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->db,$this->usuario,$this->senha, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
  ));
}
function login($email, $senha){
	$stmt = $this->pdo->prepare("SELECT * FROM funcionarios WHERE email = :email AND senha = :senha");
	$stmt->bindValue(":email",$email);
	$stmt->bindValue(":senha",($senha));
	$run = $stmt->execute();
	$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rs;
}

function converteDataPT($data)
{
    if (strlen($data) <= 10)
    {
        return substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);
    }
    else
    {
        return substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4)." - ".substr($data,10,9);
    }

}
}
?>