<?php
require_once('../cod/seg.php');

// Conectar com o banco
require_once('../cod/bdconexao.php'); // gera o obj de conexão $con

if (isset($_POST['submit'])) {

	// Recebe as variáveis do formulário
	$nome = $_POST['nome'];
	$tipo = $_POST['tipo'];
	$usuId = $_SESSION['usuId'];

	// Verificação de erro
	$erro = 0;
	$msg = array();

	$id = $_POST['id'];

	// Inserir no banco
	$sql = "
		UPDATE produto 
		SET proNome='$nome', proTipo= '$tipo' , usuId='$usuId'
		WHERE proCod = $id

		";

	if ($con->query($sql) === TRUE)
		header("Location: pesquisar.php");

	echo $con->error;
}
?>

<?php include('../cod/header.php'); ?>

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

<?php

$id = $_GET['id'];
//Criar a query
$sql = "SELECT * FROM produto WHERE proCod = $id";

// Executar a query
$result = $con->query($sql);
// Tratei a consulta e joguei pra dentro do obj info
$info = mysqli_fetch_object($result);

?>
<form action="alterar.php" method="post">
	<h4>Alterar Produto</h4></br>
	<input type="hidden" value="<?php echo $id; ?>" name="id" />
	<div class="form-row">
		<input type="hidden" value="<?php echo $id; ?>" name="id" />
		<div class="form-group col-lg-12">
			<label for="nome">Nome</label>
			<input type="text" name="nome" class="form-control" id="nome" value="<?php echo $info->proNome; ?>" required="required">
		</div>
		<div class="form-group col-lg-6">
			<label for="tipo">Tipo</label><br>
			<div class="btn-group btn-group-toggle" data-toggle="buttons">
				<?php
				if ($info->proTipo == "Permanente") {
					?>
					<label class="btn btn-light active"><input name="tipo" type="radio" id="option1" value="Permanente" autocomplete="off" checked />
						Permanente </label>
					<label class="btn btn-light"><input name="tipo" type="radio" id="option2" value="Consumo" autocomplete="off" /> Consumo</label>
					<?php

				} else {
					?>
					<label class="btn btn-light"><input name="tipo" type="radio" id="option1" value="Permanente" autocomplete="off" /> Permanente</label>
					<label class="btn btn-light active"><input name="tipo" type="radio" id="option2" value="Consumo" autocomplete="off" checked />
						Consumo</label>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-info float-right mt-1" name="submit">Alterar</button>
	<a class="btn btn-light float-right mt-1 mr-2" href="pesquisar.php" role="button">Cancelar</a>
</form>
<?php include('../cod/footer.php'); ?>