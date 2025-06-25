<?php
require_once('../cod/bdconexao.php'); // gera o obj de conexão $con
//Excluir o fornecedor
if (isset($_GET['op']) && isset($_GET['id'])) {
	if ($_GET['op'] == 'excluir') {

		$erro = 0;
		$msg = array();

		// Criar a query
		$id = $_GET['id'];
		$sql = "DELETE FROM fornecedor WHERE forCod = $id";
		// Executar a query
		if ($con->query($sql) === TRUE)
			array_push($msg, "Operação realizada com sucesso!");
		else {
			$erro = 1;
			array_push($msg, "Operação não realizada!");
		}
	}
}
?>
<?php include('../cod/header.php'); ?>
<?php
if (isset($msg)) {
	foreach ($msg as $item) {
		if ($erro == 1) {
			?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?php echo $item ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
		} else {
			?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<?php echo $item ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
		}
	}
}
?>
<h4>Pesquisar Empresa</h4>
<input class="form-control" id="myInput" type="text" placeholder="Pesquisar...">
<br>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Código</th>
			<th>Nome</th>
			<th>CNPJ</th>
			<th>Cidade</th>
			<th>UF</th>
			<th>Última alteração</th>
			<th>Ação</th>
		</tr>
	</thead>
	<tbody id="myTable">
		<?php
		// Criar a query
		$sql = "SELECT * FROM fornecedor, usuario
			WHERE fornecedor.usuId = usuario.usuId ";
		// Executar a query
		$result = $con->query($sql);
		if (mysqli_num_rows($result) < 1) {
			echo "Resultados não encontrados!";
		} else {

			// Tratar o resultado
			while ($row = mysqli_fetch_object($result)) {
				echo "
					<tr>
					<td>$row->forCod</td>
					<td>$row->forNome</td>
					<td>$row->forCNPJ</td>
					<td>$row->forCidade</td>
					<td>$row->forEstado</td>
					<td>$row->usuNome</td>
					<td>
					<a class='btn btn-outline-info btn-sm' href='alterar.php?id=$row->forCod'> Alterar </a>
					<a class='btn btn-outline-danger btn-sm' href='pesquisar.php?op=excluir&id=$row->forCod'> Excluir </a>
					</td>
					</tr>					
					";
			}
		}
		?>
	</tbody>
</table>

<?php include('../cod/footer.php'); ?>
<script>
	$(document).ready(function () {
		$("#myInput").on("keyup", function () {
			var value = $(this).val().toLowerCase();
			$("#myTable tr").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});
</script>