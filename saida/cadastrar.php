<?php include('../cod/header.php');
require_once('../cod/bdconexao.php');

$op = 'form1';

date_default_timezone_set('America/Sao_Paulo');
$dataHoje = date('Y-m-d');

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
		$sai_proCod = $_POST['sai_proCod'];
		$saiCod = intval($_POST['saiCod']);

		// Recupera os dados da saída para repor o estoque
		$sqlInfo = "SELECT proCod, saiQntProduto FROM saida_produto WHERE sai_proCod = $sai_proCod";
		$result = $con->query($sqlInfo);
		$info = $result->fetch_assoc();
		$proCod = $info['proCod'];
		$saiQnt = $info['saiQntProduto'];

		// Executa DELETE
		$sql = "DELETE FROM saida_produto WHERE sai_proCod = $sai_proCod";
		if (mysqli_query($con, $sql)) {
			// Repor estoque
			$sqlUpdate = "UPDATE produto SET proQnt = proQnt + $saiQnt WHERE proCod = $proCod";
			$con->query($sqlUpdate);
		} else {
			echo "Erro ao excluir: " . mysqli_error($con);
		}

	} elseif ($acao === 'alterar') {
		$msg = array();
		$erro = 0;

		$sai_proCod = $_POST['sai_proCod'];
		$novoProduto = intval($_POST['proCod']);
		$novaQuantidade = intval($_POST['saiQntProduto']);
		$setor = intval($_POST['setCod']);

		// 1. Buscar os dados antigos da saída
		$sqlAnterior = "SELECT proCod, saiQntProduto FROM saida_produto WHERE sai_proCod = $sai_proCod";
		$resultAnterior = $con->query($sqlAnterior);
		$anterior = $resultAnterior->fetch_assoc();
		$produtoAnterior = intval($anterior['proCod']);
		$qtdAnterior = intval($anterior['saiQntProduto']);

		// 2. Repor estoque do produto anterior
		$sqlRepor = "UPDATE produto SET proQnt = proQnt + $qtdAnterior WHERE proCod = $produtoAnterior";
		$con->query($sqlRepor);

		// 3. Verificar estoque do novo produto
		$sqlEstoque = "SELECT proQnt FROM produto WHERE proCod = $novoProduto";
		$resultEstoque = $con->query($sqlEstoque);
		$estoque = $resultEstoque->fetch_assoc();
		$estoqueAtual = intval($estoque['proQnt']);

		if ($estoqueAtual < $novaQuantidade) {
			$erro = 1;
			array_push($msg, "Erro: Estoque insuficiente para o novo produto. Apenas $estoqueAtual unidades disponíveis.");

			// Volta o que repôs antes (para manter integridade)
			$sqlDesfazerReposicao = "UPDATE produto SET proQnt = proQnt - $qtdAnterior WHERE proCod = $produtoAnterior";
			$con->query($sqlDesfazerReposicao);

		} else {
			// 4. Atualizar o registro
			$sqlUpdate = "UPDATE saida_produto 
						  SET proCod = $novoProduto, saiQntProduto = $novaQuantidade, setCod = $setor
						  WHERE sai_proCod = $sai_proCod";

			if ($con->query($sqlUpdate)) {
				// 5. Subtrair nova quantidade do estoque do novo produto
				$sqlDescontar = "UPDATE produto SET proQnt = proQnt - $novaQuantidade WHERE proCod = $novoProduto";
				$con->query($sqlDescontar);
				array_push($msg, "Produto alterado com sucesso.");
			} else {
				array_push($msg, "Erro ao atualizar produto: " . $con->error);

				// Volta o estoque original do produto anterior caso falhe
				$sqlReverterReposicao = "UPDATE produto SET proQnt = proQnt - $qtdAnterior WHERE proCod = $produtoAnterior";
				$con->query($sqlReverterReposicao);
			}
		}
	} else {

		// Recebe as variáveis do formulário
		$produto = $_POST['produto'];
		$qtd = $_POST['quantidade'];
		$setor = $_POST['setor'];

		$erro = 0;
		$msg = array();

		// Verificar se há estoque suficiente
		$sqlEstoque = "SELECT proQnt FROM produto WHERE proCod = $produto";
		$resultEstoque = $con->query($sqlEstoque);
		$rowEstoque = $resultEstoque->fetch_assoc();
		$estoqueAtual = intval($rowEstoque['proQnt']);

		if ($estoqueAtual < $qtd) {
			$erro = 1;
			array_push($msg, "Erro: Estoque insuficiente. Apenas $estoqueAtual unidades disponíveis.");
		}


		// Se não houver erro manda pro banco
		if (!$erro) {
			// Inserir no banco
			$sql = "
			INSERT INTO saida_produto (proCod, saiCod, setCod, saiQntProduto) 
			VALUES ($produto,$idSaida,$setor,$qtd)
			";

			if ($con->query($sql) === TRUE) {
				array_push($msg, "Produto cadastrado com sucesso");

				$sqlUpdate = "UPDATE produto SET proQnt = proQnt - $qtd WHERE proCod = $produto";
				$con->query($sqlUpdate);

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
			<input type="date" name="data" class="form-control col-lg-3" id="data" max="<?= $dataHoje ?>" required>
		</div>
		<div class=" form-group">
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
	<!--MOSTRA A PRÉVIA-->
	<div>
		<p><i>Prévia do Registro nº <?php echo $saiCod; ?>:</i></p>
		<table class="table">
			<thead>
				<tr>
					<th>Qnt.</th>
					<th>Produto</th>
					<th>Setor</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody id="registroSaida">
				<?php
				$sql = "
					SELECT * FROM saida_produto WHERE saiCod = $idSaida
					";
				$result = $con->query($sql);

				while ($row = mysqli_fetch_object($result)) {
					?>
					<tr>
						<form action="cadastrar.php" method="POST">
							<td class="col-sm-2"><!--QUANTIDADE-->
								<div class="input-group input-group-sm">
									<input type="number" name="saiQntProduto" class="form-control" value="<?php echo $row->saiQntProduto; ?>">
								</div>
							</td>
							<td class="col-sm-4"><!--PRODUTO-->
								<div class="input-group input-group-sm">
									<select id="produto" name='proCod' class="form-control">
										<?php
										$sql = "SELECT * FROM produto ORDER BY proNome";
										$result2 = $con->query($sql);
										while ($row2 = mysqli_fetch_object($result2)) {
											if ($row->proCod == $row2->proCod) {
												echo "<option value='$row2->proCod' selected> $row2->proNome</option>";
											} else {
												echo "<option value='$row2->proCod'> $row2->proNome</option>";
											}
										}
										?>
									</select>
								</div>
							</td>
							<td class="col-sm-4"><!--SETOR-->
								<div class="input-group input-group-sm">
									<select id="setor" name="setCod" class="form-control">
										<?php
										$sql = "SELECT * FROM setor ORDER BY setNome";
										$result2 = $con->query($sql);
										while ($row3 = mysqli_fetch_object($result2)) {
											if ($row->setCod == $row3->setCod) {
												echo "<option value='$row3->setCod' selected> $row3->setNome</option>";
											} else {
												echo "<option value='$row3->setCod'> $row3->setNome</option>";
											}
										}
										?>
									</select>
								</div>
							</td>
							<td class="col-sm-2"><!--AÇÃO-->
								<input type="hidden" name="op" value="form2" />
								<input type="hidden" name="saiCod" value="<?php echo $idSaida; ?>" />
								<input type="hidden" name="sai_proCod" value="<?php echo $row->sai_proCod; ?>" />

								<button type="submit" name="acao" value="alterar" class="btn btn-info btn-sm">
									<img src="../img/Edit.png" alt="Editar">
								</button>
								<button type="submit" name="acao" value="excluir" class="btn btn-danger btn-sm">
									<img src="../img/lixeira.png" alt="Excluir"></a>
								</button>
							</td>
						</form>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<div class=text-right>
			<input type="submit" value="Cancelar" class="btn btn-default text-right mt-1" disabled />
			<input type="submit" value="Finalizar" class="btn btn-info text-right mt-1" disabled />
		</div>

	</div>
<?php } ?>
<?php include('../cod/footer.php'); ?>