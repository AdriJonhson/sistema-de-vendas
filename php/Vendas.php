<?php 

function realizarCompra(){
	$dataCompra = date('Y-m-d');
	$idVendedor = $_SESSION['id_vendedor'];
	$idCliente = filter_input(INPUT_POST, 'inpIdCliente');
	$qtd = filter_input(INPUT_POST, 'inpQtd');
	$idMovel = filter_input(INPUT_POST, 'idMovel');
	$preco = filter_input(INPUT_POST, 'preco');
	$total = $preco * $qtd;

	$con  = startConnection();
	$stmt = $con->prepare("INSERT INTO vendas VALUES(default, ?, ?, ?, ?, ?, ?)");
	$stmt->bindValue(1, $idVendedor);
	$stmt->bindValue(2, $idMovel);
	$stmt->bindValue(3, $idCliente);
	$stmt->bindValue(4, $dataCompra);
	$stmt->bindValue(5, $qtd);
	$stmt->bindValue(6, $total);
	$stmt->execute();

	if($stmt->rowCount() > 0){
		//Chamada do Stored Procedure
		$stmtUpdateMovel = $con->prepare("CALL diminuir_qtd(?, ?)");
		$stmtUpdateMovel->bindParam(1, $idMovel);
		$stmtUpdateMovel->bindParam(2, $qtd);
		$stmtUpdateMovel->execute();

		$_SESSION['msgSuce'] = "Compra realizada com sucesso";
	}else{
		$_SESSION['msgErro'] = "Erro ao realizar a compra";
	}

	header("Location: ../index.php");
}

//Função que verifica o móvel mais vendido no mês atual
function verMovelMes(){
	require_once 'Connection.php';
	
	$mesAtual = date('m');
	$anoAtual = date('Y');

	$con = startConnection();
	$stmt = $con->prepare("SELECT m.nome AS nome, sum(v.qtd) as total FROM vendas AS v
	JOIN moveis AS m
	ON m.id = v.id_movel
	WHERE MONTH(v.data_venda) = ? AND YEAR(v.data_venda) = ?
	group by v.id_movel
	order by total desc LIMIT 1");

	$stmt->bindValue(1, $mesAtual);
	$stmt->bindValue(2, $anoAtual);

	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);

	foreach($row as $value){
		$nomeMovel = $value->nome;
	}

	return $nomeMovel;
}

//Função que verifica o móvel mais vendido
function verMovelTop(){
	require_once 'Connection.php';

	$con = startConnection();
	$stmt = $con->prepare("SELECT m.nome AS nome, sum(v.qtd) as total FROM vendas AS v
	JOIN moveis AS m
	ON m.id = v.id_movel
	group by v.id_movel
	order by total desc LIMIT 1");

	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);

	foreach($row as $value){
		$nomeMovel = $value->nome;
	}

	return $nomeMovel;
}

//Função que conta o total de móveis vendidos
function contarTotal(){
	require_once 'Connection.php';

	$con = startConnection();
	$stmt = $con->prepare("SELECT SUM(qtd) AS qtd FROM vendas");

	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);

	foreach($row as $value){
		$qtd = $value->qtd;
	}

	return $qtd;
}

//Função que conta o total de móveis vendidos no mês
function contarTotalMes(){
	require_once 'Connection.php';

	$mesAtual = date('m');
	$anoAtual = date('Y');
	
	$con = startConnection();
	$stmt = $con->prepare("SELECT SUM(qtd) AS qtd FROM vendas WHERE MONTH(data_venda) = ? AND YEAR(data_venda) = ?");

	$stmt->bindValue(1, $mesAtual);
	$stmt->bindValue(2, $anoAtual);

	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);

	foreach($row as $value){
		$qtd = $value->qtd;
	}

	return $qtd;
}

function calcularRendaMes(){
	require_once 'Connection.php';

	$mesAtual = date('m');
	$anoAtual = date('Y');
	
	$con = startConnection();
	$stmt = $con->prepare("SELECT SUM(total) AS total FROM vendas WHERE MONTH(data_venda) = ? AND YEAR(data_venda) = ?");

	$stmt->bindValue(1, $mesAtual);
	$stmt->bindValue(2, $anoAtual);

	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);

	foreach($row as $value){
		$total = $value->total;
	}

	$total = number_format($total,2,',','.');
	return $total;
}

function calcularRendaTotal(){
	require_once 'Connection.php';

	$con = startConnection();
	$stmt = $con->prepare("SELECT SUM(total) AS total FROM vendas");

	$stmt->execute();
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);

	foreach($row as $value){
		$total = $value->total;
	}

	$total = number_format($total,2,',','.');
	return $total;
}

function verVendasFuncionarios(){

	require_once 'Connection.php';

	$mesAtual = date('m');
	$anoAtual = date('Y');

	$con = startConnection();

	$stmt = $con->prepare("SELECT COUNT(v.id_vendedor) AS qtd,u.nome AS nome FROM vendas AS v
	JOIN users AS u
	ON u.id = v.id_vendedor 
	WHERE MONTH(data_venda) = ? AND YEAR(data_venda) = ?
	GROUP BY id_vendedor;");

	$stmt->bindValue(1, $mesAtual);
	$stmt->bindValue(2, $anoAtual);

	$stmt->execute();

	while($row = $stmt->fetch()){
		$funcionarios[] = $row;
	}

	return $funcionarios;
}
?>