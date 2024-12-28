<?php
	if (isset($_POST['submit'])){
		// Conectar com o banco
		require_once('../cod/bdconexao.php'); // gera o obj de conexão $con
	
		// Recebe as variáveis do formulário
		$nf = $_POST['nf'];
		$data = $_POST['data'];
		$empresa = $_POST['empresa'];
		
		$erro=0;
		$msg = array();
		
		// Se não houver erro manda pro banco
		if (!$erro){
			// Inserir no banco
			$sql = "
			INSERT INTO entrada (entNF, entData, entEmpresa) 
			VALUES ('$nf','$data','$empresa')
			";
			
			if ($con->query($sql) === TRUE){
				array_push($msg,"Operação realizada com sucesso!");
				header("Location: cadastrar.php");
			}else{
				$erro = 1;
				array_push($msg,"Operação não realizada!");
				header("Location: cadastrar.php");
			}
		}
	}
?>