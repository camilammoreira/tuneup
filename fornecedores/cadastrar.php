<?php
include('../cod/header.php');

if (isset($_POST['submit'])) {
	// Conectar com o banco
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con

	// Recebe as variáveis do formulário
	$nome = $_POST['nome'];
	$cnpj = $_POST['cnpj'];
	$representante = $_POST['representante'];
	$telefone = $_POST['telefone'];
	$email = $_POST['email'];
	$rua = $_POST['rua'];
	$numero = $_POST['numero'];
	$bairro = $_POST['bairro'];
	$cep = $_POST['cep'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$usuId = $_SESSION['usuId'];

	$erro = 0;
	$msg = array();

	// Inserir no banco
	$sql = "
		INSERT INTO fornecedor (forNome, forRepresentante, forFone, forCNPJ, forEmail, forRua, forCep, forNumero, forBairro, forCidade, forEstado, usuId) 
		VALUES ('$nome','$representante','$telefone','$cnpj','$email','$rua','$cep','$numero','$bairro','$cidade','$estado','$usuId')
		";

	if ($con->query($sql) === TRUE)
		array_push($msg, "Operação realizada com sucesso!");
	else {
		$erro = 1;
		array_push($msg, "Operação não realizada!");
	}

	echo $con->error;
}
?>
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
<form action="cadastrar.php" method="post">
	<h4>Cadastrar Empresa</h4></br>
	<div class="form-group">
	</div>
	<div class="form-row">
		<div class="form-group col-md-9">
			<label for="nome">Nome</label>
			<input type="text" name="nome" class="form-control" id="nome" required="required">
		</div>
		<div class="form-group col-md-3">
			<label for="inputCNPJ">CNPJ/CPF</label>
			<input type="text" name="cnpj" class="form-control" id="cnpj" required="required">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="rep">Representante </label>
			<input type="text" name="representante" class="form-control" id="rep">
		</div>
		<div class="form-group col-md-3">
			<label for="tel">Telefone </label>
			<input type="text" name="telefone" class="form-control" onkeypress="mascara(this, '## ####-####')" maxlength="12">
		</div>
		<div class="form-group col-md-3">
			<label for="email">E-mail </label>
			<input type="email" name="email" class="form-control" id="email">
		</div>
	</div>
	<label for="end">Endereço</label>
	<div class="form-row">
		<div class="form-group col-md-7">
			<input type="text" name="rua" class="form-control" id="inputAddress" placeholder="Rua, Avenida..">
		</div>
		<div class="form-group col-md-2">
			<input type="text" name="numero" class="form-control" id="inputAddress" placeholder="Número">
		</div>
		<div class="form-group col-md-3">
			<input type="text" name="bairro" class="form-control" id="inputAddress" placeholder="Bairro">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="inputCidade">Cidade</label>
			<input type="text" name="cidade" class="form-control" id="inputCidade">
		</div>
		<div class="form-group col-md-4">
			<label for="inputState">Estado</label>
			<select name="estado" id="inputState" class="escolha form-control">
				<option></option>
				<option value="AC">Acre</option>
				<option value="AL">Alagoas</option>
				<option value="AP">Amapá</option>
				<option value="AM">Amazonas</option>
				<option value="BA">Bahia</option>
				<option value="CE">Ceará</option>
				<option value="DF">Distrito Federal</option>
				<option value="ES">Espírito Santo</option>
				<option value="GO">Goiás</option>
				<option value="MA">Maranhão</option>
				<option value="MT">Mato Grosso</option>
				<option value="MS">Mato Grosso do Sul</option>
				<option value="MG">Minas Gerais</option>
				<option value="PA">Pará</option>
				<option value="PB">Paraíba</option>
				<option value="PR">Paraná</option>
				<option value="PE">Pernambuco</option>
				<option value="PI">Piauí</option>
				<option value="RJ">Rio de Janeiro</option>
				<option value="RN">Rio Grande do Norte</option>
				<option value="RS">Rio Grande do Sul</option>
				<option value="RO">Rondônia</option>
				<option value="RR">Roraima</option>
				<option value="SC">Santa Catarina</option>
				<option value="SP">São Paulo</option>
				<option value="SE">Sergipe</option>
				<option value="TO">Tocantins</option>
			</select>
		</div>
		<div class="form-group col-md-2">
			<label for="inputZip">CEP</label>
			<input type="text" name="cep" class="form-control" onkeypress="mascara(this, '#####-###')" maxlength="9">
		</div>
	</div>
	<input type="submit" value="Cadastrar" class="btn btn-info float-right mt-1" name="submit">

</form>
<script language="JavaScript">
	function mascara(t, mask) {
		var i = t.value.length;
		var saida = mask.substring(1, 0);
		var texto = mask.substring(i)
		if (texto.substring(0, 1) != saida) {
			t.value += texto.substring(0, 1);
		}
	}
</script>
<?php include('../cod/footer.php'); ?>