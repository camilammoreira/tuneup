<?php	
    require_once('seg.php');
    define('BASE_URL', '/tuneup/');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/select2.css">
  <link rel="icon" href="<?php echo BASE_URL; ?>img/favicon.png">
  <title>Tune-Up</title>
</head>
<body>
  <div class="container-fluid">
     <div>
         <a href="<?php echo BASE_URL; ?>index.php"><img class="img-fluid" src="<?php echo BASE_URL; ?>img/logo.png"/></a>
     </div>

     <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle ="dropdown" aria-haspopup="true" aria-expanded="false">
                      Empresas
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>empresas/cadastrar.php">Cadastrar</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>empresas/pesquisar.php">Pesquisar</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle  ="dropdown" aria-haspopup="true" aria-expanded="false">
                  Produtos
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>produtos/cadastrar.php">Cadastrar</a>
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>produtos/pesquisar.php">Pesquisar</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle  ="dropdown" aria-haspopup="true" aria-expanded="false">
              Setores
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?php echo BASE_URL; ?>setores/cadastrar.php">Cadastrar</a>
            <a class="dropdown-item" href="<?php echo BASE_URL; ?>setores/pesquisar.php">Pesquisar</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle  ="dropdown" aria-haspopup="true" aria-expanded="false">
          Entrada
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="<?php echo BASE_URL; ?>entrada/cadastrar.php">Cadastrar</a>
        <a class="dropdown-item" href="<?php echo BASE_URL; ?>entrada/pesquisar.php">Pesquisar</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo BASE_URL; ?>entrada/relatorio.php">Gerar Relatório</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Saída
  </a>
  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="<?php echo BASE_URL; ?>saida/cadastrar.php">Cadastrar</a>
    <a class="dropdown-item" href="<?php echo BASE_URL; ?>saida/pesquisar.php">Pesquisar</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="<?php echo BASE_URL; ?>saida/relatorio.php">Gerar Relatório</a>
</div>
</li>
</ul>
<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="opcoes" role="button" data-toggle="dropdown" title="Opções" aria-haspopup="true" aria-expanded="false">
            <img src="<?php echo BASE_URL; ?>img/settings.png">
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="opcoes">
            <a class="dropdown-item" href="<?php echo BASE_URL; ?>opcoes/principal.php">Usuário e Configurações</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo BASE_URL; ?>logoff.php">Sair</a>
        </div>
    </li>
</ul>
</div>
</nav>
<div class="row mt-4 mx-auto col-lg-8 shadow-sm p-4 mb-4 bg-white">
    <div class="p-2 col-sm bg-white">