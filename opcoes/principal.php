<?php
require_once('../cod/seg.php');
require_once('../cod/bdconexao.php');
//Excluir o adm
if( isset($_GET['op']) && isset($_GET['id']) ){
	if ($_GET['op'] == 'excluir'){
		
		$erro = 0;
		$msg = array();
		
		// Criar a query
		$id = $_GET['id'];
        $sql = "DELETE FROM usuario WHERE usuId = $id";
		// Executar a query
        if ($con->query($sql) === TRUE)
			array_push($msg,"Operação realizada com sucesso!");
		else {
			$erro = 1;
			array_push($msg,"Operação não realizada!");
		}
	}
}
if (isset($_POST['submit'])){
	// Conectar com o banco
	require_once('../cod/bdconexao.php'); // gera o obj de conexão $con

	// Recebe as variáveis do formulário
	$nome = $_POST['nome'];
	$senha = $_POST['senha'];
	$senhaNova = $_POST['senhaNova'];

	$id = $_SESSION['usuId'];
	// Criar a query
	$sql = "SELECT usuSenha FROM usuario WHERE usuId = $id";
	// Executar a query
	$result = $con->query($sql);
	$senhaAtual = mysqli_fetch_object($result);
	
	if (md5($senha) != $senhaAtual->usuSenha){
		$erro = 1;
		array_push($msg, "Senha atual incorreta!");
	}
	// Verificação de erro
	$erro = 0;
	$msg = array();
	
	if (!$erro){
		// Criar a query
		if (!empty($senhaNova)){
			$senha = $senhaNova;
		}
		$id = $_SESSION['usuId'];
		$senha = md5($senha);
		$sql = "
		UPDATE usuario 
		SET usuNome = '$nome', usuSenha = '$senha'
		WHERE usuId = $id
		";
		
		if ($con->query($sql) === TRUE){
			array_push($msg, 'Operação realizada com sucesso!');
		} else {			
			$erro = 1;
			array_push($msg, "Operação não realizada!");
		}
	}
}
?>
<?php
if (isset($_POST['cadastrar'])){
	//Conectar com o banco
	require_once('../cod/bdconexao.php'); // O obj. de conexão $con vem daqui.
	
	$nome = $_POST['novoNome'];
	$senha = $_POST['novoSenha'];
	$senhaConfirma = $_POST['senhaConfirma'];
	
	$erro = 0;
	$msg = array();
	
	if ($senha != $senhaConfirma){
		$erro = 1;
		array_push($msg, 'As senhas não coincidem!');
	}
	
	if (!$erro){
		$senha = md5($senha);
		$sql = "
		INSERT INTO usuario (usuNome, usuSenha) 
		VALUES ('$nome','$senha')
		";
		
		if ($con->query($sql) === TRUE){
			array_push($msg, 'Usuário cadastrado com sucesso!');
		} else {			
			$erro = 1;
			array_push($msg, "Operação não realizada!");
		}
		
		
	}
}

	$id = $_SESSION['usuId'];
	
	//Criar a query
	
	$sql = "SELECT * FROM usuario WHERE usuId = $id";
	
	// Executar a query
	
	$result = $con->query($sql);
	
	// Tratei a consulta e joguei pra dentro do obj info
	
	$info = mysqli_fetch_object($result);
	
 include('../cod/header.php');?>
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
		<h4>Usuário</h4>
		</br>
	<form action="principal.php" method="post">
		<p>Seus dados</p>
		<div class="form-group">
			<input type="hidden" value="<?php echo $id;?>" name="id"/>
			<div class="form-group col-md-12">
				<label for="usr">Nome de Usuário</label>
				<input type="text" class="form-control" name="nome" value="<?php echo $info->usuNome; ?>" required>
			</div>
			<div class="form-group col-md-12">
				<label for="senha">Senha</label>
				<input type="password" class="form-control" name="senha" required>
			</div>
			<div class="form-group col-md-12">
				<label for="senha">Nova Senha</label>
				<input type="password" class="form-control" name="senhaNova">
			</div>
		</div>
		<button type="submit" name="submit" class="btn btn-success btn-sm float-right mb-1 mr-3" data-toggle="tooltip" title="Alterar Meus Dados">Alterar</button>
		</br>
		<hr>
		
		<button type="button" class="btn btn-light" data-toggle="modal" title="Adicionar Usuário" data-target="#add-user">
			<img src="../img/add-user.png" class="w-75">
		</button>
		<button type="button" class="btn btn-light" data-toggle="modal" title="Excluir um usuário" data-target="#list-user">
			<img src="../img/lixeira.png" class="w-75">
		</button>
		<a href="../logoff.php" class="btn btn-warning">Sair</a>
	</form>
	
	<!-- Modal ADD USER-->
	<div id="add-user" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Cadastrar Novo Usuário</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="principal.php" method="post">
						<div class="form-group">
							<div class="form-group col-md-12">
								<label for="cod">Nome de Usuário</label>
								<input type="text" class="form-control" name="novoNome" required>
							</div>
							<div class="form-group col-md-12">
								<label for="cod">Senha</label>
								<input type="password" class="form-control" name="novoSenha" required>
							</div>
							<div class="form-group col-md-12">
								<label for="cod">Confirmar Senha</label>
								<input type="password" class="form-control" name="senhaConfirma" required>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="cadastrar" name="cadastrar" class="btn btn-primary">Cadastrar</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Modal LIST USER-->
	<div id="list-user" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Lista de Usuários</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
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
					  <br />
					  <input class="form-control" id="myInput" type="text" placeholder="Buscar...">
					  <br>
					  <table class="table table-hover">
						<thead>
						  <tr>
							<th>Id</th>
							<th>Nome</th>
							<th>Ação</th>
						  </tr>
						</thead>
						<tbody id="myTable">
							<?php			
								// Criar a query
							$sql = "SELECT * FROM usuario";
								// Executar a query
							$result = $con->query($sql);
							if (mysqli_num_rows($result) < 1){
								echo "Resultados não encontrados!";
							} else {
								
									// Tratar o resultado
								while($row = mysqli_fetch_object($result)){
									echo "
									<tr>
										<td>$row->usuId</td>
										<td>$row->usuNome</td>
										<td>
										<a class='btn btn-outline-danger btn-sm' href='principal.php?op=excluir&id=$row->usuId'> Excluir </a>
										</td>
									</tr>					
								 ";
							   }
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
	<div class="p-2 col-sm bg-light">
		<h4>Configurações</h4>
		</br>
		<p>Opções do Sistema</p>
		</br>
		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Excluir Todos os Dados</button>
		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Excluir Todos os Dados</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Tem certeza que deseja excluir?
						</br> Esta ação não pode ser desfeita!</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal">Sim, tenho certeza</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include('../cod/footer.php');?>
 <script>
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

  <?php // Fechar conexão.
  fecharConexao($con);
  ?>	