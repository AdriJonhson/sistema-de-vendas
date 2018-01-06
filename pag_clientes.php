<?php require_once 'templates/header.php'; ?>
<?php 
if(!(isset($_SESSION['id_vendedor']))){
	header("Location: login.php");
}
?>
<?php require_once 'templates/navbar.php'; ?>

<?php 
	if(isset($_SESSION['msgErroCad'])){
			echo "<script type=\"text/javascript\">
			$(document).ready(function() {
				$('#myModal').modal('show');
			})
			</script>";
		}
?>

<div class="container-fluid">
	<h2>Clientes</h2>
	<?php require_once 'templates/msgs.php'; ?>
	
	<table class="table">
		<thead>
			<tr>
				<th>Nome</th>
				<th>CPF</th>
				<th>E-Mail</th>
				<th>Telefone</th>
				<th>Editar</th>
				<th>Excluir</th>
			</tr>
		</thead>
		
		<tbody>
			<?php 
			require_once 'php/Cliente.php';
			@$clientes = listarClientes();
			$qtdClientes = count($clientes);

			if($qtdClientes == 0){	
			?>
			<tr>
				<td colspan="4" align="center"><strong>Nenhum Cliente Cadastrado</strong></td>
			</tr>

			<?php 
			}else{ 
				foreach($clientes as $value){
			?>
			<tr>
				<td><?= $value['nome']?></td>
				<td><?= $value['cpf']?></td>
				<td><?= $value['email']?></td>
				<td><?= $value['telefone']?></td>
				<!-- <td><a href="#" data-toggle="modal" data-target="#myModalEditar" onclick="getDadosCliente();">Editar</a></td> -->
				<td><?php echo "<a href='#' data-toggle='modal' data-target='#myModalEditar' onclick=\"getDadosCliente({$value['id']},'{$value['nome']}', '{$value['cpf']}', '{$value['email']}', '{$value['telefone']}');\">Editar</a>";?></td>
				<td>
					<form action="php/Funcoes.php" method="POST">
						<input type="hidden" name="idCliente" value="<?= $value['id']?>">
						<input type="hidden" name="acao" value="excluirCliente">
						<button class="btn btn-link" onclick="return confirm('Você realmente eseja excluir esse produto? ');">Excluir</button>
					</form>
				</td>
			</tr>

			<?php } } ?>	
		</tbody>
		
		<tfoot>
			<tr>
				<td colspan="6" align="center"><a href="#" data-toggle="modal" data-target="#myModal"><strong><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Novo Cliente</strong></a></td>
			</tr>
		</tfoot>
	</table>
</div>

<!-- Modal de cadastro -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Cadastro</h4>
			</div>
			<div class="modal-body">

				<?php if(isset($_SESSION['msgErroCad'])){ ?>

				<div class="alert alert-danger" role="alert">
					<?= $_SESSION['msgErroCad']; ?>
					<?php unset($_SESSION['msgErroCad']) ?>
				</div>

				<?php } ?>

				<form action="php/Funcoes.php" method="POST">
					<div class="form-group">
						<label for="nome">Nome</label>
						<input type="text" name="inpNome" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="email">E-Mail</label>
						<input type="text" name="inpEmail" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="telefone">Telefone</label>
						<input type="text" name="inpTel" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="cpf">CPF</label>
						<input type="text" name="inpCpf" class="form-control" required>
					</div>

					<div class="form-group">
						<input type="hidden" name="acao" value="cadastrarCliente">
						<button class="btn btn-primary btn-block btn-lg">Cadastrar</button>
					</div>

				</div>
				<div class="modal-footer">
					<input type="hidden" name="acao" value="cadastrarCliente">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>

			</form>
		</div>
	</div>
</div>
<!-- Fim modal -->

<!-- Modal de edição -->
<div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar</h4>
			</div>
			<div class="modal-body">

				<?php if(isset($_SESSION['msgErroCad'])){ ?>

				<div class="alert alert-danger" role="alert">
					<?= $_SESSION['msgErroCad']; ?>
					<?php unset($_SESSION['msgErroCad']) ?>
				</div>

				<?php } ?>

				<form action="php/Funcoes.php" method="POST">
					<div class="form-group">
						<label for="nome">Nome</label>
						<input type="text" name="inpNome" class="form-control" id="nome" required>
					</div>

					<div class="form-group">
						<label for="email">E-Mail</label>
						<input type="text" name="inpEmail" class="form-control" id="email" required>
					</div>

					<div class="form-group">
						<label for="telefone">Telefone</label>
						<input type="text" name="inpTel" class="form-control" id="telefone" required>
					</div>

					<div class="form-group">
						<label for="cpf">CPF</label>
						<input type="text" name="inpCpf" class="form-control" id="cpf" required>
					</div>

					<div class="form-group">
						<input type="hidden" name="acao" value="cadastrarCliente">
						<button class="btn btn-primary btn-block btn-lg">Cadastrar</button>
					</div>

				</div>
				<div class="modal-footer">
					<input type="hidden" name="acao" value="editarCliente">
					<input type="hidden" name="idCliente" id="idCliente">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>

			</form>
		</div>
	</div>
</div>
<!-- Fim Modal -->

<script>
	function getDadosCliente(id, nome, cpf, email, telefone){
		document.getElementById('idCliente').value = id;
		document.getElementById('nome').value = nome;
		document.getElementById('cpf').value = cpf;
		document.getElementById('email').value = email;
		document.getElementById('telefone').value = telefone;
	}
</script>


<?php require_once 'templates/footer.php'; ?>