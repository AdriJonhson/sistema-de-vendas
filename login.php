<?php require 'templates/header.php'; ?>
	<link rel="stylesheet" href="css/signin.css">
	<div class="form-signin">
		<form action="php/Funcoes.php" method="POST">
			<h2 class="text-center">Área de Acesso</h2>
			<br>
			<?php require 'templates/msgs.php'; ?>

			<div class="form-group">
				<input type="text" id="login" name="inpLogin" class="form-control" placeholder="Digite seu Login" required>
			</div>

			<div class="form-group">
				<input type="password" name="inpSenha" id="senha" class="form-control" placeholder="Digite sua senha" required>
			</div>

			<div class="form-group">
				<input type="hidden" name="acao" value="login">
				<button type="submit" class="btn btn-primary btn-lg btn-block">Enviar</button>
			</div>
		</form>
	</div>

<?php require 'templates/footer.php' ?>