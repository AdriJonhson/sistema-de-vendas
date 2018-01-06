<?php 
function startConnection(){
	$HOST = "mysql:host=localhost;dbname=sistema_vendas";
	$USER = "root";
	$PASS = "root";
	try{
		$con = new PDO($HOST, $USER, $PASS);
		return $con;
	}catch(PDOException $ex){
		die("Erro na conexão: ".$ex);
	}
}


?>