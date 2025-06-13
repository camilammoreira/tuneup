<?php
include('../cod/header.php');
require_once('../cod/bdconexao.php'); ?>
<?php
if (isset($_POST['submit'])) {
	// Conectar com o banco
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con

	// Recebe as variáveis do formulário
	$nf = $_POST['nf'];
	$data = $_POST['data'];
	$empresa = $_POST['empresa'];

	$erro = 0;
	$msg = array();

	// Se não houver erro manda pro banco
	if (!$erro) {
		// Inserir no banco
		$sql = "
			INSERT INTO entrada (entNF, entData, entEmpresa) 
			VALUES ('$nf','$data','$empresa')
			";

		if ($con->query($sql) === TRUE) {
			array_push($msg, "Operação realizada com sucesso!");
		} else {
			$erro = 1;
			array_push($msg, "Operação não realizada!");
		}
	}
}
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
<form action="cadastrar-entrada.php" method="post">
	<h4>Registrar Entrada</h4></br>
	<div class="form-group">
		<label for="nf">Nº da Nota Fiscal</label>
		<input type="text" name="nf" class="form-control col-lg-3" id="nf" required>
	</div>
	<div class="form-row">
		<div class="form-group col-lg-3">
			<label>Data</label>
			<input type="text" name="data" class="form-control" id="data">
		</div>
		<div class="form-group col-lg-4">
			<label>Empresa</label>
			<select name="empresa" class="form-control">
				<option value="0">Escolha...</option>
				<?php
				$sql = "SELECT * FROM fornecedor ORDER BY forNome";
				$result = $con->query($sql);
				while ($row = mysqli_fetch_object($result))
					echo "<option value='$row->forCod'> $row->forNome</option>";
				?>
			</select>
		</div>
	</div>
	<input type="submit" name="submit" value="Cadastrar" class="btn btn-info float-right mt-1" />
	</br></br>
	<hr>
	<div class="p-2 col-lg-6 mx-auto">



		<div class="form-group">

			<label for="produto">Produto</label>

			<select name="produto" class="form-control">
				<option value="0">Escolha...</option>
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

				<input type="number" class="form-control" id="quantidade" />

			</div>

			<div class="form-group col-md-6">

				<label for="valor">Valor Unitário</label>

				<div class="input-group mb-3">

					<div class="input-group-prepend">

						<span class="input-group-text" id="basic-addon1">R$</span>

					</div>

					<input type="text" class="form-control" onKeyUp="maskIt(this,event,'###.###.###,##',true)" minlength="4" maxlength="13" size="13"
						aria-label="quantidade" aria-describedby="basic-addon1" dir="rtl">

				</div>

			</div>

		</div>

		<div class="text-right">

			<input type="submit" name="add-item" value="Adicionar item" class="btn btn-info float-right mt-1" />

			</br></br>
		</div>

</form>

</div>

<div><!--PRÉVIA-->

	<p><i>Registro de Nota Fiscal nº <?php echo $nf; ?>
			<?php
			if (isset($nome)) {
				echo "($nome)";
			}
			?>:
		</i></p>

	<table class="table table-houver">

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

			<tr class='row'>

				<td scope="col-xs-2 col-sm-2 col-md-2 col-lg-2"><!--QUANTIDADE-->

					<div class="input-group input-group-sm">

						<input type="number" class="form-control" value="15">

					</div>

				</td>

				<td scope="col-xs-3 col-sm-3 col-md-3 col-lg-3"><!--PRODUTO-->

					<div class="input-group input-group-sm">

						<select id="produto" class="form-control">

							<option>Escolha...</option>

							<option selected>Mouse Tal Tal Tal</option>

							<option>Teclado</option>

							<option>Monitor</option>

						</select>

					</div>

				</td>

				<td scope="col-xs-3 col-sm-3 col-md-3 col-lg-3"><!--EMPRESA-->

					<div class="input-group input-group-sm">

						<select id="empresa" class="form-control">

							<option>Escolha...</option>

							<option selected>Matrix Não Sei Oq LTDA</option>

							<option>Infodell</option>

							<option>Pasma</option>

						</select>

					</div>

				</td>

				<td scope="col-xs-3 col-sm-3 col-md-3 col-lg-3"><!--TOTAL-->

					<div class="input-group input-group-sm">

						<div class="input-group-prepend">

							<span class="input-group-text" id="inputGroup-sizing-sm">R$</span>

						</div>

						<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"
							value="100,00">

					</div>

				</td>

				<td scope="col-xs-1 col-sm-1 col-md-1 col-lg-1"><!--AÇÃO-->

					<button class="btn btn-sm btn-light" title="Excluir"><img src="../img/lixeira.png" alt="Excluir"></button>

					<button class="btn btn-sm btn-light" title="Editar"><img src="../img/Edit.png" alt="Editar"></button>

				</td>

			</tr>

		</tbody>

	</table>

	<div class="text-right">

		<input type="button" name="finalizar" value="Finalizar" class="btn btn-info text-right mt-1" />

	</div>

</div>

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