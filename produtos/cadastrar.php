<?php
	require_once('../cod/seg.php');
	include('../cod/header.php');
?>
<?php
if (isset($_POST['submit'])){
	// Conectar com o banco
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con

	// Recebe as variáveis do formulário
	$nome = $_POST['nome'];
	$tipo = $_POST['tipo'];
	$qnt = $_POST['qnt'];
	$usuId = $_SESSION['usuId'];

	
	// Verificação de erro
	$erro = 0;
	$msg = array();
	
	// Se não houver erro manda pro banco
	if (!$erro){		
		// Inserir no banco
		$sql = "
		INSERT INTO produto (proNome, proTipo, proQnt, usuId) 
		VALUES ('$nome','$tipo', '$qnt','$usuId')
		";
		
		if ($con->query($sql) === TRUE)
			array_push($msg,"Operação realizada com sucesso!");
		else{
			$erro = 1;
			array_push($msg,"Operação não realizada!");
		}
	}
}
?>
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
	<form action="cadastrar.php" method="post">
		<h4>Cadastrar Produto</h4></br>
		<div class="form-row">
			<div class="form-group col-lg-7">
				<label for="nome">Nome</label>
				<input type="text" name="nome" class="form-control" id="nome" required>
			</div>
			<div class="form-group col-sm-2">
				<label for="qnt">Qnt. inicial (un)</label>
				<input type="number" name="qnt" class="form-control" id="qnt" required>
			</div>
			<div class="form-group col-lg-3">
				<label for="tipo">Tipo</label>
				</br>
				<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<label class="btn btn-light"><input name="tipo" type="radio" id="option1" value="Permanente" autocomplete="off" required /> Permanente </label>
						<label class="btn btn-light"><input name="tipo" type="radio" id="option2" value="Consumo" autocomplete="off" required /> Consumo</label>
				</div>
			</div>
		</div>
		<input type="submit" value="Cadastrar" class="btn btn-info float-right mt-1" name="submit">
	</form>
<?php include('../cod/footer.php');?>