<?php
	include('../cod/header.php');

	if (isset($_POST['submit'])){
		// Conectar com o banco
		require_once('../cod/bdconexao.php'); // gera o obj de conexão $con
	
		// Recebe as variáveis do formulário
		$nome = $_POST['nome'];
		$responsavel = $_POST['responsavel'];
		$telefone = $_POST['telefone'];
		$email = $_POST['email'];
		$usuId = $_SESSION['usuId'];
		
		$erro=0;
		$msg = array();

		// Verifica se já existe um setor com esse nome
		$sql_verifica = "SELECT setCod FROM setor WHERE setNome = '$nome'";
		$result_verifica = $con->query($sql_verifica);

		if ($result_verifica->num_rows > 0) {
			$erro = 1;
			array_push($msg, "Já existe um setor cadastrado com esse nome");
		} else {
			// Se não existir, faz o INSERT (ou UPDATE)
			$sql = "
			INSERT INTO setor (setNome, setResponsavel, setFone, setEmail, usuId) 
			VALUES ('$nome','$responsavel','$telefone','$email','$usuId')"; // ou seu UPDATE

			if ($con->query($sql) === TRUE) {
				array_push($msg, "Operação realizada com sucesso");
			} else {
				$erro = 1;
				array_push($msg, "Operação não realizada: " . $con->error);
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
		<h4>Cadastrar Setor</h4></br>
		<div class="form-group">
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="nome">Nome</label>
					<input type="text" name="nome" class="form-control" id="nome" maxlength="100" required>
				</div>
			</div>
			<label for="end">Contato</label>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="tel">Telefone do Setor</label>
					<input type="text" name="telefone" class="form-control" onkeypress="mascara(this, '## #####-####')" maxlength="13">
				</div>
				<div class="form-group col-md-4">
					<label for="email">E-mail do Setor</label>
					<input type="email" name="email" class="form-control" id="email" maxlength="40">
				</div>
				<div class="form-group col-md-5">
					<label for="responsavel">Responsável</label>
					<input type="text" name="responsavel" class="form-control" id="responsavel" maxlength="100">
				</div>
			</div>
		</div>
		<input type="submit" value="Cadastrar" class="btn btn-info float-right mt-1" name="submit">
	</form>
	<script language="JavaScript">
		function mascara(t, mask){
			const i = t.value.length;
			const saida = mask.substring(1,0);
			LargestContentfulPaint
			const texto = mask.substring(i)
			if (texto.substring(0,1) != saida){
				t.value += texto.substring(0,1);
			}
		}
	</script>
<?php include('../cod/footer.php');?>