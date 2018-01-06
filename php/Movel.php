<?php 

function cadastrar(){
	$nome = filter_input(INPUT_POST, 'inpNome');
	$preco = filter_input(INPUT_POST, 'inpPreco');
	$qtd = filter_input(INPUT_POST, 'inpQtd');

	if(empty($nome) || empty($preco) || empty($qtd)){
		$_SESSION['msgErroCad'] = "Nenhum campo pode está vazio";
		header("Location: ../pag_estoque.php");
	}else{	

		$con = startConnection();
		$stmt = $con->prepare("INSERT INTO moveis VALUES(default,?,?,?)");
		$stmt->bindValue(1, $nome);
		$stmt->bindValue(2, $preco);
		$stmt->bindValue(3, $qtd);

		if($stmt->execute()){
			$_SESSION['msgSuce'] = "Produto cadastrado com sucesso";
		}else{
			$_SESSION['msgErroCad'] = "Erro ao cadastrar o produto";
		}

		header("Location: ../pag_estoque.php");
	}
}

function listar(){
	require 'Connection.php';
	$con = startConnection();
	$stmt = $con->prepare("SELECT * FROM moveis");
	$stmt->execute();

	while($row = $stmt->fetch()){
		$moveis[] = $row;
	}

	return $moveis;
}

function excluir(){
	$id = filter_input(INPUT_POST, 'idMovel');
	$con = startConnection();
	$stmt = $con->prepare("DELETE FROM moveis WHERE id = ?");
	$stmt->bindValue(1, $id);
	$stmt->execute();

	if($stmt->rowCount() > 0){
		$_SESSION['msgSuce'] = "Produto excluído com sucesso";
	}else{
		$_SESSION['msgErro'] = "Erro ao excluir o produto";
	}

	header("Location: ../pag_estoque.php");
}

function editar(){
	$idMovel = filter_input(INPUT_POST, 'idMovel');
	$nome = filter_input(INPUT_POST, 'inpNome');
	$preco = filter_input(INPUT_POST, 'inpPreco');

	if(empty($nome) || empty($preco)){
		$_SESSION['msgErro'] = "Nenhum campo pode está vazio";
		header("Location: ../pag_estoque.php");
	}else{	
		$con = startConnection();
		$stmt = $con->prepare("UPDATE moveis SET nome = ?, preco = ? WHERE id = ?");
		$stmt->bindValue(1, $nome);
		$stmt->bindValue(2, $preco);
		$stmt->bindValue(3, $idMovel);
		$stmt->execute();

		if($stmt->rowCount() > 0){
			$_SESSION['msgSuce'] = "Dados alterados com sucesso";
		}else{
			$_SESSION['msgSuce'] = "Erro ao alterar os dados";
		}

		header("Location: ../pag_estoque.php");
	}
}

function verDadosMovel($idMovel){
	require 'Connection.php';
	$con = startConnection();
	$stmt = $con->prepare("SELECT * FROM moveis WHERE id = ?");
	$stmt->bindValue(1, $idMovel);
	$stmt->execute();
	$row = $stmt->fetch();

	return $row;
}

function buscarMovel($nome){
	require 'Connection.php';
	$con = startConnection();
	$stmt = $con->prepare("SELECT * FROM moveis WHERE nome LIKE ?");
	$stmt->bindValue(1, '%'.$nome.'%');
	$stmt->execute();

	while($row = $stmt->fetch()){
		$moveis[] = $row;
	}

	return $moveis;
}

function adicionarMovel(){
	$id = filter_input(INPUT_POST, 'idMovel');
	$qtd = filter_input(INPUT_POST, 'inpQtd');

	$con = startConnection();
	$stmt = $con->prepare("UPDATE moveis SET qtd = qtd + ? WHERE id = ?");
	$stmt->bindValue(1, $qtd);
	$stmt->bindValue(2, $id);
	$stmt->execute();

	if($stmt->rowCount() > 0){
		$_SESSION['msgSuce'] = "Dados alterados com sucesso";
	}else{
		$_SESSION['msgSuce'] = "Erro ao alterar os dados";
	}

	header("Location: ../pag_estoque.php");

}

function removerMovel(){
	$id = filter_input(INPUT_POST, 'idMovel');
	$qtd = filter_input(INPUT_POST, 'inpQtd');

	$con = startConnection();
	$stmt = $con->prepare("UPDATE moveis SET qtd = qtd - ? WHERE id = ?");
	$stmt->bindValue(1, $qtd);
	$stmt->bindValue(2, $id);
	$stmt->execute();

	if($stmt->rowCount() > 0){
		$_SESSION['msgSuce'] = "Dados alterados com sucesso";
	}else{
		$_SESSION['msgSuce'] = "Erro ao alterar os dados";
	}

	header("Location: ../pag_estoque.php");
}



?>