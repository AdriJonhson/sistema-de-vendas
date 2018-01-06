<?php require 'templates/header.php'; ?>

<?php   
	//Verificando se o usuário está logado
	if(!(isset($_SESSION['id_vendedor']))){
		header("Location: login.php");
	}
?>

<?php require 'templates/navbar-index.php'; ?>
<div class="container-fluid">
	<h2>Catálogo</h2>
	<?php require 'templates/msgs.php'; ?>

	<table class="table">
		
		<thead>
			<tr>
				<th>Código</th>
				<th>Nome</th>
				<th>Preço</th>
				<th>Quantidade em Estoque</th>
				<th>Comprar</th>	
			</tr>
		</thead>

		<tbody>
			<?php 
				require 'php/Movel.php';
			
				@$moveis = listar();

				foreach($moveis as $values){
					$preco = number_format($values['preco'],2,',','.');
			?>
			<tr>
				<td><?= $values['id']?></td>
				<td><?= $values['nome']?></td>
				<td><?= "R$ ".$preco?></td>
				<td><?php echo($values['qtd'] <= 0) ? "Em falta" : $values['qtd'];?></td>
				<!-- <td><a href="#" data-toggle="modal" data-target="#modalCompra" onclick="setValoresMovel(<?=$values['id']?>,<?= '$preco'?>,1,1);"><span class="glyphicon glyphicon-shopping-cart"></span></a></td> -->
				<td><?php echo "<a href='#' data-toggle='modal' data-target='#modalCompra' onclick=\"setValoresMovel({$values['id']}, '$preco', '{$values['nome']}', {$values['preco']}, {$values['qtd']});\"><span class=\"glyphicon glyphicon-shopping-cart\"></span></a>"; ?></td>
			</tr>
			

			
		<?php } ?>
		</tbody>
	</table>
</div>
<!-- Modal Compra-->
<div class="modal fade" id="modalCompra" tabindex="-1" role="dialog" aria-labelledby="modalCompra">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="trprecoTratadoue">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirmar Compra</h4>
			</div>
			<div class="modal-body">
				<form action="php/Funcoes.php" method="post">
					
					<div class="form-group">
						<label for="clientes">Cliente</label>
						<select name="inpIdCliente" id="clientes" class="form-control">
							<?php  
							require_once 'php/Cliente.php';
							@$clientes = listarClientes();
							foreach($clientes as $valueCliente){
								?>
								<option value="<?= $valueCliente['id']?>"><?= $valueCliente['nome']?></option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label>Produto</label>
							<input type="text" value="" readonly="false" class="form-control" id="inpNome">
						</div>

						<div class="form-group">
							<label>Preço</label>
							<input type="text" value="" readonly="false" class="form-control" id="inpPreco">
						</div>

						<div class="form-group">
							<label>Quantidade</label>
							<input type="number" min="1" max="" name="inpQtd" class="form-control" placeholder="Quantidade da compra" id="inpQtd">
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="acao" value="realizarCompra">
						<input type="hidden" name="idMovel" value="" id="idMovel">
						<input type="hidden" name="preco" value="" id="preco">

						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary" id='btnConf'>Confirmar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<!-- Fim Modal -->

<script>
	function setValoresMovel(id, precoTratado, nome, precoBanco, qtd){
		document.getElementById('inpPreco').value = "R$ "+precoTratado;
		document.getElementById('inpNome').value = nome;
		document.getElementById('inpQtd').max = qtd;
		document.getElementById('idMovel').value = id;
		document.getElementById('preco').value = precoBanco;

		if(qtd <= 0 ){
			document.getElementById('btnConf').disabled = true;
		}
	}

</script>


<?php require 'templates/footer.php' ?>