<script src="https://use.fontawesome.com/4cbe07834d.js"></script>

<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">Bem 10</a>
		</div>
		<ul class="nav navbar-nav">
			<li><a href="index.php">Catálogo</a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i>&nbsp;<?= $_SESSION['nome'];?><span class="caret"></span></a>

				<ul class="dropdown-menu">
						
					<li><a href="pag_clientes.php"><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp; Clientes</a></li>

					<li><a href="pag_estoque.php"><i class="fa fa-table" aria-hidden="true"></i></i>&nbsp;Estoque</a></li>

					<li><a href="pag_historico.php"><i class="fa fa-history" aria-hidden="true"></i>&nbsp;Histório de vendas</a></li>

					<li><a href="pag_relatorio.php"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Gerar Relatório</a></li>

					<li><a href="php/Funcoes.php?acao=sair"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Sair</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>