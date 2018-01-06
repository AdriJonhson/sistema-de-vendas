<?php
	session_start(); 
	require 'Users.php';
	require 'Movel.php';
	require 'Vendas.php';
	require 'Cliente.php';
	require 'Connection.php';

	if(isset($_POST['acao'])){
		if($_POST['acao'] == "login"){
			//Users.php
			checkLogin();
		}

		if($_POST['acao'] == "cadastrarMovel"){
			//Movel.php
			cadastrar();
		}

		if($_POST['acao'] == "excluirMovel"){
			//Movel.php
			excluir();
		}

		if($_POST['acao'] == "editarMovel"){
			//Movel.php
			editar();
		}

		if($_POST['acao'] == "realizarCompra"){
			//Vendas.php
			realizarCompra();
		}

		if($_POST['acao'] == "addMovel"){
			//Movel.php
			adicionarMovel();
		}

		if($_POST['acao'] == "remMovel"){
			//Movel.php
			removerMovel();
		}

		if($_POST['acao'] == "cadastrarCliente"){
			//Cliente.php
			cadastrarCliente();
		}

		if($_POST['acao'] == "excluirCliente"){
			excluirCliente();
		}

		if($_POST['acao'] == "editarCliente"){
			editarCliente();
		}

	}

	if(isset($_GET['acao'])){
		if($_GET['acao'] == "sair"){
			//User.php
			sair();
		}
	}






?>