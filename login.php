<?php
session_start();
//Conectar com o banco
require_once('cod/bdconexao.php'); // O obj. de conexão $con vem daqui.		

//Validação do usuário no banco	
if (isset($_POST['submit'])) {
	$usuario = $_POST['usuario'];
	$senha = md5($_POST['senha']);

	// Criar a query		
	$sql = "
		SELECT *
		FROM usuario
		WHERE usuNome = '$usuario' AND usuSenha = '$senha'
		";
	// Executar a query
	$result = $con->query($sql);

	$erro = 0;
	$msg = array();

	if (mysqli_num_rows($result) == 1) {
		$infoUsuario = mysqli_fetch_object($result);
		$_SESSION['usuId'] = $infoUsuario->usuId;
		$_SESSION['usuNome'] = $infoUsuario->usuNome;
		header('Location: index.php');
	} else {
		$erro = 1;
		array_push($msg, 'E-mail ou senha incorreta!');
	}
} ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="icon" href="img/favicon.png">

	<title> Login </title>
</head>

<body>
	<div class="container">

		<div class="col-lg-4 mx-auto mt-5 mb-4 p-4 shadow-sm">
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
			<div class="row text-center mb-4">
				<img src="img/logo.png" class="mx-auto w-100 h-100" /></br>
			</div>
			<div class="text-center mb-4">
				<h4>Olá!</h4>
				<p><i>Faça seu login para prossseguir</i></p>
			</div>

			<form class="form-signin mt-4" action="login.php" method="post">
				<input type="text" name="usuario" class="form-control" placeholder="Usuário" required autofocus>
				<input type="password" name="senha" class="form-control" placeholder="Senha" required>
				</br>
				<button class="btn btn-info btn-block" name='submit' type="submit">Entrar</button>
			</form>

		</div>
	</div>
	<script src="js/jquery-3.3.1.min.js"> </script>
	<script src="js/popper.min.js"> </script>
	<script src="js/bootstrap.min.js"> </script>
</body>

</html>