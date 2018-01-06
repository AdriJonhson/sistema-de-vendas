<?php require 'templates/header.php'; ?>
<?php  
	//Verificando se o usuário está logado
	if(!(isset($_SESSION['id_vendedor']))){
		header("Location: login.php");
	}


	//Vai aplicar o filtro escolhido no select
	require_once 'php/Connection.php';

	$tipoBusca = filter_input(INPUT_POST, 'tipoBusca');
	$dataBusca = filter_input(INPUT_POST, 'inpData');

	$con = startConnection();
	$stmt = $con->prepare("SELECT v.id AS idV, u.nome AS nomeU, m.nome AS nomeM, v.data_venda AS data, v.qtd AS qtd, v.total AS total, c.nome AS nomeC FROM vendas AS v
	JOIN moveis AS m ON m.id = v.id_movel
	JOIN clientes AS c ON c.id = v.id_cliente
	JOIN users AS u ON u.id = v.id_vendedor ORDER BY nomeM ASC");

	if($tipoBusca == "buscarTudo"){

		$stmt = $con->prepare("SELECT v.id AS idV, u.nome AS nomeU, m.nome AS nomeM, v.data_venda AS data, v.qtd AS qtd, v.total AS total, c.nome AS nomeC FROM vendas AS v
		JOIN moveis AS m ON m.id = v.id_movel
		JOIN clientes AS c ON c.id = v.id_cliente
		JOIN users AS u ON u.id = v.id_vendedor ORDER BY nomeM ASC");

	}elseif($tipoBusca == "buscarVendasMes"){
		$mesAtual = date("m");
		$anoAtual = date("Y");
		$stmt = $con->prepare("SELECT v.id AS idV, u.nome AS nomeU, m.nome AS nomeM, v.data_venda AS data, v.qtd AS qtd, v.total AS total, c.nome AS nomeC FROM vendas AS v
		JOIN moveis AS m ON m.id = v.id_movel
		JOIN clientes AS c ON c.id = v.id_cliente
		JOIN users AS u ON u.id = v.id_vendedor
		WHERE MONTH(v.data_venda) = ? AND YEAR(v.data_venda) = ? ORDER BY nomeM ASC");

		$stmt->bindValue(1, $mesAtual);
		$stmt->bindValue(2, $anoAtual);
	
	}elseif($tipoBusca == "buscarData"){
		$stmt = $con->prepare("SELECT v.id AS idV, u.nome AS nomeU, m.nome AS nomeM, v.data_venda AS data, v.qtd AS qtd, v.total AS total, c.nome AS nomeC FROM vendas AS v
		JOIN moveis AS m ON m.id = v.id_movel
		JOIN clientes AS c ON c.id = v.id_cliente
		JOIN users AS u ON u.id = v.id_vendedor
		WHERE v.data_venda = ? ORDER BY nomeM ASC");
		$stmt->bindValue(1, $dataBusca);
	}

	$stmt->execute();

	while($row = $stmt->fetch()){
		$vendas[] = $row;
	}

	@$qtdVendas = count($vendas);

	function inverterData($data){
		$data = explode("-", $data);
		$novaData = $data[2]."/".$data[1]."/".$data[0];
		return $novaData;
	}

?>

<?php require 'templates/navbar.php'; ?>

<div class="container-fluid">

	<h2>Histórico de Vendas</h2>
	
	<div class="row">
		<form action="" method="POST">
			<div class="input-group">
				<select name="tipoBusca" class="form-control">
					<option value="buscarTudo">Todas as Vendas</option>
					<option value="buscarVendasMes">Vendas do mês</option>
					<option value="buscarData">Escolher a data</option>
				</select>
				<span class="input-group-btn">
					<input type="hidden" name="acao" value="buscarVendas">
					<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th>Cod. Venda</th>
				<th>Vendedor</th>
				<th>Cliente</th>
				<th>Móvel</th>
				<th>Quantidade</th>
				<th>Total</th>
				<th>Data da venda</th>
			</tr>
		</thead>

		<tbody>
			<?php if($qtdVendas == 0){ ?>
				<tr>
					<td colspan="6" align="center"><strong>Nenhuma Venda</strong></td>
				</tr>
			<?php }else{ ?>
			<?php 
				foreach($vendas as $values){
				$total = number_format($values['total'],2,',','.');
			?>
				<tr>
					<td><?= $values['idV'] ?></td>
					<td><?= $values['nomeU'] ?></td>
					<td><?= $values['nomeC'] ?></td>
					<td><?= $values['nomeM'] ?></td>
					<td><?= $values['qtd'] ?></td>
					<td><?= "R$ ".$total ?></td>
					<td><?= inverterData($values['data']) ?></td>
				</tr>
			<?php } ?>
			<?php } ?>
		</tbody>
	</table>

</div>

<!-- Modal Data -->
<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Histórico de Vendas</h4>
      </div>
      <div class="modal-body">
	        <div class="form-group">
	        	<input type="date" name="inpData" class="form-control">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Fim Modal -->

<script>
	$('select').on('change', function () {
		if ($(this).val() == "buscarData") {
			$('#modalData').modal('show');
		}
	});
</script>

<?php require 'templates/footer.php' ?>