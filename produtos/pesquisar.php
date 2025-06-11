<?php
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con
	//Excluir o adm
	if( isset($_GET['op']) && isset($_GET['id']) ){
		if ($_GET['op'] == 'excluir'){
			$erro = 0;
			$msg = array();
			// Criar a query
			$id = $_GET['id'];
			$sql = "DELETE FROM produto WHERE proCod = $id";
			// Executar a query
			if ($con->query($sql) === TRUE)
				array_push($msg,"Produto excluído");
			else {
				$erro = 1;
				array_push($msg,"Operação não realizada!");
			}
		}
		if ($_GET['op'] == 'arquivar'){
			$erro = 0;
			$msg = array();
			$id = $_GET['id'];
			$sql = "UPDATE produto SET ativo = 0 WHERE proCod = $id";
			if ($con->query($sql) === TRUE)
			array_push($msg,"Produto arquivado");
			else {
				$erro = 1;
				array_push($msg,"Operação não realizada");
			}	
		}
	}
	?>
	<?php include('../cod/header.php');?>
	<?php 
	if (isset($msg)){
		foreach($msg as $item){ 
			if ($erro==1){
				?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?php echo $item ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>				
				<?php
			}else{
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
	<form action="pesquisar.php" method="get">		
		<h4>Pesquisar Produto</h4>
		<input class="form-control" id="myInput" type="text" placeholder="Pesquisar...">
		<br>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Cód.</th>
					<th>Nome</th>
					<th>Estoque</th>
					<th>Tipo</th>
					<th>Última alteração</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody id="myTable">
				<?php			
				// Criar a query
				$sql = "SELECT * FROM produto, usuario
				WHERE produto.usuId = usuario.usuId AND produto.ativo = 1";
				// Executar a query
				$result = $con->query($sql);
				if (mysqli_num_rows($result) < 1){
					echo "Nenhum resultado encontrado";
				} else {
					// Tratar o resultado
					while($row = mysqli_fetch_object($result)){
						$id_produto = $row->proCod;

						// Verificar se o produto está em entradas ou saídas
						$tem_relacao = false;

						$verifica_entrada = mysqli_query($con, "SELECT ent_proCod FROM entrada_produto WHERE proCod = $id_produto LIMIT 1");
						if (mysqli_num_rows($verifica_entrada) > 0) {
							$tem_relacao = true;
						}

						$verifica_saida = mysqli_query($con, "SELECT sai_proCod FROM saida_produto WHERE proCod = $id_produto LIMIT 1");
						if (mysqli_num_rows($verifica_saida) > 0) {
							$tem_relacao = true;
						}

						echo "
						<tr>
						<td>$row->proCod</td>
						<td>$row->proNome</td>	
						<td>$row->proQnt</td>	
						<td>$row->proTipo</td>
						<td>$row->usuNome</td>
						<td>
						<a class='btn btn-outline-info btn-sm' href='alterar.php?id=$row->proCod'> Alterar </a>";
						if ($tem_relacao) {
							echo "<a class='btn btn-outline-secondary btn-sm' href='pesquisar.php?op=arquivar&id=$row->proCod'> Arquivar </a>";
						} else {
							echo "<a class='btn btn-outline-danger btn-sm' href='pesquisar.php?op=excluir&id=$row->proCod' onclick='return confirm(\"Deseja excluir este produto permanentemente?\")' > Excluir </a>";
						}
						echo "</td>";
						echo "</tr>";
					}
				}
				?>
			</tbody>
		</table>
	</form>            
	<?php include('../cod/footer.php');?>
	<script>
		$(document).ready(function(){
			$("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
		});
	</script>