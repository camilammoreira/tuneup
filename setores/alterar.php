	<?php include_once('../cod/seg.php'); ?>
	<?php
	// Conectar com o banco
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con
	
	if (isset($_POST['submit'])){
		// Recebe as variáveis do formulário
		$nome = $_POST['nome'];
		$responsavel = $_POST['responsavel'];
		$telefone = $_POST['telefone'];
		$email = $_POST['email'];
		$usuId = $_SESSION['usuId'];
		// Verificação de erro
		$erro = 0;
		$msg = array();

		$id = $_POST['id'];	

		// Inserir no banco
		$sql = "
		UPDATE setor 
		SET setNome='$nome', setResponsavel= '$responsavel', setFone='$telefone', setEmail='$email', usuId='$usuId'
		WHERE setCod = $id
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
	$sql = "SELECT * FROM setor WHERE setCod = $id";
	// Executar a query
	$result = $con->query($sql);
	// Tratei a consulta e joguei pra dentro do obj info
	$info = mysqli_fetch_object($result);
	?>

	<form action="alterar.php" method="post">
		<h4>Alterar Setor</h4></br>
		<div class="form-group">
			<input type="hidden" value="<?php echo $id;?>" name="id"/>
			<div class="form-row">
				<input type="hidden" value="<?php echo $id;?>" name="id"/>
				<div class="form-group col-md-12">
					<label for="nome">Nome</label>
					<input type="text" name="nome" class="form-control" id="nome" maxlength="100" value="<?php echo $info->setNome; ?>" required>
				</div>
			</div>
			<label for="end">Contato</label>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="tel">Telefone do Setor</label>
					<input type="text" name="telefone" class="form-control" onkeypress="mascara(this, '## #####-####')" maxlength="13" value="<?php echo $info->setFone; ?>" >
				</div>
				<div class="form-group col-md-4">
					<label for="email">E-mail do Setor</label>
					<input type="email" name="email" class="form-control" id="email" maxlength="40" value="<?php echo $info->setEmail; ?>" >
				</div>
				<div class="form-group col-md-5">
					<label for="responsavel">Responsável</label>
					<input type="text" name="responsavel" class="form-control" id="responsavel" maxlength="100" value="<?php echo $info->setResponsavel; ?>" >
				</div>
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