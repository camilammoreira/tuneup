<?php include('../cod/header.php');
require_once('../cod/bdconexao.php');

$op = 'form1';

if (isset($_POST['op']) && $_POST['op'] == 'form1') {
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con

	// Recebe as variáveis do formulário
	$cod = $_POST['saiCod'];
	$data = $_POST['data'];
	$descricao = $_POST['descricao'];
	$usuId = $_SESSION['usuId'];

	$erro = 0;
	$msg = array();

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	try {
		if (!$erro) {
			$sql = "
			INSERT INTO saida (saiCod, saiData, saiDescricao, usuId) 
			VALUES ('$cod','$data','$descricao','$usuId')
			";

			$con->query($sql);
			$op = 'form2';
			$idSaida = $con->insert_id;
		}
	} catch (mysqli_sql_exception $e) {
		if ($e->getCode() == 1062) { // 1062 = Duplicate entry
			$erro = 1;
			array_push($msg, "Código de saída já cadastrado");
		} else {
			$erro = 1;
			array_push($msg, "Erro ao cadastrar nova saída: " . $e->getMessage());
		}
	}
}

// OPÇÃO DE CADASTRO EDIÇÃO E EXCLUSÃO DE PRODUTOS
if (isset($_POST['op']) && $_POST['op'] == 'form2') {
	$op = $_POST['op'];
	// Conectar com o banco
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con

	$acao = $_POST['acao'] ?? '';
	$idSaida = $_POST['saiCod'];

	if ($acao === 'excluir') {
		$sait_proCod = $_POST['sai_proCod'];
		$saiCod = intval($_POST['saiCod']);
		$sql = "DELETE FROM saida_produto WHERE sai_proCod = $sai_proCod";
		if (mysqli_query($con, $sql)) {
			array_push($msg, "Produto excluído");
		} else {
			echo "Erro ao excluir: " . mysqli_error($con);
		}

	} elseif ($acao === 'alterar') {
		$produto = mysqli_real_escape_string($con, $_POST['produto']);
		$quantidade = intval($_POST['quantidade']);
		$setor = intval($con, $_POST['setor']);

		$sql = "UPDATE saida_produto 
				SET proCod = '$produto', quantidade = $quantidade, setor = $setor
				WHERE id = $sai_proCod";

		if (mysqli_query($con, $sql)) {
			header("Location: cadastrar.php?id=$saiCod");
		} else {
			echo "Erro ao atualizar: " . mysqli_error($con);
		}

	} else {

		// Recebe as variáveis do formulário
		$produto = $_POST['produto'];
		$qtd = $_POST['quantidade'];
		$setor = $_POST['setor'];

		$erro = 0;
		$msg = array();

		// Se não houver erro manda pro banco
		if (!$erro) {
			// Inserir no banco
			$sql = "
			INSERT INTO saida_produto (proCod, saiCod, setCod, saiQntProduto) 
			VALUES ($produto,$idSaida,$setor,$qtd)
			";

			if ($con->query($sql) === TRUE) {
				array_push($msg, "Produto cadastrado com sucesso");
			} else {
				$erro = 1;
				array_push($msg, "Operação não realizada");
			}
		}
	}

}


if (isset($msg)) {
	foreach ($msg as $item) {
		if ($erro == 1) {
			?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?php echo $item; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
		} else {
			?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<?php echo $item; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
		}
	}
}
?>
<?php
// SÓ MOSTRA SE NÃO FOR ADD O PRODUTO!!!
if ($op === 'form1') {
	?>
	<form action="cadastrar.php" method="post">
		<input type="hidden" name="op" value="form1" />
		<h4>Registrar Saída</h4></br>
		<div class="form-group">
			<label for="cod">Código Interno</label>
			<input type="text" name="saiCod" class="form-control col-lg-3" id="cod" required>
		</div>
		<div class="form-group">
			<label>Data</label>
			<input type="date" name="data" class="form-control col-lg-3" id="data" required>
		</div>
		<div class="form-group">
			<label for="nome">Descrição <small>(Opcional)</small></label>
			<input type="text" name="descricao" class="form-control" id="descricao">
		</div>
		<div class=text-right>
			<input type="submit" value="Cadastrar" class="btn btn-info text-right mt-1" />
		</div>
	</form>
	<?php
}

// SÓ MOSTRA SE FOR ADD O PRODUTO
if ($op === 'form2') {
	$sql = "SELECT * FROM saida WHERE saiCod = $idSaida";

	$result = $con->query($sql);
	$row = mysqli_fetch_object($result);
	$saiCod = $row->saiCod;
	$descricao = $row->saiDescricao;
	?>
	<div class="p-2 col-lg-6 mx-auto">
		<h4>Registro de Saída nº <?php echo $saiCod ?></h4>
		<p><?php echo $descricao ?></p>
		<form action="cadastrar.php" method="post">
			<input type="hidden" name="op" value="form2" />
			<input type="hidden" name="saiCod" value="<?php echo $saiCod; ?>" />
			<div class="form-group">
				<label for="produto">Produto</label>
				<select name="produto" class="form-control" required>
					<option></option>
					<?php
					$sql = "SELECT * FROM produto ORDER BY proNome";
					$result = $con->query($sql);
					while ($row = mysqli_fetch_object($result))
						echo "<option value='$row->proCod'> $row->proNome</option>";
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="setor">Setor</label>
				<select name="setor" class="form-control" required>
					<option></option>
					<?php
					$sql = "SELECT * FROM setor ORDER BY setNome";
					$result = $con->query($sql);
					while ($row = mysqli_fetch_object($result))
						echo "<option value='$row->setCod'> $row->setNome</option>";
					?>
				</select>
			</div>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="quantidade">Qnt.</label>
					<input type="number" min="1" name="quantidade" class="form-control" required />
				</div>
			</div>
			<div class=text-right>
				<input type="submit" value="Adicionar item" class="btn btn-info text-right mt-1" />
			</div>
		</form>
	</div>
	<div>
		<p><i>Prévia do Registro nº 00000 (nome):</i></p>
		<table class="table">
			<thead>
				<tr>
					<th>Qnt.</th>
					<th>Produto</th>
					<th>Setor</th>
					<th>V. Total</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody id="registroSaida">
				<tr>
					<td><!--QUANTIDADE-->
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" value="15" disabled>
						</div>
					</td>
					<td><!--PRODUTO-->
						<div class="input-group input-group-sm">
							<select id="produto" class="form-control" disabled>
								<option>Escolha...</option>
								<option selected>Mouse Tal Tal Tal</option>
								<option>Teclado</option>
								<option>Monitor</option>
							</select>
						</div>
					</td>
					<td><!--SETOR-->
						<div class="input-group input-group-sm">
							<select id="setor" class="form-control" disabled>
								<option>Escolha...</option>
								<option selected>Administração</option>
								<option>Almoxerifado</option>
								<option>Docentes</option>
							</select>
						</div>
					</td>
					<td><!--TOTAL-->
						<div class="input-group input-group-sm">
							<div class="input-group-prepend">
								<span class="input-group-text" id="inputGroup-sizing-sm">R$</span>
							</div>
							<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"
								value="100,00" disabled>
						</div>
					</td>
					<td><!--AÇÃO-->
						<button class="btn btn-sm btn-light float-left" title="Excluir" disabled><img src="../img/lixeira.png" alt="Excluir"></button>
						<button class="btn btn-sm btn-light float-left" title="Editar" disabled><img src="../img/Edit.png" alt="Editar"></button>
					</td>
				</tr>
				<tr>
					<td><!--QUANTIDADE-->
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="25"
								disabled>
						</div>
					</td>
					<td><!--PRODUTO-->
						<div class="input-group input-group-sm">
							<select id="produto" class="form-control" disabled>
								<option>Escolha...</option>
								<option>Mouse</option>
								<option selected>Teclado</option>
								<option>Monitor</option>
							</select>
						</div>
					</td>
					<td><!--SETOR-->
						<div class="input-group input-group-sm">
							<select id="setor" class="form-control" disabled>
								<option>Escolha...</option>
								<option selected>Administração</option>
								<option>Almoxerifado</option>
								<option selected>Docentes</option>
							</select>
						</div>
					</td>
					<td><!--TOTAL-->
						<div class="input-group input-group-sm">
							<div class="input-group-prepend">
								<span class="input-group-text" id="inputGroup-sizing-sm">R$</span>
							</div>
							<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"
								value="180,00" disabled>
						</div>
					</td>
					<td><!--AÇÃO-->
						<button class="btn btn-sm btn-light float-left" title="Excluir" disabled><img src="../img/lixeira.png" alt="Excluir"></button>
						<button class="btn btn-sm btn-light float-left" title="Editar" disabled><img src="../img/Edit.png" alt="Editar"></button>
					</td>
				</tr>
			</tbody>
		</table>
		<div class=text-right>
			<input type="submit" value="Cancelar" class="btn btn-default text-right mt-1" disabled />
			<input type="submit" value="Finalizar" class="btn btn-info text-right mt-1" disabled />
		</div>

	</div>
<?php } ?>
<?php include('../cod/footer.php'); ?>