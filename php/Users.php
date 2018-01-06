<?php 

function checkLogin(){
	$login = filter_input(INPUT_POST, 'inpLogin');
	$senha = filter_input(INPUT_POST, 'inpSenha');

	if(empty($login) || empty($senha)){
		$_SESSION['msgErro'] = "Preencha todos os campos";
		header("Location: ../login.php");
	}else{
		$con = startConnection();
		$stmt = $con->prepare("SELECT * FROM users WHERE login = :login AND senha = :senha");
		$stmt->bindValue(':login', $login);
		$stmt->bindValue(':senha', $senha);
		$stmt->execute();

		if($stmt->rowCount() != 0){
			$row = $stmt->fetchAll(PDO::FETCH_OBJ);
			
			foreach($row as $value){
				$_SESSION['id_vendedor'] = $value->id;
				$_SESSION['nome'] = $value->nome;
			}

			header("Location: ../index.php");

		}else{
			$_SESSION['msgErro'] = "Login ou Senha inválidos";
			header("Location: ../login.php");
		}
	}
}

function sair(){
	session_destroy();
	header("Location: ../index.php");
}


?>