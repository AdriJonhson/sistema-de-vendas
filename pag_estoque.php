<?php require 'templates/header.php'; ?>
<?php  
	//Verificando se o usuário está logado
	if(!(isset($_SESSION['id_vendedor']))){
		header("Location: login.php");
	}
?>


<?php require 'templates/navbar.php'; ?>

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
	<h2>Estoque</h2>
	<?php require 'templates/msgs.php'; ?>

	<table class="table">
		
		<thead>
			<tr>
				<th>Código</th>
				<th>Nome</th>
				<th>Preço</th>
				<th>Quantidade</th>
				<th>Total</th>
				<th>Controle</th>
				<th>Editar</th>
				<th>Excluir</th>
			</tr>
		</thead>
			
		<tbody>
			<?php 
				require 'php/Movel.php';
				@$moveis = listar();

				foreach($moveis as $values){
					$preco = number_format($values['preco'],2,',','.');
					$total = $values['preco'] * $values['qtd'];
					$total = number_format($total, 2, ',', '.');

			?>
			<tr <?php echo($values['qtd'] < 5) ? "class='danger'" : "";?>>
				<td><?= $values['id']?></td>
				<td><?= $values['nome']?></td>
				<td><?= "R$ ".$preco?></td>
				<td><?= $values['qtd']?></td>
				<td><?= "R$ ".$total?></td>
				<th>
					<div class="btn-group">
						<button class="btn btn-primary" data-toggle="modal" data-target="#myModalControle" name="idProduto" onclick="aumentarQuant(<?= $values['id']?>, <?= $values['qtd'] ?>);">+</button>
						<button class="btn btn-primary" data-toggle="modal" data-target="#myModalControle" name="idProduto" onclick="diminuirQuant(<?= $values['id']?>, <?= $values['qtd'] ?>);">-</button>
					</div>
				</th>
				<td>
	
					<?php echo "<button class='btn btn-link' data-target='#myModalEditar' data-toggle='modal' onclick=\"setDadosMovel({$values['id']}, {$values['preco']}, '{$values['nome']}');\">Editar</button>"; ?>
				<td>
					<form action="php/Funcoes.php" method="POST">
						<input type="hidden" name="idMovel" value="<?= $values['id']?>">
						<input type="hidden" name="acao" value="excluirMovel">
						<button class="btn btn-link" onclick="return confirm('Você realmente eseja excluir esse produto? ');">Excluir</button>
					</form>
				</td>
			</tr>
			<?php } ?>
		</tbody>

		<tfoot>
			<tr align="center">
				<td colspan="7" align="center"><a href="#" data-toggle="modal" data-target="#myModal">Adicionar Novo Produto</a></td>
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
						<input type="text" class="form-control" name="inpNome" id="nome" >
					</div>

					<div class="form-group">
						<label for="preco">Preço</label>
						<input type="double" class="form-control" name="inpPreco" id="preco" >
					</div>

					<div class="form-group">
						<label for="qtd">Quantidade</label>
						<input type="number" class="form-control" name="inpQtd" id="qtd" min='1' >
					</div>

				</div>
				<div class="modal-footer">
					<input type="hidden" name="acao" value="cadastrarMovel">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>

			</form>
		</div>
	</div>
</div>
<!-- Fim modal -->

<!-- Modal de controle de produtos -->
<div class="modal fade" id="myModalControle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="titulo"></h4>
			</div>
			<div class="modal-body">
				<form action="php/Funcoes.php" method="POST">
					<div class="form-group">
						<label for="">Quantidade Atual: </label>
						<span id="qtdAtual"></span>
					</div>
						
					<div class="form-group">
						<input type="number" name="inpQtd" id="quantidade" class="form-control" required>
					</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="acao" value="" id="acaoControle">
				<input type="hidden" name="idMovel" value="" id="idMovel">
		
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary">Salvar</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Fim modal -->

<!-- Modal Editar -->
<div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar Produto</h4>
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
						<input type="text" class="form-control" name="inpNome" id="inpNome">
					</div>

					<div class="form-group">
						<label for="preco">Preço</label>
						<input type="double" class="form-control" name="inpPreco" id="inpPreco" >
					</div>

				</div>
				<div class="modal-footer">
					<input type="hidden" name="acao" value="editarMovel">
					<input type="hidden" name="idMovel" id="inpIdMovel">

					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>

			</form>
		</div>
	</div>
</div>
<!-- Fim Modal -->


<script>
	function aumentarQuant(id, qtd){
		document.getElementById('qtdAtual').innerHTML = qtd;
		document.getElementById('idMovel').value = id;
		document.getElementById('acaoControle').value = "addMovel";
		document.getElementById('quantidade').placeholder = "Quantidade que deseja aumentar";
		document.getElementById('quantidade').min = 1;
		document.getElementById('titulo').innerHTML = "Adicionar";
	}

	function diminuirQuant(id, qtd){
		document.getElementById('qtdAtual').innerHTML = qtd;
		document.getElementById('idMovel').value = id;
		document.getElementById('acaoControle').value = "remMovel";
		document.getElementById('quantidade').placeholder = "Quantidade que deseja remover";
		document.getElementById('quantidade').max = qtd;
		document.getElementById('titulo').innerHTML = "Remover";
	}

	function setDadosMovel(id, preco, nome){
		document.getElementById('inpIdMovel').value = id;
		document.getElementById('inpPreco').value   = preco;
		document.getElementById('inpNome').value = nome;
	}

</script>
<?php require 'templates/footer.php' ?>