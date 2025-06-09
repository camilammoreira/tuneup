	<?php include_once('../cod/seg.php'); ?>
	<?php
	// Conectar com o banco
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con
	
	if (isset($_POST['submit'])){
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
		// Verificação de erro
		$erro = 0;
		$msg = array();

		$id = $_POST['id'];	

		// Inserir no banco
		$sql = "
		UPDATE fornecedor 
		SET forNome='$nome', forCNPJ='$cnpj', forRepresentante= '$representante', forFone='$telefone', forEmail='$email', forRua='$rua', forNumero='$numero', forBairro='$bairro', forCep='$cep', forCidade='$cidade', forEstado='$estado', usuId='$usuId'
		WHERE forCod = $id
		";

		if ($con->query($sql) === TRUE)
			header("Location: ./pesquisar.php");
		else{
			$erro = 1;
			array_push($msg,"Operação não realizada!");
		}
		
		echo $con->error;
	}

	?>
	<?php include('../cod/header.php');
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
	<?php

	$id = $_GET['id'];

		  //Criar a query

	$sql = "SELECT * FROM fornecedor WHERE forCod = $id";

		  // Executar a query

	$result = $con->query($sql);

		  // Tratei a consulta e joguei pra dentro do obj info

	$info = mysqli_fetch_object($result);

	?>

	<form action="alterar.php" method="post">

		<h4>Alterar Empresa</h4></br>

		<input type="hidden" value="<?php echo $id;?>" name="id"/>

		<div class="form-row">

			<div class="form-group col-md-9">

				<label for="nome">Nome</label>

				<input type="text" name="nome" class="form-control" value="<?php echo $info->forNome; ?>" required="required"/>

			</div>

			<div class="form-group col-md-3">

				<label for="inputCNPJ">CNPJ/CPF</label>

				<input type="text" name="cnpj" class="form-control" value="<?php echo $info->forCNPJ; ?>" required="required"/>

			</div>

		</div>

		<div class="form-row">

			<div class="form-group col-md-6">

				<label for="rep">Representante </label>

				<input type="text" name="representante" class="form-control" value="<?php echo $info->forRepresentante; ?>"/>

			</div>

			<div class="form-group col-md-3">

				<label for="tel">Telefone </label>

				<input type="tel" name="telefone" class="form-control" onkeypress="mascara(this, '## #####-####')" maxlength="12" value="<?php echo $info->forFone; ?>"/>

			</div>

			<div class="form-group col-md-3">

				<label for="email">E-mail </label>

				<input type="email" name="email" class="form-control" value="<?php echo $info->forEmail; ?>"/>

			</div>

		</div>

		<label for="end">Endereço</label>

		<div class="form-row">

			<div class="form-group col-md-7">

				<input type="text" name="rua" class="form-control" value="<?php echo $info->forRua; ?>" placeholder="Rua, Avenida.."/>

			</div>

			<div class="form-group col-md-2">

				<input type="text" name="numero" class="form-control" value="<?php echo $info->forNumero; ?>" placeholder="Número"/>

			</div>

			<div class="form-group col-md-3">

				<input type="text" name="bairro" class="form-control" value="<?php echo $info->forBairro; ?>" placeholder="Bairro"/>

			</div>

		</div>

		<div class="form-row">

			<div class="form-group col-md-6">

				<label for="inputCidade">Cidade</label>

				<input type="text" name="cidade" class="form-control" value="<?php echo $info->forCidade; ?>"/>

			</div>

			<div class="form-group col-md-4">

				<label for="inputState">Estado</label>

				<select name="estado" id="inputState" class="form-control">

					<option selected><?php echo $info->forEstado; ?></option>

					<option> AC</option>

					<option> AL</option>

					<option> AP</option>

					<option> AM</option>

					<option> BA</option>

					<option> CE</option>

					<option> DF</option>

					<option> ES</option>

					<option> GO</option>

					<option> MA</option>

					<option> MT</option>

					<option> MS</option>

					<option> MG</option>

					<option> PA</option>

					<option> PB</option>

					<option> PR</option>

					<option> PR</option>

					<option> PI</option>

					<option> RJ</option>

					<option> RN</option>

					<option> RS</option>

					<option> RO</option>

					<option> RR</option>

					<option> SC</option>

					<option> SP</option>

					<option> SE</option>

					<option> TO</option>

				</select>

			</div>

			<div class="form-group col-md-2">

				<label for="inputZip">CEP</label>

				<input type="text" name="cep" class="form-control" onkeypress="mascara(this, '#####-###')" maxlength="9" value="<?php echo $info->forCep; ?>"/>

			</div>

		</div>

		<button type="submit" class="btn btn-info float-right mt-1" name="submit">Alterar</button>

		<a class="btn btn-light float-right mt-1 mr-2" href="pesquisar.php" role="button">Cancelar</a>

	</form>
	
	<script language="JavaScript">

		function mascara(t, mask){

			var i = t.value.length;

			var saida = mask.substring(1,0);

			var texto = mask.substring(i)

			if (texto.substring(0,1) != saida){

				t.value += texto.substring(0,1);

			}

		}

	</script>

	<?php include('../cod/footer.php');?>