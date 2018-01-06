<?php require_once 'templates/header.php'; ?>
<?php 
if(!(isset($_SESSION['id_vendedor']))){
	header("Location: login.php");
}
?>
<?php require_once 'templates/navbar.php'; ?>


<div class="container-fluid">

	<h2>Cadastro de clientes</h2>
	<?php require_once 'templates/msgs.php'; ?>
	
	<form action="php/Funcoes.php" method="POST">
		<div class="form-group">
			<label for="nome">Nome</label>
			<input type="text" name="inpNome" class="form-control">
		</div>

		<div class="form-group">
			<label for="email">E-Mail</label>
			<input type="text" name="inpEmail" class="form-control">
		</div>

		<div class="form-group">
			<label for="telefone">Telefone</label>
			<input type="text" name="inpTel" class="form-control">
		</div>

		<div class="form-group">
			<label for="cpf">CPF</label>
			<input type="text" name="inpCpf" class="form-control">
		</div>

		<div class="form-group">
			<input type="hidden" name="acao" value="cadastrarCliente">
			<button class="btn btn-primary btn-block btn-lg">Cadastrar</button>
		</div>
	</form>


</div>




<?php require_once 'templates/footer.php'; ?>