<?php
require_once('cod/bdconexao.php'); // gera o obj de conexão $con
// If upload button is clicked ...
if (isset($_POST['upload'])) {
	// Get image name
	$image = $_FILES['image']['name'];

	// image file directory
	$target = "images/" . basename($image);

	$sql = "INSERT INTO aluno (image) VALUES ('$image')";
	// execute query
	mysqli_query($db, $sql);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		$msg = "Image uploaded successfully";
	} else {
		$msg = "Failed to upload image";
	}
}
$result = mysqli_query($con, "SELECT * FROM aluno");

if (isset($_POST['submit'])) {		// Conectar com o banco
	require_once('cod/bdconexao.php'); // gera o obj de conexão $con

	// Recebe as variáveis do formulário
	$nome = $_POST['nome'];
	//$nomeSocial = $_POST['nomeSocial'];
	$cpf = $_POST['cpf'];
	$rg = $_POST['rg'];
	//$genero = $_POST['genero'];
	$data = $_POST['data'];
	$telefone = $_POST['telefone'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$ensino = $_POST['ensino'];
	$campus = $_POST['campus'];
	$matricula = $_POST['matricula'];
	$curso = $_POST['curso'];
	//$foto = $_FILES['foto'];
	$prefixo = $_POST['prefixo'];
	$ano = $_POST['ano'];
	$cod = "$prefixo-$ano";
	$usuId = $_SESSION['usuId'];

	$erro = 0;
	$msg = array();
	$error = 0;

	//aqui tava o outro codigo de upload

	// Inserir no banco
	$sql = "
	INSERT INTO aluno 				
	(aluNome, aluNomeSocial, aluCPF, aluRG, aluGenero, aluData, aluTelefone, aluCidade, aluEstado, aluEnsino, aluCampus, aluMatricula, aluCurso, aluFoto, aluCodUso, aluAno) 
	VALUES ('$nome','$nomeSocial','$cpf','$rg','$genero','$data','$telefone','$cidade','$estado','$ensino','$campus','$matricula','$curso','$image','$cod','$ano')
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
<!doctype html>
<html lang="pt-BR>  
<head>    
	<!-- Required meta tags -->    
	<meta charset=" utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
	integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<title>CIE IFNMG | Cadastrar</title>
</head>

<body>
	<?php include('cod/navbar.php'); ?>
	<div class="container mt-4 mx-auto col-lg-8 shadow p-4 mb-4 bg-white">
		<?php
		if (isset($msg)) {
			foreach ($msg as $item) {
				if ($erro == 1) { ?>
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
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php
				}
			}
		}
		?>
		<h4>Cadastar nova carteirinha</h4>
		<br />
		<form action="cadastrar.php" method="post">
			<h6>INFORMAÇÕES PESSOAIS</h6>
			<div class="form-group">
				<label>Nome*</label>
				<input type="text" name="nome" style="text-transform:uppercase" class="form-control" minlength="5" placeholder="Nome completo"
					class="form-control" maxlength="50" required>
			</div>
			<!--
				<div id="nomeSocial" class="form-group" style="display:none;">			
				<label>Nome Social</label>				
				<input type='text' name='nomeSocial' class='form-control' minlength='5' placeholder='Nome social' class='form-control' maxlength='50' required>			
			</div>	
			<div class="form-row">				
				<div id="genero" class="form-group col-md-3">				
					<label>Gênero*</label>					
					<select id="genero" name="genero" class="form-control"  required>						
						<option value="" selected>Selecione..</option>						
						<option value="Feminino">Feminino</option>						
						<option value="Masculino">Masculino</option>						
						<option value="Transexual">Transexual</option>						
						<option value="Travesti">Travesti</option>					
					</select>				
				</div>
			-->
			<div class="form-row">
				<div class="form-group col-md-3">
					<label>Data de Nascimento*</label>
					<input type="date" name="data" class="form-control" onkeypress="mascara(this, '##/##/####')" minlength="10" maxlength="10"
						required>
				</div>
				<div class="form-group col-md-3">
					<label>CPF*</label>
					<input type="text" name="cpf" class="form-control" onkeypress="mascara(this, '###.###.###-##')" minlength="14" maxlength="14"
						required>
				</div>
				<div class="form-group col-md-3">
					<label>RG*</label>
					<input type="text" name="rg" class="form-control" maxlength="20" required>
				</div>
			</div>
			<br />
			<h6>CONTATO (opcional)</h6>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label>Telefone</label>
					<input type="text" name="telefone" class="form-control" placeholder="Formato: 99 9999-9999"
						onkeypress="mascara(this, '## ####-####')" maxlength="12">
				</div>
				<div class="form-group col-md-4">
					<label>Cidade</label>
					<input type="text" name="cidade" minlength="5" class="form-control" maxlength="50" />
				</div>
				<div class="form-group col-md-4">
					<label>Estado</label>
					<select name="estado" class="form-control">
						<option value="" selected>Selecione..</option>
						<option>AC</option>
						<option>AL</option>
						<option>AP</option>
						<option>AM</option>
						<option>BA</option>
						<option>CE</option>
						<option>DF</option>
						<option>ES</option>
						<option>GO</option>
						<option>MA</option>
						<option>MT</option>
						<option>MS</option>
						<option>MG</option>
						<option>PA</option>
						<option>PB</option>
						<option>PR</option>
						<option>PR</option>
						<option>PI</option>
						<option>RJ</option>
						<option>RN</option>
						<option>RS</option>
						<option>RO</option>
						<option>RR</option>
						<option>SC</option>
						<option>SP</option>
						<option>SE</option>
						<option>TO</option>
					</select>
				</div>
			</div>
			<hr />
			<h6>INSTITUCIONAL</h6>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label>Campus*</label>
					<select name="campus" class="form-control" required>
						<option selected>Salinas</option>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label>Ensino*</label>
					<select name="ensino" class="form-control" required>
						<option selected>Médio Integrado</option>
						<option>Técnico</option>
						<option>Superior</option>
						<option>Mestrado</option>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label>Curso*</label>
					<select name="curso" class="form-control" required>
						<option selected>Selecione..</option>
						<option>Técnico em Informática</option>
						<option>Técnico em Agropecuária</option>
						<option>Técnico em Agroindústria</option>
					</select>
				</div>
				<br />
				<div class="form-group col-md-4">
					<label>Nº de Matrícula*</label>
					<input type="text" name="matricula" class="form-control" required>
				</div>
			</div>
			<form method="POST" action="cadastrar.php" enctype="multipart/form-data">
				<label>Foto 3x4*</label>
				<?php
				while ($row = mysqli_fetch_array($result)) {
					echo "<div id='img_div'>";
					echo "<img src='images/" . $row['image'] . "' >";
					echo "</div>";
				}
				?>
				<br />
				<input type="file" name="image" class="btn btn-light" required><br /><br />
				<button type="submit" name="upload">Salvar imagem</button>
			</form>
			</br>
			<button type="submit" name="submit" class="btn btn-primary">Cadastrar</button>
		</form>
	</div>
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
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
		integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
		integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>