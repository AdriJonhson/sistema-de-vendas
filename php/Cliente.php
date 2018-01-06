<?php 

	function verificarCpf($cpf){
		$con = startConnection();

		$stmtCpf = $con->prepare("SELECT cpf FROM clientes WHERE cpf = ?");
		$stmtCpf->bindValue(1, $cpf);
		$stmtCpf->execute();

		if($stmtCpf->rowCount() > 0){
			return true;
		}
	}

	function cadastrarCliente(){
		$erro = false;
		$nome = filter_input(INPUT_POST, 'inpNome');
		$email = filter_input(INPUT_POST, 'inpEmail');
		$telefone = filter_input(INPUT_POST, 'inpTel');
		$cpf = filter_input(INPUT_POST, 'inpCpf');

		$cpfTratado = str_replace('.', '', $cpf);
		$cpfTratado = str_replace('-', '', $cpfTratado);

		$telTratado = str_replace('(', '', $telefone);
		$telTratado = str_replace(')', '', $telefone);
		$telTratado = str_replace('-', '', $telefone);

		if(!(preg_match("#^([\w\.-]+)\@([\w\.-]+)+\.([a-z]{2,6})$#",$email))){
			$erro = true;
			$_SESSION['msgErroCad'] = "E-Mail Inválido";
		}

		if(verificarCpf($cpfTratado)){
			$erro = true;
			$_SESSION['msgErroCad'] = "Esse CPF já está cadastrado";	
		}

		if(!$erro){
			$con = startConnection();
			$stmtCadastro = $con->prepare("INSERT INTO clientes VALUES(default,?,?,?,?)");
			$stmtCadastro->bindValue(1, $nome);
			$stmtCadastro->bindValue(2, $email);
			$stmtCadastro->bindValue(3, $telTratado);
			$stmtCadastro->bindValue(4, $cpfTratado);
			$stmtCadastro->execute();

			if($stmtCadastro->rowCount() > 0){
				$_SESSION['msgSuce'] = "Cliente cadastrado com sucesso";
				header("Location: ../pag_clientes.php");
			}else{
				$_SESSION['msgErroCad'] = "Erro ao tentar realizar o cadastro do cliente";
				header("Location: ../pag_clientes.php");
			}
			
		}else{
			header("Location: ../pag_clientes.php");
		}
	}

	function listarClientes(){
		require_once 'Connection.php';
		$con = startConnection();
		$pdo = $con->prepare("SELECT * FROM clientes");
		$pdo->execute();

		while($row = $pdo->fetch()){
			$clientes[] = $row;
		}

		return $clientes;
	}

	function editarCliente(){
		$id = filter_input(INPUT_POST, 'idCliente');
		$nome = filter_input(INPUT_POST, 'inpNome');
		$email = filter_input(INPUT_POST, 'inpEmail');
		$telefone = filter_input(INPUT_POST, 'inpTel');
		$cpf = filter_input(INPUT_POST, 'inpCpf');

		$cpfTratado = str_replace('.', '', $cpf);
		$cpfTratado = str_replace('-', '', $cpfTratado);

		$telTratado = str_replace('(', '', $telefone);
		$telTratado = str_replace(')', '', $telefone);
		$telTratado = str_replace('-', '', $telefone);

		if(!(preg_match("#^([\w\.-]+)\@([\w\.-]+)+\.([a-z]{2,6})$#",$email))){
			$erro = true;
			$_SESSION['msgErroCad'] = "E-Mail Inválido";
		}

		if(verificarCpf($cpfTratado)){
			$erro = true;
			$_SESSION['msgErroCad'] = "Esse CPF já está cadastrado";	
		}

		if(!$erro){
			$con = startConnection();
			$stmtCadastro = $con->prepare("UPDATE clientes SET nome = ?, email = ?, telefone = ?, cpf = ? WHERE id = ?");
			$stmtCadastro->bindValue(1, $nome);
			$stmtCadastro->bindValue(2, $email);
			$stmtCadastro->bindValue(3, $telTratado);
			$stmtCadastro->bindValue(4, $cpfTratado);
			$stmtCadastro->bindValue(5, $id);
			$stmtCadastro->execute();

			if($stmtCadastro->rowCount() > 0){
				$_SESSION['msgSuce'] = "Dados alterados com sucesso";
				header("Location: ../pag_clientes.php");
			}else{
				$_SESSION['msgErroCad'] = "Erro ao tentar alterar os dados";
				header("Location: ../pag_clientes.php");
			}
			
		}else{
			header("Location: ../pag_clientes.php");
		}
	}

	function excluirCliente(){
		$con = startConnection();
		$idCliente = filter_input(INPUT_POST, 'idCliente');
		$stmt = $con->prepare("DELETE FROM clientes WHERE id = ?");
		$stmt->bindValue(1, $idCliente);
		$stmt->execute();

		if($stmt->rowCount() > 0){
			$_SESSION['msgSuce'] = "Cliente excluído com sucesso";
		}else{
			$_SESSION['msgErro'] = "Erro ao excluir os dados do cliente";
		}

		header("Location: ../pag_clientes.php");
	}