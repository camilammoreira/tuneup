<?php
include('../cod/header.php');
require_once('../cod/bdconexao.php'); ?>
<?php

// op valores:
// op = 'NF' parte de inserir nota fiscal
// op = 'PR' parte de inserir produto

$op = 'NF';

// OPÇÃO DE CADASTRO DE NOTA FISCAL!!!
if (isset($_POST['op']) && $_POST['op'] == 'NF') {
	$op = $_POST['op'];
	// Conectar com o banco
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con

	// Recebe as variáveis do formulário
	$nf = $_POST['nf'];
	$data = $_POST['data'];
	$fornecedor = $_POST['fornecedor'];
	$usuId = $_SESSION['usuId'];

	$erro = 0;
	$msg = array();

	// VALIDA NUMERO DE NOTA FISCAL
	function validarNF($nf)
	{
		// Verifica se tem exatamente 44 dígitos numéricos
		if (!preg_match('/^\d{44}$/', $nf)) {
			return false;
		}

		$corpo = substr($nf, 0, 43);
		$dvInformado = intval(substr($nf, -1));
		$dvCalculado = calcularDV($corpo);

		return $dvInformado === $dvCalculado;
	}

	function calcularDV($chave43)
	{
		$pesos = [2, 3, 4, 5, 6, 7, 8, 9];
		$soma = 0;
		$len = strlen($chave43);

		// Inverte a string e aplica os pesos da direita para a esquerda
		for ($i = 0; $i < $len; $i++) {
			$digito = intval($chave43[$len - 1 - $i]);
			$peso = $pesos[$i % count($pesos)];
			$soma += $digito * $peso;
		}

		$resto = $soma % 11;
		$dv = 11 - $resto;
		return ($dv >= 10) ? 0 : $dv;
	}

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	try {
		if (!$erro) {
			$sql = "
			INSERT INTO entrada (entNF, entData, entFornecedor, usuId) 
			VALUES ('$nf','$data','$fornecedor','$usuId')
			";

			$con->query($sql); // Aqui pode lançar exceção se NF já existe
			$op = 'PR';
			$idNOTA = $con->insert_id;
		}
	} catch (mysqli_sql_exception $e) {
		if ($e->getCode() == 1062) { // 1062 = Duplicate entry
			$erro = 1;
			array_push($msg, "Nota fiscal já cadastrada");
		} else {
			$erro = 1;
			array_push($msg, "Erro ao cadastrar nota fiscal: " . $e->getMessage());
		}
	}

}

// OPÇÃO DE CADASTRO EDIÇÃO E EXCLUSÃO DE PRODUTOS
if (isset($_POST['op']) && $_POST['op'] == 'PR') {
	$op = $_POST['op'];
	// Conectar com o banco
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con

	$acao = $_POST['acao'] ?? '';
	$idNOTA = $_POST['nf'];

	if ($acao === 'excluir') {
		$ent_proCod = $_POST['ent_proCod'];
		$entCod = intval($_POST['entCod']);
		$sql = "DELETE FROM entrada_produto WHERE ent_proCod = $ent_proCod";
		if (mysqli_query($con, $sql)) {
			// array_push($msg,"PRODUTO excluido com sucesso!");
			// header("Location: cadastar.php?id=$entCod");
		} else {
			echo "Erro ao excluir: " . mysqli_error($con);
		}

	} elseif ($acao === 'alterar') {
		$produto = mysqli_real_escape_string($con, $_POST['produto']);
		$quantidade = intval($_POST['quantidade']);
		$valor = intval($con, $_POST['valor']);

		$sql = "UPDATE entrada_produto 
				SET nome_produto = '$produto', quantidade = $quantidade, valor = $valor
				WHERE id = $ent_proCod";

		if (mysqli_query($con, $sql)) {
			header("Location: cadastrar.php?id=$entCod");
		} else {
			echo "Erro ao atualizar: " . mysqli_error($con);
		}

	} else {

		// Recebe as variáveis do formulário
		$produto = $_POST['produto'];
		$qtd = $_POST['quantidade'];
		$valor = $_POST['valor'];
		$valor = str_replace(".", "", $valor);
		$valor = str_replace(",", ".", $valor);

		$erro = 0;
		$msg = array();

		// Se não houver erro manda pro banco
		if (!$erro) {
			// Inserir no banco
			$sql = "
			INSERT INTO entrada_produto (proCod, entCod, entValorProduto,entQntProduto) 
			VALUES ($produto,$idNOTA,$valor,$qtd)
			";

			if ($con->query($sql) === TRUE) {
				array_push($msg, "PRODUTO cadastrado com sucesso!");
			} else {
				$erro = 1;
				array_push($msg, "Operação não realizada!");
			}
		}
	}

}
// //ALTERA A LINHA
// if (isset($_POST['alt-item'])){
// 	// Recebe as variáveis do formulário
// 	$produto = $_POST['produto'];
// 	$qtd = $_POST['quantidade'];
// 	$valor = $_POST['valor'];
// 	$valor = str_replace(".","",$valor);
// 	$valor = str_replace(",",".",$valor);
// 	$idNOTA = $_POST['nf'];
// 	// Verificação de erro
// 	$erro = 0;
// 	$msg = array();

// 	$id = $_POST['id'];	

// 	// Inserir no banco
// 	$sql = "
// 	UPDATE entrada_produto 
// 	SET proCod='$produto', entCod='$idNOTA', entValorProduto= '$valor', entQntProduto='$qtd'
// 	WHERE ent_proCod = $id
// 	";

// 	if ($con->query($sql) === TRUE)
// 		header("Location: pesquisar.php");
// 	else{
// 		$erro = 1;
// 		array_push($msg,"Operação não realizada!");
// 	}

// 	echo $con->error;
// }
// //EXCLUI A LINHA
// if(isset($_POST['']) && isset($_GET['id']) ){
// 	if ($_GET['op2'] == 'excluir'){
// 		$erro = 0;
// 		$msg = array();
// 		// Criar a query
// 		$id = $_GET['id'];
// 		$sql = "DELETE FROM entrada_produto WHERE proCod = $id";
// 		// Executar a query
// 		if (mysqli_query($conexao, $sql)) {
// 			// Redireciona de volta para a página da nota
// 			$id_entrada = intval($_POST['entCod']);
// 			header("Location: cadastrar.php?id=entCod");
// 			exit();
// 		// if ($con->query($sql) === TRUE)
// 		// 	array_push($msg,"Produto excluído da nota fical");
// 		} else {
// 			$erro = 1;
// 			array_push($msg,"Erro ao excluir produto: " . $e->getMessage());
// 		}
// 	}
// }



?>

<?php
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
if ($op != 'PR') {
	?>

	<form action="cadastrar.php" method="post">
		<!-- OPÇÃO DE CADASTRAR!!! -->
		<input type="hidden" name="op" value="NF" />
		<h4>Registrar Entrada</h4></br>
		<div class="form-group">
			<label for="nf">Nº da Nota Fiscal</label>
			<input type="number" name="nf" class="form-control col-lg-5" id="nf" required>
		</div>
		<div class="form-group">
			<label>Data</label>
			<input type="date" name="data" class="form-control col-lg-5" id="data" required>
		</div>
		<div class="form-group">
			<label>Fornecedor</label></br>
			<select name="fornecedor" class="escolha form-control col-lg-5" required>
				<option></option>
				<?php
				$sql = "SELECT * FROM fornecedor ORDER BY forNome";
				$result = $con->query($sql);
				while ($row = mysqli_fetch_object($result))
					echo "<option value='$row->forCod'> $row->forNome</option>";
				?>
			</select>
		</div>
		<input type="submit" name="submit" value="Cadastrar" class="btn btn-info float-right mt-1" />
	</form>

	<?php
}
// SÓ MOSTRA SE FOR ADD O PRODUTO!!!
if ($op == 'PR') {
	$sql = "SELECT * FROM entrada WHERE entCod = $idNOTA";

	$result = $con->query($sql);
	$row = mysqli_fetch_object($result);
	$nf = $row->entNF;
	?>
	<h4>Nota Fiscal nº <?php echo $nf ?></h4>
	<form action="cadastrar.php" method="post">
		<div class="p-2 col-lg-6 mx-auto">
			<!-- SALVA NO FORM A OPÇÃO DO PRODUTO!!! -->
			<input type="hidden" name="op" value="PR" />
			<!-- SALVA O ID DA NOTA FISCAL!!! -->
			<input type="hidden" name="nf" value="<?php echo $idNOTA; ?>" />
			<div class="form-group">
				<label for="produto">Produto</label>
				<select name="produto" class="escolha form-control" required>
					<option></option>
					<?php
					$sql = "SELECT * FROM produto ORDER BY proNome";
					$result = $con->query($sql);
					while ($row = mysqli_fetch_object($result))
						echo "<option value='$row->proCod'> $row->proNome</option>";
					?>
				</select>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="quantidade">Qnt.</label>
					<input type="number" min="1" name='quantidade' class="form-control" id="quantidade" required />
				</div>
				<div class="form-group col-md-6">
					<label for="valor">Valor Unitário</label>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1">R$</span>
						</div>
						<input type="text" name='valor' class="form-control" onKeyUp="maskIt(this,event,'###.###.###,##',true)" minlength="4"
							maxlength="13" size="13" aria-label="quantidade" aria-describedby="basic-addon1" dir="rtl" required>
					</div>
				</div>
			</div>
			<div class="text-right">
				<input type="submit" name="add-item" value="Adicionar item" class="btn btn-info text-right mt-1" />
			</div>
		</div>
	</form>

	<!--MOSTRA A PRÉVIA-->
	<p><i>Registro de Nota Fiscal nº <?php echo $nf ?>:</i></p>
	<form action="cadastrar.php" method="post">
		<table class="table">
			<thead>
				<tr>
					<th>Qnt.</th>
					<th>Produto</th>
					<th>Valor Un.</th>
					<th>Total</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody id="registroEntrada">
				<?php
				$sql = "
				SELECT * FROM entrada_produto WHERE entCod = $idNOTA
				";
				$result = $con->query($sql);

				while ($row = mysqli_fetch_object($result)) {
					?>
					<tr>
						<form action="cadastrar.php" method="POST">
							<td>
								<div class="input-group input-group-sm">
									<input type="number" name="quantidade" class="form-control col-sm-5" value="<?php echo $row->entQntProduto; ?>">
								</div>
							</td>
							<td><!--PRODUTO-->
								<div class="input-group input-group-sm">
									<select name="produto" class="escolha form-control">
										<option></option>
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
							<td>
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text" id="inputGroup-sizing-sm">R$</span>
									</div>
									<input type="text" name="valor" class="form-control" onKeyUp="maskIt(this,event,'###.###.###,##',true)" minlength="4"
										maxlength="13" size="13" aria-label="quantidade" aria-describedby="basic-addon1" dir="rtl"
										value="<?php echo number_format($row->entValorProduto, 2, ",", "."); ?>">
								</div>
							</td>
							<td>
								<?php
								$vtotal = $row->entValorProduto * $row->entQntProduto;
								echo "R$" . number_format($vtotal, 2, ",", ".");
								?>
							</td>
							<td>
								<input type="hidden" name="op" value="PR" />
								<input type="hidden" name="nf" value="<?php echo $idNOTA; ?>" />
								<input type="hidden" name="entCod" value="<?php echo $idNOTA; ?>" />
								<input type="hidden" name="ent_proCod" value="<?php echo $row->ent_proCod; ?>" />

								<button type="submit" name="acao" value="alterar" class="btn btn-info btn-sm">
									<img src="../img/Edit.png" alt="Editar">
								</button>
								<button type="submit" name="acao" value="excluir" class="btn btn-danger btn-sm">
									<img src="../img/lixeira.png" alt="Excluir"></a>
								</button>
						</form>

		</form>
		</td>
		</tr>
		<?php
				}
				?>



	</tbody>

	</table>
	<?php
}
?>

<?php include('../cod/footer.php'); ?>

<script type="text/javascript">
	function maskIt(w, e, m, r, a) {
		// Cancela se o evento for Backspace
		if (!e) var e = window.event
		if (e.keyCode) code = e.keyCode;
		else if (e.which) code = e.which;

		// Variáveis da função
		var txt = (!r) ? w.value.replace(/[^\d]+/gi, '') : w.value.replace(/[^\d]+/gi, '').reverse();
		var mask = (!r) ? m : m.reverse();
		var pre = (a) ? a.pre : "";
		var pos = (a) ? a.pos : "";
		var ret = "";
		if (code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g, '').length) return false;

		// Loop na máscara para aplicar os caracteres
		for (var x = 0, y = 0, z = mask.length; x < z && y < txt.length;) {
			if (mask.charAt(x) != '#') {
				ret += mask.charAt(x); x++;
			}
			else {
				ret += txt.charAt(y); y++; x++;
			}
		}

		// Retorno da função
		ret = (!r) ? ret : ret.reverse()
		w.value = pre + ret + pos;
	}

	// Novo método para o objeto 'String'
	String.prototype.reverse = function () {
		return this.split('').reverse().join('');
	};
</script>
<script language="javascript">
	function number_format(number, decimals, dec_point, thousands_sep) {
		var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
		var d = dec_point == undefined ? "," : dec_point;
		var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
		var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	}
</script>
<script>
	function calcula(operacion) {
		var valor = parseFloat(document.calc.valor.value.replace(/\./g, "").replace(",", "."));
		var result = eval(valor * quantidade);
		document.calc.resultado.value = number_format(result, 2, ',', '.');
	} 
</script>